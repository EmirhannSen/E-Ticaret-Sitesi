<?php include 'header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Uye Kayit</title>
    <style>
        /* Arka planı grileştiren ve opak hale getiren stil */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }

        /* Modalın içeriği */
        .custom-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Başarı ikonu */
        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }

        /* Metin */
        .modal-text {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>

<body>

<div class="users_main_div" style="background-color: #ffffff;  font-family : 'Roboto',sans-serif ; ">

    <div class="user_login_register_div">

        <!-- Header !-->
        <div class="user_page_header dis-mob">
            Yeni Hesap Oluşturun
        </div>


        <div class="user_page_login_form">
            <div class="teslimat-form-area">
                <form action="settings/islem.php" method="POST">
                    <div class="register-page-uyelik-tipi-main uye-tipi">
                        <div class="register-page-uyelik-tipi-h">
                            <div class="register-page-uyelik-tipi-h-in">
                                Üyelik Türü
                            </div>
                        </div>
                        <div class="register-page-uyelik-tipi ">
                            <div class="rdio rdio-primary font-14 ">
                                <input name="uye_tip" value="bireysel" id="bireysel" type="radio" checked>
                                <label for="bireysel">Bireysel</label>
                            </div>
                            <div class="rdio rdio-primary font-14">
                                <input name="uye_tip" value="kurumsal" id="kurumsal" type="radio">
                                <label for="kurumsal">Kurumsal</label>
                            </div>
                        </div>
                    </div>

                    <div class="uye-tipi-bireysel row">

                    </div>

                    <div class="uye-tipi-kurumsal row">
                        <!-- Kurumsal !-->
                        <div class="form-group col-md-12">
                            <label for="firma_unvan" style="font-weight: 600;">Firma Ünvanı</label>
                            <input type="text" name="firma_unvan" value="" id="firma_unvan" class="form-control"
                                   autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="vergi_dairesi" style="font-weight: 600;">Vergi Dairesi</label>
                            <input type="text" name="vergi_dairesi" value="" id="vergi_dairesi" class="form-control"
                                   autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="vergi_no" style="font-weight: 600;">* Vergi No</label>
                            <input type="number" name="vergi_no" value="" id="vergi_no" class="form-control"
                                   autocomplete="off">
                        </div>
                        <!-- Kurumsal SON !-->
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="kullanici_ad" style="font-weight: 600;">* Adınız</label>
                            <input type="text" name="kullanici_ad" required="" id="kullanici_ad" value=""
                                   class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="kullanici_soyad" style="font-weight: 600;">* Soyadınız</label>
                            <input type="text" name="kullanici_soyad" required="" id="kullanici_soyad" value=""
                                   class="form-control"
                                   autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="kullanici_mail" style="font-weight: 600;">* E-Posta Adresiniz</label>
                            <input type="text" name="kullanici_mail" required="" id="kullanici_mail" value=""
                                   class="form-control"
                                   autocomplete="off">
                        </div>
                        <div class="form-group col-md-12 password-absolute">
                            <label for="kullanici_passwordone" style="font-weight: 600;">* Şifre</label>
                            <input id="password-field" type="password" name="kullanici_passwordone"
                                   id="kullanici_passwordone"
                                   class="form-control" autocomplete="off">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group col-md-12 password-absolute">
                            <label for="kullanici_passwordtwo" style="font-weight: 600;">* Şifre Tekrar</label>
                            <input id="password-field" type="password" name="kullanici_passwordtwo"
                                   id="kullanici_passwordtwo"
                                   class="form-control" autocomplete="off">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group col-md-12" style="margin-top: 15px;">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="sozlesme_onayi" value="1" class="custom-control-input"
                                       id="sozlesmeOnay">
                                <label class="custom-control-label" for="sozlesmeOnay" style="font-size: 14px ; ">
                                    <a data-toggle="modal" data-target="#sozlesmeModal"
                                       style="color: #333; cursor: pointer ">
                                        <strong style="text-decoration: underline;">Üyelik Sözleşmesini</strong></a>
                                    okudum, onaylıyorum </label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="kullanici_smsonay" value="1" class="custom-control-input"
                                       id="kullanici_smsonay" checked>
                                <label class="custom-control-label" for="kullanici_smsonay" style="font-size: 14px ; ">
                                    Kampanya ve duyurulardan SMS ile haberdar olmak istiyorum </label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="kullanici_epostaonay" value="1"
                                       class="custom-control-input"
                                       id="kullanici_epostaonay" checked>
                                <label class="custom-control-label" for="kullanici_epostaonay"
                                       style="font-size: 14px ; ">
                                    Kampanya ve duyurulardan E-Posta ile haberdar olmak istiyorum </label>
                            </div>
                        </div>
                        <div class="form-group col-md-12 ">
                            <button type="submit" name="kullanicikaydet" class="button-blue button-2x"
                                    style="width: 100%; margin-top: 10px;  ">HESABI OLUŞTUR
                            </button>
                        </div>
                        <div class="form-group col-md-12 "
                             style="margin-bottom: 0; margin-top: 10px; font-size: 14px ;">
                            Zaten kayıtlı bir hesabınız mı var? <a href="uye-giris.php"
                                                                   style="font-weight: bold; color: #000;">Hemen Giriş
                                Yapın</a>
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

                                        <?php if ($_GET['durum'] == "farklisifre") { ?>
                                            <div>
                                                <strong>Hata!</strong> Girdiğiniz şifreler eşleşmiyor.
                                            </div>

                                        <?php } elseif ($_GET['durum'] == "eksiksifre") { ?>

                                            <div>
                                                <strong>Hata!</strong> Şifreniz minimum 6 karakter uzunluğunda
                                                olmalıdır.
                                            </div>

                                        <?php } elseif ($_GET['durum'] == "mukerrerkayit") { ?>

                                            <div>
                                                <strong>Hata!</strong> Bu kullanıcı daha önce kayıt edilmiş.
                                            </div>

                                        <?php } elseif ($_GET['durum'] == "basarisiz") { ?>

                                            <div>
                                                <strong>Hata!</strong> Kayıt Yapılamadı Sistem Yöneticisine Danışınız.
                                            </div>

                                        <?php } ?>

                                    </div>
                                    <div class="category-cart-add-success-modal-footer">
                                        <button type="button" class="button-blue button-2x"
                                                style="width: 100%; text-align: center; " data-dismiss="modal">Tamam
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } elseif (isset($_GET['durum']) && $_GET['durum'] == "basarili") { ?>

                        <div class="modal-backdrop"></div>

                        <div class="custom-modal">
                            <div class="success-icon">
                                <i class="ion-ios-checkmark-circle-outline"></i>
                            </div>
                          <!-- Gecici olarak kapatıldı  <div class="modal-text">
                                İşleminiz başarıyla tamamlanmıştır.<br>
                                Üye giriş sayfasına yönlendiriliyorsunuz...
                                <p><strong id="countdown">5</strong> saniye</p>
                            </div>  -->
                            <div class="modal-text">
                            Kaydınız başarıyla tamamlanmıştır.<br>
                            Hesabınız yönetici onayı bekliyor. Onaylandıktan sonra giriş yapabilirsiniz.<br>
                            <p>Anlayışınız için teşekkür ederiz.</p>
                            <p><strong id="countdown">5</strong> saniye</p>
                            </div>
                        </div>

                        <!-- Ionicons (Başarı İkonu için) -->
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.7.0/css/ionicons.min.css" rel="stylesheet">

                        <!-- Geri Sayım JS -->
                        <script>
                            let countdown = 5;
                            const countdownElement = document.getElementById('countdown');

                            const interval = setInterval(() => {
                                countdown--;
                                countdownElement.textContent = countdown;
                                if (countdown === 0) {
                                    clearInterval(interval);
                                    // Yönlendirme işlemi
                                    window.location.href = 'uye-giris.php'; // Üye giriş sayfasına yönlendiriyoruz
                                }
                            }, 1000);
                        </script>

                    <?php } ?>
                </form>
            </div>
        </div>

        <div class="user_page_right_text_div">
            <div style="font-size: 18px; font-weight: bold; color: #000; margin-bottom: 25px;">&Uuml;ye olmanız i&ccedil;in
                bir ka&ccedil; neden
            </div>
            <div style="font-size: 14px; margin-bottom: 30px;">Sitemize &uuml;yelik &uuml;cretsizdir. Eğer kayıt
                yaptırmadıysanız birka&ccedil; dakika i&ccedil;inde sitemize &uuml;ye olup giriş yapabilirsiniz.
            </div>
            <ul style="padding: 0!important; padding-left: 20px !important; font-size: 14px;">
                <li>&Ouml;nceki siparişlerinize kolayca ulaşabilirsiniz.</li>
                <li>Destek bildiriminde bulunarak tenik ekibimizle iletişime ge&ccedil;ebilirsiniz</li>
                <li>&Uuml;r&uuml;nlerinizi favorilere ekleyebilirsiniz</li>
                <li>İndirim Kuponlarından faydalanabilirsiniz</li>
                <li>&Uuml;r&uuml;nlere yorum veya değerlendirme ekleyebilirsiniz</li>
                <li>Size &ouml;zel bildirimleri g&ouml;rebilirsiniz</li>
                <li>Kolayca adınıza adres tanımlaması yapabilir, faturalarınız i&ccedil;in ayrıca adresler
                    oluşturabilirsiniz
                </li>
                <li>&Ouml;zel &uuml;ye gruplarına dahil olabilir, bu gruplara &ouml;zel indirimli fiyatlardan
                    yararlanabilirsiniz
                </li>
            </ul>
        </div>

    </div>


</div>

<div class="modal " id="sozlesmeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalCenterTitle" style="font-weight: bold;">
                    Üyelik Sözleşmesi </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ;">
                <p>Bu alanı İ&ccedil;erik Y&ouml;netimi &gt; S&ouml;zleşmeler &gt; &Uuml;yelik S&ouml;zleşmesi alanından
                    mevcut dilinize g&ouml;re d&uuml;zenleyebilirsiniz</p></div>
            <div class="modal-footer">
                <button type="button" class="button-black button-1x" data-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>



</body>


</html>


<script id="rendered-js">
    $('.uye-tipi input').change(function () {
        $(this).closest('.uye-tipi').next('.uye-tipi-bireysel').toggle(this.value == '1').next('.uye-tipi-kurumsal').toggle(this.value == '2');
    }).filter(':checked').change();

    /* Password See */
    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    /*  <========SON=========>>> Password See SON */
</script>
<div id="shopButtonOverlay" style="font-family : 'Open Sans',Sans-serif ;">
    <div class="shopButtonT">
        <div><img src="../images/load.svg"></div>
        <div>İşleminiz Sürüyor, Lütfen Bekleyiniz</div>
    </div>
</div></div>

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

