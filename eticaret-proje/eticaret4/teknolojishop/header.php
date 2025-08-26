<?php
ob_start();
session_start();
/*ini_set('display_errors', 1);
error_reporting(E_ALL);*/
include 'settings/baglan.php';
include 'settings/fonksiyon.php';

$siteAyarSor = $db->prepare("SELECT * FROM ayar where ayar_id=0");
$siteAyarSor->execute();
$siteAyarCek = $siteAyarSor->fetch(PDO::FETCH_ASSOC);


// Kullanıcı oturumunu kontrol et
if (isset($_SESSION['kullanici_mail'])) {
    $kullanicisor = $db->prepare("SELECT * FROM kullanicilar where kullanici_mail=:mail");
    $kullanicisor->execute(array(
        'mail' => $_SESSION['kullanici_mail']
    ));
    $say = $kullanicisor->rowCount();
    $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);

    // Kullanıcının favori ürünlerini bir array'de tut (performans için)
    $favoriUrunler = [];
    try {
        $favoriSor = $db->prepare("SELECT urun_id FROM favoriler WHERE kullanici_id = :kullanici_id");
        $favoriSor->execute(['kullanici_id' => $kullanicicek['kullanici_id']]);
        while($favori = $favoriSor->fetch(PDO::FETCH_ASSOC)) {
            $favoriUrunler[] = $favori['urun_id'];
        }
    } catch(PDOException $e) {
        // Favoriler tablosu henüz oluşturulmamış olabilir
    }

    // Ürünün favorilerde olup olmadığını kontrol eden fonksiyon
    function isFavorite($urun_id) {
        global $favoriUrunler;
        return in_array($urun_id, $favoriUrunler);
    }
} else {
    $say = 0; // Oturum yoksa kullanıcı giriş yapmamış sayılır
    $kullanicicek = null;
    $favoriUrunler = [];
    
    // Oturum yokken de fonksiyonu tanımla
    function isFavorite($urun_id) {
        return false;
    }
}

?>

