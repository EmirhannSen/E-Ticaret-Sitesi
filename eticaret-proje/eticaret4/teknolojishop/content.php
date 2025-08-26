
<?php

include 'settings/baglan.php';

include 'header.php';

    $icerikSor = $db->prepare("SELECT * FROM icerikler where icerik_durum='1' and icerik_seourl=:icerik_seourl");
    $icerikSor->execute(['icerik_seourl' => $_GET['content']]);
    $icerikCek = $icerikSor->fetch(PDO::FETCH_ASSOC);


?>

<link rel="stylesheet" href="assets/css/content.css" rel="preload">


<div id="MainDiv" style="background-color: #f3f6f9; width: 100%;  overflow: hidden  ">
    <div class="page-banner-main">
        <div class="page-banner-in-text">
            <div class="page-banner-h "> <?php echo $icerikCek['icerik_baslik'] ?> </div>
            <div class="page-banner-links ">
                <a href="index.php">
                    <i class="fa fa-home"></i> Anasayfa </a>
                <span>/</span>
                <a><?php echo $icerikCek['icerik_baslik'] ?></a>
            </div>
        </div>
    </div>
    <div class="htmlpage-container-main">
       
        
        <?php include 'content-left-menu.php'; ?>
        

        <div class="htmlpage-content-div" style="font-family : 'Roboto',Sans-serif ; ">
            <!--<div class="content_title_big">
                <h1 class="content_title-primary"></h1>
            </div> -->
            <?php echo $icerikCek['icerik_metni'] ?>
        </div>

    </div>
</div>



<?php include("footer.php"); ?>