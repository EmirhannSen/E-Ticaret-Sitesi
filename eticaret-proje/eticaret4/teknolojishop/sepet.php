<?php 
include 'header.php';

// Kullanıcı giriş kontrolü
if(!isset($_SESSION['kullanici_mail'])) {
    // Kullanıcı giriş yapmamışsa, ürünleri session'da tutabiliriz veya giriş sayfasına yönlendirebiliriz
    header("Location:uye-giris.php?durum=girisyap");
    exit;
}

// Kullanıcı giriş yapmışsa devam ediyoruz
$sepetDetaySor = $db->prepare("SELECT * FROM sepet WHERE kullanici_id = :kullanici_id");
$sepetDetaySor->execute(['kullanici_id' => $kullanicicek['kullanici_id']]);
$sepetDetayCek = $sepetDetaySor->fetchAll(PDO::FETCH_ASSOC);

?>

    <head>
        <title>Alışverişe Devam Et</title>
    </head>

    <style>
        .page-banner-main {
            background: #1f1f1f;
            padding: 30px 0 30px 0;
            font-family: 'Roboto', sans-serif;
            border-bottom: 1px solid #ffffff;
            border-top: 1px solid #ffffff;
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .page-banner-in-text {
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-banner-h {
            font-size: 28px;
            color: #ffffff;
            font-weight: 400;
            line-height: 28px;
        }

        .page-banner-links {
            text-align: right;
            color: #cccccc;
        }

        .page-banner-links span {
            color: #cccccc;
            font-size: 13px;
        }

        .page-banner-links a {
            color: #cccccc;
            font-size: 13px;
        }

        .page-banner-links a:hover {
            color: #cccccc;
        }</style>

    <style>
        .tooltip {
            font-size: 12px !important;
        }

        .cart-main-div {
            font-family: 'Roboto', Sans-serif;
        }

        .no-cart-items-main-div {
            font-family: 'Roboto', Sans-serif;
            background-color: #fff;
        }

        .no-cart-items-main-div a {
            font-family: 'Roboto', Sans-serif;
        }

        .cart-left-div {
            float: left;
            width: 70%;
            box-sizing: border-box;
            padding: 10px 20px;
        }

        .cart-right-div {
            float: right;
            width: 30%;
            box-sizing: border-box;
            padding: 10px 20px;
        }

        .cart-left-box-main {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #EBEBEB;
        }

        .cart-head {
            font-weight: bold;
            color: #555;
        }

        .cart-left-box-1 {
            width: 10%;
        }

        .cart-left-box-1 img {
            max-width: 100%;
            height: auto;
        }

        .cart-left-box-2 {
            width: 30%;
            padding-left: 15px;
        }

        .cart-left-box-3, .cart-left-box-4, .cart-left-box-5 {
            width: 15%;
            text-align: center;
        }

        .cart-left-box-6 {
            width: 5%;
            text-align: center;
        }

        .cart-right-div-inside {
            background-color: #f8f8f8;
            border: 1px solid #EBEBEB;
            padding: 15px;
            margin-bottom: 20px;
        }

        .cart-right-div-head {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #EBEBEB;
        }

        .cart-right-div-price-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .button-blue {
            background-color: #4285F4;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
        }

        .button-red {
            background-color: #DB4437;
            color: white;
            border: none;
            padding: 12px 15px;
            cursor: pointer;
            font-weight: bold;
        }

        .button-green {
            background-color: #0F9D58;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
        }

        .button-2x {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .cart-left-div, .cart-right-div {
                width: 100%;
                float: none;
            }
        }
        @media (min-width: 1200px) {
    .container {
        max-width: 1300px;
    }
}
    </style>


    <div class="main-body">

        <div style="width: 100%; background-color: #fff; overflow: hidden">
            <div class="page-banner-main">
                <div class="container">
                    <div class="page-banner-in-text">
                        <div class="page-banner-h ">
                            Sepetiniz
                        </div>
                        <div class="page-banner-links ">
                            <a href="index.php"><i class="fa fa-home"></i> Anasayfa</a>
                            <span>/</span>
                            <a>Sepetiniz</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container">
                <?php if (count($sepetDetayCek) > 0): ?>
                <div class="cart-main-div">
                    <!-- Ücretsiz Kargo Bilgilendirmesi !-->
                    <!-- Ücretsiz Kargo Bilgilendirmesi SON !-->
                    <div class="cart-left-div">
                        <div id="output">
                            <div class="cart-left-box-main cart-head " style="padding: 0; border-top: 1px solid #EBEBEB ">
                                <div class="cart-left-box-1">
                                </div>
                                <div class="cart-left-box-2">
                                    Ürün
                                </div>
                                <div class="cart-left-box-3">
                                    Birim Fiyat
                                </div>
                                <div class="cart-left-box-4">
                                <span style="padding: 0 0 0 28px">
                                    Adet                            </span>
                                </div>
                                <div class="cart-left-box-4">
                                    Toplam
                                </div>
                            </div>


                            <!-- Sepet Itemleri !-->
                            <!-- ANA ÜRÜN STOK KONTROLLÜ SEPET İTEMLERİ !-->
                            <?php
                            $araToplam=0;
                            $toplamKdvTutari=0;

                            foreach ($sepetDetayCek as $sepetItem) {

                                $urunDetaySor = $db->prepare("SELECT * FROM urun WHERE urun_id=:urun_id");
                                $urunDetaySor->execute(['urun_id' => $sepetItem['urun_id']]);
                                $urunDetayCek = $urunDetaySor->fetch(PDO::FETCH_ASSOC);


                                ?>
                                <div class="cart-left-box-main Item<?php echo $urunDetayCek['urun_id'] ?>">
                                    <div class="cart-left-box-1">
                                        <a href="urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>" target="_blank">
                                            <img src="<?php echo $urunDetayCek['urun_resim1'] ?>"
                                                alt="<?php echo $urunDetayCek['urun_adi'] ?>">
                                        </a>
                                    </div>
                                    <div class="cart-left-box-2">
                                        <div class="cart-left-box-2-txt">
                                            <a href="urun-<?=seo($urunDetayCek["urun_adi"]).'-'.$urunDetayCek["urun_id"]?>" target="_blank">
                                                <?php echo $urunDetayCek['urun_adi'] ?> </a>

                                            <div style="height: 10px"></div>

                                            <div class="cart-left-variant-div" style="font-size: 12px ; ">
                                                <strong>+ %<?php echo $urunDetayCek['urun_kdvorani'] ?> KDV :</strong>
                                                <?php $kdvHaricFiyat= $urunDetayCek['urun_satisfiyati']/(1+($urunDetayCek['urun_kdvorani']/100));
                                                $kdvTutari = $urunDetayCek['urun_satisfiyati'] - $kdvHaricFiyat;
                                                ?>
                                                <span id="item-price"><?php echo number_format(round($kdvTutari*$sepetItem['urun_adet'],2), 2, ',', '.'); ?></span> TL x <?php echo $sepetItem['urun_adet'] ?> Adet
                                            </div>

                                            <div class="cart-left-variant-div"
                                                style="font-size: 11px ; background-color: #f8f8f8; padding-left: 5px;">
                                                <i class="fa fa-gift"></i> ÜCRETSİZ KARGO
                                            </div>
                                            <!-- Kargo Bilgisi SON !-->


                                        </div>

                                    </div>
                                    <div class="cart-left-box-3">


                                        <strong>
                                            <span id="item-price"><?php echo number_format(round($kdvHaricFiyat, 2), 2, ',', '.'); ?></span> TL </strong>
                                    </div>
                                    <div class="cart-left-box-4">
                                        <!-- Azaltma Butonu -->
                                        <form method="POST" action="settings/islem.php" class="d-inline-block">
                                            <input type="hidden" name="sepet_id" value="<?php echo $sepetItem['sepet_id']; ?>">
                                            <input type="hidden" name="urun_id" value="<?php echo $sepetItem['urun_id']; ?>">
                                            <input type="hidden" name="urun_adet" value="<?php echo max($sepetItem['urun_adet'] - 1, 1); ?>"> <!-- Minimum 1 -->
                                            <button type="submit" name="sepet_guncelle" class="btn btn-sm btn-light rounded-0"
                                                    style="border-color:#DDD; background-color: #fff; width: 25px;">
                                                -
                                            </button>
                                        </form>

                                        <!-- Mevcut Adet -->
                                        <input type="text" value="<?php echo $sepetItem['urun_adet']; ?>" class="form-control btn-sm rounded-0"
                                            style="width:50px; height: 31px; border-color:#DDD; text-align: center; display: inline-block; vertical-align: top; background-color: #fff;"
                                            disabled="">

                                        <!-- Artırma Butonu -->
                                        <form method="POST" action="settings/islem.php" class="d-inline-block">
                                            <input type="hidden" name="sepet_id" value="<?php echo $sepetItem['sepet_id']; ?>">
                                            <input type="hidden" name="urun_id" value="<?php echo $sepetItem['urun_id']; ?>">
                                            <input type="hidden" name="urun_adet" value="<?php echo $sepetItem['urun_adet'] + 1; ?>">
                                            <button type="submit" name="sepet_guncelle" class="btn btn-sm btn-light rounded-0"
                                                    style="border-color:#DDD; background-color: #fff; width: 25px;">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                    <div class="cart-left-box-5">

                                        <!-- Ürünün Sepet Toplamı !--> 


                                        <strong>
                                            <span id="item-price"><?php echo number_format($urunDetayCek['urun_satisfiyati']*$sepetItem['urun_adet'], 2, ',', '.'); ?></span> TL </strong>
                                        <br>
                                        <span style="font-size: 11px;">(KDV Dahil)</span>
                                        <!-- Ürünün Sepet Toplamı SON !-->

                                    </div>
                                    <div class="cart-left-box-6">
                                        <a data-id="<?php echo $urunDetayCek['urun_id'] ?>"
                                        class="btn btn-sm btn-danger open-delete-modal"
                                        style="border-radius: 0 !important; padding: 5px 6px !important; font-size: 12px !important; line-height: 10px !important;"
                                        href="" data-toggle="modal" data-target="#confirm-delete">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>

                                </div>
                                <?php
                                $araToplam += $kdvHaricFiyat*$sepetItem['urun_adet'];
                                $toplamKdvTutari += $kdvTutari*$sepetItem['urun_adet'];
                            }  ?>
                        </div>
                    </div>
                    <div class="cart-right-div">

                        <div class="cart-right-div-inside" style="margin-bottom: 10px !important;">
                            <div class="cart-right-div-head">
                                Kupon İndirimi
                            </div>
                            <div class="cart-right-div-s">
                                Bir kupon kodunuz varsa aşağıdaki alana girdikten sonra uygula düğmesine basınız
                            </div>
                            <div class="cart-right-div-coupon" style="display: flex; margin-top: 10px;">
                                <input type="text" name="" id="" autocomplete="off" style="flex:1" class="form-control">
                                <button data-toggle="modal" data-target="#discountModal" class="button-blue ml-2">Uygula
                                </button>
                            </div>
                        </div>


                        <!-- Üyelik aktif  !-->
                        <!-- Giriş Yapılmamış! üye girişi modal ve üyeliksiz devam et çıksın !-->
                        <div class="cart-right-div-inside">
                            <div class="cart-right-div-head">
                                Sepet Özeti
                            </div>


                            <div class="cart-right-div-price-box">
                                <div class="cart-right-div-price-box-left">
                                    Ara Toplam
                                </div>
                                <div class="cart-right-div-price-box-right">

                                    <span id="item-price"><?php echo number_format(round($araToplam,2), 2, ',', '.'); ?></span> TL
                                </div>
                            </div>

                            <div class="cart-right-div-price-box">
                                <div class="cart-right-div-price-box-left">
                                    KDV
                                </div>
                                <div class="cart-right-div-price-box-right">

                                    <span id="item-price"><?php echo number_format(round($toplamKdvTutari,2), 2, ',', '.'); ?></span> TL
                                </div>
                            </div>


                            <div class="cart-right-div-price-box">
                                <div class="cart-right-div-price-box-left">
                                    Kargo Tutarı
                                </div>
                                <div class="cart-right-div-price-box-right">
                                    <span style="font-size: 12px ;">ÜCRETSİZ KARGO</span>

                                </div>
                            </div>


                            <div class="cart-right-div-price-box">
                                <div class="cart-right-div-price-box-left">
                                    Ödenecek Tutar
                                </div>
                                <div class="cart-right-div-price-box-right font-16">
                                    <span id="item-price"><?php echo number_format(round($araToplam+$toplamKdvTutari,2), 2, ',', '.'); ?></span> TL
                                </div>
                            </div>


                            <!-- ücretsiz kargo için sayaç !-->
                            <!-- ücretsiz kargo için sayaç SON !-->

                            <a href="odeme.php" class="button-red button-2x" style="display: block; width: 100%; text-align: center; text-decoration: none; margin-top: 15px;">
                                SEPETİ ONAYLA
                            </a>
                        </div>
                        <!-- Giriş Yapılmamış! üye girişi modal ve üyeliksiz devam et çıksın SON !-->
                        <!-- Üyelik aktif  SON !-->


                    </div>
                </div>
                <?php else: ?>
                <!-- Sepet boş ise -->
                <div class="no-cart-items-main-div text-center py-5">
                    <div class="card text-center p-5">
                        <div class="card-body">
                            <i class="fa fa-shopping-basket fa-4x mb-3 text-muted"></i>
                            <h3>Sepetiniz Boş</h3>
                            <p class="text-muted mb-4">Sepetinizde ürün bulunmamaktadır.</p>
                            <a href="index.php" class="button-blue button-2x">
                                <i class="fa fa-arrow-left mr-2"></i> Alışverişe Başla
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Onay Modal -->
    <div class="modal fade" id="discountModal">
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <a type="button" class="close" data-dismiss="modal"
                    style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:0 !important; border:0 !important;">×</a>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="fa fa-info-circle"
                        style="font-size: 45px ; color: #558cff;"></i><br>
                    <div>
                        İndirim kuponunu kullanabilmek için üye girişi yapmanız gerekmektedir.
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <a href="uye-giris.php" class="button-blue button-2x"
                        style="width: 100%; text-align: center; ">ÜYE GİRİŞİ / YENİ ÜYELİK</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ürün Silme Modal -->
    <div class="modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div style="position: absolute; z-index: 9; right: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body"
                    style="font-size: 14px; font-weight: 300; padding: 20px !important; letter-spacing: 0.04em!important;">
                    Bu ürünü sepetinizden kaldırmak istediğinize emin misiniz?
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-green button-2x" data-dismiss="modal">İptal</button>
                    <a href="#" id="deleteLink" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Evet, Kaldır
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.open-delete-modal').click(function(e) {
                e.preventDefault();
                var urunId = $(this).data('id');
                $('#deleteLink').attr('href', 'settings/islem.php?sepetsil=ok&urun_id=' + urunId);
            });
        });
    </script>

<?php include 'footer.php'; ?>