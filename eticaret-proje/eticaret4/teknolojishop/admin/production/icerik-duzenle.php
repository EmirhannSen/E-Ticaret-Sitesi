<?php 

include 'header.php'; 


$iceriksor=$db->prepare("SELECT * FROM icerikler where icerik_id=:id");
$iceriksor->execute(array(
  'id' => $_GET['icerik_id']
  ));

$icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC);

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>İçerik Düzenleme <small>,

              <?php 

              if (isset($_GET['durum']) && $_GET['durum']=="ok") {?>

              <b style="color:green;">İşlem Başarılı...</b>

              <?php } elseif (isset($_GET['durum']) && $_GET['durum']=="no") {?>

              <b style="color:red;">İşlem Başarısız...</b>

              <?php }

              ?>


            </small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-icerik" role="icerik">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
            <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Ad <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="icerik_baslik" value="<?php echo $icerikcek['icerik_baslik'] ?>" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Durum<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="heard" class="form-control" name="icerik_durum" required>
                            <!-- Kısa İf Kulllanımı
                    <?php echo $icerikcek['icerik_durum'] == '1' ? 'selected=""' : ''; ?>
                  -->
                            <option value="1" <?php echo $icerikcek['icerik_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>
                            <option value="0" <?php if ($icerikcek['icerik_durum']==0) { echo 'selected=""'; } ?>>Pasif</option>
                            <!-- <?php
                            if ($icerikcek['icerik_durum']==0) {?>
                   <option value="0">Pasif</option>
                   <option value="1">Aktif</option>
                   <?php } else {?>
                   <option value="1">Aktif</option>
                   <option value="0">Pasif</option>
                   <?php  }
                            ?> -->
                        </select>
                    </div>
                </div>



                <!-- Ck Editör Başlangıç -->

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Detay </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <textarea  class="ckeditor" id="editor1" name="icerik_metni"><?php echo $icerikcek['icerik_metni']; ?></textarea>
                    </div>
                </div>

                <script type="text/javascript">

                    CKEDITOR.replace( 'editor1',

                        {

                            filebrowserBrowseUrl : 'ckfinder/ckfinder.html',

                            filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',

                            filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',

                            filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                            filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                            filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',

                            forcePasteAsPlainText: true

                        }

                    );

                </script>

                <!-- Ck Editör Bitiş -->

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Url </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" name="icerik_seourl" value="<?php echo $icerikcek['icerik_seourl'] ?>"  class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Sıra </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" name="icerik_sira" value="<?php echo $icerikcek['icerik_sira'] ?>" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

              <!-- İçerik Tipi -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Tipi <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="icerik_type" class="form-control" name="icerik_type" required>
                    <?php
                    $icerikTypeSor = $db->prepare("SELECT DISTINCT icerik_type FROM icerikler");
                    $icerikTypeSor->execute();
                    while ($icerikTypeCek = $icerikTypeSor->fetch(PDO::FETCH_ASSOC)) { ?>
                      <option value="<?php echo $icerikTypeCek['icerik_type']; ?>" <?php echo $icerikcek['icerik_type'] == $icerikTypeCek['icerik_type'] ? 'selected' : ''; ?>>
                        <?php echo $icerikTypeCek['icerik_type']; ?>
                      </option>
                    <?php } ?>
                    <option value="yeni">Yeni Tip Ekle</option>
                  </select>
                  <input type="text" id="yeni_icerik_type" name="yeni_icerik_type" placeholder="Yeni içerik tipi giriniz" class="form-control col-md-7 col-xs-12" style="display:none; margin-top:10px;">
                </div>
              </div>
              <script>
                document.getElementById('icerik_type').addEventListener('change', function () {
                  const yeniIcerikType = document.getElementById('yeni_icerik_type');
                  if (this.value === 'yeni') {
                    yeniIcerikType.style.display = 'block';
                  } else {
                    yeniIcerikType.style.display = 'none';
                  }
                });
              </script>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sayfa Linki </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="" id="first-name" name="content_url" disabled="" value="/content-<?php echo seo($icerikcek['icerik_seourl']) ?>" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>




             <input type="hidden" name="icerik_id" value="<?php echo $icerikcek['icerik_id'] ?>">


             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="icerikduzenle" class="btn btn-success">Güncelle</button>
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
