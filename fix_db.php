<?php
require_once __DIR__ . '/config/database.php';
$db = new Database();
$conn = $db->getConnection();
$stmt = $conn->query("UPDATE overtimeassign SET Status = 'OT Full' WHERE Status = ''");
echo 'Updated ' . $stmt->rowCount() . ' rows.';
?>
