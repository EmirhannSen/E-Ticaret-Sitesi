<?php 
include 'header.php';

// Kullanıcı girişi yapılmamışsa login sayfasına yönlendir
if(!isset($_SESSION['kullanici_mail'])) {
    header("Location:uye-giris.php?durum=girisyap");
    exit;
}

// Kullanıcı durumu 1 değilse (onaylanmamışsa) anasayfaya yönlendir
if($kullanicicek['kullanici_durum'] != 1) {
    header("Location:index.php?durum=yetkisiz");
    exit;
}

// Sepeti kontrol et
$kullanici_id = $kullanicicek['kullanici_id'];
$sepetsor = $db->prepare("SELECT s.*, u.urun_adi, u.urun_satisfiyati, u.urun_resim1, u.urun_doviz, u.urun_kdvorani 
                         FROM sepet s 
                         INNER JOIN urun u ON s.urun_id = u.urun_id 
                         WHERE s.kullanici_id=:id");
$sepetsor->execute([
    'id' => $kullanici_id
]);

$sepet_urun_sayisi = $sepetsor->rowCount();

// Sepet boşsa anasayfaya yönlendir
if($sepet_urun_sayisi == 0) {
    header("Location:index.php?durum=sepet-bos");
    exit;
}

// Toplam tutarı hesapla
$araToplam = 0;
$toplamKdvTutari = 0;
$genelToplam = 0;
$sepet_urunleri = $sepetsor->fetchAll(PDO::FETCH_ASSOC);

foreach($sepet_urunleri as $sepet) {
    $kdvHaricFiyat = $sepet['urun_satisfiyati'] / (1+($sepet['urun_kdvorani']/100));
    $kdvTutari = $sepet['urun_satisfiyati'] - $kdvHaricFiyat;
    
    $araToplam += $kdvHaricFiyat * $sepet['urun_adet'];
    $toplamKdvTutari += $kdvTutari * $sepet['urun_adet'];
    $genelToplam += $sepet['urun_satisfiyati'] * $sepet['urun_adet'];
}

// Banka hesaplarını getir
$bankasor = $db->prepare("SELECT * FROM banka_hesaplari WHERE banka_durum=:durum");
$bankasor->execute(['durum' => 1]);
$bankalar = $bankasor->fetchAll(PDO::FETCH_ASSOC);

// Türkiye illeri veritabanından çek
$sehirsor = $db->prepare("SELECT * FROM sehir ORDER BY sehir_ad ASC");
$sehirsor->execute();
$sehirler = $sehirsor->fetchAll(PDO::FETCH_ASSOC);

// Kullanıcının ilinde bulunan ilçeleri çek (eğer il seçilmişse)
$ilceler = [];
if(!empty($kullanicicek['kullanici_il'])) {
    $ilcesor = $db->prepare("SELECT * FROM ilceler WHERE sehir_id = :sehir_id ORDER BY ilce_ad ASC");
    $ilcesor->execute(['sehir_id' => $kullanicicek['kullanici_il']]);
    $ilceler = $ilcesor->fetchAll(PDO::FETCH_ASSOC);
}
?>

<style>
    .page-banner-main {
        background: #1f1f1f;
        padding: 30px 0 30px 0;
        font-family: 'Roboto', sans-serif;
        border-bottom: 1px solid #ffffff;
        border-top: 1px solid #ffffff;
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .page-banner-in-text {
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-banner-h {
        font-size: 28px;
        color: #ffffff;
        font-weight: 400;
        line-height: 28px;
    }

    .page-banner-links {
        text-align: right;
        color: #cccccc;
    }

    .page-banner-links span {
        color: #cccccc;
        font-size: 13px;
    }

    .page-banner-links a {
        color: #cccccc;
        font-size: 13px;
    }

    .page-banner-links a:hover {
        color: #cccccc;
    }

    .payment-main-div {
        font-family: 'Roboto', Sans-serif;
        background-color: #fff;
        padding: 20px 0;
    }

    .button-blue {
        background-color: #4285F4;
        color: white;
        border: none;
        padding: 8px 15px;
        cursor: pointer;
    }

    .button-red {
        background-color: #DB4437;
        color: white;
        border: none;
        padding: 12px 15px;
        cursor: pointer;
        font-weight: bold;
    }

    .button-green {
        background-color: #0F9D58;
        color: white;
        border: none;
        padding: 8px 15px;
        cursor: pointer;
    }

    .button-2x {
        font-size: 16px;
    }

    .payment-section {
        background: #f9f9f9;
        border: 1px solid #ebebeb;
        padding: 20px;
        margin-bottom: 20px;
    }

    .payment-section-header {
        font-size: 18px;
        font-weight: bold;
        padding-bottom: 15px;
        margin-bottom: 15px;
        border-bottom: 1px solid #ebebeb;
    }

    .payment-summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 5px 0;
    }

    .payment-method-option {
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #ebebeb;
        border-radius: 5px;
        cursor: pointer;
    }

    .payment-method-option.active {
        border-color: #4285F4;
        background-color: #f0f7ff;
    }

    .payment-method-title {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .payment-method-content {
        padding-top: 15px;
        display: none;
    }

    .product-list-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #ebebeb;
    }

    .product-image {
        width: 60px;
        margin-right: 15px;
    }

    .product-details {
        flex-grow: 1;
    }

    .product-price {
        text-align: right;
        font-weight: bold;
    }

    .input-label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }
    
    /* Form doğrulama stilleri */
    .form-control.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }
    
    .form-control.is-invalid ~ .invalid-feedback {
        display: block;
    }
    
    .text-danger {
        color: #dc3545;
    }
    
    /* Gerekli alanlar için yıldız işareti */
    .required-field::after {
        content: " *";
        color: #dc3545;
    }
