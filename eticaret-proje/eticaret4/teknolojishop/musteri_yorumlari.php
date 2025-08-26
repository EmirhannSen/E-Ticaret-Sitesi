<?php

include 'settings/baglan.php';
include 'header.php';


$yorumSorgu = $db->prepare("SELECT * FROM yorumlar WHERE urun_id=0 AND yorum_type='website'");
$yorumSorgu->execute();
$yorumlar = $yorumSorgu->fetchAll(PDO::FETCH_ASSOC);

if (count($yorumlar) > 0) {


    ?>

    <div id="MainDiv" style="background-color: #fff; width: 100%; font-family : 'Open Sans',Sans-serif ;  ">
        <div class="page-banner-main">
            <div class="page-banner-in-text">
                <div class="page-banner-h "> Müşterilerimizin Yorumları</div>
                <div class="page-banner-links ">
                    <a href="index.html">
                        <i class="fa fa-home"></i> Anasayfa </a>
                    <span>/</span>
                    <a> Müşterilerimizin Yorumları </a>
                </div>
            </div>
        </div>
        <div class="musteriyorum-container-main">
            <div class="musteriyorum-container-main-in">


                <?php
                foreach ($yorumlar as $yorum) {
                    $kullaniciBilgileriSor = $db->prepare("SELECT * FROM kullanicilar where kullanici_id=:kullanici_id");
                    $kullaniciBilgileriSor->execute(['kullanici_id' => $yorum['kullanici_id']]);
                    $kullaniciBilgileriCek = $kullaniciBilgileriSor->fetch(PDO::FETCH_ASSOC);
                    if ($kullaniciBilgileriCek) {
                        ?>
                        <div class="musteri-yorum-boxes">
                            <div class="yorumlar-box-img" style="border: 4px solid #CCC;">
                                <img src="<?php echo $kullaniciBilgileriCek['kullanici_resim'] ?>"
                                     alt="<?php echo $kullaniciBilgileriCek['kullanici_ad'] ?>">
                            </div>
                            <div class="yorumlar-text-area">
                                <div class="yorumlar-text-p"
                                     style="color: #666;"> <?php echo $kullaniciBilgileriCek['kullanici_unvan'] ?> </div>
                                <div class="yorumlar-text-h"
                                     style="color: #000;"> <?php echo $kullaniciBilgileriCek['kullanici_adsoyad'] ?> </div>
                                <div class="yorumlar-text-s"
                                     style="color: #333; font-size: 14px ;"> <?php echo $yorum['yorum_detay'] ?> </div>


                                <div class="yorumlar-text-star">
                                    <?php for ($i = 1; $i <= $yorum['yorum_puan']; $i++) { ?>
                                        <span style="color:#FFB400">★</span>
                                    <?php } ?>
                                </div>


                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

            </div>
        </div>
    </div>

<?php } ?>



        

