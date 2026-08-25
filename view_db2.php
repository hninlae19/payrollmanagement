<?php
require_once 'config/database.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->query('SELECT e.EmpID, e.FirstName, e.LastName, eb.BonusDate, eb.Amount FROM empbonous eb JOIN employee e ON eb.EmpID = e.EmpID');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
