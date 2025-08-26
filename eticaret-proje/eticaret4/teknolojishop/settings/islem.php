<?php

ob_start();
session_start();

include 'baglan.php';
include 'fonksiyon.php';


// Kullanıcı kayıt 
if (isset($_POST['kullanicikaydet'])) {

    //htmlspecialchars formdan gelen yazılardaki html etiketlerini zararlı kodlara karşı önlem alarak metin olarak gösterir
    echo $kullanici_ad = htmlspecialchars($_POST['kullanici_ad']);
    echo "<br>";
    echo $kullanici_soyad = htmlspecialchars($_POST['kullanici_soyad']);
    echo "<br>";
    echo $kullanici_mail = htmlspecialchars($_POST['kullanici_mail']);
    echo "<br>";

    echo $kullanici_passwordone = $_POST['kullanici_passwordone'];
    echo "<br>";
    echo $kullanici_passwordtwo = $_POST['kullanici_passwordtwo'];
    echo "<br>";

    $kullanici_adsoyad = $_POST['kullanici_ad'] . ' ' . $_POST['kullanici_soyad'];


    if ($kullanici_passwordone == $kullanici_passwordtwo) {
        if ($kullanici_passwordone >= 6) {
            $kullanicisor = $db->prepare("select * from kullanicilar where kullanici_mail=:mail");
            $kullanicisor->execute(array(
                'mail' => $kullanici_mail
            ));

            //dönen satır sayısını belirtir
            $say = $kullanicisor->rowCount();

            if ($say == 0) {
                //md5 fonksiyonu bir veriyi şifrelemeye yarar grilen veriyi hash değerine dönüştüren bir algoritmadır
                $password = md5($kullanici_passwordone);
                $kullanici_yetki = 1;

                //Kullanıcı kayıt işlemi yapılıyor...
                $kullanicikaydet = $db->prepare("INSERT INTO kullanicilar SET
					kullanici_ad=:kullanici_ad,
					kullanici_soyad=:kullanici_soyad,
                    kullanici_adsoyad = :kullanici_adsoyad,
					kullanici_mail=:kullanici_mail,
					kullanici_password=:kullanici_password,
                    kullanici_durum = :kullanici_durum,
					kullanici_yetki=:kullanici_yetki
					");
                $insert = $kullanicikaydet->execute(array(
                    'kullanici_ad' => $kullanici_ad,
                    'kullanici_soyad' => $kullanici_soyad,
                    'kullanici_adsoyad' => $kullanici_adsoyad,
                    'kullanici_mail' => $kullanici_mail,
                    'kullanici_password' => $password,
                    'kullanici_durum' => 0,  // Kullanıcı durumu 0 olarak ayarlandı, admin onayı bekliyor geçici olarak yaptık
                    'kullanici_yetki' => $kullanici_yetki
                ));

                if ($insert) {
                    header("Location:../uye-kayit.php?durum=basarili");
                } else {
                    header("Location:../uye-kayit.php?durum=basarisiz");
                }
            } else {
                header("Location:../uye-kayit.php?durum=mukerrerkayit");
            }
        } else {
            header("Location:../uye-kayit.php?durum=eksiksifre");
        }
    } else {
        header("Location:../uye-kayit.php?durum=farklisifre");
    }
}

if (isset($_POST['kullanicigiris'])) {
    $kullanici_mail = htmlspecialchars($_POST['kullanici_mail']);
    $kullanici_password = md5($_POST['kullanici_password']);

    $kullanicisor = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_mail=:mail AND kullanici_yetki=:yetki");
    $kullanicisor->execute(array(
        'mail' => $kullanici_mail,
        'yetki' => 1
    ));

    $say = $kullanicisor->rowCount();

    if ($say == 1) {
        $kullanicibilgileri = $kullanicisor->fetch(PDO::FETCH_ASSOC);

        if ($kullanicibilgileri['kullanici_durum'] != '1') {
            header("Location:../uye-giris.php?durum=pasifkullanici");
            exit;
        } else {
            if ($kullanicibilgileri['kullanici_password'] == $kullanici_password) {
                $_SESSION['kullanici_mail'] = $kullanici_mail;
                header("Location:../index.php?durum=basarili");
                exit;
            } else {
                header("Location:../uye-giris.php?durum=basarisizgiris");
                exit;
            }
        }
    } else {
        header("Location:../uye-giris.php?durum=kayitbulunamadi");
        exit;
    }
}


// Sepete Ekle
if (isset($_POST['sepetekle'])) {
    // Kullanıcı giriş kontrolü
    if (!isset($_SESSION['kullanici_mail'])) {
        // Kullanıcı giriş yapmamışsa, giriş modalını göster
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
        
        // Modal gösterme kodunu ekle
        echo "<script>
            window.location.href = '$referer?modal=login';
        </script>";
        exit;
    }
    
    // Kullanıcı ve ürün kontrolü
    $sepetDetaysor = $db->prepare("SELECT * FROM sepet WHERE kullanici_id = :kullanici_id AND urun_id = :urun_id");
    $sepetDetaysor->execute(array(
        'kullanici_id' => $_POST['kullanici_id'],
        'urun_id' => $_POST['urun_id']
    ));

    $sepetDetay = $sepetDetaysor->fetch(PDO::FETCH_ASSOC);
    $say = $sepetDetaysor->rowCount();

    if ($say > 0) {
        // Eğer aynı ürün sepette varsa, ürün adedini artır
        $yeniAdet = $sepetDetay['urun_adet'] + $_POST['quantity'];
        $guncelle = $db->prepare("UPDATE sepet SET urun_adet = :urun_adet WHERE kullanici_id = :kullanici_id AND urun_id = :urun_id");
        $update = $guncelle->execute(array(
            'urun_adet' => $yeniAdet,
            'kullanici_id' => $_POST['kullanici_id'],
            'urun_id' => $_POST['urun_id']
        ));

        if ($update) {
            Header("Location:../sepet?durum=guncellendi");
        } else {
            Header("Location:../sepet?durum=no");
        }
    } else {
        // Eğer ürün sepette yoksa, yeni bir satır ekle
        $ayarekle = $db->prepare("INSERT INTO sepet SET
            urun_adet = :urun_adet,
            kullanici_id = :kullanici_id,
            urun_id = :urun_id
        ");

        $insert = $ayarekle->execute(array(
            'urun_adet' => $_POST['quantity'],
            'kullanici_id' => $_POST['kullanici_id'],
            'urun_id' => $_POST['urun_id']
        ));

        if ($insert) {
            Header("Location:../sepet?durum=eklendi");
        } else {
            Header("Location:../sepet?durum=no");
        }
    }
}

// Sepet ürün adeti güncelleme
if (isset($_POST['sepet_guncelle'])) {
    $sepet_id = $_POST['sepet_id'];
    $urun_adet = $_POST['urun_adet'];
    
    $guncelle = $db->prepare("UPDATE sepet SET urun_adet = :urun_adet WHERE sepet_id = :sepet_id");
    $update = $guncelle->execute([
        'urun_adet' => $urun_adet,
        'sepet_id' => $sepet_id
    ]);
    
    if ($update) {
        Header("Location:../sepet.php?durum=guncellendi");
    } else {
        Header("Location:../sepet.php?durum=hata");
    }
}

// Sepetten ürün silme
if (isset($_GET['sepetsil']) && $_GET['sepetsil'] == "ok") {
    $sepet_id = $_GET['sepet_id'];
    
    $sil = $db->prepare("DELETE FROM sepet WHERE sepet_id = :sepet_id");
    $kontrol = $sil->execute([
        'sepet_id' => $sepet_id
    ]);
    
    if ($kontrol) {
        Header("Location:../sepet.php?durum=silindi");
    } else {
        Header("Location:../sepet.php?durum=hata");
    }
}

//  Sepetten Ürün Silme
if (isset($_POST['sepetUrunSil'])) {
    $sil=$db->prepare("DELETE FROM sepet WHERE urun_id=:urun_id");
    $delete=$sil->execute(array(
        'urun_id' => $_POST['urun_id']
    ));

    if ($delete) {
        Header("Location:../sepet?durum=silindi");
    } else {
        Header("Location:../sepet?durum=no");
    }
}

// Sepette Ürün Adedi Güncelleme
if (isset($_POST['adetGuncelle'])) {
    $guncelle = $db->prepare("UPDATE sepet SET urun_adet=:urun_adet WHERE urun_id=:urun_id");
    $update = $guncelle->execute(array(
        'urun_adet' => $_POST['urun_adet'],
        'urun_id' => $_POST['urun_id']
    ));

    if ($update) {
        Header("Location:../sepet?durum=guncellendi");
    } else {
        Header("Location:../sepet?durum=no");
    }
}

// Favoriye Ekle
if (isset($_POST['favoriekle'])) {
    // Kullanıcı kontrolü
    if (!isset($_SESSION['kullanici_mail'])) {
        // Kullanıcı giriş yapmamış, giriş sayfasına yönlendir
        header("Location:../uye-giris.php");
        exit;
    }
    
    $kullanici_id = $_POST['kullanici_id'];
    $urun_id = $_POST['urun_id'];
    
    // Önce favori tablosunu kontrol et
    try {
        $favoriKontrol = $db->query("SELECT 1 FROM favoriler LIMIT 1");
    } catch(PDOException $e) {
        $db->query("CREATE TABLE IF NOT EXISTS favoriler (
            favori_id INT AUTO_INCREMENT PRIMARY KEY,
            kullanici_id INT NOT NULL,
            urun_id INT NOT NULL,
            favori_tarih TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY(kullanici_id, urun_id)
        )");
    }
    
    // Favoriye ekle (varsa güncelle)
    $favoriEkle = $db->prepare("INSERT IGNORE INTO favoriler SET 
        kullanici_id = :kullanici_id,
        urun_id = :urun_id");
    
    $insert = $favoriEkle->execute([
        'kullanici_id' => $kullanici_id,
        'urun_id' => $urun_id
    ]);
    
    if ($insert) {
        header("Location:../favorilerim.php?durum=ok");
    } else {
        header("Location:../favorilerim.php?durum=no");
    }
}

// Favoriden Çıkar
if (isset($_POST['favoricikar'])) {
    $kullanici_id = $_POST['kullanici_id'];
    $urun_id = $_POST['urun_id'];
    
    $favoriCikar = $db->prepare("DELETE FROM favoriler WHERE kullanici_id = :kullanici_id AND urun_id = :urun_id");
    $delete = $favoriCikar->execute([
        'kullanici_id' => $kullanici_id,
        'urun_id' => $urun_id
    ]);
    
    if ($delete) {
        header("Location:../favorilerim.php?durum=ok");
    } else {
        header("Location:../favorilerim.php?durum=no");
    }
}

// Sipariş tamamlama
if (isset($_POST['siparis_tamamla'])) {
    $kullanici_id = $_POST['kullanici_id'];
    $siparis_toplam = $_POST['siparis_toplam'];
    $odeme_tipi = $_POST['odeme_tipi'];
    $banka = isset($_POST['banka']) ? $_POST['banka'] : '';
    
    // Teslimat bilgilerini al
    $teslimat_ad = $_POST['teslimat_ad'];
    $teslimat_soyad = $_POST['teslimat_soyad'];
    $teslimat_tc = $_POST['teslimat_tc'];
    $teslimat_tel = $_POST['teslimat_tel'];
    $teslimat_mail = $_POST['teslimat_mail'];
    $teslimat_adres = $_POST['teslimat_adres'];
    $teslimat_il = $_POST['teslimat_il']; // Şehir ID
    $teslimat_ilce = $_POST['teslimat_ilce']; // İlçe ID
    
    // Mesafeli satış sözleşmesi kontrol et
    if (!isset($_POST['mesafeli_satis'])) {
        header("Location:../odeme.php?durum=sozlesme");
        exit;
    }
    
    // Zorunlu alanları kontrol et
    if (empty($teslimat_ad) || empty($teslimat_soyad) || empty($teslimat_mail) || 
        empty($teslimat_adres) || empty($teslimat_il) || empty($teslimat_ilce)) {
        header("Location:../odeme.php?durum=zorunlu-alanlar");
        exit;
    }
    
    // Sipariş numarası oluştur
    $siparis_no = rand(100000, 999999);
    
    // Kullanıcı bilgilerini güncelle
    $kullanici_guncelle = $db->prepare("UPDATE kullanicilar SET 
        kullanici_ad = :ad,
        kullanici_soyad = :soyad,
        kullanici_adsoyad = :adsoyad,
        kullanici_tc = :tc,
        kullanici_gsm = :gsm,
        kullanici_mail = :mail,
        kullanici_adres = :adres,
        kullanici_il = :il,
        kullanici_ilce = :ilce
        WHERE kullanici_id = :kullanici_id
    ");
    
    $kullanici_guncelle->execute([
        'ad' => $teslimat_ad,
        'soyad' => $teslimat_soyad,
        'adsoyad' => $teslimat_ad . ' ' . $teslimat_soyad,
        'tc' => $teslimat_tc,
        'gsm' => $teslimat_tel,
        'mail' => $teslimat_mail,
        'adres' => $teslimat_adres,
        'il' => $teslimat_il,
        'ilce' => $teslimat_ilce,
        'kullanici_id' => $kullanici_id
    ]);
    
    // Sepetteki ürünleri al
    $sepetsor = $db->prepare("SELECT * FROM sepet WHERE kullanici_id = :kullanici_id");
    $sepetsor->execute(['kullanici_id' => $kullanici_id]);
    $sepet_urunleri = $sepetsor->fetchAll(PDO::FETCH_ASSOC);
    
    // Sipariş oluştur
    $siparis_ekle = $db->prepare("INSERT INTO siparis SET 
        siparis_zaman = NOW(),
        siparis_no = :siparis_no,
        kullanici_id = :kullanici_id,
        siparis_toplam = :siparis_toplam,
        siparis_tip = :siparis_tip,
        siparis_banka = :siparis_banka,
        siparis_odeme = :siparis_odeme,
        siparis_durum_id = :siparis_durum_id
    ");
    
    $insert = $siparis_ekle->execute([
        'siparis_no' => $siparis_no,
        'kullanici_id' => $kullanici_id,
        'siparis_toplam' => $siparis_toplam,
        'siparis_tip' => $odeme_tipi,
        'siparis_banka' => $banka,
        'siparis_odeme' => 0, // Ödenmedi
        'siparis_durum_id' => 1 // Sipariş Alındı
    ]);
    
    if ($insert) {
        // Sipariş ID'sini al
        $siparis_id = $db->lastInsertId();
        
        // Sepetteki her ürün için sipariş detayı oluştur
        foreach ($sepet_urunleri as $urun) {
            // Ürün bilgilerini al
            $urunsor = $db->prepare("SELECT * FROM urun WHERE urun_id = :urun_id");
            $urunsor->execute(['urun_id' => $urun['urun_id']]);
            $uruncek = $urunsor->fetch(PDO::FETCH_ASSOC);
            
            // Sipariş detayı oluştur
            $detay_ekle = $db->prepare("INSERT INTO siparis_detay SET 
                siparis_id = :siparis_id,
                urun_id = :urun_id,
                urun_fiyat = :urun_fiyat,
                urun_adet = :urun_adet
            ");
            
            $detay_ekle->execute([
                'siparis_id' => $siparis_id,
                'urun_id' => $urun['urun_id'],
                'urun_fiyat' => $uruncek['urun_satisfiyati'],
                'urun_adet' => $urun['urun_adet']
            ]);
            
            // Ürün stoktan düş
            $stok_guncelle = $db->prepare("UPDATE urun SET urun_stok = urun_stok - :adet WHERE urun_id = :urun_id");
            $stok_guncelle->execute([
                'adet' => $urun['urun_adet'],
                'urun_id' => $urun['urun_id']
            ]);
        }
        
        // Sepeti temizle
        $sepet_temizle = $db->prepare("DELETE FROM sepet WHERE kullanici_id = :kullanici_id");
        $sepet_temizle->execute(['kullanici_id' => $kullanici_id]);
        
        // Sipariş tamamlandı sayfasına yönlendir
        Header("Location:../siparis-tamamlandi.php?siparis_no=$siparis_no");
    } else {
        // Hata durumunda sepet sayfasına yönlendir
        Header("Location:../sepet.php?durum=hata");
    }
}

?>

