<?php 

include 'header.php'; 

function kategoriListele($db, $kategori_ust = 0, $seviye = 0) {
    $kategorisor = $db->prepare("SELECT * FROM kategori WHERE kategori_ust = :ust ORDER BY kategori_ad ASC");
    $kategorisor->execute(['ust' => $kategori_ust]);
    while ($kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $kategoricek['kategori_id'] . '">' . str_repeat('- ', $seviye) . $kategoricek['kategori_ad'] . '</option>';
        kategoriListele($db, $kategoricek['kategori_id'], $seviye + 1);
    }
}
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Kategori Ekle <small>,

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
            <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <!-- Üst Kategori -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ust-kategori">Üst Kategori</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="kategori_ust">
                    <option value="0">Ana Kategori</option>
                    <?php kategoriListele($db); ?>
                  </select>
                </div>
              </div>

              <!-- Kategori Ad -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori-ad">Kategori Ad <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="kategori-ad" name="kategori_ad" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <!-- Kategori Sıra -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori-sira">Kategori Sıra</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="kategori-sira" name="kategori_sira" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <!-- Kategori Durum -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori-durum">Kategori Durum <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="kategori-durum" class="form-control" name="kategori_durum" required>
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                  </select>
                </div>
              </div>

              <input type="hidden" name="kategori_id" value="<?php echo $kategoricek['kategori_id'] ?>"> 

              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="kategoriekle" class="btn btn-success">Kaydet</button>
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
