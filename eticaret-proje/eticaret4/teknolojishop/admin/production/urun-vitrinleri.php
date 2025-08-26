<?php include 'header.php'; ?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Ürün Vitrinleri 
              <small>
                <?php 
                if(isset($_GET['durum'])) {
                  if ($_GET['durum']=="ok") { ?>
                    <b style="color:green;">İşlem Başarılı...</b>
                  <?php } elseif ($_GET['durum']=="no") { ?>
                    <b style="color:red;">İşlem Başarısız...</b>
                  <?php }
                }
                ?>
              </small>
            </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-md-12" style="padding-bottom: 20px;">
                <div style="float:left;">
                  <a href="urun-vitrin-ekle.php" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Vitrin Oluştur</a>
                </div>
              </div>
            </div>

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>ID</th>
                  <th>Vitrin Adı</th>
                  <th>Açıklama</th>
                  <th>Ürünler</th>
                  <th>Durum</th>
                  <th>İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Vitrin bilgilerini ve her vitrine ait ürün sayısını çekelim
                $vitrinsor = $db->prepare("SELECT v.*, COUNT(vu.urun_id) as urun_sayisi 
                                          FROM vitrin v 
                                          LEFT JOIN vitrin_urun vu ON v.vitrin_id = vu.vitrin_id 
                                          WHERE v.vitrin_id IN (72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84)
                                          GROUP BY v.vitrin_id 
                                          ORDER BY v.vitrin_sira ASC");
                $vitrinsor->execute();
                
                $say = 0;
                while ($vitrincek = $vitrinsor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                ?>
                <tr>
                  <td><?php echo $say; ?></td>
                  <td><?php echo $vitrincek['vitrin_id']; ?></td>
                  <td><?php echo $vitrincek['vitrin_adi']; ?></td>
                  <td><?php echo $vitrincek['vitrin_aciklama']; ?></td>
                  <td>
                    <strong><?php echo $vitrincek['urun_sayisi']; ?></strong> ürün tanımlı
                  </td>
                  <td>
                    <?php if ($vitrincek['vitrin_durum']) { ?>
                      <button class="btn btn-success btn-xs">Aktif</button>
                    <?php } else { ?>
                      <button class="btn btn-danger btn-xs">Pasif</button>
                    <?php } ?>
                  </td>
                  <td width="120">
                    <a href="urun-vitrin-duzenle.php?vitrin_id=<?php echo $vitrincek['vitrin_id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Düzenle</a>
                    <a href="../netting/islem.php?vitrinsil=ok&vitrin_id=<?php echo $vitrincek['vitrin_id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Bu vitrini silmek istediğinizden emin misiniz?');"><i class="fa fa-trash"></i> Sil</a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
