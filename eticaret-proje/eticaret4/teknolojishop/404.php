<?php

include 'settings/baglan.php';

$siteAyarSor = $db->prepare("SELECT * FROM ayar where ayar_id=0");
$siteAyarSor->execute();
$siteAyarCek = $siteAyarSor->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="tr" dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<base>
<base>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="shortcut icon" href="<?php echo $siteAyarCek['ayar_favicon'] ?>">
<div class="main-body">
    <title>404 | <?php echo $siteAyarCek['ayar_title'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Open Sans', Sans-serif;
        }

        .topIMG {
            max-width: 200px;
            max-height: 100px;
        }

        .main-div {
            width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            color: #000000;
            box-sizing: border-box;
            padding: 30px 0
        }

        .notfound-img img {
            max-width: 500px;
        }

        .notfound-left {
            margin-right: 20px;
            width: 450px;
            color: #000000;
        }

        .notfound-left-h {
            font-size: 40px;
            font-weight: bold;
        }

        .notfound-left-s {
            font-size: 16px;
            font-weight: 600;
            margin-top: 15px;
            margin-bottom: 40px;
        }

        .notfound-header {
            width: 100%;
            box-sizing: border-box;
            padding: 20px;
            text-align: center;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ebebeb;
        }

        @media screen and (max-width: 410px) and (min-width: 321px) {
            .main-div {
                width: 93%;
            }

            .notfound-img img {
                max-width: 100%;
                margin-top: 30px;
            }
        }

        @media screen and (max-width: 321px) and (min-width: 0px) {
            .main-div {
                width: 93%;
            }

            .notfound-img img {
                max-width: 100%;
                margin-top: 30px;
            }
        }

        @media screen and (max-width: 767px) and (min-width: 410px) {
            .main-div {
                width: 93%;
            }

            .notfound-img img {
                max-width: 100%;
                margin-top: 30px;
            }
        }

        @media screen and (max-width: 1023px) and (min-width: 767px) {
            .main-div {
                width: 93%;
            }

            .notfound-img img {
                max-width: 100%;
                margin-top: 30px;
            }
        }
    </style>
</div>
</base>
</head>
<body>
</html>
<div class="notfound-header">
    <a href="index.html">
        <img class="topIMG" src="images/logo/67400-405-84159-107-logo.png">
    </a>
</div>
<div class="main-div">
    <div class="notfound-left">
        <div class="notfound-left-h"> Sayfa Bulunamadı!</div>
        <div class="notfound-left-s"> Üzgünüz! Aradığınız sayfayı bulamadık. Ama aradığınızı bulacağınıza inancımız
            tam.
        </div>
        <a href="index.php" class="button-orange button-4x" style="text-decoration: none;"> Anasayfaya Git </a>
    </div>
    <div class="notfound-img">
        <img src="images/uploads/69847-656-45924-157-404img.jpg">
    </div>
</div>
</body>
</div>