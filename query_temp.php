<?php
require_once 'config/Database.php'; 
$db = new Database(); 
$conn = $db->getConnection(); 

$stmt = $conn->query("SELECT e.EmpID, e.FirstName, e.LastName, p.BasicSalary FROM employee e JOIN position p ON e.PositionID = p.PositionID WHERE e.FirstName LIKE '%Thura%'"); 
$emp = $stmt->fetch(PDO::FETCH_ASSOC); 
print_r($emp); 

$stmt = $conn->prepare("SELECT * FROM leaverequest WHERE EmpID = :id AND Status = 'Approved' AND StartDate LIKE '2026-%'"); 
$stmt->execute(['id' => $emp['EmpID']]); 
print_r($stmt->fetchAll(PDO::FETCH_ASSOC)); 

$stmt = $conn->query("SELECT * FROM leavetypes"); 
print_r($stmt->fetchAll(PDO::FETCH_ASSOC)); 
