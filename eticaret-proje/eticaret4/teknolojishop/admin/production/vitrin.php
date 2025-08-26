<?php
include 'header.php';

// Vitrinleri getir
$vitrinsor = $db->prepare("SELECT * FROM vitrin WHERE vitrin_id IN (72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84) ORDER BY vitrin_sira");
$vitrinsor->execute();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Vitrin Listesi <small>
                <?php 
                if(isset($_GET['durum'])) {
                  if ($_GET['durum']=="ok") { ?>
                    <b style="color:green;">İşlem Başarılı...</b>
                  <?php } elseif ($_GET['durum']=="no") { ?>
                    <b style="color:red;">İşlem Başarısız...</b>
                  <?php }
                }
                ?>
              </small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Vitrin Adı</th>
                  <th>Vitrin Açıklaması</th>
                  <th>Durum</th>
                  <th>İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $say = 0;
                while($vitrincek=$vitrinsor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                ?>
                <tr>
                  <td><?php echo $say; ?></td>
                  <td><?php echo $vitrincek['vitrin_adi']; ?></td>
                  <td><?php echo $vitrincek['vitrin_aciklama']; ?></td>
                  <td>
                    <?php if ($vitrincek['vitrin_durum']==1) { ?>
                      <button class="btn btn-success btn-xs">Aktif</button>
                    <?php } else { ?>
                      <button class="btn btn-danger btn-xs">Pasif</button>
                    <?php } ?>
                  </td>
                  <td width="120">
                    <a href="vitrin-duzenle.php?vitrin_id=<?php echo $vitrincek['vitrin_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a>
                    <a href="vitrin-urun.php?vitrin_id=<?php echo $vitrincek['vitrin_id']; ?>"><button class="btn btn-warning btn-xs">Ürünler</button></a>
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
