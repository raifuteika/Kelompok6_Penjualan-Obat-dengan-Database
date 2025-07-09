<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // Tidak dienkripsi
    $role = "admin"; // Default role

    // Cek apakah username sudah digunakan
    $check = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
    } else {
        // Simpan user baru
        $stmt = $conn->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <style>
        body {
            background: url('assets/images/baground baru.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border: 3px solid #444;
            border-radius: 10px;
            box-shadow: 5px 5px 0 #666;
            width: 400px;
            text-align: center;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #aaa;
        }

        button {
            padding: 10px 20px;
            background: teal;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Registrasi Admin</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Masukkan Username" required><br>
            <input type="password" name="password" placeholder="Masukkan Password" required><br>
            <button type="submit" name="register">Daftar</button>
        </form>
    </div>

</body>

</html>