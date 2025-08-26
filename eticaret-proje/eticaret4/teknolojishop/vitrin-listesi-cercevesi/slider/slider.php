<?php 
include 'settings/baglan.php';

// vitrin tablosundan kayıt çekiliyor
$sliderSor = $db->prepare("SELECT * FROM vitrin WHERE vitrin_dizayn = :vitrin_dizayn AND vitrin_durum = 1");
$sliderSor->execute(['vitrin_dizayn' => 'slider_display1']);
$sliderCek = $sliderSor->fetch(PDO::FETCH_ASSOC);

if ($sliderCek) { // Eğer vitrin bulunursa

// vitrin_resimleri tablosundan kayıtlar çekiliyor
$sliderResimSor = $db->prepare("SELECT * FROM vitrin_resimleri WHERE vitrin_id = :vitrin_id ORDER BY vitrin_resim_sira ASC");
$sliderResimSor->execute(['vitrin_id' => $sliderCek['vitrin_id']]);

?>
    
    <div class="slider-main-div" style="width: 100%; background-color: #ffffff; overflow: hidden;">
      <div class="swiper-container">
        <div class="swiper-wrapper">

            <?php while ($sliderResimCek = $sliderResimSor->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="swiper-slide slide-top-desktop" style="background-image:url(<?php echo $sliderResimCek['vitrin_resim'] ?>); background-size: cover !important; background-position: top center;">
                    <a href="<?php echo $sliderResimCek['vitrin_resim_url'] ?>" style="position:absolute; width: 100%; height: 100%; z-index: 9;"></a>
                </div>
                <div class="swiper-slide slide-top-mobile" style="background-image:url(<?php echo $sliderResimCek['vitrin_resim'] ?>); background-size: cover !important; background-position: top center;">
                    <a href="<?php echo $sliderResimCek['vitrin_resim_url'] ?>" style="position:absolute; width: 100%; height: 100%; z-index: 9;"></a>
                </div>
            <?php } ?>

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <?php 
}


?>
