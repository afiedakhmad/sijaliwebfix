<?php

// Pastikan mengganti informasi database sesuai dengan kebutuhan Anda
include '../conn.php';
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$host = "localhost";
$dbname = "u468167295_sijali";
$username = "u468167295_sijali";
$password = "SIJali2023@";
$db_charset = "utf8mb4";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mengambil data dari tabel users
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Membuat objek Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menulis header
    $header = ['Id', 'Username', 'Password','Nama Lengkap', 'Role'];
    $columnIndex = 1;
    foreach ($header as $column) {
        $sheet->setCellValueByColumnAndRow($columnIndex++, 1, $column);
    }

    // Menulis data
    $rowIndex = 2;
    foreach ($users as $user) {
        $columnIndex = 1;
        foreach ($user as $value) {
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $value);
        }
        $rowIndex++;
    }

    // Menyimpan ke file Excel
    $writer = new Xlsx($spreadsheet);
    $excelFileName = 'user_data.xlsx';
    $writer->save($excelFileName);

    // Menentukan header untuk file Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $excelFileName . '"');
    header('Cache-Control: max-age=0');

    // Mengirim file Excel ke output
    $writer->save('php://output');

    exit;
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan dalam koneksi database: ' . $e->getMessage()]);
    exit;
}
?>
