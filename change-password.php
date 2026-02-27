<?php
require_once 'config/db_config.php';

$username = 'admin';
$new_password = 'admin123';
$hashed = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE admins SET password = ? WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $hashed, $username);

if (mysqli_stmt_execute($stmt)) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password.";
}

mysqli_stmt_close($stmt);
// DELETE THIS FILE AFTER USE!
?>
