<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/HolidayHelper.php';
require_once __DIR__ . '/Attendance.php';

class Payroll {
    private $conn;
    private $table = 'Payroll';

    public $PayrollID;
    public $EmpID;
    public $BasicSalary;
    public $PayrollMonth;
    public $PayableDays;
    public $BonousAmount;
    public $OvertimeAmount;
    public $LeaveDeductionAmount;
    public $NetSalary;
    public $Status;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT p.*, e.FirstName, e.LastName, e.ProfilePicture, e.JoinDate, pos.PositionName, d.DeptName, d.DeptID 
                  FROM " . $this->table . " p
                  LEFT JOIN Employee e ON p.EmpID = e.EmpID
                  LEFT JOIN Position pos ON e.PositionID = pos.PositionID
                  LEFT JOIN Department d ON pos.DeptID = d.DeptID
                  ORDER BY p.EmpID ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $payrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->appendDynamicFields($payrolls);
    }

    public function getByEmployee($emp_id) {
        $query = "SELECT p.*, e.FirstName, e.LastName, e.ProfilePicture, e.JoinDate, pos.PositionName, d.DeptName, d.DeptID 
                  FROM " . $this->table . " p
                  LEFT JOIN Employee e ON p.EmpID = e.EmpID
                  LEFT JOIN Position pos ON e.PositionID = pos.PositionID
                  LEFT JOIN Department d ON pos.DeptID = d.DeptID
                  WHERE p.EmpID = :emp_id 
                  ORDER BY p.PayrollID DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':emp_id', $emp_id);
        $stmt->execute();
        $payrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $this->appendDynamicFields($payrolls);
    }

    public function getById($id) {
        $query = "SELECT p.*, e.FirstName, e.LastName, e.ProfilePicture, e.JoinDate, pos.PositionName, d.DeptName, d.DeptID 
                  FROM " . $this->table . " p
                  LEFT JOIN Employee e ON p.EmpID = e.EmpID
                  LEFT JOIN Position pos ON e.PositionID = pos.PositionID
                  LEFT JOIN Department d ON pos.DeptID = d.DeptID
                  WHERE p.PayrollID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $payroll = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($payroll) {
            $payrolls = $this->appendDynamicFields([$payroll]);
            return $payrolls[0];
        }
        return false;
    }
    
    private function appendDynamicFields($payrolls) {
        if (empty($payrolls)) return $payrolls;
        
        foreach ($payrolls as &$p) {
            $monthStr = $p['PayrollMonth'];
            $year = date('Y');
            $month = date('m');
            // Parse monthStr which could be "July 2026" or "2026-07"
            if (preg_match('/^(\d{4})-(\d{2})$/', $monthStr, $matches)) {
                $year = $matches[1];
                $month = $matches[2];
            } else {
                $time = strtotime("1 " . $monthStr);
                if ($time) {
                    $year = date('Y', $time);
                    $month = date('m', $time);
                }
            }
            $startDate = "$year-$month-01";
            $endDate = date("Y-m-t", strtotime($startDate));
            $empId = $p['EmpID'];
            
            // Calendar days & salary rates
            $daysInTargetMonth = (int)date('t', strtotime($startDate));
            $basicSalary = (float)($p['BasicSalary'] ?? 0);
            $dailySalary = $daysInTargetMonth > 0 ? ($basicSalary / $daysInTargetMonth) : 0;
            $hourlyRate = $dailySalary / 8;
            
            $p['working_days_count'] = $p['PayableDays'] ?? $daysInTargetMonth; // Use actual PayableDays stored in DB if available
            $p['prorated_basic_salary'] = round($dailySalary * $p['working_days_count'], 2);
            $p['daily_salary'] = round($dailySalary, 2);
            $p['hourly_rate'] = round($hourlyRate, 2);
            
            // Attendance stats & Late minutes
            $stmt = $this->conn->prepare("
                SELECT CheckInTime, CheckOutTime, Status 
                FROM attendance 
                WHERE EmpID = :emp AND AttendanceDate BETWEEN :sd AND :ed
            ");
            $stmt->execute([':emp' => $empId, ':sd' => $startDate, ':ed' => $endDate]);
            $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $presentDays = 0;
            $absentDays = 0;
            $halfDays = 0;
            $lateDays = 0;
            $totalLateMinutes = 0;
            
            foreach ($attendanceRecords as $att) {
                $st = $att['Status'];
                if ($st === 'Present') {
                    $presentDays++;
                } elseif (in_array($st, ['Absent', 'Full-Day Absence', 'Full-day absent'])) {
                    $absentDays++;
                } elseif (in_array($st, ['Half Day', 'Half-Day Absence', 'Half-day absent'])) {
                    $halfDays++;
                } elseif ($st === 'Late') {
                    $lateDays++;
                }
                
                // Calculate dynamic late minutes from CheckInTime relative to 09:00 AM
                if (!empty($att['CheckInTime'])) {
                    $totalLateMinutes += Attendance::calculateLateMinutes($att['CheckInTime']);
                }
            }
            
            $p['present_days'] = $presentDays;
            $p['absent_days'] = $absentDays;
            $p['half_days'] = $halfDays;
            $p['late_days'] = $lateDays;
            $p['late_minutes'] = $totalLateMinutes;
            
            $lateHours = $totalLateMinutes / 60;
            $p['late_hours'] = round($lateHours, 2);
            
            // Deductions
            $lateDeduction = round($hourlyRate * $lateHours, 2);
            $halfDayDeduction = round($halfDays * ($dailySalary * 0.5), 2);
            $fullDayDeduction = round($absentDays * $dailySalary, 2);
            $totalAttendanceDeduction = $lateDeduction + $halfDayDeduction + $fullDayDeduction;
            
            $p['late_deduction'] = $lateDeduction;
            $p['half_day_deduction'] = $halfDayDeduction;
            $p['full_day_deduction'] = $fullDayDeduction;
            $p['total_attendance_deduction'] = $totalAttendanceDeduction;
            
            // Fetch approved Overtime within the period
            $stmt = $this->conn->prepare("SELECT SUM(TotalHours) as ot_hours FROM overtimeassign WHERE EmpID = :emp AND OvertimeDate BETWEEN :sd AND :ed AND Status IN ('Completed', 'OT Full')");
            $stmt->execute([':emp' => $empId, ':sd' => $startDate, ':ed' => $endDate]);
            $p['ot_hours'] = $stmt->fetchColumn() ?: 0;
            
            // Fetch LeaveTypes for limits
            $stmt = $this->conn->query("SELECT * FROM leavetypes");
            $leaveTypes = [];
            foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $lt) {
                $leaveTypes[$lt['LeaveTypeID']] = $lt;
            }

            // Leave stats
            $stmt = $this->conn->prepare("
                SELECT LeaveTypeID, StartDate, EndDate 
                FROM leaverequest 
                WHERE EmpID = :emp AND Status = 'Approved'
                AND StartDate <= :ed AND EndDate >= :sd
            ");
            $stmt->execute([':emp' => $empId, ':sd' => $startDate, ':ed' => $endDate]);
            $leavesThisMonth = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $leaveDaysInMonth = 0;
            $usedByThisMonthType = [];
            
            foreach ($leavesThisMonth as $lr) {
                $lrStart = max(strtotime($startDate), strtotime($lr['StartDate']));
                $lrEnd = min(strtotime($endDate), strtotime($lr['EndDate']));
                $days = round(($lrEnd - $lrStart) / (60 * 60 * 24)) + 1;
                if ($days > 0) {
                    $leaveDaysInMonth += $days;
                    $typeId = $lr['LeaveTypeID'];
                    if(!isset($usedByThisMonthType[$typeId])) $usedByThisMonthType[$typeId] = 0;
                    $usedByThisMonthType[$typeId] += $days;
                }
            }
            
            $totalUnpaidLeaveDays = 0;
            $totalPaidLeaveDays = 0;
            $totalAllowedLeaveDays = 0;
            
            foreach($usedByThisMonthType as $typeId => $daysThisMonth) {
                $lt = $leaveTypes[$typeId] ?? null;
                if (!$lt) continue;
                
                $yearStart = "$year-01-01";
                $priorMonthEnd = date("Y-m-d", strtotime($startDate . " -1 day"));
                
                $stmt = $this->conn->prepare("
                    SELECT SUM(DATEDIFF(LEAST(EndDate, :pme), GREATEST(StartDate, :ys)) + 1)
                    FROM leaverequest
                    WHERE EmpID = :emp AND LeaveTypeID = :lt AND Status = 'Approved'
                    AND StartDate <= :pme AND EndDate >= :ys
                ");
                $stmt->execute([':emp' => $empId, ':lt' => $typeId, ':pme' => $priorMonthEnd, ':ys' => $yearStart]);
                $priorDays = $stmt->fetchColumn() ?: 0;
                
                if ($lt['IsPaid'] == 0) {
                    $totalUnpaidLeaveDays += $daysThisMonth;
                    continue;
                }
                
                $limit = $lt['DaysAllowed'];
                $totalAllowedLeaveDays += $limit;
                
                if ($limit >= 999) { 
                    $totalPaidLeaveDays += $daysThisMonth;
                    continue; 
                }
                
                $available = max(0, $limit - $priorDays);
                $excessDays = max(0, $daysThisMonth - $available);
                
                if ($excessDays > 0) {
                    $totalUnpaidLeaveDays += $excessDays;
                    $totalPaidLeaveDays += ($daysThisMonth - $excessDays);
                } else {
                    $totalPaidLeaveDays += $daysThisMonth;
                }
            }
            
            $p['leave_days'] = $leaveDaysInMonth; // Actual Leave Days
            $p['paid_leave_days'] = $totalPaidLeaveDays;
            $p['unpaid_leave_days'] = $totalUnpaidLeaveDays;
            $p['allowed_paid_leave_days'] = $totalAllowedLeaveDays;
            $p['unpaid_amount'] = $p['LeaveDeductionAmount'];
            $p['other_deductions'] = $totalAttendanceDeduction;
        }
        return $payrolls;
    }
}