</style>

<!-- Sayfa Başlık Alanı -->
<div class="page-banner-main">
    <div class="container">
        <div class="page-banner-in-text">
            <div class="page-banner-h">Ödeme</div>
            <div class="page-banner-links">
                <a href="index.php"><i class="fa fa-home"></i> Anasayfa</a>
                <span>/</span>
                <a href="sepet.php">Sepetim</a>
                <span>/</span>
                <a>Ödeme</a>
            </div>
        </div>
    </div>
</div>

<div class="payment-main-div">
    <div class="container">
        <div class="row">
            <!-- Sol Taraf - Sipariş ve Ödeme Bilgileri -->
            <div class="col-md-8">
                <!-- Teslimat Bilgileri -->
                <div class="payment-section">
                    <div class="payment-section-header">
                        <i class="fa fa-map-marker mr-2"></i> Teslimat Bilgileri
                    </div>
                    
                    <form id="teslimat-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="input-label required-field" for="firstName">Ad</label>
                                <input type="text" class="form-control" id="firstName" value="<?php echo $kullanicicek['kullanici_ad']; ?>" required>
                                <div class="invalid-feedback">Ad alanı zorunludur.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="input-label required-field" for="lastName">Soyad</label>
                                <input type="text" class="form-control" id="lastName" value="<?php echo $kullanicicek['kullanici_soyad']; ?>" required>
                                <div class="invalid-feedback">Soyad alanı zorunludur.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="input-label" for="tc">TC Kimlik No</label>
                            <input type="text" class="form-control" id="tc" name="tc" value="<?php echo $kullanicicek['kullanici_tc']; ?>" placeholder="TC Kimlik Numarası">
                        </div>

                        <div class="mb-3">
                            <label class="input-label" for="tel">Telefon</label>
                            <input type="tel" class="form-control" id="tel" value="<?php echo $kullanicicek['kullanici_gsm']; ?>" placeholder="05XX XXX XXXX">
                        </div>

                        <div class="mb-3">
                            <label class="input-label required-field" for="email">E-posta</label>
                            <input type="email" class="form-control" id="email" value="<?php echo $kullanicicek['kullanici_mail']; ?>" required>
                            <div class="invalid-feedback">Geçerli bir e-posta adresi giriniz.</div>
                        </div>

                        <div class="mb-3">
                            <label class="input-label required-field" for="address">Adres</label>
                            <textarea class="form-control" id="address" rows="3" required><?php echo $kullanicicek['kullanici_adres']; ?></textarea>
                            <div class="invalid-feedback">Adres alanı zorunludur.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="input-label required-field" for="city">İl</label>
                                <select class="form-control" id="city" required>
                                    <option value="">İl Seçiniz</option>
                                    <?php foreach ($sehirler as $sehir): ?>
                                    <option value="<?php echo $sehir['sehir_id']; ?>" <?php echo ($kullanicicek['kullanici_il'] == $sehir['sehir_id']) ? 'selected' : ''; ?>><?php echo $sehir['sehir_ad']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Lütfen bir il seçiniz.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="input-label required-field" for="district">İlçe</label>
                                <select class="form-control" id="district" required>
                                    <option value="">İlçe Seçiniz</option>
                                    <?php foreach ($ilceler as $ilce): ?>
                                    <option value="<?php echo $ilce['ilce_id']; ?>" <?php echo ($kullanicicek['kullanici_ilce'] == $ilce['ilce_id']) ? 'selected' : ''; ?>><?php echo $ilce['ilce_ad']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Lütfen bir ilçe seçiniz.</div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Ödeme Yöntemi -->
                <div class="payment-section">
                    <div class="payment-section-header">
                        <i class="fa fa-credit-card mr-2"></i> Ödeme Yöntemi
                    </div>
                    
                    <form id="payment-form" action="settings/islem.php" method="POST">
                        <input type="hidden" name="kullanici_id" value="<?php echo $kullanici_id; ?>">
                        <input type="hidden" name="siparis_toplam" value="<?php echo $genelToplam; ?>">
                        <input type="hidden" name="teslimat_ad" id="teslimat_ad">
                        <input type="hidden" name="teslimat_soyad" id="teslimat_soyad">
                        <input type="hidden" name="teslimat_tc" id="teslimat_tc">
                        <input type="hidden" name="teslimat_tel" id="teslimat_tel">
                        <input type="hidden" name="teslimat_mail" id="teslimat_mail">
                        <input type="hidden" name="teslimat_adres" id="teslimat_adres">
                        <input type="hidden" name="teslimat_il" id="teslimat_il">
                        <input type="hidden" name="teslimat_ilce" id="teslimat_ilce">
                        
                        <div class="d-block my-3">
                            <div class="custom-control custom-radio mb-3">
                                <input id="kredikarti" name="odeme_tipi" value="Kredi Kartı" type="radio" class="custom-control-input" required>
                                <label class="custom-control-label" for="kredikarti">Kredi Kartı ile Öde</label>
                            </div>
                            
                            <div id="kredikarti-form" class="payment-method-content">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="input-label" for="cc-name">Kart Üzerindeki İsim</label>
                                        <input type="text" class="form-control" id="cc-name" placeholder="Kart üzerindeki ismi giriniz">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="input-label" for="cc-number">Kart Numarası</label>
                                        <input type="text" class="form-control" id="cc-number" placeholder="XXXX XXXX XXXX XXXX">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="input-label" for="cc-expiration">Son Kullanma Tarihi</label>
                                        <input type="text" class="form-control" id="cc-expiration" placeholder="MM/YY">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="input-label" for="cc-cvv">CVV</label>
                                        <input type="text" class="form-control" id="cc-cvv" placeholder="XXX">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="custom-control custom-radio mb-3">
                                <input id="havale" name="odeme_tipi" value="Banka Havalesi" type="radio" class="custom-control-input" required>
                                <label class="custom-control-label" for="havale">Banka Havalesi / EFT</label>
                            </div>
                            
                            <div id="havale-form" class="payment-method-content">
                                <div class="form-group mb-3">
                                    <label class="input-label" for="banka_secim">Banka Seçin</label>
                                    <select class="form-control" id="banka_secim" name="banka">
                                        <?php foreach($bankalar as $banka): ?>
                                        <option value="<?php echo $banka['banka_ad']; ?>"><?php echo $banka['banka_ad']; ?> - <?php echo $banka['doviz_turu']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="alert alert-info">
                                    <p class="mb-0"><i class="fa fa-info-circle mr-2"></i> Havale/EFT yaptıktan sonra müşteri hizmetlerimizi arayarak veya mail atarak bilgilendirmenizi rica ederiz.</p>
                                </div>
                            </div>
                            
                            <div class="custom-control custom-radio">
                                <input id="kapida" name="odeme_tipi" value="Kapıda Ödeme" type="radio" class="custom-control-input" required>
                                <label class="custom-control-label" for="kapida">Kapıda Ödeme</label>
                            </div>
                            
                            <div id="kapida-form" class="payment-method-content">
                                <div class="alert alert-info">
                                    <p class="mb-0"><i class="fa fa-info-circle mr-2"></i> Kapıda ödeme seçeneğinde 10 TL hizmet bedeli tahsil edilmektedir.</p>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="mb-4">
                        
                        <div class="custom-control custom-checkbox mb-4">
                            <input type="checkbox" class="custom-control-input" id="mesafeli-satis" name="mesafeli_satis" required>
                            <label class="custom-control-label" for="mesafeli-satis">
                                <a href="mesafeli-satis-sozlesmesi" target="_blank">Mesafeli satış sözleşmesini</a> okudum ve kabul ediyorum.
                            </label>
                            <div class="invalid-feedback" id="sozlesme-error">
                                Devam etmek için mesafeli satış sözleşmesini kabul etmelisiniz.
                            </div>
                        </div>
                        
                        <button class="button-red button-2x" type="submit" id="siparis-tamamla-btn" name="siparis_tamamla" style="width: 100%; text-align: center; margin-top: 10px;">
                            SİPARİŞİ TAMAMLA
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Sağ Taraf - Sipariş Özeti -->
            <div class="col-md-4">
                <div class="payment-section">
                    <div class="payment-section-header">
                        <i class="fa fa-shopping-cart mr-2"></i> Sipariş Özeti
                    </div>
                    
                    <!-- Ürün Listesi -->
                    <div style="margin-bottom: 20px;">
                        <?php foreach($sepet_urunleri as $urun): ?>
                        <div class="product-list-item">
                            <img src="<?php echo $urun['urun_resim1']; ?>" class="product-image" alt="<?php echo $urun['urun_adi']; ?>">
                            <div class="product-details">
                                <div style="font-weight: 500;"><?php echo $urun['urun_adi']; ?></div>
                                <small class="text-muted"><?php echo $urun['urun_adet']; ?> adet</small>
                            </div>
                            <div class="product-price">
                                <?php echo number_format($urun['urun_satisfiyati'] * $urun['urun_adet'], 2, ',', '.'); ?> <?php echo $urun['urun_doviz']; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Fiyat Özeti -->
                    <div>
                        <div class="payment-summary-item">
                            <span>Ara Toplam</span>
                            <span><?php echo number_format(round($araToplam, 2), 2, ',', '.'); ?> TL</span>
                        </div>
                        <div class="payment-summary-item">
                            <span>KDV</span>
                            <span><?php echo number_format(round($toplamKdvTutari, 2), 2, ',', '.'); ?> TL</span>
                        </div>
                        <div class="payment-summary-item">
                            <span>Kargo</span>
                            <span style="color: #0F9D58;">ÜCRETSİZ</span>
                        </div>
                        <hr>
                        <div class="payment-summary-item" style="font-weight: 700; font-size: 16px;">
                            <span>Toplam</span>
                            <span><?php echo number_format($genelToplam, 2, ',', '.'); ?> TL</span>
                        </div>
                    </div>
                </div>
                
                <!-- Kargo Notu -->
                <div class="payment-section">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-truck" style="font-size: 24px; color: #4285F4; margin-right: 15px;"></i>
                        <div>
                            <div style="font-weight: 600;">Hızlı Teslimat</div>
                            <small class="text-muted">Siparişiniz 1-3 iş günü içinde kargolanacaktır.</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-shield" style="font-size: 24px; color: #0F9D58; margin-right: 15px;"></i>
                        <div>
                            <div style="font-weight: 600;">Güvenli Ödeme</div>
                            <small class="text-muted">Ödeme bilgileriniz güvenle korunmaktadır.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Ödeme yöntemi seçilince ilgili formu gösterme
