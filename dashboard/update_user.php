<?php
// Pastikan mengganti informasi database sesuai dengan kebutuhan Anda
//include 'conn.php';


$host = "localhost";
$dbname = "u468167295_sijali";
$username = "u468167295_sijali";
$password = "SIJali2023@";
$db_charset = "utf8mb4";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("UPDATE users SET nama = ?, username = ?, role = ? WHERE id = ?");
        $stmt->execute([$nama, $username, $role, $id]);

        // Redirect ke halaman users.php setelah pembaruan
        header('Location: users.php');
        exit;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        exit;
    }
} else {
    echo 'Metode permintaan tidak valid.';
    exit;
}
?>
