<?php
// Hata mesajlarını göstermek için
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include 'settings/baglan.php';
include 'header.php';

$siteAyarSor=$db->prepare("SELECT * FROM ayar where ayar_id=0");
$siteAyarSor->execute();
$siteAyarCek=$siteAyarSor->fetch(PDO::FETCH_ASSOC);


$urunDetaySor = $db->prepare("SELECT * FROM urun where urun_durum='1' and urun_id=:urun_id");
$urunDetaySor->execute(['urun_id' => $_GET['urun_id']]);
$urunDetayCek = $urunDetaySor->fetch(PDO::FETCH_ASSOC);

// Ürün favori durumunu kontrol et
$favoriDurum = false;
if($say > 0) {
    $favoriSor = $db->prepare("SELECT * FROM favoriler WHERE kullanici_id = :kullanici_id AND urun_id = :urun_id");
    $favoriSor->execute([
        'kullanici_id' => $kullanicicek['kullanici_id'],
        'urun_id' => $_GET['urun_id']
    ]);
    $favoriDurum = $favoriSor->rowCount() > 0;
}

$markasor=$db->prepare("SELECT * FROM marka where marka_adi=:marka_adi");
$markasor->execute(['marka_adi' => $urunDetayCek['urun_marka']]);
$markaCek = $markasor->fetch(PDO::FETCH_ASSOC);


$urunYorumlariSorgu = $db->prepare("SELECT * FROM yorumlar WHERE urun_id=:urun_id ORDER BY yorum_puan DESC");
$urunYorumlariSorgu->execute(['urun_id' => $_GET['urun_id']]);
$urunYorumlari = $urunYorumlariSorgu->fetchAll(PDO::FETCH_ASSOC);


$bankaPosTaksitSor=$db->prepare("SELECT * FROM banka_pos where bankapos_durum='1'");
$bankaPosTaksitSor->execute();
//$bankaPosTaksitCek = $bankaPosTaksitSor->fetch(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($urunDetayCek);
echo "</pre>";
die("test");
*/


