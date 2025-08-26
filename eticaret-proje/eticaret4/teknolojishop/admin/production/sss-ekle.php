<?php include 'header.php'; ?>
<div class="right_col" role="main">
  <div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sık Sorulan Soru Ekle</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form action="../netting/islem.php" method="POST" class="form-horizontal form-label-left">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Soru Başlığı</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="sss_tittle" required class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Soru İçeriği</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name="sss_icerik" required class="form-control"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Durum</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="sss_durum" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                  </select>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="sss_ekle" class="btn btn-success">Kaydet</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
