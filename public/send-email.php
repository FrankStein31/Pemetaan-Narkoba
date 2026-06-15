<?php
session_start();

// 1. Koneksi ke Database
$servername = "localhost";
$username = "root"; // Ganti dengan username database
$password = ""; // Ganti dengan password database
$dbname = "clinic"; // Ganti dengan nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// 2. Ambil Data dari Form
$nama = $_POST['nama'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// 3. Simpan ke Database
$sql = "INSERT INTO messages (nama, email, subject, message, status, admin_feedback)
        VALUES (?, ?, ?, ?, 'pending', '-')";

// Gunakan prepared statement untuk menghindari SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nama, $email, $subject, $message);

if ($stmt->execute()) {
    $_SESSION['success'] = "Pesan berhasil dikirim!";
} else {
    $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();

// Redirect kembali ke halaman form
// Redirect ke root path "/" (sesuai route LandingController)
// Redirect ke route '/' dengan URL yang benar
// Jika di localhost port 8000
// Redirect ke URL absolut
if ($stmt->execute()) {
    header("Location: http://127.0.0.1:8080/landing?status=success");
    exit(); // Pastikan exit() dipanggil setelah header()
}

?>