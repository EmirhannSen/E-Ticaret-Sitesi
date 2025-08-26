<?php

include 'settings/baglan.php';
//include 'header.php';

// vitrin tablosundan kayıt çekiliyor
$tabliVitrinSor = $db->prepare("SELECT * FROM vitrin WHERE vitrin_dizayn = :vitrin_dizayn AND vitrin_durum = 1 ORDER BY vitrin_sira ASC");
$tabliVitrinSor->execute(['vitrin_dizayn' => 'tabli_vitrin']);
$tabliVitrinler = $tabliVitrinSor->fetchAll(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($tabliVitrinCek);
echo "</pre>";
die("test");
*/
?>



    <div class="urunler-module-main-div">
        <div class="urunler-module-inside-area">
            <div class="urun-kutulari-main"><!-- Tablar !-->


                <div class="home-product-tabs"> <!-- Tab Basliklari !-->
                    <?php foreach ($tabliVitrinler as $tabliVitrinCek) {

                        $tabStatus = '';
                        if ($tabliVitrinCek['vitrin_sira'] == '1') {
                            $tabStatus = 'active';
                        }

                        ?>


                        <div class="home-product-tablinks lspacsmall <?php echo $tabStatus ?>"
                             data-country="<?php echo $tabliVitrinCek['vitrin_aciklama'] ?>"><p
                                data-title="<?php echo $tabliVitrinCek['vitrin_aciklama'] ?>"><?php echo $tabliVitrinCek['vitrin_adi'] ?></p>
                        </div>

                    <?php } ?>

                </div>


                <section id="home-product-tabs-wrapper" style="width: 100%;  ">
                    <div class="wrapper_tabcontent">

                        <?php foreach ($tabliVitrinler as $tabliVitrinCek) {
                            $tabStatus = '';
                            if ($tabliVitrinCek['vitrin_sira'] == '1') {
                                $tabStatus = 'active';
                            }

                            ?>

                            <div id="<?php echo $tabliVitrinCek['vitrin_aciklama'] ?>" class="home-product-tabcontent <?php echo $tabStatus ?>">
                                <div class="home-product-tabcontent-in">


                                    <?php

                                    $tabliVitrinUrunSor = $db->prepare("SELECT * FROM vitrin_urun WHERE vitrin_id = :vitrin_id ORDER BY vitrin_urun_sira ASC");
                                    $tabliVitrinUrunSor->execute(['vitrin_id' => $tabliVitrinCek['vitrin_id']]);

                                    while ($tabliVitrinUrunCek = $tabliVitrinUrunSor->fetch(PDO::FETCH_ASSOC)) {

                                        $urunDetaySor = $db->prepare("SELECT * FROM urun WHERE urun_id = :urun_id AND urun_durum='1'");
                                        $urunDetaySor->execute(['urun_id' => $tabliVitrinUrunCek['urun_id']]);
                                        $urunDetayCek = $urunDetaySor->fetch(PDO::FETCH_ASSOC);


                                        ?>

                                        <div class="cat-detail-products-box">
                                            <div class="cat-detail-products-box-cart-1">


                                                <?php if ($urunDetayCek['urun_stok']) { ?>
                                                    <form action="settings/islem.php" method="post">
                                                        <input name="urun_id" type="hidden" value="<?php echo $urunDetayCek['urun_id'] ?>">
                                                        <input name="kullanici_id" type="hidden" value="<?php echo $kullanicicek['kullanici_id'] ?>">
                                                        <input name="quantity" type="hidden" value="1">
                                                        <button name="sepetekle" class="tooltip-right" data-tooltip="SEPETE EKLE">
                                                            <i  class="fa fa-shopping-basket"></i></button>
                                                    </form>
                                                <?php } ?>

                                                <?php if($say > 0): // Kullanıcı giriş yapmış ?>
                                                    <?php if(isFavorite($urunDetayCek['urun_id'])): // Favori eklenmişse ?>
                                                        <a href="favorilerim.php?urun_id=<?php echo $urunDetayCek['urun_id'] ?>&islem=cikar" class="tooltip-right" data-tooltip="Favorilerimden Çıkar">
                                                            <i class="fa fa-heart" style="color: #e74c3c;"></i>
                                                        </a>
                                                    <?php else: // Favori eklenmemişse ?>
                                                        <a href="favorilerim.php?urun_id=<?php echo $urunDetayCek['urun_id'] ?>&islem=ekle" class="tooltip-right" data-tooltip="Favorilere Ekle">
                                                            <i class="fa fa-heart-o"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                <?php else: // Kullanıcı giriş yapmamış ?>
                                                <a href="#" data-toggle="modal" data-target="#loginModal" class="tooltip-right" data-tooltip="Favorilere Ekle">
                                                    <i class="fa fa-heart-o"></i>
                                                </a>
                                                <?php endif; ?>
                                                <a href="#" class="tooltip-right product-compare" data-code="<?php echo $urunDetayCek['urun_kodu'] ?>" data-tooltip="Karşılaştırmaya Ekle"><i
                                                        class="fa fa-random"></i></a></div>


                                            <?php if ($urunDetayCek['urun_stok']) { ?>
                                                <div class="cat-detail-products-box-img "><a
                                                        href="urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>"><img
                                                            src="<?php echo $urunDetayCek['urun_resim1'] ?>"
                                                            alt="<?php echo $urunDetayCek['urun_adi'] ?>"></a>
                                                </div>
                                            <?php } else { ?>
                                                <div class="cat-detail-products-box-img product-grey-img">
                                                    <a href="urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>">
                                                        <img src="<?php echo $urunDetayCek['urun_resim1'] ?>"
                                                             alt="<?php echo $urunDetayCek['urun_adi'] ?>"></a>
                                                </div>

                                            <?php } ?>


                                            <div class="cat-detail-products-box-info">
                                                <div class="cat-detail-products-box-marka"><a href="marka/nikon/index.html"
                                                                                              style="color: #000000;"><?php echo $urunDetayCek['urun_marka'] ?></a>
                                                </div>
                                                <div class="cat-detail-products-box-h"><a
                                                        href="urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>"
                                                        style="color: #000000;"><?php echo $urunDetayCek['urun_adi'] ?></a></div>
                                            </div>


                                            <?php if ($urunDetayCek['urun_stok']) { // ürün stoğu varsa?>


                                                <div class="cat-detail-products-box-fiyat">

                                                    <?php if ($urunDetayCek['urun_piyasafiyati'] > 0.00) { //piyasa fiyatı varsa?>
                                                        <div class="cat-detail-products-box-fiyat-eski" style="color: #b0b0b0;">
                                                            <span id="item-price"><?php echo $urunDetayCek['urun_piyasafiyati'] . ' ' . $urunDetayCek['urun_doviz'] ?></span>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="cat-detail-products-box-fiyat-out">
                                                        <div class="cat-detail-products-box-fiyat-mevcut" style="color: #000000; "><span
                                                                id="item-price"><?php echo $urunDetayCek['urun_satisfiyati'] . ' ' . $urunDetayCek['urun_doviz'] ?></span>
                                                        </div>
                                                    </div>

                                                    <?php if ($urunDetayCek['urun_piyasafiyati'] > 0.00) { // piyasa fiyatı var ise indirim oranı hesaplanarak yazılacak
                                                        $indirimOrani = (100 - ($urunDetayCek['urun_satisfiyati'] / $urunDetayCek['urun_piyasafiyati']) * 100);
                                                        ?>
                                                        <div class="cat-detail-products-box-indirim tooltip-bottom"
                                                             data-tooltip="Ürün İndirimde!">% <?php echo round($indirimOrani, 2) ?></div>
                                                    <?php } ?>

                                                </div>


                                            <?php } else { // ürün stoğu yoksa ?>

                                                <div class="cat-detail-products-box-fiyat">
                                                    <div class="cat-detail-products-box-fiyat-out button-red button-1x"
                                                         style="width: 100%; text-align: center;">Stokta Yok
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>

                                    <?php } ?>


                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </section><!-- Tablar SON !--></div>
        </div>
    </div>


<?php //include("footer.php"); ?>