?>
<style>
    .page-banner-main {
        background: #f8f8f8;
        padding: 20px 0 20px 0;
        font-family: 'Roboto', sans-serif;
        border-bottom: 1px solid #ebebeb;
        border-top: 1px solid #ebebeb;
        margin-top: 10px;
        margin-bottom: 0px;
    }

    .page-banner-in-text {
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-banner-h {
        font-size: 20px;
        color: #171717;
        font-weight: 400;
        line-height: 20px;
    }

    .page-banner-links {
        text-align: right;
        color: #000000;
    }

    .page-banner-links span {
        color: #000000;
        font-size: 13px;
    }

    .page-banner-links a {
        color: #000000;
        font-size: 13px;
    }

    .page-banner-links a:hover {
        color: #000000;
    }</style>


<div class="urun-detay-main" style="overflow: hidden;">
    <div class="page-banner-main">
        <div class="page-banner-in-text">
            <div class="page-banner-h ">
                Ürün Detayı
            </div>
            <div class="page-banner-links ">
                <a href="index.php"><i class="fa fa-home"></i> Anasayfa</a>
                <span>/</span>
                <a href="javascript:Void(0)">Ürün Detayı</a>
            </div>
        </div>
    </div>
    <div class="urun-detay-main-in">

        <div class="urun-detay-sol-alan">

            <!-- Ürün Görselleri ve Galeri !-->
            <link rel="Stylesheet" type="text/css" href="assets/css/productgallery.css"/>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"
                    type="text/javascript"></script>
            <script src="assets/js/jquery.glasscase.min.js" type="text/javascript"></script>
            <ul id="glasscase" class="gc-start">

                <!-- Ü -->
                <?php for($i=1;$i<=6;$i++) { // Burada 6 tane ürün görselini çektim.
                    if($urunDetayCek['urun_resim'.$i]) {  // eğer üründe 5 ten az resim tanımlıysa sadece tanımlı olan resimleri çektim.
                        ?>
                    <li><img src="<?php echo $urunDetayCek['urun_resim'.$i] ?>"
                             alt="Text"/></li>
                <?php } }

                // Urun resmi yok ise varsayılan olarak bir resim ekledim.
                if(empty($urunDetayCek['urun_resim1'])){
                    $urunDetayCek['urun_resim1'] = "images/product/productphotonotfound.jpg";
                    ?>
                    <li><img src="<?php echo $urunDetayCek['urun_resim1'] ?>"
                             alt="Text"/></li>
                <?php } ?>
            </ul>


            <script type="text/javascript">

                $(document).ready(function () {
                    $('#glasscase').glassCase({
                        'thumbsPosition': 'left',
                        'widthDisplay': '600',
                        'heightDisplay': '730',
                        'nrThumbsPerRow': '6'
                    });
                });

            </script>

        </div>
        <div class="urun-detay-sag-alan" style="background-color: #fff; border: 1px solid #ffffff;">
            <div class="urun-detay-sag-alan-baslik">
                <?php echo $urunDetayCek['urun_adi'] ?>
            </div>
            <div class="urun-detay-sag-alan-iliskili-kat">
                <a href="akilli-telefonlar/">Akıllı Telefonlar</a>
                <i class="fa fa-angle-right"></i>
                <a href="galaxy/">Galaxy</a>
            </div>

            

            <div class="urun-detay-baslik-alti">


                <?php if (!empty($urunYorumlari) && is_array($urunYorumlari)) {
                    // Ürün yorumları varsa ve gelen data bir dizi ise, üründeki yorumları gösteriyorum
                    ?>
                    <div class="urun-detay-sag-alan-yildiz">
                        <?php
                        // Ortalama puanı hesaplıyorum
                        $toplamPuan = 0;
                        foreach ($urunYorumlari as $yorum) {
                            $toplamPuan += $yorum['yorum_puan'];
                        }
                        $ortalamaPuan = count($urunYorumlari) > 0 ? ceil($toplamPuan / count($urunYorumlari)) : 0;

                        // Ortalama puana göre yıldız gösterimi
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $ortalamaPuan) {
                                // Dolu yıldız
                                echo '<span style="color:#ffb400">★</span>';
                            } else {
                                // Boş yıldız
                                echo '<span style="color:#CCC">★</span>';
                            }
                        }
                        ?>
                        <a href="#tabs-comments" class="scroll" rel="#tabs-comments" style="color: #000; margin-left: 10px;">
                            <!-- Üründe kaç tane yorum var ise count ile yorum sayısını gösteriyorum -->
                            <span style="font-size: 13px; color: #777;">(
                <span style="font-weight: bold;"><?php echo count($urunYorumlari); ?></span> Değerlendirme)
            </span>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="urun-detay-sag-alan-yildiz">
                        <?php
                        // Hiç yorum yoksa 5 boş yıldız gösteriliyor
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<span style="color:#CCC">★</span>';
                        }
                        ?>
                        <a href="#tabs-comments" class="scroll" rel="#tabs-comments" style="color: #000; margin-left: 10px;">
            <span style="font-size: 13px; color: #777;">(
                <span style="font-weight: bold;">0</span> Değerlendirme)
            </span>
                        </a>
                    </div>
                <?php } ?>


                <!-- Burada ürünü sosyal medyada paylaşma butonları bulunuyor start
                Bunlar dinamik hale getirilecek -->
                <div class="urun-detay-social">
                    <a href="https://www.facebook.com/sharer.php?u=http://localhost/eticaret/teknolojishop/urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>"
                       onClick="return popup(this, 'notes')"><i aria-hidden="true" data-toggle="tooltip"
                                                                data-placement="bottom" title="Sosyal Medya'da Paylaş"
                                                                class="fa fa-facebook"></i></a>
                    <a href="https://twitter.com/intent/tweet?url=http://localhost/eticaret/teknolojishop/urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>"
                       onClick="return popup(this, 'notes')"><i class="fa fa-twitter" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Sosyal Medya'da Paylaş"></i></a>
                    <a href="http://www.linkedin.com/shareArticle?mini=true&url=http://localhost/eticaret/teknolojishop/urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>"
                       onClick="return popup(this, 'notes')"><i class="fa fa-linkedin" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Sosyal Medya'da Paylaş"></i></a>
                    <a href="https://www.pinterest.com/pin/create/button/?url=http://localhost/eticaret/teknolojishop/urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>"
                       onClick="return popup(this, 'notes')"><i class="fa fa-pinterest-p" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Sosyal Medya'da Paylaş"></i></a>
                    <a href="https://api.whatsapp.com/send?text=Galaxy Note10 http://localhost/eticaret/teknolojishop/urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>"
                       target="_blank"><i class="fa fa-whatsapp" data-toggle="tooltip" data-placement="bottom"
                                          title="Sosyal Medya'da Paylaş"></i></a>
                </div>
                <!-- Burada ürünü sosyal medyada paylaşma butonları bulunuyor end -->


            </div>

            <!-- Üründe tanımlı olan marka görselini ve url si start -->
            <div class="urun-detay-sag-alan-d-bilgiler-box">
                <a target="_blank" href="urun_listeleme.php?marka=<?php echo urlencode($markaCek['marka_adi']); ?>" data-toggle="tooltip" data-placement="right"
                   title="<?php echo $markaCek['marka_adi'] ?>">
                    <img src="<?php echo $markaCek['marka_resim'] ?>" alt="">
                </a>
            </div>
            
             <!-- Üründe tanımlı olan marka görselini ve url si end -->

            <!-- Marka bilgisi kısmı -->
            <div class="product-info-cell">
                <span class="product-info-label">Marka:</span>
                <span class="product-info-value">
                    <a href="urun_listeleme.php?marka=<?php echo urlencode($urunDetayCek['urun_marka']); ?>">
                        <?php echo $urunDetayCek['urun_marka']; ?>
                    </a>
                </span>
            </div>

            <!-- Diğer Bilgiler !-->
            <div class="urun-detay-sag-alan-d-bilgiler">

                <div class="urun-detay-sag-alan-d-bilgiler-box">
                    Ürün Kodu : <strong><?php echo $urunDetayCek['urun_kodu'] ?></strong>
                </div>
                <div class="urun-detay-sag-alan-d-bilgiler-box">
                    Stok Durumu :
                    <?php if($urunDetayCek['urun_stok']) {  //ürün stokta var ise Mevcut olarak yazıyoruz
                        ?>
                    <span style="color:var(--green); font-weight: 600;">Mevcut</span>
                    <?php } else {  //ürün stokta yok ise Stokta Yok olarak yazıyoruz
                        ?>
                        <span style="color:var(--red); font-weight: 600;" >Stokta Yok</span>
                    <?php } ?>

                </div>
                <div class="urun-detay-sag-alan-d-bilgiler-box">
                </div>
            </div>
            <!-- Diğer Bilgiler SON !-->



            <!-- Stok var ise ürün fiyatını, sepete ekleme butonunu gösteriyoruz
             Stok varsa Fiyat Herkese Açıktır.
             Ürünün mevcut fiyatı -->
            <?php if($urunDetayCek['urun_stok']) { // Stok varsa ürün fiyatını göster
                ?>

                <?php if ($urunDetayCek['urun_piyasafiyati'] > 0.00) { //piyasa fiyatı varsa
                    $indirimOrani = (100 - ($urunDetayCek['urun_satisfiyati'] / $urunDetayCek['urun_piyasafiyati']) * 100);
                    $indirimTutari = $urunDetayCek['urun_piyasafiyati'] - $urunDetayCek['urun_satisfiyati'];
                    ?>
                    <div class="urun-detay-sag-alan-fiyatlar">
                        <div class="urun-detay-sag-alan-fiyat-sol">
                            <span>Önceki Fiyat</span>
                            <span>:</span>
                        </div>
                        <div class="urun-detay-sag-alan-fiyat-sag" style="text-decoration:line-through"> <?php echo $urunDetayCek['urun_piyasafiyati'] .' ' . $urunDetayCek['urun_doviz'] ?> </div>
                    </div>
                    <div class="urun-detay-sag-alan-fiyatlar">
                        <div class="urun-detay-sag-alan-fiyat-sol">
    <span style="font-weight: bold;">
      <i class="fa fa-tag"></i> İndirimli Fiyatı <br>(KDV Dahil) </span>
                            <span>:</span>
                        </div>
                        <div class="urun-detay-sag-alan-fiyat-sag" style="font-size:23px ; font-weight: bold; color: #000; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span id="item-price"><?php echo $urunDetayCek['urun_satisfiyati'] .' ' . $urunDetayCek['urun_doviz'] ?></span>
                            </div>
                            <span class="btn btn-sm btn-danger kazanc-mobil-div">
      <i class="fa fa-arrow-down"></i> % <?php echo round($indirimOrani, 2) ?> İndirim <br>
      <span id="item-price"><?php echo round($indirimTutari, 2) ?></span> TL Kazanç </span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="urun-detay-sag-alan-fiyatlar">
                    <div class="urun-detay-sag-alan-fiyat-sol">
                        <span style="font-weight: bold;">Ürünün Fiyatı <br>(KDV Dahil)</span>
                        <span>:</span>
                    </div>

                    <div class="urun-detay-sag-alan-fiyat-sag" style="font-size:23px ; font-weight: bold; color: #000; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <!-- Ürün fiyatını yazıyorum -->
                            <span id="item-price"><strong><?php echo $urunDetayCek['urun_satisfiyati'] .' ' . $urunDetayCek['urun_doviz'] ?></span>
                        </div>
                    </div>
            </div>
                <?php } ?>

                <!-- Ürünün mevcut fiyatı SON !-->





            <!-- Taksit Seçeneğe Git !-->
            <div style="width: 100%;  margin: 10px 0; padding: 10px 0;  font-size: 14px ; ">
                <i class="fa fa-credit-card"></i>
                <a style="font-weight: bold; color: #000;" href="#tabs-taksitler" rel="#tabs-taksitler" class="scroll">
                    Taksit Seçeneklerini Görün </a>
            </div>


            <!-- Ürün Ek Detay Kutuları !-->
            <div class="urun-detay-sag-alan-ek-bilgiler">
                <div class="urun-detay-sag-alan-ek-bilgiler-box">
                    <i class="fa fa-gift"></i> Ücretsiz Kargo
                </div>
            </div>

            <!-- Son ürünler Uyarısı Start
            Burada ürün stoğu ayar tablosundaki default_kritik_stok değerine eşit veya küçük ise Son Ürünler Uyarısı veriyoruz
            -->
            <?php if($urunDetayCek['urun_stok'] <= $siteAyarCek['default_kritik_stok']) { ?>
            <div style="width: 100%; display: flex ; margin-top: 20px; ">
                <div class="alert alert-danger" style="font-size: 13px; border:1px solid #DFB0B5; padding: 4px 15px; width: auto; margin: 0;  ">
                    <strong><?php echo $urunDetayCek['urun_stok'] ?></strong> Adet Kaldı! Acele Et!                                        </div>
            </div>
            <?php } ?>
            <!-- Son ürünler Uyarısı End !-->



            <!--  <========Start=========>>> Sepete EKle Butonu henüz dinamik yapılmadı  !-->
            <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
            <form action="settings/islem.php" method="post" id="entercancel">
                <input name="kullanici_id" type="hidden" value="<?php echo $kullanicicek['kullanici_id'] ?>">
                <div class="urun-detay-sag-alan-sepet">
                    <!-- Sepete EKle Button !-->
                    <div class="urun-detay-sag-alan-sepet-box">
                        <input name="urun_id" type="hidden" value="<?php echo $urunDetayCek['urun_id'] ?>">
                        <div class="quantity">
                            <input type="number" min="1" max="15" step="1" value="1" name="quantity">
                        </div>
                    </div>
                    <div class="urun-detay-sag-alan-sepet-box">
                        <button type="submit" name="sepetekle" class=" button-black ">
                            SEPETE EKLE
                        </button>
                    </div>
            </form>

            <!--  <========SON=========>>> Sepete EKle Button SON !-->

        </div>
        <?php } else { // Ürün stoğu yoksa fiyat ve sepete ekleme butonlarını göstermeden kullanıcıya stok yok uyarısı veriyoruz
                ?>
            <div class="urun-detay-sag-alan-no-stok">
                <i class="fa fa-info-circle"></i> Bu ürün geçici olarak temin edilememektedir</div>
        <?php } ?>

        <!-- Disabled button !-->
        <script>
            $('#orderForm').bind('submit', function (e) {
                var button = $('#btnSubmit');
                button.prop('disabled', true);
                var valid = true;
                if (!valid) {
                    e.preventDefault();
                    button.prop('disabled', false);
                }
            });
        </script>
        <!--  <========SON=========>>> Disabled button SON !-->


        <!-- Stok varsa SON !-->


        <!-- Favorilere ekle ve karşılaştırma butonu START -->
        <div class="urun-detay-sag-alan-urun-islemler-main">
            <?php if($say > 0): // Kullanıcı giriş yapmış ?>
                <?php if($favoriDurum): ?>
                    <a href="favorilerim.php?urun_id=<?php echo $urunDetayCek['urun_id']; ?>&islem=cikar" class="fav-a">
                        <i class="fa fa-heart" style="color: #e74c3c;"></i> <span>Favorilerimden Çıkar</span>
                    </a>
                <?php else: ?>
                    <a href="favorilerim.php?urun_id=<?php echo $urunDetayCek['urun_id']; ?>&islem=ekle" class="fav-a">
                        <i class="fa fa-heart-o"></i> <span>Favorilere Ekle</span>
                    </a>
                <?php endif; ?>
            <?php else: // Kullanıcı giriş yapmamış ?>
                <a href="#" class="fav-a" data-toggle="modal" data-target="#favModal">
                    <i class="fa fa-heart-o"></i> <span>Favorilere Ekle</span>
                </a>
            <?php endif; ?>

            <a href="#" class="karsilastir-product product-compare" data-code="<?php echo $urunDetayCek['urun_kodu'] ?>">
                <i class="fa fa-random"></i> <span>Karşılaştırma Listesine Ekle</span>
            </a>
        </div>
        <!--  <========SON=========>>> Favorilere ekle ve karşılaştırma butonu SON !-->
    </div>
