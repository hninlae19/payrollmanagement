<?php
require_once 'config/database.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->query('SELECT EmpID, PayrollMonth, BonousAmount FROM payroll');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
