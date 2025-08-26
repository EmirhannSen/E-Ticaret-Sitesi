<?php
// Database bağlantısı sağlıyoruz
include 'settings/baglan.php';

include 'header.php';

// Anasayfa sliderı
include("vitrin-listesi-cercevesi/slider/slider.php");

// Uclu Banner
include 'vitrin-listesi-cercevesi/uclu_banner/uclu_banner.php';

// Tablı vitrinler
include 'vitrin-listesi-cercevesi/tabli_vitrinler/tabli_vitrinler.php';

// Banner slider
include 'vitrin-listesi-cercevesi/banner_slider/banner_slider.php';

//Elektronik ürünler vitrini
include 'vitrin-listesi-cercevesi/vitrin_urun_slider/vitrin_elektronik_urunler.php';

// Fırsat vitrini
include 'vitrin-listesi-cercevesi/vitrin_urun_slider/vitrin_firsat_slider.php';

//Markalar vitrini
include 'vitrin-listesi-cercevesi/markalar_slider/markalar_slider.php';

include("footer.php");

?>