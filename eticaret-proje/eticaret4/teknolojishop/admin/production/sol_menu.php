<?php include 'header.php'; ?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Vitrin Yönetimi</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Ürün Vitrinleri</h2>
            <div align="right">
              <a href="urun-vitrin-ekle.php"><button class="btn btn-success btn-xs">Yeni Ekle</button></a>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Vitrin Adı</th>
                  <th>Vitrin Açıklaması</th>
                  <th>Durum</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $say = 0;
                $vitrinsor = $db->prepare("SELECT * FROM vitrin ORDER BY vitrin_id DESC");
                $vitrinsor->execute();
                while ($vitrincek = $vitrinsor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                ?>
                <tr>
                  <td><?php echo $say; ?></td>
                  <td><?php echo $vitrincek['vitrin_adi']; ?></td>
                  <td><?php echo $vitrincek['vitrin_aciklama']; ?></td>
                  <td>
                    <?php if ($vitrincek['vitrin_durum'] == "1") { ?>
                      <button class="btn btn-success btn-xs">Aktif</button>
                    <?php } else { ?>
                      <button class="btn btn-danger btn-xs">Pasif</button>
                    <?php } ?>
                  </td>
                  <td>
                    <a href="urun-vitrin-duzenle.php?vitrin_id=<?php echo $vitrincek['vitrin_id']; ?>">
                      <button class="btn btn-primary btn-xs">Düzenle</button>
                    </a>
                  </td>
                  <td>
                    <a href="../netting/islem.php?vitrinsil=ok&vitrin_id=<?php echo $vitrincek['vitrin_id']; ?>">
                      <button class="btn btn-danger btn-xs">Sil</button>
                    </a>
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