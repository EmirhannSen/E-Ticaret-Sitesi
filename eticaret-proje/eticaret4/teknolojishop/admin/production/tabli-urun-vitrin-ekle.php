<?php include 'header.php'; ?>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Tablı Ürün Vitrini Ekle</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yeni Tablı Vitrin Oluştur</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form action="../netting/islem.php" method="POST" class="form-horizontal">
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Vitrin Adı <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="ad" required class="form-control">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sıralama</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" name="sira" value="0" class="form-control">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Durum</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="durum" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="tabli_vitrin_ekle" class="btn btn-success">Kaydet</button>
                  <a href="tabli-urun-vitrinleri.php" class="btn btn-default">İptal</a>
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
