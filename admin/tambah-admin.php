<?php
if (!isset($_SESSION)) {
  session_start(); 
  ob_start();
}

@ini_set('output_buffering',0);
set_time_limit(0);
error_reporting(0);

if (!isset($_SESSION['password']) || !isset($_SESSION['username'])) {     
  session_unset();
  header("Location:index.php");
  exit;
}

require_once 'koneksi.php';

$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_user = '$id_user'");
$admin = mysqli_fetch_array($query);
$id_user = $admin['id_user'];
$username = $admin['username'];
$notelp = $admin['notelp'];
$foto = $admin['foto'];
$namaAdmin = $admin['name'];
$levelAdmin = $admin['level'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Polinema-Pay | Admin</title>
  <link rel="shortcut icon" href="img/logo.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
  <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
  <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
  <script type="text/javascript">
    var auto_refresh = setInterval(
      function () {
        $('#load_content').load('updateFotoProfil.php').fadeIn("slow");
            }, 10000); // refresh setiap 10000 milliseconds

          </script>
        </head>

        <body>
          <!-- Left Panel -->
          <aside id="left-panel" class="left-panel">
            <nav class="navbar navbar-expand-sm navbar-default">
              <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                  <li>
                    <a href="home.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                  </li>
                  <li class="menu-title">Data</li><!-- /.menu-title -->
                  <li><a href="user-mahasiswa.php" > <i class="menu-icon fa fa-users"></i>User</a></li>
                  <li><a href="user-relawan.php"> <i class="menu-icon ti-signal"></i>Relawan</a></li>
                  <li><a href="user-merchant.php"> <i class="menu-icon fa fa-shopping-cart"></i>Merchant</a></li>
                  <?php if ($levelAdmin == "SuperAdmin") {
                    echo "<li class='active'><a href='user-admin.php'> <i class='menu-icon fa fa-user'></i>Admin</a></li>";
                  } ?>


                  <li class="menu-title">Fitur</li><!-- /.menu-title -->
                  <li><a href="peninjaupesanan.php"> <i class="menu-icon ti-list"></i>Pesanan Jemput Sampah</a></li>
                  <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa ti-time"></i>Riwayat</a>
                    <ul class="sub-menu children dropdown-menu">
                      <li><i class="ti-trash"></i><a href="riwayat-tukarsampah.php">Tukar Sampah</a></li>
                      <li><i class="ti-server"></i><a href="riwayat-tukarpoin.php">Tukar Poin</a></li>
                    </ul>
                  </li>
                  <li><a href="konversiharga.php"> <i class="menu-icon ti-money"></i>Konversi Harga</a></li>

                </ul>
              </div><!-- /.navbar-collapse -->
            </nav>
          </aside>
          <!-- /#left-panel -->
          <!-- Right Panel -->
          <div id="right-panel" class="right-panel">
            <!-- Header-->
            <header id="header" class="header">
              <div class="top-left">
                <div class="navbar-header">
                  <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                  <a class="navbar-brand" href="./"><img src="img/logo.png" alt="Logo"></a>
                  <a class="navbar-brand hidden" href="./"><img src="img/logo2.png" alt="Logo"></a>
                </div>
              </div>
              <div class="top-right">
                <div class="header-menu">
                  <div class="header-left">
                    <P style="color: white; margin-top: 15px; margin-right: 15px">Hai <?php echo $namaAdmin ?></P>
                  </div>

                  <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <!-- <img class="user-avatar rounded-circle" src="img/admin.jpg" alt="User Avatar"> -->
                      <img  class="user-avatar rounded-circle" src="https://polinema-pay.online/upload/FotoProfil/<?php echo $admin['foto']; ?>" alt="User Avatar">
                    </a>

                    <div class="user-menu dropdown-menu">
                      <a class="nav-link" href="accounts.php"><i class="fa fa- user"></i>Profil</a>
                      <a class="nav-link" href="logout.php"><i class="fa fa-power -off"></i>Keluar</a>
                    </div>
                  </div>

                </div>
              </div>
            </header>
            <!-- /#header -->

           <?php

    // Check If form submitted, insert form data into users table.
           if(isset($_POST['Submit'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $notelp = $_POST['notelp'];
            $foto = $_POST['foto'];

        // include database connection file
            include_once("koneksi.php");

        // Insert user data into table
            $result = mysqli_query($koneksi, "INSERT INTO admin (username,password,notelp,foto) VALUES('$username','$password','$notelp','$foto')");
            ?>
            <center>
                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success">Sukses!</span>
                        Admin baru telah ditambahkan.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </center>
            <?php
          }
          ?>

            <!-- Content -->
            <div class="breadcrumbs">
              <div class="breadcrumbs-inner">
                <div class="row m-0">
                  <div class="col-sm-8">
                    <div class="page-header float-left">
                      <div class="page-title">
                        <ol class="breadcrumb text-right">
                          <li><a href="#">Data</a></li>
                          <li><a href="user-admin.php"> Admin</a></li>
                          <li class="active">Tambah Admin</li
                          </ol>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="content">
                <!-- Animated -->
                <div class="animated fadeIn">
                  <div class="sufee-login d-flex align-content-center flex-wrap">
                    <div class="container">
                      <div class="login-content">
                        <div class="login-logo">
                          <P style="margin-bottom: 40px"><H2>Tambah Admin</H2></P>
                        </div>
                        <div class="login-form">
                          <form method="POST" class="tm-edit-product-form" enctype="multipart/form-data">
                            <div class="form-group">
                              <label>Username</label>
                              <input type="text" name="username" class="form-control" placeholder="Username" required="">

                            </div>
                            <div class="form-group">
                              <label>Password</label>
                              <input type="password" name="password" class="form-control" placeholder="Password" required="">
                            </div>

                            <button type="submit" name="Submit" class="btn btn-success btn-flat m-b-30 m-t-30">Tambah</button>

                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="clearfix"></div>


                </div>
                <!-- .animated -->
              </div>
              <!-- /.content -->
              <div class="clearfix"></div>
              <!-- Footer -->
              <footer class="site-footer">
                <div class="footer-inner bg-white">
                  <div class="row">
                    <div class="col-sm-6">
                      Copyright &copy; 2020 Polinema-Pay
                    </div>

                  </div>
                </div>
              </footer>
              <!-- /.site-footer -->
            </div>
            <!-- /#right-panel -->

            <!-- Scripts -->
            <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
            <script src="assets/js/main.js"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

            <!--untuk otomatis save ke db setelah memilih foto tanpa button simpan-->
            <script>
              $(document).ready(function(){
               $(document).on('change', '#file', function(){
                var name = document.getElementById("file").files[0].name;
                var form_data = new FormData();
                var ext = name.split('.').pop().toLowerCase();
                if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
                {
                 alert("Invalid Image File");
               }
               var oFReader = new FileReader();
               oFReader.readAsDataURL(document.getElementById("file").files[0]);
               var f = document.getElementById("file").files[0];
               var fsize = f.size||f.fileSize;
               if(fsize > 2000000)
               {
                 alert("Ukuran File Gambar Terlalu Besar Maksimal 2MB");
               }
               else
               {
                 form_data.append("file", document.getElementById('file').files[0]);
                 $.ajax({
                  url:"upload.php?idUser=<?php echo $id_user ?>",
                  method:"POST",
                  data: form_data,
                  contentType: false,
                  cache: false,
                  processData: false,
                  beforeSend:function(){
                   $('#uploaded_image').html("<label class='text-success'>Sedang Mengupload Gambar...</label>");
                 },
                 success:function(data)
                 {
                   $('#uploaded_image').html(data);
                 }
               });
               }
             });
             });
           </script>
        </body>
        </html>