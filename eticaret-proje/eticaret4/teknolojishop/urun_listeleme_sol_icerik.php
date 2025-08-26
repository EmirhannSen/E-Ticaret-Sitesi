<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'settings/baglan.php';

//include 'getproducts.php';

// Ana kategori ve alt kategorileri al
$kategori_id = isset($_GET['kategori_id']) ? (int)$_GET['kategori_id'] : -1;
$altKategoriler = alt_kategorileri_bul($db, $kategori_id);
$tumKategoriIds = array_merge([$kategori_id], $altKategoriler);

// Kategorilerdeki markaları sorgula
$kategoriPlaceholders = implode(',', array_fill(0, count($tumKategoriIds), '?'));

// Değişkeni başlangıçta boş bir dizi olarak tanımla
$altKategoriCek = [];

// Burada $GET yerine $_GET olmalı - bu bir yazım hatasıydı
if(isset($_GET['kategori_id']) && $_GET['kategori_id']){
    $altKategoriSor = $db->prepare("SELECT * FROM kategori where kategori_ust=:kategori_id");
    $altKategoriSor->execute(['kategori_id' => $_GET['kategori_id']]);
    $altKategoriCek = $altKategoriSor->fetchAll(PDO::FETCH_ASSOC);
}

$filtreSecenekleriSor = $db->prepare("SELECT * FROM filtre_sablonu where filtre_durum='1'");
$filtreSecenekleriSor->execute();
$filtreSecenekleriCek = $filtreSecenekleriSor->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT DISTINCT urun_marka FROM urun WHERE kategori_id IN ($kategoriPlaceholders)";
$stmt = $db->prepare($sql);
$stmt->execute($tumKategoriIds);
$kategoriUrunMarkalarCek = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kategori için minimum ve maksimum fiyatları sorgula
$min_fiyat = 0;
$max_fiyat = 50000; // Varsayılan değerler

try {
    $fiyat_sorgu = $db->prepare("SELECT MIN(urun_satisfiyati) as min_fiyat, MAX(urun_satisfiyati) as max_fiyat FROM urun WHERE urun_durum = '1' AND urun_satisfiyati > 0");
    
    if ($kategori_id > 0) {
        // Eğer alt kategoriler de dahil edilecekse
        $alt_kategoriler = alt_kategorileri_bul($db, $kategori_id);
        $alt_kategoriler[] = $kategori_id;
        $kategori_ids = implode(',', array_map('intval', $alt_kategoriler));
        
        if (!empty($kategori_ids)) {
            $fiyat_sorgu = $db->prepare("SELECT MIN(urun_satisfiyati) as min_fiyat, MAX(urun_satisfiyati) as max_fiyat FROM urun WHERE urun_durum = '1' AND kategori_id IN ($kategori_ids) AND urun_satisfiyati > 0");
        }
    }
    
    $fiyat_sorgu->execute();
    $fiyat_bilgisi = $fiyat_sorgu->fetch(PDO::FETCH_ASSOC);
    
    // NULL veya 0 kontrolü yap
    if (!empty($fiyat_bilgisi['min_fiyat']) && $fiyat_bilgisi['min_fiyat'] > 0) {
        $min_fiyat = floor($fiyat_bilgisi['min_fiyat']);
    }
    
    if (!empty($fiyat_bilgisi['max_fiyat']) && $fiyat_bilgisi['max_fiyat'] > 0) {
        $max_fiyat = ceil($fiyat_bilgisi['max_fiyat']);
    }
    
    // Min ve max değerler aynıysa farkı artır
    if ($min_fiyat == $max_fiyat) {
        $min_fiyat = $min_fiyat > 100 ? $min_fiyat - 100 : 0;
        $max_fiyat = $max_fiyat + 100;
    }
    
    // Hata ayıklama için (sorunu teşhis etmek için)
    /*
    echo '<pre style="background:#fff;padding:10px;position:absolute;z-index:99999;top:0;right:0;">';
    echo "SQL: SELECT MIN(urun_satisfiyati) as min_fiyat, MAX(urun_satisfiyati) as max_fiyat FROM urun WHERE urun_durum = 1 AND kategori_id IN ($kategori_ids) AND urun_satisfiyati > 0<br>";
    echo "Fiyat bilgisi: ";
    print_r($fiyat_bilgisi);
    echo "<br>Min fiyat: $min_fiyat, Max fiyat: $max_fiyat";
    echo '</pre>';
    */
    
} catch (Exception $e) {
    // Hata durumunda varsayılan değerleri kullan
    // Hata ayıklama için:
    // echo "Fiyat sorgusunda hata: " . $e->getMessage();
}

