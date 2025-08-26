<?php 

include 'header.php'; 


$bankasor=$db->prepare("SELECT * FROM banka_hesaplari where banka_id=:id");
$bankasor->execute(array(
  'id' => $_GET['banka_id']
  ));

$bankacek=$bankasor->fetch(PDO::FETCH_ASSOC);

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Banka Hesabı Düzenle <small>,

              <?php 

              if (isset($_GET['durum']) && $_GET['durum']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif (isset($_GET['durum']) && $_GET['durum']=="no") {?>

              <b style="color:red;">İşlem Başarısız...</b>

              <?php }

              ?>


            </small></h2>
          
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
            <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Banka Adı <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="banka_ad" value="<?php echo $bankacek['banka_ad'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Durum<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="heard" class="form-control" name="banka_durum" required>
                            <option value="1" <?php echo $bankacek['banka_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>
                            <option value="0" <?php if ($bankacek['banka_durum']==0) { echo 'selected=""'; } ?>>Pasif</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Şube Kodu<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" name="banka_sube" value="<?php echo $bankacek['banka_sube'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hesap No<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" name="banka_hesapno" value="<?php echo $bankacek['banka_hesapno'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Banka IBAN <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="banka_iban" value="<?php echo $bankacek['banka_iban'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hesap Sahibi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="banka_hesapsahibi" value="<?php echo $bankacek['banka_hesapsahibi'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Döviz Türü<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="heard" class="form-control" name="doviz_turu" required>
                            <option value="TL">TL</option>
                            <option value="USD">USD</option>
                            <option value="EURO">EURO</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Banka Logo<br><span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?php
                        if (strlen($bankacek['banka_logo'])>0) {?>
                            <img width="200"  src="../../<?php echo $bankacek['banka_logo']; ?>">
                        <?php } else {?>
                            <img width="200"  src="../../images/logo-yok.png">
                        <?php } ?>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Resim Seç</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file" id="first-name"  name="banka_logo"  class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <input type="hidden" name="existing_logo" value="<?php echo $bankacek['banka_logo']; ?>">

             <input type="hidden" name="banka_id" value="<?php echo $bankacek['banka_id'] ?>"> 


             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="bankaduzenle" class="btn btn-success">Güncelle</button>
              </div>
            </div>

          </form>



        </div>
      </div>
    </div>
  </div>



  <hr>
  <hr>
  <hr>



</div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
