<?php 

include 'header.php'; 

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>İçerik Ekleme <small>,

            </small></h2>
            
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
            <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Başlık <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="icerik_baslik"  required="required" placeholder="İçerik başlığı giriniz" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Durum<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="heard" class="form-control" name="icerik_durum" required>
                            <option value="1" >Aktif</option>
                            <option value="0" >Pasif</option>
                        </select>
                    </div>
                </div>

              <!-- Ck Editör Başlangıç -->

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Detay </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea  class="ckeditor" id="editor1" name="icerik_metni"></textarea>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Tipi <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="icerik_type" class="form-control" name="icerik_type" required>
                        <?php
                        $icerikTypeSor = $db->prepare("SELECT DISTINCT icerik_type FROM icerikler");
                        $icerikTypeSor->execute();
                        while ($icerikTypeCek = $icerikTypeSor->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $icerikTypeCek['icerik_type']; ?>"><?php echo $icerikTypeCek['icerik_type']; ?></option>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Sıra </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="first-name" name="icerik_sira" placeholder="İçerik sıra giriniz"  class="form-control col-md-7 col-xs-12">
                    </div>
                </div>




             <div class="ln_solid"></div>
             <div class="form-group">
              <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" name="icerikkaydet" class="btn btn-success">Kaydet</button>
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
