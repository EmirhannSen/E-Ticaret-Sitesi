    
<?php 
include 'settings/baglan.php';

$siteAyarSor=$db->prepare("SELECT * FROM ayar where ayar_id=0");
$siteAyarSor->execute();
$siteAyarCek=$siteAyarSor->fetch(PDO::FETCH_ASSOC);

$kategoriSor=$db->prepare("SELECT * FROM kategori where kategori_ust='0' and kategori_durum='1'");
$kategoriSor->execute();
$kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC);

?>



<script type="text/javascript">
  var title = document.title;
  var alttitle = "Alışverişe Devam Et";
  window.onblur = function() {
    document.title = alttitle;
  };
  window.onfocus = function() {
    document.title = title;
  };
</script>



<div class="ticaret-kutulari-main-div" style="background-color: #ffffff; border-top: 1px solid #ffffff; border-bottom: 1px solid #ffffff;">
  <div class="ticaret-kutulari-inside">
    <div class="ticaret-kutu-box">
      <div class="ticaret-kutu-box-i" style="color: #000000;">
        <i class="las la-truck"></i>
      </div>
      <div class="ticaret-kutu-box-text">
        <div class="ticaret-kutu-box-text-h" style="color: #000000;">Hızlı Kargo</div>
        <div class="ticaret-kutu-box-text-s" style="color: #000000;">Siparişinizin Ardından Anında Kargo</div>
      </div>
    </div>
    <div class="ticaret-kutu-box">
      <div class="ticaret-kutu-box-i" style="color: #000000;">
        <i class="las la-life-ring"></i>
      </div>
      <div class="ticaret-kutu-box-text">
        <div class="ticaret-kutu-box-text-h" style="color: #000000;">Canlı Destek</div>
        <div class="ticaret-kutu-box-text-s" style="color: #000000;">%100 Müşteri Memnuniyeti</div>
      </div>
    </div>
    <div class="ticaret-kutu-box">
      <div class="ticaret-kutu-box-i" style="color: #000000;">
        <i class="las la-lock"></i>
      </div>
      <div class="ticaret-kutu-box-text">
        <div class="ticaret-kutu-box-text-h" style="color: #000000;">Güvenli Ödeme</div>
        <div class="ticaret-kutu-box-text-s" style="color: #000000;">256 Bit SSL Şifreleme</div>
      </div>
    </div>
    <div class="ticaret-kutu-box">
      <div class="ticaret-kutu-box-i" style="color: #000000;">
        <i class="las la-recycle"></i>
      </div>
      <div class="ticaret-kutu-box-text">
        <div class="ticaret-kutu-box-text-h" style="color: #000000;">Ücretsiz İade</div>
        <div class="ticaret-kutu-box-text-s" style="color: #000000;">Anında Ücretsiz İade</div>
      </div>
    </div>
  </div>
</div>




<div class="footer-module-main-div">
  <div class="footer-module-inside-area">
    <!-- Logo Telif alanı !-->
    <div class="footer-module-box footer-1-area">
      <div class="footer-module-box-logo">
        <img src="<?php echo $siteAyarCek['ayar_logo'] ?>" alt="<?php echo $siteAyarCek['ayar_description'] ?>">
      </div>
      <div class="footer-module-box-telif">
    <?php echo $siteAyarCek['ayar_adres'] . ' ' .  $siteAyarCek['ayar_il'] . ' / ' .  $siteAyarCek['ayar_ilce'] ?>
  </br>
  <?php echo 'Telefon : ' .  $siteAyarCek['ayar_tel'] ?>
    </div>
      <div class="footer-module-box-social">
        <a href="<?php echo $siteAyarCek['ayar_twitter'] ?>" target="_blank" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Twitter">
          <i class="fa fa-twitter"></i>
        </a>
        <a href="<?php echo $siteAyarCek['ayar_facebook'] ?>" target="_blank" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Facebook">
          <i class="fa fa-facebook"></i>
        </a>
        <a href="<?php echo $siteAyarCek['ayar_instagram'] ?>" target="_blank" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="instagram">
          <i class="fa fa-instagram"></i>
        </a>
        <a href="<?php echo $siteAyarCek['ayar_linkedin'] ?>" target="_blank" class="iletisim-container-in-top-box-social" data-toggle="tooltip" data-placement="top" title="Linkedin">
                          <i class="fa fa-linkedin"></i>
                        </a>
        <a href="<?php echo $siteAyarCek['ayar_youtube'] ?>" target="_blank" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="YouTube">
          <i class="fa fa-youtube-play"></i>
        </a>
      </div>
      <div class="footer-module-box-telif" style="margin-top: 20px;">
        <p>&nbsp; 
          <a href="<?php echo $siteAyarCek['ayar_ios_url'] ?>" target="_blank"><img src="<?php echo $siteAyarCek['ayar_ios_logo'] ?>" alt="" width="120" height="36" /></a>
          <a href="<?php echo $siteAyarCek['ayar_android_url'] ?>" target="_blank"><img src="<?php echo $siteAyarCek['ayar_android_logo'] ?>" alt="android" /></a>
        </p>
      </div>
    </div>


    <div class="footer-module-box footer-4-area">
      <div class="footer-module-header-text d-flex align-items-center"> BAĞLANTILAR</div>
      <div class="footer-module-links-div">
        <a href="content-hakkimizda"> Hakkımızda</a>
        <a href="sss.php"> Yardım</a>
        <a href="banka-hesaplarimiz.php"> Hesap Numaralarımız</a>
        <a href="iletisim.php"> Bize Ulaşın</a>
      </div>
    </div>
    <div class="footer-module-box footer-4-area">
      <div class="footer-module-header-text d-flex align-items-center"> ÜYELİK</div>
      <div class="footer-module-links-div">
        <a target="_blank" href="uye-kayit.php"> Yeni Üyelik Formu</a>
        <a href="uye-giris.php"> Üye Girişi </a>
        <a href="content-mesafeli_satis_sozlesmesi"> Mesafeli Satış Sözleşmesi</a>
        <a href="content-kullanici_sozlesmesi"> Kullanıcı Sözleşmesi </a>
        <a href="content-iptal_ve_iade_kosullari"> İptal ve İade Koşulları </a>
        <a href="content-uyelik_sozlesmesi"> Üyelik Sözleşmesi</a>
      </div>
    </div>
    <div class="footer-module-box footer-4-area">
      <div class="footer-module-header-text d-flex align-items-center"> KATEGORİLER</div>
      <div class="footer-module-links-div">
        <?php while ($kategoriCek=$kategoriSor->fetch(PDO::FETCH_ASSOC)) {  ?>

        <a href="kategori-<?=seo($kategoriCek["kategori_ad"]).'-'.$kategoriCek["kategori_id"]?>"> <?php echo $kategoriCek['kategori_ad'] ?></a>
       <?php } ?>
      </div>
    </div>
   
    <!-- Contact SON !-->
    <div class="footer-shop-card-area">
      <img src="images/banks/bank-card.png" alt="">
    </div>
  </div>
