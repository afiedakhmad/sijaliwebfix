<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan mengganti informasi database sesuai dengan kebutuhan Anda
    include '../conn.php'; // Sesuaikan dengan path ke file koneksi Anda
    require_once '../vendor/autoload.php'; // Sesuaikan dengan path ke autoload.php Anda

    $host = "localhost";
    $dbname = "u468167295_sijali";
    $username = "u468167295_sijali";
    $password = "SIJali2023@";
    $db_charset = "utf8mb4";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_FILES['file']['error'] == 0) {
            $filePath = $_FILES['file']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // Mulai dari baris ke-2
            for ($i = 2; $i <= count($sheetData); $i++) {
                $row = $sheetData[$i];
                $username = $row['B'];

                // Cek apakah username sudah ada di database
                $stmtCheckUsername = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
                $stmtCheckUsername->execute([$username]);
                $count = $stmtCheckUsername->fetchColumn();

                if ($count == 0) {
                    // Jika username belum ada, simpan data ke database
                    $nama = $row['A'];
                    $password = md5($row['C']); // Menggunakan MD5 untuk mengenkripsi password
                    $role = $row['D'];

                    $stmt = $pdo->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$nama, $username, $password, $role]);
                } else {
                    // Jika username sudah ada, berikan respons dengan pesan kesalahan
                    echo json_encode(['success' => false, 'message' => "Username '$username' sudah ada. Data tidak diimpor."]);
                    exit; // Keluar dari skrip agar tidak melanjutkan loop
                }
            }

            // Berikan respons berhasil jika loop selesai
            echo json_encode(['success' => true, 'message' => 'Data berhasil diimpor.']);
        } else {
            // Berikan respons kesalahan unggahan file
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan dalam unggahan file.']);
        }
    } catch (PDOException $e) {
        // Berikan respons kesalahan koneksi database
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan dalam koneksi database: ' . $e->getMessage()]);
    }
} else {
    // Berikan respons metode permintaan tidak valid
    echo json_encode(['success' => false, 'message' => 'Metode permintaan tidak valid.']);
}

?>
