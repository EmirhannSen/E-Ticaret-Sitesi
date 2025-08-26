<?php 
include 'header.php'; 

// Şehirleri çek
$sehirsor = $db->prepare("SELECT * FROM sehir ORDER BY sehir_ad ASC");
$sehirsor->execute();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yeni Yönetici Ekle</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <?php 
            if (isset($_GET['durum'])) {
              if ($_GET['durum'] == "ok") { ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <strong>Başarılı!</strong> İşlem başarıyla gerçekleştirildi.
                </div>
              <?php } elseif ($_GET['durum'] == "no") { ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <strong>Hata!</strong> İşlem sırasında bir problem oluştu.
                </div>
              <?php } elseif ($_GET['durum'] == "mailvar") { ?>
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <strong>Hata!</strong> Bu e-posta adresi zaten kullanılıyor.
                </div>
              <?php }
            }
            ?>

            <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_resim">Profil Resmi</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" id="kullanici_resim" name="kullanici_resim" class="form-control">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_tc">TC Kimlik No</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="kullanici_tc" name="kullanici_tc" class="form-control col-md-7 col-xs-12">
                  <small class="text-muted">Boş bırakılırsa otomatik olarak 11111111111 atanacaktır.</small>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_ad">Ad <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="kullanici_ad" name="kullanici_ad" required class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_soyad">Soyad <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="kullanici_soyad" name="kullanici_soyad" required class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_mail">E-posta <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="email" id="kullanici_mail" name="kullanici_mail" required class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_gsm">Telefon</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="kullanici_gsm" name="kullanici_gsm" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_password">Şifre <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="password" id="kullanici_password" name="kullanici_password" required class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_adres">Adres</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea id="kullanici_adres" name="kullanici_adres" class="form-control"></textarea>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_il">İl</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="kullanici_il" name="kullanici_il" class="form-control select2" onchange="ilceGetir(this.value)">
                    <option value="">Şehir Seçiniz</option>
                    <?php while($sehir = $sehirsor->fetch(PDO::FETCH_ASSOC)) { ?>
                      <option value="<?php echo $sehir['sehir_id']; ?>">
                        <?php echo $sehir['sehir_ad']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_ilce">İlçe</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="kullanici_ilce" name="kullanici_ilce" class="form-control select2">
                    <option value="">İlçe Seçiniz</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_unvan">Unvan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="kullanici_unvan" name="kullanici_unvan" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kullanici_durum">Durum</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="kullanici_durum" name="kullanici_durum" class="form-control">
                    <option value="1" selected>Aktif</option>
                    <option value="0">Pasif</option>
                  </select>
                </div>
              </div>
              
              <!-- Kullanıcı yetkisi admin (5) olarak ayarlanıyor -->
              <input type="hidden" name="kullanici_yetki" value="5">
              
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="admin-list.php" class="btn btn-default">İptal</a>
                  <button type="submit" name="adminekle" class="btn btn-success">Yöneticiyi Ekle</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<script>
function ilceGetir(sehir_id) {
  if (sehir_id == "") {
    document.getElementById("kullanici_ilce").innerHTML = "<option value=''>İlçe Seçiniz</option>";
    return;
  }
  
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("kullanici_ilce").innerHTML = this.responseText;
    }
  };
  xmlhttp.open("GET", "ajax/ilce-getir.php?sehir_id="+sehir_id, true);
  xmlhttp.send();
}
</script>

<?php include 'footer.php'; ?>