</div>



</div>
</body>

</html>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.5/swiper-bundle.min.js'></script>
<script src='assets/js/slider/aos.js'></script>


<script src='assets/js/1_9_7_jquery.lazyload.js'></script>
<script src="assets/helper/bootstrap/js/popper.min.js"></script>
<script src="assets/helper/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/helper/other/common/common.min.js"></script>
<script src="assets/helper/other/jquery.appear/jquery.appear.min.js"></script>
<script src="assets/helper/other/theme.js"></script>
<script src="assets/helper/other/theme.init.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script src='assets/js/footerlibs.js'></script>
<script>
  /* Slider Main Carousel */
  var swiper = new Swiper('.swiper-container', {
    effect: 'slide',
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    autoplay: {
      delay: 5000,
    },
    speed: 1300,
    on: {
      slideChangeTransitionStart: function() {
        $('.slider-section').hide(0);
        $('.slider-section').removeClass('aos-init').removeClass('aos-animate');
      },
      slideChangeTransitionEnd: function() {
        $('.slider-section').show(0);
        AOS.init();
      }
    }
  });
  AOS.init(); /*  <========SON=========>>> Slider Main Carousel SON */
</script>
<script>
  var swiper = new Swiper('.swiper-product-list', {
    autoplay: {
      delay: 5000,
    },
    speed: 300,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    slidesPerView: 1,
    spaceBetween: 0,
    breakpoints: {
      0: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      400: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      415: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      600: {
        slidesPerView: 3,
        spaceBetween: 10,
      },
      768: {
        slidesPerView: 4,
        spaceBetween: 10,
      },
      800: {
        slidesPerView: 4,
        spaceBetween: 12,
      },
      1000: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 15,
      },
      1152: {
        slidesPerView: 4,
        spaceBetween: 15,
      },
      1280: {
        slidesPerView: 4,
        spaceBetween: 13,
      },
      1600: {
        slidesPerView: 4,
        spaceBetween: 13,
      },
      1920: {
        slidesPerView: 4,
        spaceBetween: 13,
      },
      2560: {
        slidesPerView: 4,
        spaceBetween: 13,
      },
    },
    /*enable auto height*/
  });
</script>
<div class="modal fade" id="varyantModal" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-sm ">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
      <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i>
        <br>
        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;">Sepete Eklenemedi!</div>
        <div>Bu ürünün seçenekleri bulunmaktadır.</div>
        <div style="font-size: 12px; margin-top: 20px; line-height: 15px!important; color: #666;">Ürünün detay sayfasına giderek seçim yapmalısınız.</div>
      </div>
      <div class="category-cart-add-success-modal-footer">
        <button type="button" class="button-blue button-2x" style="width: 100%; text-align: center; " data-dismiss="modal">Tamam</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="loginModal">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
      <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
        <i class="ion-ios-locked" style="font-size: 45px ; color: #558cff;"></i>
        <br>Ürünü favorilere ekleyebilmeniz için üye girişi yapmanız gerekmektedir.
      </div>
      <div class="category-cart-add-success-modal-footer">
        <a href="uye-girisi/index.html" class="button-2x button-blue" style="width: 100%; text-align: center; text-transform: uppercase;">ÜYE GİRİŞİ / YENİ ÜYELİK</a>
      </div>
    </div>
  </div>
</div>