<?php 
include 'header.php';

// POS bilgilerini al
$possor = $db->prepare("SELECT * FROM banka_pos WHERE bankapos_id=:id");
$possor->execute(['id' => $_GET['bankapos_id']]);
$poscek = $possor->fetch(PDO::FETCH_ASSOC);
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Sanal POS Düzenle</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>POS Bilgileri
              <small>
                <?php 
                if (isset($_GET['durum'])) {
                  if ($_GET['durum']=="ok") { ?>
                    <b style="color:green;">İşlem Başarılı...</b>
                  <?php } elseif ($_GET['durum']=="no") { ?>
                    <b style="color:red;">İşlem Başarısız...</b>
                  <?php }
                }
                ?>
              </small>
            </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
              
              <input type="hidden" name="bankapos_id" value="<?php echo $poscek['bankapos_id']; ?>">
              <input type="hidden" name="mevcut_resim" value="<?php echo $poscek['bankapos_resim']; ?>">
              
              <!-- Banka Adı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bankapos_adi">Banka Adı <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="bankapos_adi" name="bankapos_adi" value="<?php echo $poscek['bankapos_adi']; ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <!-- Mevcut Logo -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Mevcut Logo</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php if(!empty($poscek['bankapos_resim'])) { ?>
                    <img src="../../<?php echo $poscek['bankapos_resim']; ?>" width="200" alt="<?php echo $poscek['bankapos_adi']; ?>">
                  <?php } else { ?>
                    <div class="alert alert-warning">Logo yüklenmemiş</div>
                  <?php } ?>
                </div>
              </div>

              <!-- Banka Resmi -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bankapos_resim">Yeni Logo Yükle</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" id="bankapos_resim" name="bankapos_resim" class="form-control col-md-7 col-xs-12">
                  <p class="help-block">Yeni bir logo yüklerseniz, mevcut logo değiştirilecektir. Önerilen boyut: 200x100px</p>
                </div>
              </div>

              <!-- Taksit Sayısı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bankapos_taksit_sayisi">Taksit Sayısı <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" id="bankapos_taksit_sayisi" name="bankapos_taksit_sayisi" required="required" min="1" max="12" value="<?php echo $poscek['bankapos_taksit_sayisi']; ?>" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <!-- Faiz Oranları -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Faiz Oranları (%)</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <!-- Tek Çekim -->
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>Tek Çekim</label>
                        <input type="text" name="bankapos_taksit1" value="<?php echo $poscek['bankapos_taksit1']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>2 Taksit</label>
                        <input type="text" name="bankapos_taksit2" value="<?php echo $poscek['bankapos_taksit2']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>3 Taksit</label>
                        <input type="text" name="bankapos_taksit3" value="<?php echo $poscek['bankapos_taksit3']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>4 Taksit</label>
                        <input type="text" name="bankapos_taksit4" value="<?php echo $poscek['bankapos_taksit4']; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  
                  <!-- 5-8 Taksit -->
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>5 Taksit</label>
                        <input type="text" name="bankapos_taksit5" value="<?php echo $poscek['bankapos_taksit5']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>6 Taksit</label>
                        <input type="text" name="bankapos_taksit6" value="<?php echo $poscek['bankapos_taksit6']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>7 Taksit</label>
                        <input type="text" name="bankapos_taksit7" value="<?php echo $poscek['bankapos_taksit7']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>8 Taksit</label>
                        <input type="text" name="bankapos_taksit8" value="<?php echo $poscek['bankapos_taksit8']; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  
                  <!-- 9-12 Taksit -->
                  <div class="row">
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>9 Taksit</label>
                        <input type="text" name="bankapos_taksit9" value="<?php echo $poscek['bankapos_taksit9']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>10 Taksit</label>
                        <input type="text" name="bankapos_taksit10" value="<?php echo $poscek['bankapos_taksit10']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>11 Taksit</label>
                        <input type="text" name="bankapos_taksit11" value="<?php echo $poscek['bankapos_taksit11']; ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group">
                        <label>12 Taksit</label>
                        <input type="text" name="bankapos_taksit12" value="<?php echo $poscek['bankapos_taksit12']; ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Banka Durum -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bankapos_durum">POS Durumu</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="bankapos_durum" name="bankapos_durum" class="form-control">
                    <option value="1" <?php echo $poscek['bankapos_durum'] == '1' ? 'selected' : ''; ?>>Aktif</option>
                    <option value="0" <?php echo $poscek['bankapos_durum'] == '0' ? 'selected' : ''; ?>>Pasif</option>
                  </select>
                </div>
              </div>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="sanalpos_duzenle" class="btn btn-success">Güncelle</button>
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

<?php include 'footer.php'; ?>