<!doctype html>
<html lang="tr" dir="ltr">
<head>
    <base>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title><?php echo $siteAyarCek['ayar_title'] ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="news_keywords" content="">
    <meta name="author" content="<?php echo $siteAyarCek['ayar_author'] ?>"/>
    <meta itemprop="author" content="<?php echo $siteAyarCek['ayar_author'] ?>"/>
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta property="og:type" content="website"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo $siteAyarCek['ayar_favicon'] ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="404.php">
    <link rel="apple-touch-icon" sizes="60x60" href="404.php">
    <link rel="apple-touch-icon" sizes="72x72" href="404.php">
    <link rel="apple-touch-icon" sizes="76x76" href="404.php">
    <link rel="apple-touch-icon" sizes="114x114" href="404.php">
    <link rel="apple-touch-icon" sizes="120x120" href="404.php">
    <link rel="apple-touch-icon" sizes="144x144" href="404.php">
    <link rel="apple-touch-icon" sizes="152x152" href="404.php">
    <link rel="apple-touch-icon" sizes="180x180" href="404.php">
    <link rel="stylesheet" href="assets/css/font-awesome/font-awesome.min.css" rel="preload"/>
    <link rel="stylesheet" href="assets/css/line-awesome/css/line-awesome.min.css" rel="preload">
    <link rel="stylesheet" href="assets/css/style.css" rel="preload">
    <link rel="stylesheet" href="assets/css/responsive.css" rel="preload">
    <link rel="stylesheet" href="assets/helper/bootstrap/css/bootstrap.min.css" rel="preload">
    <link rel="stylesheet" href="assets/css/site_style.css" rel="preload">
    <link rel="stylesheet" href="assets/css/jquery-ui/jquery-ui.css" rel="preload">
    <link rel='stylesheet' href='assets/css/slider/swiper.min.css' rel="preload">
    <link rel="stylesheet" href="assets/css/flag/flag-icon.css" rel="preload">
    <noscript id="deferred-styles">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&amp;display=swap"
              rel="stylesheet" type="text/css" rel="preload">
    </noscript>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/custom.js">
    </script><!-- ToTop Module -->

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a> <!-- ToTop Module End -->
    <link rel='stylesheet' href='assets/css/slider/aos.css'>
    <link rel="stylesheet" href="assets/css/modules_style.css">
    
    <style>
        /* Sepet Dropdown Stilleri */
        .dropdown-cart-items {
            max-height: 300px;
            overflow-y: auto;
            padding: 0;
        }
        
        .dropdown-cart-item {
            display: flex;
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
        }
        
        .dropdown-cart-item:last-child {
            border-bottom: none;
        }
        
        .dropdown-cart-item-img {
            width: 60px;
            height: 60px;
            margin-right: 10px;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .dropdown-cart-item-img img {
            max-width: 100%;
            max-height: 100%;
        }
        
        .dropdown-cart-item-content {
            flex: 1;
            min-width: 0;
        }
        
        .dropdown-cart-item-title {
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .dropdown-cart-item-price {
            font-size: 12px;
            color: #1f1f1f;
            font-weight: bold;
        }
        
        .dropdown-cart-item-quantity {
            font-size: 11px;
            color: #666;
        }
        
        .dropdown-cart-footer {
            padding: 10px;
            border-top: 1px solid #eee;
            background: #f9f9f9;
        }
        
        .dropdown-cart-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .dropdown-cart-button {
            display: block;
            text-align: center;
            padding: 8px 15px;
            background-color: #1f1f1f;
            color: #fff !important;
            font-weight: 500;
            border-radius: 3px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .dropdown-cart-button:hover {
            background-color: #444;
            color: #fff !important;
            text-decoration: none;
        }
        
        .cart-item-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 18px;
            height: 18px;
            line-height: 16px;
            text-align: center;
            background-color: #f44336;
            color: white;
            border-radius: 50%;
            font-size: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .cart-item-remove:hover {
            background-color: #d32f2f;
        }
        
        .dropdown-cart-header {
            padding: 10px;
            font-weight: bold;
            background-color: #f9f9f9;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>


<div class="main-body">
    <div class="header-main-div" style="background-color: #ffffff; font-family : 'Roboto',Sans-serif ;">
        <div class="desktop-header-area"><!-- TopHtml !-->
            <style> .topheader-html-main-in p {
                    margin-bottom: 0;
                }</style>
            <div class="topheader-html-main" id="headBar">
                <div class="topheader-html-main-in">
                    <div style="text-align: center;"><span style="font-size: 15px;">Siparişleriniz Aynı G&uuml;n Kargoda <a
                                    style="margin-left: 10px; display: inline-block;"
                                    href="" target="_blank" rel="noopener">Detaylı Bilgi &gt; </a></span>
                    </div>
                    <div class="topheader-html-close" href="javascript:void(0)" onclick="Hide(headBar);"><i
                                class="fa fa-times"></i></div>
                </div>
            </div><!--  <========SON=========>>> TopHtml SON !--> <!-- Desktop/Masaüstü Header !-->
            <div class="header-desktop-main-div">
                <div class="header-desktop-main-div-in"><!-- Logo !-->
                    <div class="header-desktop-logo-div"><a href="index.php"><img src="images/logo/84159-107-logo.png"
                                                                                  alt="Shop7 E-Ticaret"></a></div>
                    <!-- Logo SON !-->
                    <div class="header-desktop-right-area"><!-- Arama Button Tip 1 !-->
                        <!--  <========SON=========>>> Arama Button Tip 1 SON !--><!-- Çağrı Merkezi !-->
                        <!--  <========SON=========>>> Çağrı Merkezi SON !--><!-- Search type 2 !-->
                        <div class="header-desktop-navbutton-box"><a id="search-tip2-button" style=" cursor: pointer"
                                                                     class="tooltip-bottom"
                                                                     data-tooltip="Arama Yapın"><i
                                        class="las la-search"></i></a></div>
                        <!--  <========SON=========>>> Search type 2 SON !--><!-- Bell - Bildirimler !-->
                        <!--  <========SON=========>>> Bell - Bildirimler SON !--><!-- Login !-->
                        <div class="header-desktop-navbutton-box"><a href="#" class="tooltip-bottom"
                                                                     data-tooltip="Üyelik" data-toggle="dropdown"
                                                                     aria-haspopup="true" aria-expanded="false"><i
                                        class="las la-user"></i></a><!-- User NoLogin Dropdown !-->
                            <div class="dropdown-menu dropdown-menu-right user-drop">
                                <?php if($say > 0) { // Kullanıcı giriş yapmış ?>
                                <div class="dropdown-user-area">
                                    <div class="dropdown-user-area-header">
                                        <span class="dropdown-userarea-header" style="font-weight: bold; font-size: 14px; margin-bottom: 10px; display: block;">
                                            <i class="fa fa-user-circle-o"></i> Hoş geldiniz, <?php echo $kullanicicek['kullanici_adsoyad']; ?>
                                        </span>
                                    </div>
                                    <div class="dropdown-user-area-link-area">
                                        <a href="hesabim.php"><i class="fa fa-user"></i> Hesabım</a>
                                        <a href="siparislerim.php"><i class="fa fa-shopping-bag"></i> Siparişlerim</a>
                                        <a href="favorilerim.php"><i class="fa fa-heart"></i> Favori Ürünlerim</a>
                                        <a href="karsilastirmalar.php"><i class="fa fa-random"></i> Karşılaştırma Listesi&nbsp;<strong></strong></a>
                                        <a href="bildirimler.php"><i class="las la-bell"></i> Bildirimler&nbsp;<strong>(0)</strong></a>
                                        <a href="logout.php"><i class="fa fa-sign-out"></i> Güvenli Çıkış</a>
                                    </div>
                                </div>
                                <?php } else { // Kullanıcı giriş yapmamış ?>
                                <div class="dropdown-user-area">
                                    <div class="dropdown-user-area-header"><a href="uye-giris.php"
                                                                              class="button-black" style="">ÜYE GİRİŞİ
                                            YAP</a>
                                        <div class="dropdown-user-area-lineText">
                                            <div class="dropdown-user-area-lineText-in">Veya</div>
                                        </div>
                                        <a href="uye-kayit.php" class="button-green" style="">HEMEN ÜYE OL</a></div>
                                    <div class="dropdown-user-area-link-area"><a href="karsilastirmalar.php"><i
                                                    class="fa fa-random"></i> Karşılaştırma
                                            Listesi&nbsp;<strong></strong></a> <a href="favorilerim.php"><i
                                                    class="fa fa-heart"></i> Favori Ürünler Listesi</a> <a
                                                href="bildirimler.php"><i class="las la-bell"></i> Bildirimler&nbsp;<strong>(0)</strong></a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div><!--  <========SON=========>>> User NoLogin Dropdown SON !--></div>
                        <!--  <========SON=========>>> Login SON !--><!-- Favoriler !-->
                        <div class="header-desktop-navbutton-box"><a href="favoriler.php"
                                                                     class="tooltip-bottom" data-tooltip="Favoriler"><i
                                        class="lar la-heart"></i></a></div>
                        <!--  <========SON=========>>> Favoriler SON !--><!-- Sepet !-->
                        <div class="header-desktop-navbutton-box carting">
                            <a href="#" class="tooltip-bottom" data-tooltip="Sepetiniz" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="las la-shopping-cart"></i>
                                <?php
                                // Sepetteki ürün sayısını kontrol et
                                $sepet_count = 0;
                                if(isset($_SESSION['kullanici_mail'])) {
                                    $sepetsor = $db->prepare("SELECT SUM(urun_adet) as toplam FROM sepet WHERE kullanici_id=:id");
                                    $sepetsor->execute(['id' => $kullanicicek['kullanici_id']]);
                                    $sepet_count = $sepetsor->fetch(PDO::FETCH_ASSOC)['toplam'] ?? 0;
                                }
                                
                                // Sepette ürün varsa, ürün sayısını göster
                                if($sepet_count > 0) {
                                    echo '<span class="cart-count">'.$sepet_count.'</span>';
                                }
                                ?>
                            </a>
                            
                            <!-- Sepet Dropdown !-->
                            <div class="dropdown-menu dropdown-menu-right cart-drop">
                                <?php if($sepet_count > 0): 
                                    // Sepet ürünlerini getir
                                    $sepetsor = $db->prepare("SELECT s.*, u.urun_adi, u.urun_satisfiyati, u.urun_resim1, u.urun_doviz 
                                                             FROM sepet s 
                                                             INNER JOIN urun u ON s.urun_id = u.urun_id 
                                                             WHERE s.kullanici_id=:id");
                                    $sepetsor->execute(['id' => $kullanicicek['kullanici_id']]);
                                    $sepet_urunler = $sepetsor->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    // Toplam tutarı hesapla
                                    $toplam_tutar = 0;
                                    foreach($sepet_urunler as $urun) {
                                        $toplam_tutar += $urun['urun_satisfiyati'] * $urun['urun_adet'];
                                    }
                                ?>
                                <!-- Sepette ürün varsa göster -->
                                <div class="dropdown-cart-header">Sepetim (<?php echo $sepet_count; ?> Ürün)</div>
                                <div class="dropdown-cart-items">
                                    <?php foreach($sepet_urunler as $urun): ?>
                                    <div class="dropdown-cart-item">
                                        <div class="dropdown-cart-item-img">
                                            <img src="<?php echo $urun['urun_resim1']; ?>" alt="<?php echo $urun['urun_adi']; ?>">
                                        </div>
                                        <div class="dropdown-cart-item-content">
                                            <div class="dropdown-cart-item-title"><?php echo $urun['urun_adi']; ?></div>
                                            <div class="dropdown-cart-item-quantity"><?php echo $urun['urun_adet']; ?> adet</div>
                                            <div class="dropdown-cart-item-price">
                                                <?php echo number_format($urun['urun_satisfiyati'] * $urun['urun_adet'], 2, ',', '.'); ?> <?php echo $urun['urun_doviz']; ?>
                                            </div>
                                        </div>
                                        <div class="cart-item-remove" onclick="removeFromCart(<?php echo $urun['sepet_id']; ?>)">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="dropdown-cart-footer">
                                    <div class="dropdown-cart-total">
                                        <span>Toplam:</span>
                                        <span><?php echo number_format($toplam_tutar, 2, ',', '.'); ?> TL</span>
                                    </div>
                                    <a href="sepet.php" class="dropdown-cart-button">SEPETE GİT</a>
                                </div>
                                <?php else: ?>
                                <!-- Sepet boşsa mevcut tasarımı koru -->
                                <div class="dropdown-cart-noitem">
                                    <i class="ion-bag"></i>
                                    <div class="dropdown-cart-noitem-t">Alışveriş Sepetiniz Boş</div>
                                    <div class="dropdown-cart-noitem-s">Önemli fırsatlardan yararlanarak uygun fiyata alışveriş fırsatını kaçırmayın</div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <!--  <========SON=========>>> Sepet Dropdown SON !-->
                        </div>
                        <!--  <========SON=========>>> Sepet SON !--></div>
                </div>
            </div>


            <?php include 'kategoriler.php'; ?>


        </div>
    </div>
    <div class="head-search-overlay">
        <div class="search-tip2-overlay" id="mk-search-head-search-overlay"><a class="mk-fullscreen-close"
                                                                               style="color: #fff; cursor: pointer"><i
                        class="fa fa-times"></i></a>
            <div id="search-tip2-wrapper">
                <form id="search-tip2-inside" method="get" action="arama.php">
                    <input type="hidden" name="s" value="1">
                    <input type="text" name="q" placeholder="Binlerce ürün içinden arayın..." 
                           id="mk-fullscreen-search-input" autocomplete="off" required>
                    <i class="fa fa-search fullscreen-search-icon">
                        <input value="" type="submit" style="cursor: pointer">
                    </i>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Favorilere eklemek için giriş yapma uyarı modalı -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #f8f9fa; border-bottom: 3px solid #1f1f1f;">
            <h5 class="modal-title" id="loginModalLabel" style="color: #333;"><i class="fa fa-info-circle mr-2" style="color: #1f1f1f;"></i> Üyelik Gerekli</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center py-4">
            <i class="fa fa-user-circle-o fa-4x mb-3" style="color: #1f1f1f;"></i>
            <p>Bu özelliği kullanabilmek için üye girişi yapmanız gerekmektedir.</p>
            <p class="text-muted small">Üye değilseniz hemen ücretsiz kayıt olabilirsiniz.</p>
          </div>
          <div class="modal-footer" style="background-color: #f8f9fa; justify-content: center; border-top: 1px solid #e9ecef;">
            <a href="uye-giris.php" class="btn button-black button-2x" style="padding: 10px 30px;">
              <i class="fa fa-sign-in mr-1"></i> Giriş Yap
            </a>
            <a href="uye-kayit.php" class="btn button-grey-out button-2x">
              <i class="fa fa-user-plus mr-1"></i> Üye Ol
            </a>
          </div>
        </div>
      </div>
    </div>
    <script> jQuery(document).ready(function ($) {
            var wHeight = window.innerHeight;
            $('#search-tip2-inside').css('top', wHeight / 2);
            jQuery(window).resize(function () {
                wHeight = window.innerHeight;
                $('#search-tip2-inside').css('top', wHeight / 2);
            });
            $('#search-tip2-button').click(function () {
                $(document).mouseup(function (e) {
                    var container = $("#search-tip2-wrapper");
                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        $("div.search-tip2-overlay").removeClass("search-tip2-overlay-show");
                    }
                });
                console.log("Open Search, Search Centered");
                $("div.search-tip2-overlay").addClass("search-tip2-overlay-show");
            });
            $(".mk-fullscreen-close").click(function () {
                console.log("Closed Search");
                $("div.search-tip2-overlay").removeClass("search-tip2-overlay-show");
            });
        });</script>
    
    <script>
        $(document).ready(function() {
            // URL'den parametreleri al
            const urlParams = new URLSearchParams(window.location.search);
            const modal = urlParams.get('modal');
            
            // Modal gösterilmesi gerekiyorsa
            if (modal === 'login') {
                // Login modalını göster
                $('#loginModal').modal('show');
                
                // URL'den modal parametresini temizle (sayfa yenilendiğinde tekrar açılmaması için)
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
        
        // Sepetten ürün silme fonksiyonu - islem.php ile
        function removeFromCart(sepet_id) {
            if (confirm("Bu ürünü sepetten çıkarmak istediğinize emin misiniz?")) {
                // Form oluştur ve gönder
                var form = document.createElement('form');
                form.method = 'GET';
                form.action = 'settings/islem.php';
                form.style.display = 'none';
                
                var sepetsilInput = document.createElement('input');
                sepetsilInput.name = 'sepetsil';
                sepetsilInput.value = 'ok';
                form.appendChild(sepetsilInput);
                
                var sepetIdInput = document.createElement('input');
                sepetIdInput.name = 'sepet_id';
                sepetIdInput.value = sepet_id;
                form.appendChild(sepetIdInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</div>
</html>