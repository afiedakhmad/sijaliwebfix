<?php
// Include file koneksi ke database
include '../conn.php';

// Cek apakah form login telah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkode password menggunakan MD5
    $hashedPassword = md5($password);

    // Query untuk memeriksa keberadaan username dan password di database
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Cek jumlah baris hasil query
        $num_rows = mysqli_num_rows($result);

        if ($num_rows == 1) {
            // Jika username dan password cocok, redirect ke halaman sukses atau halaman dashboard
            header('Location: ../dashboard/dashboard.php');
            exit();
        } else {
            // Jika username atau password salah, redirect kembali ke halaman login
            header('Location: login.html');
            exit();
        }
    } else {
        // Jika terjadi kesalahan dalam query, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }

    // Tutup koneksi ke database
    mysqli_close($conn);
}
?>
