<?php

include 'settings/baglan.php';

include 'header.php';

$bankabilgiSor = $db->prepare("SELECT * FROM banka_hesaplari where banka_durum='1'");
$bankabilgiSor->execute();
//$bankabilgiCek=$bankabilgiSor->fetch(PDO::FETCH_ASSOC);

?>


<link rel="stylesheet" href="assets/css/content.css" rel="preload">

<div id="MainDiv"
     style="background-color: #ffffff; width: 100%; font-family : 'Open Sans',Sans-serif ; overflow: hidden  ">
    <div class="page-banner-main">
        <div class="page-banner-in-text">
            <div class="page-banner-h "> Banka Hesap Numaralarımız</div>
            <div class="page-banner-links ">
                <a href="index.php">
                    <i class="fa fa-home"></i> Anasayfa </a>
                <span style="font-weight: bold;">/</span>
                <a> Hesap Numaralarımız </a>
            </div>
        </div>
    </div>
    <div class="iletisim-container-main">


        <?php include 'content-left-menu.php'; ?>


        <div class="alt_sayfa_flex_1">

            <?php while ($bankabilgiCek = $bankabilgiSor->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="banka-hesap-main-box">
                    <div class="banka-hesap-main-box-img">
                        <img src="<?php echo $bankabilgiCek['banka_logo'] ?>"
                             alt="<?php echo $bankabilgiCek['banka_ad'] ?>">
                    </div>
                    <div class="banka-hesap-main-box-flex">
                        <div class="banka-hesap-main-box-flex-name">
                            <div class="banka-hesap-main-box-flex-ust"> BANKA ADI</div>
                            <div class="banka-hesap-main-box-flex-alt"> <?php echo $bankabilgiCek['banka_ad'] ?> </div>
                        </div>
                        <div class="banka-hesap-main-box-flex-doviz">
                            <div class="banka-hesap-main-box-flex-ust"> BİRİM</div>
                            <div class="banka-hesap-main-box-flex-alt"> <?php echo $bankabilgiCek['doviz_turu'] ?> </div>
                        </div>
                        <div class="banka-hesap-main-box-flex-isim">
                            <div class="banka-hesap-main-box-flex-ust"> HESAP SAHİBİ</div>
                            <div class="banka-hesap-main-box-flex-alt"> <?php echo $bankabilgiCek['banka_hesapsahibi'] ?> </div>
                        </div>
                        <div class="banka-hesap-main-box-flex-hesap">
                            <div class="banka-hesap-main-box-flex-ust"> ŞUBE/HESAP NO</div>
                            <div class="banka-hesap-main-box-flex-alt"> <?php echo $bankabilgiCek['banka_sube'] . '/' . $bankabilgiCek['banka_hesapno'] ?> </div>
                        </div>
                        <div class="banka-hesap-main-box-flex-iban">
                            <div class="banka-hesap-main-box-flex-ust"> IBAN</div>
                            <div class="banka-hesap-main-box-flex-alt"> <?php echo $bankabilgiCek['banka_iban'] ?> </div>
                        </div>
                    </div>
                </div>

            <?php } ?>


        </div>
    </div>
</div>


<?php include("footer.php"); ?>
