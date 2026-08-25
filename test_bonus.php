<?php
require_once 'config/database.php';
require_once 'models/Employee.php';
require_once 'models/EmpBonous.php';

$employeeModel = new Employee();
$employeesList = $employeeModel->getAll();

$deptIdInput = 1; // Assuming DeptID 1 exists
$assignType = 'department';

$employeesToProcess = [];
if ($assignType === 'department') {
    foreach ($employeesList as $e) {
        if ($e['DeptID'] == $deptIdInput && $e['Status'] === 'Active') {
            $employeesToProcess[] = $e['EmpID'];
        }
    }
}

echo "Employees to process for Dept $deptIdInput:\n";
print_r($employeesToProcess);
?>