</div>
<!-- Yorumlar ile alakalı modal ve alert kodları SON !-->
<!-- Üye Girişi Modal !-->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg ">
            <div class="modal-in-login">
                <a type="button" class="close" data-dismiss="modal"
                   style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                    &times;
                </a>
                <div class="modal-in-login-head">
                    <div class="modal-in-login-head-h">
                        <div class="modal-in-login-head-h-text">
                            Üye Girişi
                        </div>
                    </div>
                    <div class="modal-in-login-head-s">
                        İşlem yapabilmek için üye girişi gereklidir
                    </div>
                </div>
                <div class="modal-in-login-form teslimat-form-area">
                    <form action="productloginpage" method="post">
                        <input type="hidden" name="return_product" value="galaxy-note10">
                        <input type="hidden" name="return_id" value="575">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="emailadress" style="font-weight: 600;">* E-Posta Adresiniz</label>
                                <input type="email" name="emailadress" id="emailadress" required class="form-control"
                                       autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="password" style="font-weight: 600;">* Şifreniz</label>
                                <input type="password" name="password" id="password" required class="form-control"
                                       autocomplete="off">
                            </div>
                            <div class="form-group col-md-4 ">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="rememberme" value="rememberme"
                                           class="custom-control-input" id="rememberme">
                                    <label class="custom-control-label" for="rememberme"
                                           style="font-size: 14px !important ;  ">
                                        Beni Hatırla </label>
                                </div>
                            </div>
                            <div class="form-group col-md-8" style="text-align: right;">
                                <a class="modal-in-login-form-reset-password" href="sifremi-unuttum.php" target="_blank">Şifremi
                                    Unuttum!</a>
                            </div>
                            <div class="form-group col-md-12 " style="margin-top: 20px;">
                                <button name="userlogin" class="button-blue button-2x" style="width: 100%;  ">GİRİŞ
                                    YAP
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-in-login-foot">
                    <div class="modal-in-login-head-h">
                        <div class="modal-in-login-head-h-text">
                            Yeni Üyelik
                        </div>
                    </div>
                    <div class="modal-in-login-head-s" style="margin-bottom: 15px;">
                        Üyeliğiniz yok mu? Hemen aşağıdaki butona tıklayarak kolaylıkla üye olabilirsiniz
                    </div>
                    <a href="uye-kayit.php" class="button-green button-2x"
                       style="width: 100%; text-align: center; ">HEMEN ÜYE OL</a>
                </div>

            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="favModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"
                    style="color: #000; position: absolute; right: 10px; top: 5px;">&times;
            </button>
            <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                <i class="ion-ios-locked" style="font-size: 45px ; color: #558cff;"></i><br>
                Ürünü favorilere ekleyebilmeniz için üye girişi yapmanız gerekmektedir.
            </div>
            <div class="category-cart-add-success-modal-footer">
                <a href="uye-giris.php" class="button-2x button-blue"
                   style="width: 100%; text-align: center; text-transform: uppercase;">ÜYE GİRİŞİ / YENİ ÜYELİK</a>
            </div>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Favori Uyarı Popup SON !-->


