<?php
require_once __DIR__ . '/config/database.php';
$db = new Database();
$conn = $db->getConnection();
$conn->exec("ALTER TABLE overtimeassign MODIFY COLUMN Status enum('Pending','Accepted','Rejected','InProgress','Completed','NoOT','Cancelled','No Show','OT Full') NOT NULL DEFAULT 'Pending'");
echo 'Altered successfully';
?>
