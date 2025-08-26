<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'settings/baglan.php';

// Temel sorgu
$sql = "SELECT * FROM urun WHERE urun_durum = '1'";
$params = [];

// Arama parametresi kontrolü
if(isset($_GET['q']) && !empty($_GET['q'])) {
    $aranan = $_GET['q'];
    $aranan = strip_tags(trim($aranan));
    
    $sql .= " AND (urun_adi LIKE :aranan OR urun_aciklama LIKE :aranan OR urun_marka LIKE :aranan)";
    $params['aranan'] = '%'.$aranan.'%';
    
    // Arama başlığı için değişken
    $arama_baslik = "\"" . htmlspecialchars($aranan) . "\" için arama sonuçları";
}

// Kategori filtresi
if (isset($_GET['kategori_id']) && !empty($_GET['kategori_id'])) {
    $kategori_id = $_GET['kategori_id'];
    $alt_kategoriler = alt_kategorileri_bul($db, $kategori_id);
    $alt_kategoriler[] = $kategori_id;
    $kategori_ids = implode(',', array_map('intval', $alt_kategoriler));
    $sql .= " AND kategori_id IN ($kategori_ids)";
    
    // Kategori başlığı için bilgileri çek
    $kategoriSor = $db->prepare("SELECT * FROM kategori WHERE kategori_id = :kategori_id");
    $kategoriSor->execute(['kategori_id' => $kategori_id]);
    $kategoriCek = $kategoriSor->fetchAll(PDO::FETCH_ASSOC);
}

// Marka filtresi - Birden fazla marka seçimi için
if (isset($_GET['marka']) && !empty($_GET['marka'])) {
    $markalar = explode(',', $_GET['marka']);
    if (count($markalar) == 1) {
        $sql .= " AND urun_marka = :marka";
        $params['marka'] = $markalar[0];
    } else {
        $markaParams = [];
        foreach ($markalar as $index => $marka) {
            $paramName = "marka_".$index;
            $markaParams[] = ":$paramName";
            $params[$paramName] = $marka;
        }
        $sql .= " AND urun_marka IN (".implode(',', $markaParams).")";
    }
}

// Özellik filtresi
if (isset($_GET['ozellik']) && !empty($_GET['ozellik'])) {
    // Özellik filtresi için gerekli SQL ekleyin
}

// Fiyat aralığı - Doğru sütun adını kullan
if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $sql .= " AND urun_satisfiyati BETWEEN :min_price AND :max_price";
    $params['min_price'] = $_GET['min_price'];
    $params['max_price'] = $_GET['max_price'];
}

// Sorguyu çalıştır
$urunsor = $db->prepare($sql);
$urunsor->execute($params);

