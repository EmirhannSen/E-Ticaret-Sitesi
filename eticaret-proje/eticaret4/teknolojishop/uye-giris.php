<?php
include 'header.php';

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Uye Giris</title>
</head>

<body>


<div class="users_main_div" style="background-color: #ffffff;  font-family : 'Roboto',sans-serif ; ">
    <div class="user_login_register_div">
        <div class="user_page_header dis-mob">
            <i class="las la-user"></i> ÜYE GİRİŞİ
        </div>
        <div class="user_page_login_form">
            <div class=" teslimat-form-area">
                <form action="settings/islem.php" method="post">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="kullanici_mail" style="font-weight: 600;">* E-Posta Adresiniz</label>
                            <input type="email" name="kullanici_mail" id="kullanici_mail" required class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="kullanici_password" style="font-weight: 600;">* Şifreniz</label>
                            <input type="password" name="kullanici_password" id="kullanici_password" required class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12 ">
                            <button name="kullanicigiris" class="button-blue button-2x" style="width: 100%;  ">GİRİŞ YAP</button>
                        </div>
                        <div class="form-group col-md-12">
                            <a class="modal-in-login-form-reset-password" href="sifremi-unuttum.php">Şifremi Unuttum!</a>
                        </div>
                        <div class="form-group col-md-12 " style="margin-bottom: 0; margin-top: 10px; font-size: 14px ;"> Kayıtlı bir hesabınız yok mu? <a href="uye-kayit.php" style="font-weight: bold; color: #000;">Hemen Üye Olun</a>
                        </div>
                    </div>

                    <?php if (isset($_GET['durum']) && $_GET['durum'] != "basarili") { ?>

                        <div class="modal show" id="errorModal" data-backdrop="static"
                             style="z-index: 99999; padding-right: 17px; display: block;" aria-modal="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm ">
                                <div class="modal-content">
                                    <button type="button" class="close" data-dismiss="modal"
                                            style="color: #000; position: absolute; right: 10px; top: 5px;">×
                                    </button>
                                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                                        <i class="ion-ios-information-outline"
                                           style="font-size: 45px ; color: #558cff;"></i><br>

                                        <?php if (isset($_GET['durum']) && $_GET['durum'] == "pasifkullanici") { ?>
                                            <div>
                                                <strong>Hata!</strong> Kullanıcınız pasif durumdadır. Sistem Yöneticisine Danışınız.
                                            </div>

                                        <?php } elseif (isset($_GET['durum']) && $_GET['durum'] == "basarisizgiris") { ?>

                                            <div>
                                                <strong>Hata!</strong> Kullanıcı Bilgileri Hatalıdır. Lütfen Tekrar Deneyiniz.
                                            </div>

                                        <?php } elseif (isset($_GET['durum']) && $_GET['durum'] == "kayitbulunamadi") { ?>

                                            <div>
                                                <strong>Hata!</strong> Kullanıcı kaydınız bulunmamaktadır.
                                            </div>

                                        <?php }  ?>

                                    </div>
                                    <div class="category-cart-add-success-modal-footer">
                                        <button type="button" class="button-blue button-2x"
                                                style="width: 100%; text-align: center; " data-dismiss="modal">Tamam
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                </form>
            </div>
        </div>
        <div class="user_page_right_text_div">
            <div style="font-size: 18px; font-weight: bold; color: #000; margin-bottom: 25px;">&Uuml;yeliğiniz yok mu?</div>
            <div style="font-size: 14px;">Sitemize &uuml;yelik &uuml;cretsizdir. Eğer kayıt yaptırmadıysanız birka&ccedil; dakika i&ccedil;inde sitemize &uuml;ye olup giriş yapabilirsiniz. &Uuml;ye olma işlemini sipariş verme aşamasında da yapabilirsiniz!</div>
            <div style="margin-top: 25px;">
                <a href="uye-kayit.php" class="button-green button-2x">HEMEN ÜYE OL</a>
            </div>
        </div>
    </div>
</div>

<script> $(window).on("load", function () {
        $('#errorModal').modal('show');
    });
    $(window).load(function () {
        $('#errorModal').modal('show');
    });
    var $modalDialog = $("#errorModal");
    $modalDialog.modal('show');
    setTimeout(function () {
        $modalDialog.modal('hide');
    }, 0);</script>


</body>

</html>

</div>

