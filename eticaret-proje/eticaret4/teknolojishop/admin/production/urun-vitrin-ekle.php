<?php include 'header.php'; ?>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Yeni Vitrin Ekle</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <form action="../netting/islem.php" method="POST" class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Vitrin Adı <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="vitrin_adi" required class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Vitrin Açıklaması</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name="vitrin_aciklama" class="form-control col-md-7 col-xs-12"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Vitrin Tasarımı <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="vitrin_dizayn" required class="form-control">
                    <option value="">Tasarım Seçiniz</option>
                    <option value="slider_display1">Slider Display 1</option>
                    <option value="uclu_banner">Üçlü Banner</option>
                    <option value="banner_slider">Banner Slider</option>
                    <option value="vitrin_urun_slider">Vitrin Ürün Slider</option>
                    <option value="firsat_vitrin_banner">Fırsat Vitrin Banner</option>
                    <option value="tabli_vitrin">Tablı Vitrin</option>
                    <option value="markalar">Markalar</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sıralama</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" name="vitrin_sira" value="0" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Durum</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="vitrin_durum" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="vitrinekle" class="btn btn-success">Kaydet</button>
                  <a href="urun-vitrinleri.php" class="btn btn-default">İptal</a>
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
