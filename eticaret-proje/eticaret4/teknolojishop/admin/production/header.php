<?php
ob_start();
session_start();
include '../netting/baglan.php';
include 'fonksiyon.php';

//Belirli veriyi seçme işlemi
$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id=:id");
$ayarsor->execute(array(
  'id' => 0
  ));
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);


$kullanicisor=$db->prepare("SELECT * FROM kullanicilar where kullanici_mail=:mail");
$kullanicisor->execute(array(
  'mail' => $_SESSION['kullanici_mail']
  ));
$say=$kullanicisor->rowCount();
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

if ($say==0) {
  Header("Location:login.php?durum=izinsiz");
  exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Admin Panel</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- jQuery -->
  <script src="../vendors/jquery/dist/jquery.min.js"></script>

  <!-- Select2 CSS ve JS -->
  <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
  <script src="../vendors/select2/dist/js/select2.min.js"></script>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- Dropzone.js -->
  <link href="../vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
  <script src="../vendors/dropzone/dist/min/dropzone.min.js"></script>
  
  <!-- Ck Editör -->
  <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
  <link href="../build/css/custom-admin.css" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="index.php" class="site_title">
              <i class="fa fa-shopping-cart"></i> <span>TeknolojiShop</span>
            </a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <?php if(!empty($kullanicicek['kullanici_resim'])) { ?>
                <img src="../../<?php echo $kullanicicek['kullanici_resim']; ?>" alt="Profil" class="img-circle profile_img">
              <?php } else { ?>
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              <?php } ?>
            </div>
            <div class="profile_info">
              <span>Hoşgeldiniz,</span>
              <h2><?php echo $kullanicicek['kullanici_adsoyad'] ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>Genel</h3>
              <ul class="nav side-menu">

                <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard </a></li>

                <li><a href="siparisler.php"><i class="fa fa-shopping-cart"></i> Siparişler </a></li>

                <li><a><i class="fa fa-database"></i> Katalog <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="kategori.php">Kategoriler</a></li>
                    <li><a href="urun.php">Ürünler</a></li>
                    <li><a href="markalar.php">Markalar</a></li>
                    <li><a href="filtre-sablonu.php">Filtre Şablonları</a></li>
                    <li><a href="yorum.php">Yorumlar</a></li>
                  </ul>
                </li>

                <li><a><i class="fa fa-desktop"></i> Vitrin Yönetimi <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="urun-vitrinleri.php">Ürün Vitrinleri</a></li>
                    <li><a href="tabli-urun-vitrinleri.php">Tablı Ürün Vitrinleri</a></li>
                  </ul>
                </li>

                <li><a href="kullanici.php"><i class="fa fa-users"></i> Müşteriler </a></li>

                <li><a><i class="fa fa-file-text"></i> İçerik Yönetimi <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="icerik.php">İçerikler</a></li>
                    <li><a href="sss.php"> SSS </a></li>
                  </ul>
                </li>

                <li><a><i class="fa fa-credit-card"></i> Ödeme Sistemleri <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="banka.php"><i class="fa fa-bank"></i> Banka Hesapları </a></li>
                    <li><a href="sanal-pos.php"><i class="fa fa-credit-card"></i> Sanal POS Ayarları </a></li>
                  </ul>
                </li>

                <li><a><i class="fa fa-cogs"></i> Ayarlar <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="genel-ayar.php">Genel Ayarlar</a></li>
                    <li><a href="iletisim-ayarlar.php">İletişim Ayarlar</a></li>
                    <li><a href="sosyal-ayar.php">Sosyal Ayarlar</a></li>
                    <li><a href="admin-list.php">Kullanıcı Ayarları</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->

          <!-- menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Ayarlar" href="genel-ayar.php">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Tam Ekran" onclick="toggleFullScreen()">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Ekranı Kilitle" href="logout.php?lock=true">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Çıkış Yap" href="logout.php">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <?php if(!empty($kullanicicek['kullanici_resim'])) { ?>
                    <img src="../../<?php echo $kullanicicek['kullanici_resim']; ?>" alt="Profil">
                  <?php } else { ?>
                    <img src="images/img.jpg" alt="...">
                  <?php } ?>
                  <?php echo $kullanicicek['kullanici_adsoyad'] ?>
                  <span class="fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="admin-list.php"><i class="fa fa-user pull-right"></i> Profil Bilgilerim</a></li>
                  <li><a href="genel-ayar.php"><i class="fa fa-cog pull-right"></i> Ayarlar</a></li>
                  <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Güvenli Çıkış</a></li>
                </ul>
              </li>

              <!-- Bildirimler alanı gerekirse burada -->
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->