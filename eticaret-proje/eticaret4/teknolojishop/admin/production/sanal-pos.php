<?php 
include 'header.php'; 

// Sanal POS listesini al
$possor = $db->prepare("SELECT * FROM banka_pos ORDER BY bankapos_id ASC");
$possor->execute();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Sanal POS Ayarları</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sanal POS Listesi 
              <small>
                <?php 
                if (isset($_GET['durum'])) {
                  if ($_GET['durum']=="ok") { ?>
                    <b style="color:green;">İşlem Başarılı...</b>
                  <?php } elseif ($_GET['durum']=="no") { ?>
                    <b style="color:red;">İşlem Başarısız...</b>
                  <?php }
                }
                ?>
              </small>
            </h2>
            <div class="clearfix"></div>
            <div align="right">
              <a href="sanal-pos-ekle.php"><button class="btn btn-success btn-xs"> Yeni Ekle</button></a>
            </div>
          </div>
          <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Banka Adı</th>
                  <th>Logo</th>
                  <th>Durum</th>
                  <th>Taksit Sayısı</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $say = 0;
                while($poscek = $possor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                ?>
                <tr>
                  <td width="20"><?php echo $say; ?></td>
                  <td><?php echo $poscek['bankapos_adi']; ?></td>
                  <td>
                    <img src="../../<?php echo $poscek['bankapos_resim']; ?>" width="120" alt="<?php echo $poscek['bankapos_adi']; ?>">
                  </td>
                  <td>
                    <?php 
                    if ($poscek['bankapos_durum'] == '1') { ?>
                      <button class="btn btn-success btn-xs">Aktif</button>
                    <?php } else { ?>
                      <button class="btn btn-danger btn-xs">Pasif</button>
                    <?php } ?>
                  </td>
                  <td><?php echo $poscek['bankapos_taksit_sayisi']; ?></td>
                  <td><center><a href="sanal-pos-duzenle.php?bankapos_id=<?php echo $poscek['bankapos_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                  <td><center><a href="../netting/islem.php?bankapos_id=<?php echo $poscek['bankapos_id']; ?>&sanalpos_sil=ok" onclick="return confirm('Bu POS ayarını silmek istediğinizden emin misiniz?');"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
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
