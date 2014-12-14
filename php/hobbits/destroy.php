<?php
require_once '../bootstrap.php';
/**
 * hobbits.destroy
 */
// Enforce HTTP Method

// Destroy Hobbit
$sql = "DELETE FROM people WHERE id = :id";
$success = $DB->executeStatement($sql, ['id' => $_POST['id']]);

// Redirect back to Index...