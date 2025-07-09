<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Departments</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/animate-3.7.0.css">
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-4.1.3.min.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.min.css">
    <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/linearicons.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .form-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .form-title {
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group label {
            font-weight: 600;
        }

        #harga-obat {
            font-weight: bold;
            color: #007bff;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <!-- Header Area -->
    <header class="header-area">
        <div class="header-top">
            <div class="container"></div>
        </div>
        <div id="header">
            <div class="container">
                <div class="row align-items-center justify-content-between d-flex">
                    <div id="logo">
                        <a href="index.html"><img src="assets/images/logo/favicon.png" alt="" title="" /> APOTEK
                            JAYA</a>
                    </div>
                    <nav id="nav-menu-container">
                        <ul class="nav-menu">
                            <li class="menu-active"><a href="index.html">Home</a></li>
                            <li><a href="departments.php">Pembelian</a></li>
                            <li class="menu-has-children"><a href="#">Pages</a>
                                <ul>
                                    <li><a href="about.html">About Us</a></li>
                                </ul>
                            </li>
                            <li><a href="login.php">Login</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner Area -->
    <section class="banner-area other-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Pembelian</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- PHP Logic -->
    <?php
    include 'config.php';
    $result_obat = $conn->query("SELECT id_obat, nama, stok, harga FROM obat WHERE stok > 0");
    $obat_list = [];
    while ($row = $result_obat->fetch_assoc()) {
        $obat_list[] = $row;
    }
    ?>

    <!-- Form Area -->
    <section class="transaksi-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="form-container">
                        <h4 class="form-title text-center">Pembelian Obat</h4>
                        <form action="proses_transaksi.php" method="POST">
                            <div class="form-group">
                                <label for="tgl_transaksi">Tanggal Transaksi</label>
                                <input type="date" id="tgl_transaksi" name="tgl_transaksi" class="form-control"
                                    value="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Pilih Obat</label>
                                <ul style="list-style-type: none; padding-left: 0;">
                                    <?php foreach ($obat_list as $obat): ?>
                                        <li class="mb-2">
                                            <label style="display: flex; align-items: center;">
                                                <input type="radio" name="id_obat" value="<?php echo $obat['id_obat']; ?>"
                                                    required>
                                                <span style="margin-left: 10px;">
                                                    <?php echo "{$obat['nama']} (Stok: {$obat['stok']}) - Harga: Rp " . number_format($obat['harga'], 0, ',', '.'); ?>
                                                </span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" id="jumlah" name="jumlah" class="form-control" value="1" min="1"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="harga">Harga</label>

                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Proses Pembelian</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JS Scripts -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/vendor/bootstrap-4.1.3.min.js"></script>
    <script src="assets/js/vendor/wow.min.js"></script>
    <script src="assets/js/vendor/owl-carousel.min.js"></script>
    <script src="assets/js/vendor/jquery.datetimepicker.full.min.js"></script>
    <script src="assets/js/vendor/jquery.nice-select.min.js"></script>
    <script src="assets/js/vendor/superfish.min.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- Script untuk Menampilkan Harga -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const select = document.getElementById('id_obat');
            const hargaDiv = document.getElementById('harga-obat');

            select.addEventListener('change', function () {
                const harga = this.options[this.selectedIndex].getAttribute('data-harga');
                if (harga) {
                    hargaDiv.textContent = `Harga: Rp ${parseFloat(harga).toLocaleString('id-ID')}`;
                } else {
                    hargaDiv.textContent = '';
                }
            });
        });
    </script>

</body>

</html>