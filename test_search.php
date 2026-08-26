<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/LeaveRequest.php';

try {
    $model = new LeaveRequest();
    $leaveRequests = $model->getAll();
    
    $filters = ['search' => 'Ei', 'DeptID' => '', 'status' => '', 'leave_type' => '', 'date' => ''];
    
    $filtered = array_filter($leaveRequests, function($lr) use ($filters) {
        $match = true;
        if (!empty($filters['search'])) {
            $search = strtolower($filters['search']);
            $name = strtolower($lr['FirstName'] . ' ' . $lr['LastName']);
            $empCode = strtolower('EMP-' . str_pad($lr['EmpID'], 4, '0', STR_PAD_LEFT));
            if (strpos($name, $search) === false && strpos($empCode, $search) === false) {
                $match = false;
            }
        }
        return $match;
    });
    
    print_r(array_values($filtered));
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