// URL'den gelen değerleri kullan, yoksa otomatik hesaplanan değerleri kullan
$current_min = isset($_GET['min_price']) ? $_GET['min_price'] : $min_fiyat;
$current_max = isset($_GET['max_price']) ? $_GET['max_price'] : $max_fiyat;

/*
echo "<pre>";
print_r($altKategoriCek);
echo "</pre>";
die("test");*/
?>


<div class="detail-none">
            <div class="cat-left-main ">

                <?php if (is_array($altKategoriCek)) { ?>
                <div class="cat-left-box-main ">
                    <div class="cat-left-box-h">Alt Kategoriler
                        <div style="width: 30px; height: 3px; background-color: #000000; margin-top: 7px;  "></div>
                    </div>
                    <?php foreach ($altKategoriCek as $onecategori) { ?>

                    <div class="category-sub-design-box">
                        <li><a href="kategori-<?=seo($onecategori["kategori_ad"]).'-'.$onecategori["kategori_id"]?>"> <?php echo $onecategori['kategori_ad'] ?> </a></li>
                    </div>

                    <?php } ?>
                </div>
                <?php } ?>


                <!-- filtre seçenekleri start-->
                <div class="cat-left-box-main">
                    <div class="cat-left-box-h">Filtreleme
                        <div style="width: 30px; height: 3px; background-color: #000000; margin-top: 7px;  "></div>
                    </div>
                    <div class="cat-left-box-out-first" id="cat-left-overflow">

                        <?php foreach ($filtreSecenekleriCek as $filtresecenek) { ?>
                        <div class="cat-left-box-t">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="ozellik_<?php echo $filtresecenek['filtre_code'] ?>" onclick="filterChange()">
                                <label  class="custom-control-label" for="ozellik_<?php echo $filtresecenek['filtre_code'] ?>"><?php echo $filtresecenek['filtre_adi'] ?></label></div>
                        </div>
                        <?php } ?>

                    </div>
                </div>
                <!-- filtre seçenekleri end-->



                <div class="cat-left-box-main">
                    <div class="cat-left-box-h">Fiyat Aralığı
                        <div style="width: 30px; height: 3px; background-color: #000000; margin-top: 7px;  "></div>
                    </div>
                    <div class="cat-left-box-out-first">
                        <fieldset class="filter-price">
                            <div class="price-field"><input type="range" min="<?php echo $min_fiyat; ?>" max="<?php echo $max_fiyat; ?>"
                                                            value="<?php echo $current_min; ?>" id="lower" name="min"><input type="range"
                                                                                                           min="<?php echo $min_fiyat; ?>"
                                                                                                           max="<?php echo $max_fiyat; ?>"
                                                                                                           value="<?php echo $current_max; ?>"
                                                                                                           id="upper"
                                                                                                           name="max">
                            </div>
                            <div class="price-wrap"><input id="one" type="hidden"><input id="two" type="hidden">
                                <div class="price-wrap-outputbox"><span class="output"><?php echo number_format($current_min, 2, ',', '.'); ?></span> TL</div>
                                <div class="price-wrap-outputbox" style="margin-right: 0;"><span class="output2"><?php echo number_format($current_max, 2, ',', '.'); ?></span>
                                    TL
                                </div>
                            </div>
                            <div class="price-filter-range-button">
                                <button class="button-blue button-1x" style="width: 100%;" id="submit" onclick="filterChange()">
                                    FİYATI FİLTRELE
                                </button>
                            </div>
                        </fieldset>
                    </div>
                </div> <!-- Fiyat Aralığı !-->
                <script> var lowerSlider = document.querySelector('#lower');
                    var upperSlider = document.querySelector('#upper');
                    document.querySelector('#two').value = upperSlider.value;
                    document.querySelector('#one').value = lowerSlider.value;
                    var lowerVal = parseInt(lowerSlider.value);
                    var upperVal = parseInt(upperSlider.value);/* Lover için span ///////////////////////////////////////////*/
                    var input = document.querySelector("[id=\"lower\"]"), output = document.querySelector(".output");

                    function keydownHandler() {
                        output.innerHTML = this.value;
                    }

                    input.addEventListener("input", keydownHandler);/* Lover için span SON ///////////////////////////////////////////*//* upper için span ///////////////////////////////////////////*/
                    var input2 = document.querySelector("[id=\"upper\"]"), output2 = document.querySelector(".output2");

                    function keydownHandler2() {
                        output2.innerHTML = this.value;
                    }

                    input2.addEventListener("input", keydownHandler2);/* upper için span SON ///////////////////////////////////////////*/
                    upperSlider.oninput = function () {
                        lowerVal = parseInt(lowerSlider.value);
                        upperVal = parseInt(upperSlider.value);
                        if (upperVal < lowerVal + 4) {
                            lowerSlider.value = upperVal - 4;
                            if (lowerVal == lowerSlider.min) {
                                upperSlider.value = 4;
                            }
                        }
                        document.querySelector('#two').value = this.value;
                    };
                    lowerSlider.oninput = function () {
                        lowerVal = parseInt(lowerSlider.value);
                        upperVal = parseInt(upperSlider.value);
                        if (lowerVal > upperVal - 4) {
                            upperSlider.value = lowerVal + 4;
                            if (upperVal == upperSlider.max) {
                                lowerSlider.value = parseInt(upperSlider.max) - 4;
                            }
                        }
                        document.querySelector('#one').value = this.value;
                    };</script><!--  <========SON=========>>> Fiyat Aralığı SON !-->
                <!-- Kategorinin Marka Filtresi !-->


                <div class="cat-left-box-main">
                    <div class="cat-left-box-h">Markalar
                        <div style="width: 30px; height: 3px; background-color: #000000; margin-top: 7px;  "></div>
                    </div>


                    <div class="cat-left-box-out" id="cat-left-overflow">

                        <?php foreach ($kategoriUrunMarkalarCek as $kategoriUrunMarkalar) {
                            $markalarDetaySor = $db->prepare("SELECT * FROM marka where marka_adi=:marka_adi");
                            $markalarDetaySor->execute(['marka_adi' => $kategoriUrunMarkalar['urun_marka']]);

                            $markalarDetayCek = $markalarDetaySor->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                        <div class="cat-left-box-t">
                            <div class="custom-control custom-checkbox"><input type="checkbox"
                                                                               class="custom-control-input" id="marka_<?php echo $markalarDetayCek[0]['marka_adi'] ?>"
                                                                               onclick="filterChange()"><label
                                        class="custom-control-label" for="marka_<?php echo $markalarDetayCek[0]['marka_adi'] ?>"><?php echo $markalarDetayCek[0]['marka_adi'] ?></label></div>
                        </div>
                        <?php } ?>

                    </div>


                </div>

                <!--  <========SON=========>>> Kategorinin Marka Filtresi SON !--> </div>
        </div>