// Sonuçları al
$urunler = $urunsor->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="cat-right-main">
    <div class="cat-right-header-out">
        <div class="cat-right-header">
            <div class="cat-right-head-text" style="color: #000000; ">
                <?php 
                if(isset($arama_baslik)) {
                    echo $arama_baslik; 
                } elseif(isset($kategoriCek) && !empty($kategoriCek)) {
                    echo $kategoriCek[0]['kategori_ad'];
                } else {
                    echo "Tüm Ürünler";
                }
                ?>
            </div>
            <div class="cat-right-desc" style="color: #999999;">
                <?php 
                if(isset($aranan)) {
                    echo "Toplam " . count($urunler) . " ürün bulundu."; 
                }
                ?>
            </div>
        </div>
    </div>





    <!-- Ürünler !-->
    <div class="cat-detail-products">

        <!-- Görünüm İşlemleri !-->
        <!--  <========SON=========>>> Görünüm İşlemleri SON !-->


        <?php

        if (count($urunler) > 0) {
            foreach ($urunler as $urun) { ?>


                <div class="cat-detail-products-box">
                    <div class="cat-detail-products-box-cart-1">
                        <?php if ($urun['urun_stok']) { ?>
                            <form action="settings/islem.php" method="post">
                                <input name="urun_id" type="hidden" value="<?php echo $urun['urun_id'] ?>">
                                <input name="kullanici_id" type="hidden" value="<?php echo $kullanicicek['kullanici_id'] ?>">
                                <input name="quantity" type="hidden" value="1">
                                <button name="sepetekle" class="tooltip-right" data-tooltip="SEPETE EKLE">
                                    <i class="fa fa-shopping-basket"></i>
                                </button>
                            </form>
                        <?php } ?>

                        <?php if($say > 0): // Kullanıcı giriş yapmış ?>
                            <?php if(isFavorite($urun['urun_id'])): // Favori eklenmişse ?>
                                <a href="favorilerim.php?urun_id=<?php echo $urun['urun_id'] ?>&islem=cikar" class="tooltip-right" data-tooltip="Favorilerimden Çıkar">
                                    <i class="fa fa-heart" style="color: #e74c3c;"></i>
                                </a>
                            <?php else: // Favori eklenmemişse ?>
                                <a href="favorilerim.php?urun_id=<?php echo $urun['urun_id'] ?>&islem=ekle" class="tooltip-right" data-tooltip="Favorilere Ekle">
                                    <i class="fa fa-heart-o"></i>
                                </a>
                            <?php endif; ?>
                        <?php else: // Kullanıcı giriş yapmamış ?>
                            <a href="#" data-toggle="modal" data-target="#loginModal" class="tooltip-right" data-tooltip="Favorilere Ekle">
                                <i class="fa fa-heart-o"></i>
                            </a>
                        <?php endif; ?>

                        <a href="#" class="tooltip-right product-compare" data-code="<?php echo $urun['urun_kodu'] ?>"
                           data-tooltip="Karşılaştırmaya Ekle">
                            <i class="fa fa-random"></i>
                        </a>
                    </div>

                    <?php if ($urun['urun_stok']) { ?>
                        <div class="cat-detail-products-box-img ">
                            <a href="urun-<?=seo($urun["urun_adi"]).'-'.$urun["urun_id"]?>">
                                <img src="<?php echo $urun['urun_resim1'] ?>"
                                     alt="<?php echo $urun['urun_adi'] ?>">
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="cat-detail-products-box-img product-grey-img">
                            <a href="urun-<?=seo($urun["urun_adi"]).'-'.$urun["urun_id"]?>">
                                <img src="<?php echo $urun['urun_resim1'] ?>"
                                     alt="<?php echo $urun['urun_adi'] ?>"></a>
                        </div>

                    <?php } ?>


                    <div class="cat-detail-products-box-info">
                        <div class="cat-detail-products-box-marka">
                            <a href="" style="color: #000000;">
                                <?php echo $urun['urun_marka'] ?> </a>
                        </div>
                        <div class="cat-detail-products-box-h">
                            <a href="urun-<?=seo($urun["urun_adi"]).'-'.$urun["urun_id"]?>" style="color: #000000;">
                                <?php echo $urun['urun_adi'] ?> </a>
                        </div>
                    </div>


                    <?php if ($urun['urun_stok']) { // ürün stoğu varsa?>
                        <div class="cat-detail-products-box-fiyat">
                            <div class="cat-detail-products-box-fiyat-out">

                                <?php if ($urun['urun_piyasafiyati'] > 0.00) { //piyasa fiyatı varsa?>

                                    <div class="cat-detail-products-box-fiyat-eski" style="color: #b0b0b0;">
                                        <span id="item-price"><?php echo $urun['urun_piyasafiyati'] . ' ' . $urun['urun_doviz'] ?></span>
                                    </div>
                                <?php } ?>

                                <div class="cat-detail-products-box-fiyat-mevcut" style="color: #000000; ">

                                    <span id="item-price"><?php echo $urun['urun_satisfiyati'] . ' ' . $urun['urun_doviz'] ?></span>
                                </div>

                            </div>

                            <?php if ($urun['urun_piyasafiyati'] > 0.00) { // piyasa fiyatı var ise indirim oranı hesaplanarak yazılacak
                                $indirimOrani = (100 - ($urun['urun_satisfiyati'] / $urun['urun_piyasafiyati']) * 100);
                                ?>
                                <div class="cat-detail-products-box-indirim tooltip-bottom"
                                     data-tooltip="Ürün İndirimde!">
                                    % <?php echo round($indirimOrani, 2) ?>
                                </div>
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

            <?php }
        } else { ?>


            <div class="category-detail-no-product-alert">
                <i class="ion-alert-circled"></i> Sonuç Bulunamadı
            </div>
        <?php } ?>


    </div>
    <!--  <========SON=========>>> Ürünler SON !-->

    <!---- Sayfalama Elementleri ================== !-->
    <!---- Sayfalama Elementleri ================== !-->


</div>

<style>
    .cat-detail-products-box {
     width: 25%; 
}
    </style>