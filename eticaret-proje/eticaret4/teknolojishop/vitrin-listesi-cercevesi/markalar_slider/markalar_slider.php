<?php
include 'settings/baglan.php';

// vitrin tablosundan kayıt çekiliyor
$vitrinSor = $db->prepare("SELECT * FROM vitrin WHERE vitrin_dizayn = :vitrin_dizayn AND vitrin_durum = 1");
$vitrinSor->execute(['vitrin_dizayn' => 'markalar']);
$vitrinCek = $vitrinSor->fetch(PDO::FETCH_ASSOC);

if ($vitrinCek) { // Eğer vitrin bulunursa

// vitrin_resimleri tablosundan kayıtlar çekiliyor
$vitrinResimSor = $db->prepare("SELECT * FROM vitrin_resimleri WHERE vitrin_id = :vitrin_id ORDER BY vitrin_resim_sira ASC");
$vitrinResimSor->execute(['vitrin_id' => $vitrinCek['vitrin_id']]);

?>
    <div class="marka-module-main-div">
        <div class="marka-module-inside-area">
            <div class="swiper-clients">
                <div class="swiper-wrapper">
                    <?php while ($vitrinResimCek = $vitrinResimSor->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="swiper-slide " style="border: 1px solid #ebebeb; background-color: #ffffff;"
                             data-toggle="tooltip" data-placement="bottom"
                             title="<?php echo $vitrinResimCek['vitrin_resim_adi'] ?>">
                            <a href="urun_listeleme.php?marka=<?php echo urlencode($vitrinResimCek['vitrin_resim_adi']); ?>">
                                <img src="<?php echo $vitrinResimCek['vitrin_resim'] ?>"
                                     alt="<?php echo $vitrinResimCek['vitrin_resim_adi'] ?>">
                            </a>
                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

<?php } ?>