<?php
include 'settings/baglan.php';

// vitrin tablosundan kayıt çekiliyor
$vitrinSor = $db->prepare("SELECT * FROM vitrin WHERE vitrin_dizayn = :vitrin_dizayn AND vitrin_durum = 1");
$vitrinSor->execute(['vitrin_dizayn' => 'banner_slider']);
$vitrinCek = $vitrinSor->fetch(PDO::FETCH_ASSOC);

if ($vitrinCek) { // Eğer vitrin bulunursa

// vitrin_resimleri tablosundan kayıtlar çekiliyor
$vitrinResimSor = $db->prepare("SELECT * FROM vitrin_resimleri WHERE vitrin_id = :vitrin_id ORDER BY vitrin_resim_sira ASC");
$vitrinResimSor->execute(['vitrin_id' => $vitrinCek['vitrin_id']]);

?>

    <div class="slider-main-div"
         style="width: 100%; background-color: #ffffff; overflow: hidden; margin:0px 0; border-top:1px solid #ffffff; border-bottom:1px solid #ffffff;">
        <div class="swiper-middle-container">
            <div class="swiper-wrapper">


                <?php while ($vitrinResimCek = $vitrinResimSor->fetch(PDO::FETCH_ASSOC)) { ?>

                    <div class="swiper-slide">
                        <div class="middle-slider-img">
                            <img src="<?php echo $vitrinResimCek['vitrin_resim'] ?>"
                                 alt="<?php echo $vitrinResimCek['vitrin_resim_aciklama'] ?>" style="width: 100%">
                        </div>
                        <div class="middle-slider-img-mobile">
                            <img src="<?php echo $vitrinResimCek['vitrin_resim2'] ?>"
                                 alt="<?php echo $vitrinResimCek['vitrin_resim_aciklama'] ?>">
                        </div>
                    </div>

                <?php } ?>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>


<?php } ?>