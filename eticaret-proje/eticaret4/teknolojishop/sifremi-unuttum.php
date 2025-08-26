<?php
include 'header.php';
?>

<div class="users_main_div" style="background-color: #ffffff;  font-family : 'Roboto',sans-serif ; ">
    <div class="user_login_register_div">
        <!-- Header !-->
        <div class="user_page_header"> ŞİFRENİZİ SIFIRLAYIN </div>
        <!--  <========SON=========>>> Header SON !-->
        <div class="user_page_login_form">
            <div class=" teslimat-form-area">
                <form action="settings/islem.php" method="post">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="emailadress" style="font-weight: 600;">* E-Posta Adresiniz</label>
                            <input type="text" name="emailadress" id="emailadress" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12 ">
                            <a class="button-blue button-2x" href="#" data-toggle="modal" data-target="#hata" style="width: 100%; text-align: center; ">BAĞLANTIYI GÖNDER</a>
                        </div>
                        <div class="modal fade" id="hata" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered  " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalCenterTitle" style="font-weight: bold;"> Dikkat </h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="font-size: 14px ;"> Bu web sitesi e-posta gönderimini devre dışı bıraktığı için bu fonksiyon kullanılamaz. Site yönetimine ulaşarak durumu bildirebilirsiniz. </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button-black button-1x" data-dismiss="modal">Tamam</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="register-page-uyelik-tipi-main uye-tipi" style="margin-top: 25px; margin-bottom: 0;">
                        <div class="register-page-uyelik-tipi-h">
                            <div class="register-page-uyelik-tipi-h-in"> Önemli </div>
                        </div>
                        <div style="font-size: 13px ; margin-bottom: 10px;"> Şifrenizi sıfırlamak için üstteki alana kayıtlı e-posta adresinizi girmelisiniz. Ardından gelen mail içeriğindeki bağlantıya tıklayarak şifrenizi yenileyebilirsiniz. </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include 'footer.php'; ?>