<script>
// Filtre değişikliklerini yakala ve işle
function filterChange() {
    var urlParams = new URLSearchParams(window.location.search);

    // Seçilen özellikleri al
    var selectedFilters = [];
    var filtreCheckboxes = document.querySelectorAll('[id^="ozellik_"]:checked');
    filtreCheckboxes.forEach(function(checkbox) {
        selectedFilters.push(checkbox.id.replace('ozellik_', ''));
    });

    // Seçilen markaları al
    var selectedBrands = [];
    var markaCheckboxes = document.querySelectorAll('[id^="marka_"]:checked');
    markaCheckboxes.forEach(function(checkbox) {
        selectedBrands.push(checkbox.id.replace('marka_', ''));
    });

    // Fiyat aralığını al
    var minPrice = document.getElementById('lower').value;
    var maxPrice = document.getElementById('upper').value;
    
    // Gizli inputlara değerleri set et
    document.getElementById('min_price').value = minPrice;
    document.getElementById('max_price').value = maxPrice;

    // URL parametrelerini güncelle
    if (selectedFilters.length > 0) {
        urlParams.set('ozellik', selectedFilters.join(','));
    } else {
        urlParams.delete('ozellik');
    }

    if (selectedBrands.length > 0) {
        urlParams.set('marka', selectedBrands.join(','));
    } else {
        urlParams.delete('marka');
    }

    if (minPrice) {
        urlParams.set('min_price', minPrice);
    } else {
        urlParams.delete('min_price');
    }

    if (maxPrice) {
        urlParams.set('max_price', maxPrice);
    } else {
        urlParams.delete('max_price');
    }

    // URL'yi güncelle (sayfa yenilemeden)
    window.history.pushState(null, '', '?' + urlParams.toString());

    // AJAX ile sağ içerik kısmını yenile
    fetchFilteredResults(urlParams);
}

