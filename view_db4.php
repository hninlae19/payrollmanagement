<?php
require_once 'config/database.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->query('SELECT e.EmpID, p.DeptID FROM employee e LEFT JOIN position p ON e.PositionID = p.PositionID');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
