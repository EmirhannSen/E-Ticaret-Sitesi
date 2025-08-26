<?php

include 'header.php';

//Belirli veriyi seçme işlemi
$sssSor = $db->prepare("SELECT * FROM sss ORDER BY sss_id DESC");
$sssSor->execute();


?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Sık Sorulan Sorular <small>,

                                <?php

                                if (isset($_GET['durum']) && $_GET['durum']=="ok") {?>

                                    <b style="color:green;">İşlem Başarılı...</b>

                                <?php } elseif (isset($_GET['durum']) && $_GET['durum']=="no") {?>

                                    <b style="color:red;">İşlem Başarısız...</b>

                                <?php }

                                ?>


                            </small></h2>

                        <div class="clearfix"></div>

                        <div align="right">
                            <a href="sss-ekle.php"><button class="btn btn-success btn-xs"> Yeni Ekle</button></a>

                        </div>
                    </div>
                    <div class="x_content">


                        <!-- Div İçerik Başlangıç -->

                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Başlık</th>
                                <th>Durum</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $say=0;

                            while ($sssCek = $sssSor->fetch(PDO::FETCH_ASSOC)) {
                                $say++;
                                ?>
                                <tr>
                                    <td><?php echo $say; ?></td>
                                    <td><?php echo $sssCek['sss_tittle']; ?></td>
                                    <td>
                                        <center><?php
                                            if (isset($sssCek['sss_durum']) && $sssCek['sss_durum']==1) {?>
                                                <button class="btn btn-success btn-xs">Aktif</button>
                                            <?php } else {?>
                                                <button class="btn btn-danger btn-xs">Pasif</button>
                                            <?php } ?>
                                    </td>
                                    <td><a href="sss-duzenle.php?sss_id=<?php echo $sssCek['sss_id']; ?>" class="btn btn-primary btn-xs">Düzenle</a></td>
                                    <td><a href="../netting/islem.php?sss_sil=ok&sss_id=<?php echo $sssCek['sss_id']; ?>" class="btn btn-danger btn-xs">Sil</a></td>
                                </tr>
                            <?php  }
                            ?>
                            </tbody>
                        </table>

                        <!-- Div İçerik Bitişi -->


                    </div>
                </div>
            </div>
        </div>




    </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