<!-- Yorumlar ile alakalı modal ve alert kodları SON !-->
<div class="urun-detay-desc-main" style="margin-top: 0;">

    <!-- <div id="tabs-comments"></div>
    <div id="tabs-taksitler"></div>!-->

    <div id="urundetaytabs">
        <ul>

          

            <li><a href="#tabs-comments">Yorumlar (<?php echo count($urunYorumlari); ?>)</a></li>

            <!-- Taksit TAB Başlık Herkese Açık !-->
            <li><a href="#tabs-taksitler">Taksit Seçenekleri</a>
            </li>
     

        </ul>
        <div id="tabs-aciklama">
        </div>

        <!-- Yorumlar Menüsü  !-->
        <div id="tabs-comments">
            <div class="product-comment-head">
                <?php if($say > 0): // Kullanıcı giriş yapmış ?>
                <!-- Giriş yapan kullanıcı için yorum formu -->
                <div class="product-comment-head-1">
                    <div class="product-comment-head-1-h">
                        Yorum Yapın
                    </div>
                    <form action="nedmin/netting/islem.php" method="POST">
                        <div class="form-group">
                            <textarea name="yorum_detay" class="form-control" placeholder="Yorumunuzu yazın..." rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Puanınız</label>
                            <select name="yorum_puan" class="form-control" required>
                                <option value="5">5 Yıldız - Çok İyi</option>
                                <option value="4">4 Yıldız - İyi</option>
                                <option value="3">3 Yıldız - Orta</option>
                                <option value="2">2 Yıldız - Kötü</option>
                                <option value="1">1 Yıldız - Çok Kötü</option>
                            </select>
                        </div>
                        <input type="hidden" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id']; ?>">
                        <input type="hidden" name="urun_id" value="<?php echo $urunDetayCek['urun_id']; ?>">
                        <input type="hidden" name="gelen_url" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
                        <button type="submit" name="yorumkaydet" class="button-blue button-2x">Yorumu Gönder</button>
                    </form>
                </div>
                <?php else: // Kullanıcı giriş yapmamış ?>
                <div class="product-comment-head-1">
                    <div class="product-comment-head-1-h">
                        Yorum Yapın
                    </div>
                    <div class="product-comment-head-1-s">
                        Yorum yapabilmek için üye girişi yapılması zorunludur
                    </div>
                    <div class="product-comment-head-1-btn">
                        <div style="cursor: pointer; font-weight: 700 !important;" class="button-black button-2x"
                             data-toggle="modal" data-target="#LoginModal">ÜYE GİRİŞİ / YENİ ÜYELİK
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Ürün yorumlarını gösterme bölümü (giriş durumuna bakılmaksızın) -->
                <div class="product-comment-head-2">
                    <div class="product-comment-head-2-img">
                        <!-- Ürün görselini göster  !-->
                        <img src="<?php echo $urunDetayCek['urun_resim1'] ?>">
                    </div>

                    <div class="product-comment-head-2-ot">
                        <div class="product-comment-head-2-ot-1">
                            <!-- Üründe tanımlı olan yorumların sayısını listele  !-->
                            <?php echo count($urunYorumlari); ?> değerlendirme ve yorum
                        </div>
                        <?php if(count($urunYorumlari) == 0) {
                            // Ürün yorumları sayısı 0 ise yani kayıtlı ürün yorumu yok ise yorum yapılmamış uyarısı veriyoruz
                            ?>
                        <div class="product-comment-head-2-ot-2">
                            Bu ürün için değerlendirme yapılmamış!
                        </div>
                        <?php } else { ?>
                        <div class="product-comment-head-2-ot-4">
                            <?php
                            // Ortalama puanı hesapla
                            $toplamPuan = 0;
                            foreach ($urunYorumlari as $yorum) {
                                $toplamPuan += $yorum['yorum_puan'];
                            }
                            $ortalamaPuan = $toplamPuan / count($urunYorumlari);
                            
                            // Ortalama puanı göster
                            echo '<div style="font-size: 16px; font-weight: bold; margin: 5px 0;">Ortalama Puan: ' . number_format($ortalamaPuan, 1) . '/5</div>';
                            
                            // Yıldız gösterimi (sadece bir satır)
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= round($ortalamaPuan)) {
                                    echo '<span style="color:#ffb400; font-size: 18px;">★</span>'; // Dolu yıldız
                                } else {
                                    echo '<span style="color:#CCC; font-size: 18px;">★</span>'; // Boş yıldız
                                }
                            }
                            
                            // İsteğe bağlı: Yıldız dağılımı
                            echo '<div style="margin-top: 10px; font-size: 13px;">';
                            for ($i = 5; $i >= 1; $i--) {
                                $count = 0;
                                foreach ($urunYorumlari as $yorum) {
                                    if ($yorum['yorum_puan'] == $i) {
                                        $count++;
                                    }
                                }
                                $yuzde = (count($urunYorumlari) > 0) ? ($count / count($urunYorumlari) * 100) : 0;
                                echo '<div style="display: flex; align-items: center; margin: 2px 0;">';
                                echo '<span style="width: 60px;">' . $i . ' Yıldız:</span>';
                                echo '<div style="width: 100px; background: #eee; height: 8px; margin: 0 10px;">';
                                echo '<div style="width: ' . $yuzde . '%; background: #ffb400; height: 8px;"></div>';
                                echo '</div>';
                                echo '<span>' . $count . '</span>';
                                echo '</div>';
                            }
                            echo '</div>';
                            ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div></div>
                <!-- Tüm yorumların listelendiği bölüm -->
                <div class="product-comments-list" style="margin-top: 30px;">
                    <h3>Ürün Yorumları</h3>
                    <?php if(count($urunYorumlari) > 0): ?>
                        <?php foreach($urunYorumlari as $yorum): ?>
                            <?php 
                            // Yorum yapan kullanıcının bilgilerini çek
                            $kullaniciBilgileriSor = $db->prepare("SELECT * FROM kullanicilar where kullanici_id=:kullanici_id");
                            $kullaniciBilgileriSor->execute(['kullanici_id' => $yorum['kullanici_id']]);
                            $kullaniciBilgileriCek = $kullaniciBilgileriSor->fetch(PDO::FETCH_ASSOC);
                            if ($kullaniciBilgileriCek):
                            ?>
                            <div class="comment-item" style="border-bottom: 1px solid #eee; padding: 15px 0;">
                                <div class="comment-user">
                                    <strong><?php echo $kullaniciBilgileriCek['kullanici_adsoyad']; ?></strong>
                                    <span class="comment-date"><?php echo date('d.m.Y', strtotime($yorum['yorum_zaman'])); ?></span>
                                </div>
                                <div class="comment-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $yorum['yorum_puan']): ?>
                                            <span style="color:#ffb400">★</span>
                                        <?php else: ?>
                                            <span style="color:#CCC">★</span>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="comment-text">
                                    <?php echo $yorum['yorum_detay']; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Bu ürün için henüz yorum yapılmamış.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>



        <!--  <========START=========>>> Taksitler !-->
        <div id="tabs-taksitler">
            <div class="taksitler-main-div">


                <!--  banka_pos tablosundan sanal posları çekiyoruz !-->
                <?php while($bankaPosTaksitCek = $bankaPosTaksitSor->fetch(PDO::FETCH_ASSOC)) { $i=2; ?>
                <div class="taksitler-boxes">
                    <div class="taksitler-boxes-img">
                        <!--  sanal pos görselini ve adını yazıyoruz !-->
                        <img src="<?php echo $bankaPosTaksitCek['bankapos_resim'] ?>" alt="<?php echo $bankaPosTaksitCek['bankapos_adi'] ?>">
                    </div>
                    <div class="taksitler-boxes-aylar-white">
                        <div class="taksitler-ic-div" style="padding: 0;font-weight: 600; font-size: 13px;">Taksit
                            Tutarı
                        </div>
                        <div class="taksitler-ic-div" style="padding: 0;font-weight: 600; font-size: 13px;">Toplam
                            Tutar
                        </div>
                    </div>

<?php

for ($a=1; $a <= $bankaPosTaksitCek['bankapos_taksit_sayisi']; $a++) { // banka_pos tablosunda bankada bulunan taksit sayısı kadar satır ekliyoruz

if($bankaPosTaksitCek['bankapos_taksit'.$a] > 0.00) {  // taksit oranı 0 dan büyükse taksit leri hesaplayacağız


$taksitTutari=((($urunDetayCek['urun_satisfiyati']*$bankaPosTaksitCek['bankapos_taksit'.$a])/100));
// Ürün atış fiyatı * taksit oranı / 100
$taksitliUrunToplamFiyati=round(($urunDetayCek['urun_satisfiyati'] + $taksitTutari),2);
// SAtış fiyatına hesapladığımız taksit tutarını ekleyerek virgülden sonra 2 haneyi alıyoruz
$aylikTaksitTutari=round(($taksitliUrunToplamFiyati/$a),2);
// Aylık taksit tutarını hesaplamak içinde taksitli toplam ürün fiyaını taksit sayısına bölüyoruz ve yine virgülden sonra iki hane alıyoruz.

    ?>

                    <div class="taksitler-boxes-aylar-main">
                        <div class="taksitler-ic-div"><strong><?php echo $a ?></strong> x
                            <!-- Aylık taksit tutarını yazıyoruz -->
                            <?php echo $aylikTaksitTutari ?> TL
                        </div>
                        <div class="taksitler-ic-div">
                            <!-- Secilecek taksite göre toplam ürün fiyatını yazıyoruz -->
                            <?php echo $taksitliUrunToplamFiyati ?> TL
                        </div>
                    </div>
<?php } } ?>


                </div>
               

<?php $i++; } ?>







            </div>
        </div>


    </div>
   

</div>
<!-- </div>



</body>
</html> -->
<script src='assets/js/jquery.magnific-popup.min.js'></script>
<script src="assets/js/lightbox/lightbox.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js'></script>

<?php include 'footer.php'; ?>
<!--</div> -->
