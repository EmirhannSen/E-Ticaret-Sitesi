<?php 
include 'header.php';

// Sipariş kontrolü
if(!isset($_GET['siparis_no']) || !isset($_GET['durum']) || $_GET['durum'] != 'ok') {
    Header("Location:index.php");
    exit;
}

$siparis_no = $_GET['siparis_no'];

// Sipariş bilgilerini al
$siparissor = $db->prepare("SELECT * FROM siparis WHERE siparis_no=:no");
$siparissor->execute(['no' => $siparis_no]);
$sipariscek = $siparissor->fetch(PDO::FETCH_ASSOC);

// Sipariş yoksa ana sayfaya yönlendir
if($siparissor->rowCount() == 0) {
    Header("Location:index.php");
    exit;
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="success-icon my-4">
                        <i class="ion-ios-checkmark-circle-outline" style="font-size: 80px; color: #28a745;"></i>
                    </div>
                    
                    <h2>Siparişiniz Başarıyla Oluşturuldu!</h2>
                    <p class="lead">Sipariş Numaranız: <strong><?php echo $siparis_no; ?></strong></p>
                    <p>Siparişiniz başarıyla oluşturuldu ve onay sürecine alındı. Sipariş durumunuzu hesabınızın sipariş geçmişi bölümünden takip edebilirsiniz.</p>
                    
                    <?php if($sipariscek['odeme_tipi'] == 2): // Havale/EFT ?>
                    <div class="alert alert-info mt-3">
                        <h5>Havale/EFT Bilgileri</h5>
                        <p>Siparişinizin onaylanması için aşağıdaki banka hesaplarımızdan birine ödeme yapabilirsiniz.</p>
                        <hr>
                        <p><strong>Banka:</strong> X Bankası</p>
                        <p><strong>Hesap Sahibi:</strong> Teknoloji Shop</p>
                        <p><strong>IBAN:</strong> TR00 0000 0000 0000 0000 0000 00</p>
                        <p><small>* Açıklama kısmına sipariş numaranızı yazmayı unutmayınız.</small></p>
                    </div>
                    <?php endif; ?>
                    
                    <div class="mt-4">
                        <a href="index.php" class="btn btn-primary">Alışverişe Devam Et</a>
                        <a href="hesabim-siparislerim.php" class="btn btn-outline-secondary">Siparişlerimi Görüntüle</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ionicons (Başarı İkonu için) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.7.0/css/ionicons.min.css" rel="stylesheet">

<?php include 'footer.php'; ?>