// Fiyat aralığı değişikliklerini takip et
function initPriceRangeListeners() {
    var lowerSlider = document.querySelector('#lower');
    var upperSlider = document.querySelector('#upper');
    
    if (!lowerSlider || !upperSlider) return;
    
    var lowerVal = parseInt(lowerSlider.value);
    var upperVal = parseInt(upperSlider.value);
    
    lowerSlider.oninput = function() {
        lowerVal = parseInt(lowerSlider.value);
        if (lowerVal >= upperVal) {
            lowerSlider.value = upperVal - 100;  // 100 TL'lik fark bırak
            lowerVal = upperVal - 100;
        }
        document.querySelector('.output').innerHTML = formatPrice(lowerVal) + " TL";
        // Fiyat filtre butonunu aktif et
        document.querySelector('.price-filter-range-button button').classList.add('active');
    };
    
    upperSlider.oninput = function() {
        upperVal = parseInt(upperSlider.value);
        if (upperVal <= lowerVal) {
            upperSlider.value = lowerVal + 100;  // 100 TL'lik fark bırak
            upperVal = lowerVal + 100;
        }
        document.querySelector('.output2').innerHTML = formatPrice(upperVal) + " TL";
        // Fiyat filtre butonunu aktif et
        document.querySelector('.price-filter-range-button button').classList.add('active');
    };
    
    // Fiyat filtre butonuna tıklama olayını ekle
    document.querySelector('.price-filter-range-button button').addEventListener('click', function() {
        filterChange();
    });
}

// Fiyat formatı için yardımcı fonksiyon
function formatPrice(price) {
    return new Intl.NumberFormat('tr-TR', { 
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(price);
}

// AJAX isteği gönderme ve sonuçları yerleştirme
function fetchFilteredResults(urlParams) {
    // Yükleniyor göstergesini ekle
    var rightContent = document.querySelector('.cat-right-elements-out');
    if (rightContent) {
        rightContent.innerHTML = '<div class="loading-overlay"><div class="spinner"></div><p>Ürünler Filtreleniyor...</p></div>';
    }
    
    // Debug
    console.log("AJAX isteği URL:", window.location.pathname + '?' + urlParams.toString());
    
    // Tam URL oluştur
    var fullUrl = window.location.pathname + '?' + urlParams.toString();
    
    fetch(fullUrl, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        },
        cache: 'no-store'  // Cache kullanma
    })
    .then(response => {
        console.log("AJAX yanıtı alındı:", response.status);
        return response.text();
    })
    .then(data => {
        console.log("AJAX verisi alındı, uzunluk:", data.length);
        
        // HTML içeriğini ayrı bir div içine yerleştir
        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = data;
        
        // Debug: HTML içinde hangi elementler var?
        console.log("HTML elementi içindeki elementler:", tempDiv.querySelectorAll('*').length);
        
        // İçerik elementini bul
        var newContent = tempDiv.querySelector('.cat-right-elements-out');
        
        if (!newContent) {
            console.error("Yanıtta .cat-right-elements-out elementi bulunamadı!");
            // Alternatif olarak diğer bir seçiciyi dene
            newContent = tempDiv.querySelector('.cat-right-content');
        }
        
        if (rightContent && newContent) {
            console.log("Yeni içerik bulundu, güncelleniyor");
            rightContent.innerHTML = newContent.innerHTML;
        } else {
            console.error("İçerik bulunamadı. HTML:", data.substring(0, 500) + "...");
            
            // Sorunu çözmek için manuel sayfa yenilemesi
            window.location.href = fullUrl;
        }
    })
    .catch(error => {
        console.error('Filtreleme hatası:', error);
        // Sorunu çözmek için manuel sayfa yenilemesi
        window.location.href = fullUrl;
    });
}

