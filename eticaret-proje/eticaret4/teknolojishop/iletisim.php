<?php 

include 'settings/baglan.php';

include 'header.php'; 

// Ayar tablosunda ana ayarımız olan 0 id deki site ayarlarını çekiyoruz.
$ayarSor=$db->prepare("SELECT * FROM ayar where ayar_id='0'");
$ayarSor->execute();
$ayarCek=$ayarSor->fetch(PDO::FETCH_ASSOC);

?>

          
<link rel="stylesheet" href="assets/css/content.css" rel="preload">


            <div id="MainDiv" style="background-color: #f3f6f9; width: 100%; font-family : 'Open Sans',Sans-serif ; overflow: hidden  ">
              <div class="page-banner-main">
                <div class="page-banner-in-text">
                  <div class="page-banner-h "> Bize Ulaşın </div>
                  <div class="page-banner-links ">
                    <a href="../index.html">
                      <i class="fa fa-home"></i> Anasayfa </a>
                    <span style="font-weight: bold;">/</span>
                    <a> Bize Ulaşın </a>
                  </div>
                </div>
              </div>
              <div class="iletisim-container-main">

                
                <?php include 'content-left-menu.php'; ?>


                <div class="iletisim-container-in">
                  <div class="iletisim-container-in-top row">
                    <div class=" mb-md-4 col-md-12 ">
                      <iframe src="<?php echo $ayarCek['ayar_maps'] ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                    <div class=" mb-md-4 col-md-3" style="text-align: center;">
                      <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                          <i class="las la-headset"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h"> ÇAĞRI MERKEZİ </div>
                        <div class="iletisim-container-in-top-box-s">
                          <a href="tel:<?php echo $ayarCek['ayar_tel'] ?>"><?php echo $ayarCek['ayar_tel'] ?></a>
                        </div>
                      </div>
                    </div>
                    <div class=" mb-md-4 col-md-3" style="text-align: center;">
                      <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                          <i class="lab la-whatsapp"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h"> WHATSAPP </div>
                        <div class="iletisim-container-in-top-box-s">
                          <a href="tel:<?php echo $ayarCek['ayar_gsm'] ?>"><?php echo $ayarCek['ayar_gsm'] ?></a>
                        </div>
                      </div>
                    </div>
                    <div class=" mb-md-4 col-md-3" style="text-align: center;">
                      <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                          <i class="las la-tty"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h"> TELEFON </div>
                        <div class="iletisim-container-in-top-box-s">
                          <a href="tel:<?php echo $ayarCek['ayar_tel'] ?>"> <?php echo $ayarCek['ayar_tel'] ?> </a>
                        </div>
                      </div>
                    </div>
                    <div class=" mb-md-4 col-md-3" style="text-align: center;">
                      <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                          <i class="fa fa-mobile"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h"> GSM </div>
                        <div class="iletisim-container-in-top-box-s">
                          <a href="tel:<?php echo $ayarCek['ayar_gsm'] ?>"> <?php echo $ayarCek['ayar_gsm'] ?> </a>
                        </div>
                      </div>
                    </div>
                    <div class=" mb-md-4 col-md-6" style="text-align: center;">
                      <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                          <i class="las la-envelope"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h"> GERİ BİLDİRİM </div>
                        <div class="iletisim-container-in-top-box-s">
                          <a href="mailto:<?php echo $ayarCek['ayar_mail'] ?>"> <?php echo $ayarCek['ayar_mail'] ?> </a>
                        </div>
                      </div>
                    </div>
                    <div class=" mb-md-4 col-md-6" style="text-align: center;">
                      <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                          <i class="las la-map-marker"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h"> LOKASYON </div>
                        <div class="iletisim-container-in-top-box-s"> <?php echo $ayarCek['ayar_adres'] . ' ' . $ayarCek['ayar_il'] . '/' . $ayarCek['ayar_ilce']?> </div>
                      </div>
                    </div>
                    <div class=" mb-md-4 col-md-12" style="text-align: center; ">
                      <div class="iletisim-container-in-top-box iletisim-container-in-top-box-social-flex">
                        <a href="<?php echo $ayarCek['ayar_twitter'] ?>" target="_blank" class="iletisim-container-in-top-box-social" data-toggle="tooltip" data-placement="top" title="Twitter">
                          <i class="fa fa-twitter"></i>
                        </a>
                        <a href="<?php echo $ayarCek['ayar_facebook'] ?>" target="_blank" class="iletisim-container-in-top-box-social" data-toggle="tooltip" data-placement="top" title="Facebook">
                          <i class="fa fa-facebook"></i>
                        </a>
                        <a href="<?php echo $ayarCek['ayar_instagram'] ?>" target="_blank" class="iletisim-container-in-top-box-social" data-toggle="tooltip" data-placement="top" title="instagram">
                          <i class="fa fa-instagram"></i>
                        </a>
                        <a href="<?php echo $ayarCek['ayar_linkedin'] ?>" target="_blank" class="iletisim-container-in-top-box-social" data-toggle="tooltip" data-placement="top" title="Linkedin">
                          <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="<?php echo $ayarCek['ayar_youtube'] ?>" target="_blank" class="iletisim-container-in-top-box-social" data-toggle="tooltip" data-placement="top" title="YouTube">
                          <i class="fa fa-youtube-play"></i>
                        </a>
                      </div>
                    </div>
                    <div class=" mb-md-4 col-md-12" style="text-align: center; ">
                      <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-h"> Lütfen bize sorularınızı, yorumlarınızı ve önerilerinizi göndermekten çekinmeyin. Her e-postayı okuyoruz ve sizin fikirleriniz önemsiyoruz. </div>
                      </div>
                    </div>
                    <div class="col-md-3" style="text-align: center;">
                      <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                          <i class="las la-stopwatch"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h"> ÇALIŞMA SAATLERİ </div>
                        <div class="iletisim-container-in-top-box-s">
                          <p>
                            <span style="font-size: 14px;"><?php echo $ayarCek['ayar_mesai'] ?></span><br />
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9" style="text-align: center;">
                      <form action="https://teknolojishop.demodeposu.com/contactpost" method="post">
                        <div class="row">
                          <div class="form-group col-md-6">
                            <input type="text" name="isim" class="form-control" placeholder="İsim" autocomplete="off">
                          </div>
                          <div class="form-group col-md-6">
                            <input type="text" name="eposta" class="form-control" placeholder="E-Posta" autocomplete="off">
                          </div>
                          <div class="form-group col-md-6">
                            <input type="number" name="telno" class="form-control" placeholder="Telefon Numarası" autocomplete="off">
                          </div>
                          <div class="form-group col-md-6">
                            <input type="text" name="konu" class="form-control" placeholder="Mesaj Konusu" autocomplete="off">
                          </div>
                          <div class="form-group col-md-12">
                            <textarea name="mesaj" class="form-control" rows="2" placeholder="Mesajınız"></textarea>
                          </div>
                          <div class="form-group col-md-12" style="text-align: right;">
                            <button type="submit" id="shopButton" name="iletisimpost" class="button-red button-2x" style="font-weight: 300; width: 100%;  "> GÖNDER </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          

            <?php include("footer.php"); ?>
          
     