document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.querySelectorAll('.payment-method-option');
    const krediKartiRadio = document.getElementById('kredikarti');
    const havaleRadio = document.getElementById('havale');
    const kapidaRadio = document.getElementById('kapida');
    
    const krediKartiForm = document.getElementById('kredikarti-form');
    const havaleForm = document.getElementById('havale-form');
    const kapidaForm = document.getElementById('kapida-form');
    
    function toggleForms() {
        // Tüm içerikleri gizle
        krediKartiForm.style.display = krediKartiRadio.checked ? 'block' : 'none';
        havaleForm.style.display = havaleRadio.checked ? 'block' : 'none';
        kapidaForm.style.display = kapidaRadio.checked ? 'block' : 'none';
        
        // Active sınıfını ata
        if (krediKartiRadio.checked) {
            krediKartiRadio.closest('.custom-control').classList.add('active');
        } else {
            krediKartiRadio.closest('.custom-control').classList.remove('active');
        }
        
        if (havaleRadio.checked) {
            havaleRadio.closest('.custom-control').classList.add('active');
        } else {
            havaleRadio.closest('.custom-control').classList.remove('active');
        }
        
        if (kapidaRadio.checked) {
            kapidaRadio.closest('.custom-control').classList.add('active');
        } else {
            kapidaRadio.closest('.custom-control').classList.remove('active');
        }
    }
    
    krediKartiRadio.addEventListener('change', toggleForms);
    havaleRadio.addEventListener('change', toggleForms);
    kapidaRadio.addEventListener('change', toggleForms);
    
    // Sayfa yüklendiğinde de kontrol et
    toggleForms();
    
    // İl seçimine göre ilçeleri AJAX ile güncelleme
    const citySelect = document.getElementById('city');
    const districtSelect = document.getElementById('district');
    
    citySelect.addEventListener('change', function() {
        const selectedCityId = this.value;
        districtSelect.innerHTML = '<option value="">İlçe Seçiniz</option>';
        
        if (selectedCityId) {
            // İlçeleri AJAX ile getir
            fetch('ilce-getir.php?sehir_id=' + selectedCityId)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.forEach(ilce => {
                            const option = document.createElement('option');
                            option.value = ilce.ilce_id;
                            option.textContent = ilce.ilce_ad;
                            districtSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('İlçeler yüklenirken hata oluştu:', error));
        }
    });
    
    // Form doğrulama
    const siparisBtn = document.getElementById('siparis-tamamla-btn');
    const form = document.getElementById('payment-form');
    const teslimatForm = document.getElementById('teslimat-form');
    const mesafeliSatis = document.getElementById('mesafeli-satis');
    
    form.addEventListener('submit', function(event) {
        // Form doğrulama
        let isValid = true;
        
        // Teslimat bilgileri
        const firstName = document.getElementById('firstName');
        const lastName = document.getElementById('lastName');
        const email = document.getElementById('email');
        const address = document.getElementById('address');
        const city = document.getElementById('city');
        const district = document.getElementById('district');
        
        // Teslimat bilgilerini form verilerine aktar
        document.getElementById('teslimat_ad').value = firstName.value;
        document.getElementById('teslimat_soyad').value = lastName.value;
        document.getElementById('teslimat_tc').value = document.getElementById('tc').value;
        document.getElementById('teslimat_tel').value = document.getElementById('tel').value;
        document.getElementById('teslimat_mail').value = email.value;
        document.getElementById('teslimat_adres').value = address.value;
        document.getElementById('teslimat_il').value = city.value;
        document.getElementById('teslimat_ilce').value = district.value;
        
        // Zorunlu alanları kontrol et
        if (!firstName.value.trim()) {
            firstName.classList.add('is-invalid');
            isValid = false;
        } else {
            firstName.classList.remove('is-invalid');
        }
        
        if (!lastName.value.trim()) {
            lastName.classList.add('is-invalid');
            isValid = false;
        } else {
            lastName.classList.remove('is-invalid');
        }
        
        if (!email.value.trim() || !isValidEmail(email.value)) {
            email.classList.add('is-invalid');
            isValid = false;
        } else {
            email.classList.remove('is-invalid');
        }
        
        if (!address.value.trim()) {
            address.classList.add('is-invalid');
            isValid = false;
        } else {
            address.classList.remove('is-invalid');
        }
        
        if (!city.value) {
            city.classList.add('is-invalid');
            isValid = false;
        } else {
            city.classList.remove('is-invalid');
        }
        
        if (!district.value) {
            district.classList.add('is-invalid');
            isValid = false;
        } else {
            district.classList.remove('is-invalid');
        }
        
        // Mesafeli satış sözleşmesi onayını kontrol et
        if (!mesafeliSatis.checked) {
            document.getElementById('sozlesme-error').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('sozlesme-error').style.display = 'none';
        }
        
        // Ödeme yöntemi seçilmiş mi kontrol et
        const odemeYontemi = document.querySelector('input[name="odeme_tipi"]:checked');
        if (!odemeYontemi) {
            alert('Lütfen bir ödeme yöntemi seçin.');
            isValid = false;
        }
        
        if (!isValid) {
            event.preventDefault();
            // Sayfanın en üstüne kaydır ve hata mesajı göster
            window.scrollTo(0, 0);
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger';
            errorAlert.textContent = 'Lütfen form alanlarını eksiksiz doldurun.';
            form.insertBefore(errorAlert, form.firstChild);
            
            // 3 saniye sonra hata mesajını kaldır
            setTimeout(() => {
                errorAlert.remove();
            }, 3000);
        }
    });
    
    // Email doğrulama fonksiyonu
    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
});
</script>

<?php include 'footer.php'; ?>
