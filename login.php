<?php
    require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eclipse Chest</title>
</head>
<body style="position: relative; margin: 0; 
    background: url('assets/images/baground baru.jpg') 
    no-repeat center; 
    background-size: cover; 
    font-family: 'Comic Sans MS', cursive, sans-serif; 
    text-align: center; 
    display: flex; flex-direction: column; 
    align-items: center; justify-content: center; 
    height: 100vh;">
    <img src="img/logo cat.png" alt=""
        style="position: absolute; top: 10px; left: 10px; width: 80px; height: auto;">
    <div style="margin-bottom: 20px;">
        <h1 style="color: white; font-size: 2em; text-shadow: 2px 2px 4px black;">Login Khusus Admin/owner</h1>
    </div>
    <fieldset style="border: none;">
        <div style="max-width: 400px; padding: 20px; 
            background: white; border: 3px solid rgb(71, 60, 60); 
            box-shadow: 5px 5px 0 rgb(80, 57, 57); border-radius: 10px;">
            <h2>Login</h2>
            <form method="post">
                <label for="username">👤 Username:</label>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">🔑 Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <button style="background: rgb(83, 192, 196); color: white; border: none; padding: 10px; cursor: pointer;"
                    type="submit" name="login">Masuk</button>
                <button style="background: rgb(83, 192, 196); color: white; border: none; padding: 10px; cursor: pointer;"
                    type="submit" name="regist">Regist</button>
            </form>
        </div>
    </fieldset>
</body>
</html>