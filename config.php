<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "apotek_pintar";

    $conn = new mysqli($hostname,$username,$password, $database);
    
    //login
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $cekuser = mysqli_query($conn,"SELECT * FROM user where username ='$username' and password='$password'");
        $hitung = mysqli_num_rows($cekuser);

        if($hitung>0){
            $ambildatarole = mysqli_fetch_array($cekuser);
            $role = $ambildatarole['role'];

            if($role=='admin'){
                $_SESSION['log'] = 'Logged';
                $_SESSION['role'] = 'Admin';
                header('location:admin');
            } else {
                $_SESSION['log'] = 'Logged';
                $_SESSION['role'] = 'User';
                header('location:player');
            }
        }else{
            echo 'Data tidak ditemukan';
        }
    }

?>