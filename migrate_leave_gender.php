<?php
require_once __DIR__ . '/config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    $conn->exec("UPDATE leavetypes SET Gender = 'Male' WHERE LeaveType = 'Paternity Leave'");
    echo "Updated Paternity Leave to Male.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
