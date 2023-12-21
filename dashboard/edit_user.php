<?php
// Pastikan mengganti informasi database sesuai dengan kebutuhan Anda
//include 'conn.php';

$host = "localhost";
$dbname = "u468167295_sijali";
$username = "u468167295_sijali";
$password = "SIJali2023@";
$db_charset = "utf8mb4";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'ID Pengguna tidak valid.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Sesuaikan dengan path Bootstrap dan CSS yang Anda gunakan -->
    <link rel="stylesheet" href="../assets/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit User</h2>
    <form action="update_user.php" method="post">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <div class="mb-3">
            <label for="nama">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $user['nama']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="role">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="mitra" <?php echo ($user['role'] == 'mitra') ? 'selected' : ''; ?>>Mitra</option>
                <option value="supervisor" <?php echo ($user['role'] == 'supervisor') ? 'selected' : ''; ?>>Supervisor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="users.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Sesuaikan dengan path Bootstrap dan JS yang Anda gunakan -->
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
