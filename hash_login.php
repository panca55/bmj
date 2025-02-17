<?php
include 'db_connect.php';

$username = 'admin';
$password = 'admin123'; // Password asli
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password

$stmt = $conn->prepare("UPDATE tb_admin SET password=? WHERE username=?");
$stmt->bind_param("ss", $hashed_password, $username);
if ($stmt->execute()) {
    echo "Password berhasil diperbarui!";
} else {
    echo "Gagal memperbarui password!";
}
$stmt->close();
