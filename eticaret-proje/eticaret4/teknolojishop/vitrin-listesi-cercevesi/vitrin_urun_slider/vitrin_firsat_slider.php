<?php
include 'settings/baglan.php';

// vitrin tablosundan kayıt çekiliyor
$vitrinSor = $db->prepare("SELECT * FROM vitrin WHERE vitrin_dizayn = :vitrin_dizayn AND vitrin_durum = 1");
$vitrinSor->execute(['vitrin_dizayn' => 'firsat_vitrin_banner']);
$vitrinCek = $vitrinSor->fetch(PDO::FETCH_ASSOC);
/*
echo "<pre>";
print_r($vitrinCek);   
echo "</pre>"; 
*/
if ($vitrinCek) { // Eğer vitrin bulunursa

    $vitrinResimSor = $db->prepare("SELECT * FROM vitrin_resimleri WHERE vitrin_id = :vitrin_id");
    $vitrinResimSor->execute(['vitrin_id' => $vitrinCek['vitrin_id']]);
    $vitrinResimCek = $vitrinResimSor->fetch(PDO::FETCH_ASSOC);

// vitrin_urun tablosundan kayıtlar çekiliyor
    $vitrinUrunSor = $db->prepare("SELECT * FROM vitrin_urun WHERE vitrin_id = :vitrin_id ORDER BY vitrin_urun_sira ASC");
    $vitrinUrunSor->execute(['vitrin_id' => $vitrinCek['vitrin_id']]);


    ?>


    <div class="group-urun-module-main-div">
        <div class="group-urun-module-inside-area">
            <div class="urun-kutulari-main">
                <div class="group-product-main-box">
                    <a href="<?php echo $vitrinResimCek['vitrin_resim_url'] ?>" style="color: #000000;">
                        <div class="group-product-main-box-img ">
                            <img src="<?php echo $vitrinResimCek['vitrin_resim'] ?>"
                                 alt="<?php echo $vitrinCek['vitrin_adi'] ?>">
                        </div>
                    </a>
                    <div class="group-product-main-box-container">
                        <div class="group-product-main-box-container-header">
                            <div class="group-product-main-box-container-header-left">
                                <div class="group-product-main-box-container-header-left-h"
                                     style="color: #000000;"> <?php echo $vitrinCek['vitrin_adi'] ?> </div>
                                <div class="group-product-main-box-container-header-left-s"
                                     style="color: #999999;"> <?php echo $vitrinCek['vitrin_aciklama'] ?> </div>
                            </div>
                        </div>
                        <div class="group-product-main-box-container-boxex">
                            <!-- Ürün Kutu standart !-->
                            <!--  <========SON=========>>> Ürün Kutu standart SON !-->
                            <!-- Ürün Kutu Slider !-->
                            <div class="swiper-product-list"
                                 style="height: auto !important; padding-top: 20px; padding-bottom: 20px;">
                                <div class="swiper-wrapper">


                                    <?php while ($vitrinUrunCek = $vitrinUrunSor->fetch(PDO::FETCH_ASSOC)) {

                                        $urunDetaySor = $db->prepare("SELECT * FROM urun WHERE urun_id = :urun_id AND urun_durum='1'");
                                        $urunDetaySor->execute(['urun_id' => $vitrinUrunCek['urun_id']]);
                                        $urunDetayCek = $urunDetaySor->fetch(PDO::FETCH_ASSOC);

                                        /*echo "<pre>";
                                        print_r($urunDetayCek);
                                        echo "</pre>"; */
                                        ?>


                                        <div class="swiper-slide" style=" height: 100% !important;">
                                            <div class="cat-detail-products-box-caturunvitrin"
                                                 style="width: 100%; margin:0; height: 100% !important ">
                                                <div class="cat-detail-products-box-cart-1">

                                                    <?php if ($urunDetayCek['urun_stok']) { ?>
                                                        <form action="settings/islem.php"
                                                              method="post">
                                                            <input name="urun_id" type="hidden" value="<?php echo $urunDetayCek['urun_id'] ?>">
                                                            <input name="kullanici_id" type="hidden"
                                                                   value="<?php echo $kullanicicek['kullanici_id'] ?>">
                                                            <input name="quantity" type="hidden" value="1">
                                                            <button name="sepetekle" class="tooltip-right"
                                                                    data-tooltip="SEPETE EKLE">
                                                                <i class="fa fa-shopping-basket"></i>
                                                            </button>
                                                        </form>
                                                    <?php } ?>

                                                    <?php if ($say > 0): // Kullanıcı giriş yapmış ?>
                                                        <a href="favorilerim.php?urun_id=<?php echo $urunDetayCek['urun_id'] ?>&islem=ekle"
                                                           class="tooltip-right" data-tooltip="Favorilere Ekle">
                                                            <i class="fa fa-heart-o"></i>
                                                        </a>
                                                    <?php else: // Kullanıcı giriş yapmamış ?>
                                                        <a href="#" data-toggle="modal" data-target="#loginModal"
                                                           class="tooltip-right" data-tooltip="Favorilere Ekle">
                                                            <i class="fa fa-heart-o"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="#" class="tooltip-right product-compare"
                                                       data-code="<?php echo $urunDetayCek['urun_kodu'] ?>"
                                                       data-tooltip="Karşılaştırmaya Ekle">
                                                        <i class="fa fa-random"></i>
                                                    </a>
                                                </div>


                                                <div class="cat-detail-products-box-caturunvitrin-img ">
                                                    <a href="urun-<?= seo($urunDetayCek["urun_adi"]) . '-' . $urunDetayCek["urun_id"] ?>">
                                                        <img src="<?php echo $urunDetayCek['urun_resim1'] ?>"
                                                             alt="<?php echo $urunDetayCek['urun_adi'] ?>">
                                                    </a>
                                                </div>
                                                <div class="cat-detail-products-box-caturunvitrin-info">
                                                    <div class="cat-detail-products-box-marka">
                                                        <a href="marka/apple/index.html"
                                                           style="color: #000000;"><?php echo $urunDetayCek['urun_marka'] ?></a>
                                                    </div>
                                                    <div class="cat-detail-products-box-caturunvitrin-h">
                                                        <a href="urun-<?= seo($urunDetayCek["urun_adi"]) . '-' . $urunDetayCek["urun_id"] ?>"
                                                           style="color: #000000;"><?php echo $urunDetayCek['urun_adi'] ?></a>
                                                    </div>
                                                </div>

                                                <?php if ($urunDetayCek['urun_stok']) { // ürün stoğu varsa?>
                                                    <div class="cat-detail-products-box-caturunvitrin-fiyat">

                                                        <div class="cat-detail-products-box-fiyat-out">
                                                            <?php if ($urunDetayCek['urun_piyasafiyati'] > 0.00) { //piyasa fiyatı varsa?>
                                                                <div class="cat-detail-products-box-fiyat-eski"
                                                                     style="color: #b0b0b0;">
                                                                    <span id="item-price"><?php echo $urunDetayCek['urun_piyasafiyati'] . ' ' . $urunDetayCek['urun_doviz'] ?></span>
                                                                </div>
                                                            <?php } ?>
                                                            <!-- Piyasa fiyatı yoksa sadece ürün fiyatı yazılacak -->
                                                            <div class="cat-detail-products-box-fiyat-mevcut"
                                                                 style="color: #000000; ">
                                                                <span id="item-price"><?php echo $urunDetayCek['urun_satisfiyati'] . ' ' . $urunDetayCek['urun_doviz'] ?></span>
                                                            </div>

                                                        </div>

                                                        <?php if ($urunDetayCek['urun_piyasafiyati'] > 0.00) { // piyasa fiyatı var ise indirim oranı hesaplanarak yazılacak
                                                            $indirimOrani = (100 - ($urunDetayCek['urun_satisfiyati'] / $urunDetayCek['urun_piyasafiyati']) * 100);
                                                            ?>
                                                            <div class="cat-detail-products-box-indirim tooltip-bottom"
                                                                 data-tooltip="Ürün İndirimde!">
                                                                % <?php echo round($indirimOrani, 2) ?></div>
                                                        <?php } ?>

                                                    </div>
                                                <?php } else { // ürün stoğu yoksa?>

                                                    <div class="cat-detail-products-box-caturunvitrin-fiyat">
                                                        <div class="cat-detail-products-box-fiyat-out button-red button-1x"
                                                             style="width: 100%; text-align: center;">Stokta Yok
                                                        </div>
                                                    </div>
                                                <?php } ?>


                                            </div>
                                        </div>


                                    <?php } ?>


                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <!--  <========SON=========>>> Ürün Kutu Slider SON !-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>