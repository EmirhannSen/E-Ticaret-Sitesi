<?php include 'header.php'; ?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yeni Marka Ekle</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

            <?php 
            if (isset($_GET['durum'])) {
              if ($_GET['durum'] == "ok") { ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <strong>Başarılı!</strong> Marka başarıyla eklendi.
                </div>
              <?php } elseif ($_GET['durum'] == "no") { ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <strong>Hata!</strong> Marka eklenirken bir sorun oluştu.
                </div>
              <?php }
            }
            ?>

            <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="marka_adi">Marka Adı <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="marka_adi" name="marka_adi" required class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="marka_url">Marka URL</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="marka_url" name="marka_url" class="form-control col-md-7 col-xs-12" placeholder="marka/adres/gibi">
                  <small class="text-muted">Boş bırakırsanız otomatik oluşturulacaktır.</small>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="marka_resim">Marka Logo</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" id="marka_resim" name="marka_resim" class="form-control col-md-7 col-xs-12">
                  <small class="text-muted">Tercihen 200x100 px boyutlarında PNG formatında logo yükleyiniz.</small>
                </div>
              </div>
              
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <a href="markalar.php" class="btn btn-default">İptal</a>
                  <button type="submit" name="markaekle" class="btn btn-success">Markayı Ekle</button>
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
