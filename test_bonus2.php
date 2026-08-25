<?php
require_once 'config/database.php';
require_once 'models/Employee.php';
require_once 'models/EmpBonous.php';

$db = new Database();
$conn = $db->getConnection();

$employeeModel = new Employee();
$employeesList = $employeeModel->getAll();
$empBonousModel = new EmpBonous();

$deptIdInput = 1;
$assignType = 'department';

$employeesToProcess = [];
foreach ($employeesList as $e) {
    if ($e['DeptID'] == $deptIdInput && $e['Status'] === 'Active') {
        $employeesToProcess[] = $e['EmpID'];
    }
}

foreach ($employeesToProcess as $eId) {
    $empBonousModel->EmpID = $eId;
    $empBonousModel->Amount = 500;
    $empBonousModel->BonusDate = date('Y-m-d');
    $empBonousModel->BonousID = 1; // Assume 1 exists
    
    try {
        if ($empBonousModel->create()) {
            echo "Inserted for $eId\n";
        } else {
            echo "Failed for $eId\n";
        }
    } catch (Exception $e) {
        echo "Error for $eId: " . $e->getMessage() . "\n";
    }
}
?>