// Sayfa yüklendiğinde çalışacak kod
document.addEventListener('DOMContentLoaded', function() {
    // URL'den parametreleri al ve filtreleri buna göre ayarla
    var urlParams = new URLSearchParams(window.location.search);
    
    // Özellikleri işaretleme
    if (urlParams.has('ozellik')) {
        var ozellikler = urlParams.get('ozellik').split(',');
        ozellikler.forEach(function(ozellik) {
            var checkbox = document.getElementById('ozellik_' + ozellik);
            if (checkbox) checkbox.checked = true;
        });
    }
    
    // Markaları işaretleme
    if (urlParams.has('marka')) {
        var markalar = urlParams.get('marka').split(',');
        markalar.forEach(function(marka) {
            var checkbox = document.getElementById('marka_' + marka);
            if (checkbox) checkbox.checked = true;
        });
    }
    
    // Fiyat aralığını ayarlama
    if (urlParams.has('min_price')) {
        var minPrice = urlParams.get('min_price');
        var lowerSlider = document.getElementById('lower');
        if (lowerSlider) lowerSlider.value = minPrice;
        document.querySelector('.output').innerHTML = formatPrice(minPrice);
        document.getElementById('min_price').value = minPrice;
    }
    
    if (urlParams.has('max_price')) {
        var maxPrice = urlParams.get('max_price');
        var upperSlider = document.getElementById('upper');
        if (upperSlider) upperSlider.value = maxPrice;
        document.querySelector('.output2').innerHTML = formatPrice(maxPrice);
        document.getElementById('max_price').value = maxPrice;
    }
    
    // Fiyat aralığı için dinleyicileri ayarla
    initPriceRangeListeners();
});

// Slider'ı yeniden başlat - eski script etiketini kaldırın
document.addEventListener('DOMContentLoaded', function() {
    // Slider işlevselliğini başlat
    initPriceRangeListeners();
    
    // Otomatik filtreleme için
    var priceFilterTimer;
    var lowerSlider = document.querySelector('#lower');
    var upperSlider = document.querySelector('#upper');
    
    function applyPriceFilterWithDelay() {
        // Gizli inputlara değerleri ayarla
        document.getElementById('min_price').value = lowerSlider.value;
        document.getElementById('max_price').value = upperSlider.value;
        
        // Zamanlayıcıyı temizle
        clearTimeout(priceFilterTimer);
        
        // Yeni zamanlayıcı ayarla
        priceFilterTimer = setTimeout(function() {
            // Fiyat değerlerini filterChange'e ekle
            filterChange();
        }, 800); // 800ms bekle
    }
    
    // Slider değerleri değiştiğinde, otomatik filtreleme için hazırlan
    if (lowerSlider) lowerSlider.addEventListener('change', applyPriceFilterWithDelay);
    if (upperSlider) upperSlider.addEventListener('change', applyPriceFilterWithDelay);
});
</script>

<!-- Gizli inputlar ekle -->
<input type="hidden" id="min_price" name="min_price" value="">
<input type="hidden" id="max_price" name="max_price" value="">

<!-- CSS Stilini Ekle -->
<style>
.loading-overlay {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    width: 100%;
}
.spinner {
    border: 5px solid #f3f3f3;
    border-radius: 50%;
    border-top: 5px solid #000;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin-bottom: 15px;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.price-filter-range-button button.active {
    background-color: #000;
    color: #fff;
}
</style>


