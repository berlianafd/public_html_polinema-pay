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

include 'koneksi.php';
// kalau tidak ada id di query string
if( !isset($_GET['id']) ){
  header('Location: admin.php');
}
//ambil id dari query string
$id = $_GET['id'];
// buat query untuk ambil data dari 
$sql = "SELECT * from konversiharga where id = $id";
$query = mysqli_query($koneksi, $sql);
$user = mysqli_fetch_assoc($query);
// jika data yang di-edit tidak ditemukan
if( mysqli_num_rows($query) < 1 ){
  die("data tidak ditemukan...");
}


$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_user = '$id_user'");
$admin = mysqli_fetch_array($query);
$id_user = $admin['id_user'];
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
</head>

<body>
  <!-- Left Panel -->
  <aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
      <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="">
            <a href="home.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
          </li>
          <li class="menu-title">Data</li><!-- /.menu-title -->
          <li><a href="user-mahasiswa.php" > <i class="menu-icon fa fa-users"></i>User</a></li>
          <li><a href="user-relawan.php"> <i class="menu-icon ti-signal"></i>Relawan</a></li>
          <li><a href="user-merchant.php"> <i class="menu-icon fa fa-shopping-cart"></i>Merchant</a></li>
          <?php if ($levelAdmin == "SuperAdmin") {
            echo "<li><a href='user-admin.php'> <i class='menu-icon fa fa-user'></i>Admin</a></li>";
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
          <li class="active"><a href="konversiharga.php"> <i class="menu-icon ti-money"></i>Konversi Harga</a></li>
          
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
    <!-- Header-->

    <div class="breadcrumbs">
      <div class="breadcrumbs-inner">
        <div class="row m-0">
          <div class="col-sm-6">
            <div class="page-header float-left">
              <div class="page-title">
                <ol class="breadcrumb text-right">
                  <li><a href="#">Fitur</a></li>
                  <li><a href="konversiharga.php">Konversi Harga</a></li>
                  <li class="active">Edit Konversi Harga</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="animated fadeIn">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" align="center">
                <strong class="card-title">Edit Konversi Harga</strong>
              </div> 
              <div class="container tm-mt-big tm-mb-big">
                <div class="row"> 
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mx-auto">
                    <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                      <div class="row">
                        <div class="col-12">
                          <form class="form-horizontal" method="post" action="konversiharga-proses-edit.php">
                            <div class="form-group">

                              <div class="col-md-7 col-sm-7">
                                <input type="hidden" class="form-control" name="id" value="<?php echo $user['id']; ?>" readonly>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="" class="control-label">Jenis</label>
                              <div class="">
                                <input type="text" class="form-control" name="jenis" value="<?php echo $user['jenis']; ?>" required="">
                              </div>

                            </div>
                            <div class="form-group">
                              <label for="" class=" control-label">Harga</label>
                              <div class="">
                                <input type="text" class="form-control" name="harga" value="<?php echo $user['harga']; ?>" required="">
                              </div>
                              
                            </div>
                            <div class="form-group">
                              <label for="" class=" control-label">Keterangan</label>
                              <div class="">
                                <input type="text" class="form-control" name="keterangan" value="<?php echo $user['keterangan']; ?>" required="">
                              </div>
                            </div>
                            <div class="box-footer">
                              <div class="" align="center">
                                <button name="Submit" type="Submit" class="btn btn-primary btn-block text-uppercase">
                                  Simpan
                                </button>
                              </div>
                            </div>
                            <br>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div><!-- .animated -->
    </div><!-- .content -->
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
</body>
</html>
