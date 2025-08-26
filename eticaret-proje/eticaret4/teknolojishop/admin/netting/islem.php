<?php
ob_start();
session_start();

include 'baglan.php';
include '../production/fonksiyon.php';

if (isset($_POST['kullanicikaydet'])) {

	
	echo $kullanici_adsoyad=htmlspecialchars($_POST['kullanici_adsoyad']); echo "<br>";
	echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); echo "<br>";

	echo $kullanici_passwordone=trim($_POST['kullanici_passwordone']); echo "<br>";
	echo $kullanici_passwordtwo=trim($_POST['kullanici_passwordtwo']); echo "<br>";



	if ($kullanici_passwordone==$kullanici_passwordtwo) {


		if (strlen($kullanici_passwordone)>=6) {


			

			


// Başlangıç

			$kullanicisor=$db->prepare("select * from kullanicilar where kullanici_mail=:mail");
			$kullanicisor->execute(array(
				'mail' => $kullanici_mail
			));

			//dönen satır sayısını belirtir
			$say=$kullanicisor->rowCount();



			if ($say==0) {

				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($kullanici_passwordone);

				$kullanici_yetki=1;

			//Kullanıcı kayıt işlemi yapılıyor...
				$kullanicikaydet=$db->prepare("INSERT INTO kullanicilar SET
					kullanici_adsoyad=:kullanici_adsoyad,
					kullanici_mail=:kullanici_mail,
					kullanici_password=:kullanici_password,
					kullanici_yetki=:kullanici_yetki
					");
				$insert=$kullanicikaydet->execute(array(
					'kullanici_adsoyad' => $kullanici_adsoyad,
					'kullanici_mail' => $kullanici_mail,
					'kullanici_password' => $password,
					'kullanici_yetki' => $kullanici_yetki
				));

				if ($insert) {


					header("Location:../../index.php?durum=loginbasarili");


				//Header("Location:../production/genel-ayarlar.php?durum=ok");

				} else {


					header("Location:../../register.php?durum=basarisiz");
				}

			} else {

				header("Location:../../register.php?durum=mukerrerkayit");



			}




		// Bitiş



		} else {


			header("Location:../../register.php?durum=eksiksifre");


		}



	} else {



		header("Location:../../register.php?durum=farklisifre");
	}
	


}




if (isset($_POST['sliderkaydet'])) {


	$uploads_dir = '../../images/slider';
	@$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
	@$name = $_FILES['slider_resimyol']["name"];
	//resmin isminin benzersiz olması
	$benzersizsayi1=rand(20000,32000);
	$benzersizsayi2=rand(20000,32000);
	$benzersizsayi3=rand(20000,32000);
	$benzersizsayi4=rand(20000,32000);	
	$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");
	


	$kaydet=$db->prepare("INSERT INTO slider SET
		slider_ad=:slider_ad,
		slider_sira=:slider_sira,
		slider_link=:slider_link,
		slider_resimyol=:slider_resimyol
		");
	$insert=$kaydet->execute(array(
		'slider_ad' => $_POST['slider_ad'],
		'slider_sira' => $_POST['slider_sira'],
		'slider_link' => $_POST['slider_link'],
		'slider_resimyol' => $refimgyol
	));

	if ($insert) {

		Header("Location:../production/slider.php?durum=ok");

	} else {

		Header("Location:../production/slider.php?durum=no");
	}




}



// Slider Düzenleme Başla


if (isset($_POST['sliderduzenle'])) {

	
	if($_FILES['slider_resimyol']["size"] > 0)  { 


		$uploads_dir = '../../images/slider';
		@$tmp_name = $_FILES['slider_resimyol']["tmp_name"];
		@$name = $_FILES['slider_resimyol']["name"];
		$benzersizsayi1=rand(20000,32000);
		$benzersizsayi2=rand(20000,32000);
		$benzersizsayi3=rand(20000,32000);
		$benzersizsayi4=rand(20000,32000);
		$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
		$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
		@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

		$duzenle=$db->prepare("UPDATE slider SET
			slider_ad=:ad,
			slider_link=:link,
			slider_sira=:sira,
			slider_durum=:durum,
			slider_resimyol=:resimyol	
			WHERE slider_id={$_POST['slider_id']}");
		$update=$duzenle->execute(array(
			'ad' => $_POST['slider_ad'],
			'link' => $_POST['slider_link'],
			'sira' => $_POST['slider_sira'],
			'durum' => $_POST['slider_durum'],
			'resimyol' => $refimgyol,
		));
		

		$slider_id=$_POST['slider_id'];

		if ($update) {

			$resimsilunlink=$_POST['slider_resimyol'];
			unlink("../../$resimsilunlink");

			Header("Location:../production/slider-duzenle.php?slider_id=$slider_id&durum=ok");

		} else {

			Header("Location:../production/slider-duzenle.php?durum=no");
		}



	} else {

		$duzenle=$db->prepare("UPDATE slider SET
			slider_ad=:ad,
			slider_link=:link,
			slider_sira=:sira,
			slider_durum=:durum		
			WHERE slider_id={$_POST['slider_id']}");
		$update=$duzenle->execute(array(
			'ad' => $_POST['slider_ad'],
			'link' => $_POST['slider_link'],
			'sira' => $_POST['slider_sira'],
			'durum' => $_POST['slider_durum']
		));

		$slider_id=$_POST['slider_id'];

		if ($update) {

			Header("Location:../production/slider-duzenle.php?slider_id=$slider_id&durum=ok");

		} else {

			Header("Location:../production/slider-duzenle.php?durum=no");
		}
	}

}


// Slider Düzenleme Bitiş

if (isset($_GET['slidersil']) && $_GET['slidersil'] == "ok") {
    $sil = $db->prepare("DELETE from slider where slider_id=:slider_id");
    $kontrol = $sil->execute(array(
        'slider_id' => $_GET['slider_id']
    ));

    if ($kontrol) {
        $resimsilunlink = $_GET['slider_resimyol'];
        unlink("../../$resimsilunlink");

        Header("Location:../production/slider.php?durum=ok");
    } else {
        Header("Location:../production/slider.php?durum=no");
    }
}


if (isset($_POST['logoduzenle'])) {

	
	


	
	if ($_FILES['ayar_logo']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../production/genel-ayar.php?durum=dosyabuyuk");

	}


	$izinli_uzantilar=array('jpg','gif');

	//echo $_FILES['ayar_logo']["name"];

	$ext=strtolower(substr($_FILES['ayar_logo']["name"],strpos($_FILES['ayar_logo']["name"],'.')+1));

	if (in_array($ext, $izinli_uzantilar) === false) {
		echo "Bu uzantı kabul edilmiyor";
		Header("Location:../production/genel-ayar.php?durum=formathata");

		exit;
	}


	$uploads_dir = '../../dimg';

	@$tmp_name = $_FILES['ayar_logo']["tmp_name"];
	@$name = $_FILES['ayar_logo']["name"];

	$benzersizsayi4=rand(20000,32000);
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizsayi4.$name;

	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi4$name");

	
	$duzenle=$db->prepare("UPDATE ayar SET
		ayar_logo=:logo
		WHERE ayar_id=0");
	$update=$duzenle->execute(array(
		'logo' => $refimgyol
	));



	if ($update) {

		$resimsilunlink=$_POST['eski_yol'];
		unlink("../../$resimsilunlink");

		Header("Location:../production/genel-ayar.php?durum=ok");

	} else {

		Header("Location:../production/genel-ayar.php?durum=no");
	}

}


if (isset($_POST['admingiris'])) {

	$kullanici_mail=$_POST['kullanici_mail'];
	$kullanici_password=md5($_POST['kullanici_password']);

	$kullanicisor=$db->prepare("SELECT * FROM kullanicilar where kullanici_mail=:mail and kullanici_password=:password and kullanici_yetki=:yetki");
	$kullanicisor->execute(array(
		'mail' => $kullanici_mail,
		'password' => $kullanici_password,
		'yetki' => 5
	));

	$say=$kullanicisor->rowCount();

	if ($say==1) {
        // Kullanıcı bilgilerini çekiyoruz
        $kullanici = $kullanicisor->fetch(PDO::FETCH_ASSOC);
        
        // Kullanıcı kimliğini ve e-posta bilgisini oturuma kaydediyoruz
        $_SESSION['kullanici_id'] = $kullanici['kullanici_id'];
		$_SESSION['kullanici_mail'] = $kullanici_mail;
		
		header("Location:../production/index.php");
		exit;
	} else {
		header("Location:../production/login.php?durum=no");
		exit;
	}
}


if (isset($_POST['kullanicigiris'])) {


	
	echo $kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); 
	echo $kullanici_password=md5($_POST['kullanici_password']); 



	$kullanicisor=$db->prepare("select * from kullanicilar where kullanici_mail=:mail and kullanici_yetki=:yetki and kullanici_password=:password and kullanici_durum=:durum");
	$kullanicisor->execute(array(
		'mail' => $kullanici_mail,
		'yetki' => 1,
		'password' => $kullanici_password,
		'durum' => 1
	));


	$say=$kullanicisor->rowCount();



	if ($say==1) {

		echo $_SESSION['userkullanici_mail']=$kullanici_mail;

		header("Location:../../");
		exit;
		




	} else {


		header("Location:../../?durum=basarisizgiris");

	}


}






if (isset($_POST['genelayarkaydet'])) {
	
	//Tablo güncelleme işlemi kodları...
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_title=:ayar_title,
		ayar_description=:ayar_description,
		ayar_keywords=:ayar_keywords,
		ayar_author=:ayar_author
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_title' => $_POST['ayar_title'],
		'ayar_description' => $_POST['ayar_description'],
		'ayar_keywords' => $_POST['ayar_keywords'],
		'ayar_author' => $_POST['ayar_author']
	));


	if ($update) {
		header("Location:../production/genel-ayar.php?durum=ok");
	} else {
		header("Location:../production/genel-ayar.php?durum=no");
	}
	
}



if (isset($_POST['iletisimayarkaydet'])) {
	
	//Tablo güncelleme işlemi kodları...
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_tel=:ayar_tel,
		ayar_gsm=:ayar_gsm,
		ayar_faks=:ayar_faks,
		ayar_mail=:ayar_mail,
		ayar_ilce=:ayar_ilce,
		ayar_il=:ayar_il,
		ayar_adres=:ayar_adres,
		ayar_mesai=:ayar_mesai
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(
		'ayar_tel' => $_POST['ayar_tel'],
		'ayar_gsm' => $_POST['ayar_gsm'],
		'ayar_faks' => $_POST['ayar_faks'],
		'ayar_mail' => $_POST['ayar_mail'],
		'ayar_ilce' => $_POST['ayar_ilce'],
		'ayar_il' => $_POST['ayar_il'],
		'ayar_adres' => $_POST['ayar_adres'],
		'ayar_mesai' => $_POST['ayar_mesai']
	));

	if ($update) {
		header("Location:../production/iletisim-ayarlar.php?durum=ok");
	} else {
		header("Location:../production/iletisim-ayarlar.php?durum=no");
	}
	
}


if (isset($_POST['apiayarkaydet'])) {
	
	//Tablo güncelleme işlemi kodları...
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		
		ayar_analystic=:ayar_analystic,
		ayar_maps=:ayar_maps,
		ayar_zopim=:ayar_zopim
		WHERE ayar_id=0");

	$update=$ayarkaydet->execute(array(

		'ayar_analystic' => $_POST['ayar_analystic'],
		'ayar_maps' => $_POST['ayar_maps'],
		'ayar_zopim' => $_POST['ayar_zopim']
	));


	if ($update) {

		header("Location:../production/api-ayarlar.php?durum=ok");

	} else {

		header("Location:../production/api-ayarlar.php?durum=no");
	}
	
}

if (isset($_POST['sosyalayarkaydet'])) {
    $ayarkaydet = $db->prepare("UPDATE ayar SET
        ayar_facebook = :facebook,
        ayar_twitter = :twitter,
        ayar_instagram = :instagram,
        ayar_linkedin = :linkedin,
        ayar_youtube = :youtube
        WHERE ayar_id = 0");

    $update = $ayarkaydet->execute(array(
        'facebook' => $_POST['ayar_facebook'],
        'twitter' => $_POST['ayar_twitter'],
        'instagram' => $_POST['ayar_instagram'],
        'linkedin' => $_POST['ayar_linkedin'],
        'youtube' => $_POST['ayar_youtube']
    ));

    if ($update) {
        Header("Location:../production/sosyal-ayar.php?durum=ok");
    } else {
        Header("Location:../production/sosyal-ayar.php?durum=no");
    }
}



if (isset($_POST['hakkimizdakaydet'])) {
	
	//Tablo güncelleme işlemi kodları...

	/*

	copy paste işlemlerinde tablo ve işaretli satır isminin değiştirildiğinden emin olun!!!

	*/
	$ayarkaydet=$db->prepare("UPDATE hakkimizda SET
		hakkimizda_baslik=:hakkimizda_baslik,
		hakkimizda_icerik=:hakkimizda_icerik,
		hakkimizda_video=:hakkimizda_video,
		hakkimizda_vizyon=:hakkimizda_vizyon,
		hakkimizda_misyon=:hakkimizda_misyon
		WHERE hakkimizda_id=0");

	$update=$ayarkaydet->execute(array(
		'hakkimizda_baslik' => $_POST['hakkimizda_baslik'],
		'hakkimizda_icerik' => $_POST['hakkimizda_icerik'],
		'hakkimizda_video' => $_POST['hakkimizda_video'],
		'hakkimizda_vizyon' => $_POST['hakkimizda_vizyon'],
		'hakkimizda_misyon' => $_POST['hakkimizda_misyon']
	));


	if ($update) {

		header("Location:../production/hakkimizda.php?durum=ok");

	} else {

		header("Location:../production/hakkimizda.php?durum=no");
	}
	
}





if (isset($_POST['kullanicibilgiguncelle'])) {

	$kullanici_id=$_POST['kullanici_id'];

	$ayarkaydet=$db->prepare("UPDATE kullanici SET
		kullanici_adsoyad=:kullanici_adsoyad,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce
		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$ayarkaydet->execute(array(
		'kullanici_adsoyad' => $_POST['kullanici_adsoyad'],
		'kullanici_il' => $_POST['kullanici_il'],
		'kullanici_ilce' => $_POST['kullanici_ilce']
	));


	if ($update) {

		Header("Location:../../hesabim?durum=ok");

	} else {

		Header("Location:../../hesabim?durum=no");
	}

}


if (isset($_GET['kullanicisil']) && $_GET['kullanicisil']=="ok") {

	$sil=$db->prepare("DELETE from kullanicilar where kullanici_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['kullanici_id']
	));


	if ($kontrol) {
		header("location:../production/kullanici.php?sil=ok");
	} else {
		header("location:../production/kullanici.php?sil=no");
	}

}

/*
if (isset($_POST['icerikduzenle'])) {

	$icerik_id=$_POST['icerik_id'];

	$icerik_seourl=seo($_POST['icerik_seourl']);

	
	$ayarkaydet=$db->prepare("UPDATE icerikler SET
		icerik_baslik=:icerik_baslik,
		icerik_metni=:icerik_metni,
		icerik_seourl=:icerik_seourl,
		icerik_sira=:icerik_sira,
		icerik_durum=:icerik_durum,
		icerik_type=:icerik_type
		WHERE icerik_id={$_POST['icerik_id']}");

	$update=$ayarkaydet->execute(array(
		'icerik_baslik' => $_POST['icerik_baslik'],
		'icerik_metni' => $_POST['icerik_metni'],
		'icerik_seourl' => $icerik_seourl,
		'icerik_sira' => $_POST['icerik_sira'],
		'icerik_durum' => $_POST['icerik_durum'],
		'icerik_type' => $_POST['icerik_type']
	));


	if ($update) {

		Header("Location:../production/icerik-duzenle.php?icerik_id=$icerik_id&durum=ok");

	} else {

		Header("Location:../production/icerik-duzenle.php?icerik_id=$icerik_id&durum=no");
	}

}*/

if (isset($_POST['icerikduzenle'])) {
    $icerik_id = $_POST['icerik_id'];
    $icerik_seourl = seo($_POST['icerik_seourl']);
    $icerik_type = $_POST['icerik_type'] === 'yeni' ? $_POST['yeni_icerik_type'] : $_POST['icerik_type'];

    $ayarkaydet = $db->prepare("UPDATE icerikler SET
        icerik_baslik=:icerik_baslik,
        icerik_metni=:icerik_metni,
        icerik_seourl=:icerik_seourl,
        icerik_sira=:icerik_sira,
        icerik_durum=:icerik_durum,
        icerik_type=:icerik_type
        WHERE icerik_id=:icerik_id
    ");
    $update = $ayarkaydet->execute(array(
        'icerik_baslik' => $_POST['icerik_baslik'],
        'icerik_metni' => $_POST['icerik_metni'],
        'icerik_seourl' => $icerik_seourl,
        'icerik_sira' => $_POST['icerik_sira'],
        'icerik_durum' => $_POST['icerik_durum'],
        'icerik_type' => $icerik_type,
        'icerik_id' => $icerik_id
    ));

    if ($update) {
        Header("Location:../production/icerik-duzenle.php?icerik_id=$icerik_id&durum=ok");
    } else {
        Header("Location:../production/icerik-duzenle.php?icerik_id=$icerik_id&durum=no");
    }
}

if (isset($_GET['iceriksil']) && $_GET['iceriksil']=="ok") {

	$sil=$db->prepare("DELETE from icerikler where icerik_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['icerik_id']
	));


	if ($kontrol) {
		header("location:../production/icerik.php?sil=ok");
	} else {
		header("location:../production/icerik.php?sil=no");
	}

}

/*
if (isset($_POST['icerikkaydet'])) {


	$icerik_seourl=seo($_POST['icerik_ad']);


	$ayarekle=$db->prepare("INSERT INTO icerikler SET
        icerik_baslik=:icerik_baslik,
		icerik_metni=:icerik_metni,
		icerik_seourl=:icerik_seourl,
		icerik_sira=:icerik_sira,
		icerik_durum=:icerik_durum,
		icerik_type=:icerik_type
		");

	$insert=$ayarekle->execute(array(
        'icerik_baslik' => $_POST['icerik_baslik'],
        'icerik_metni' => $_POST['icerik_metni'],
        'icerik_seourl' => $icerik_seourl,
        'icerik_sira' => $_POST['icerik_sira'],
        'icerik_durum' => $_POST['icerik_durum'],
        'icerik_type' => $_POST['icerik_type']
	));


	if ($insert) {

		Header("Location:../production/icerik.php?durum=ok");

	} else {

		Header("Location:../production/icerik.php?durum=no");
	}

}*/

if (isset($_POST['icerikkaydet'])) {
    $icerik_seourl = seo($_POST['icerik_baslik']);
    $icerik_type = $_POST['icerik_type'] === 'yeni' ? $_POST['yeni_icerik_type'] : $_POST['icerik_type'];

    $ayarekle = $db->prepare("INSERT INTO icerikler SET
        icerik_baslik=:icerik_baslik,
        icerik_metni=:icerik_metni,
        icerik_seourl=:icerik_seourl,
        icerik_sira=:icerik_sira,
        icerik_durum=:icerik_durum,
        icerik_type=:icerik_type
    ");
    $insert = $ayarekle->execute(array(
        'icerik_baslik' => $_POST['icerik_baslik'],
        'icerik_metni' => $_POST['icerik_metni'],
        'icerik_seourl' => $icerik_seourl,
        'icerik_sira' => $_POST['icerik_sira'],
        'icerik_durum' => $_POST['icerik_durum'],
        'icerik_type' => $icerik_type
    ));

    if ($insert) {
        Header("Location:../production/icerik.php?durum=ok");
    } else {
        Header("Location:../production/icerik.php?durum=no");
    }
}

if (isset($_POST['kategoriduzenle'])) {
    $kategori_id = $_POST['kategori_id'];
    $kategori_seourl = seo($_POST['kategori_ad']);

    $kaydet = $db->prepare("UPDATE kategori SET
        kategori_ad = :ad,
        kategori_ust = :ust,
        kategori_durum = :kategori_durum,
        kategori_seourl = :seourl,
        kategori_sira = :sira
        WHERE kategori_id = :id
    ");
    $update = $kaydet->execute(array(
        'ad' => $_POST['kategori_ad'],
        'ust' => $_POST['kategori_ust'],
        'kategori_durum' => $_POST['kategori_durum'],
        'seourl' => $kategori_seourl,
        'sira' => $_POST['kategori_sira'] ?: 0, // Varsayılan değer 0
        'id' => $kategori_id 
    ));

    if ($update) {
        Header("Location:../production/kategori-duzenle.php?durum=ok&kategori_id=$kategori_id");
    } else {
        Header("Location:../production/kategori-duzenle.php?durum=no&kategori_id=$kategori_id");
    }
}

if (isset($_POST['kategoriekle'])) {
    $kategori_seourl = seo($_POST['kategori_ad']);

    $kaydet = $db->prepare("INSERT INTO kategori SET
        kategori_ad = :ad,
        kategori_ust = :ust,
        kategori_durum = :kategori_durum,
        kategori_seourl = :seourl,
        kategori_sira = :sira
    ");
    $insert = $kaydet->execute(array(
        'ad' => $_POST['kategori_ad'],
        'ust' => $_POST['kategori_ust'],
        'kategori_durum' => $_POST['kategori_durum'],
        'seourl' => $kategori_seourl,
        'sira' => $_POST['kategori_sira'] ?: 0
    ));

    if ($insert) {
        Header("Location:../production/kategori.php?durum=ok");
    } else {
        Header("Location:../production/kategori.php?durum=no");
    }
}

if (isset($_GET['kategorisil']) && $_GET['kategorisil']=="ok") {
	
	$sil=$db->prepare("DELETE from kategori where kategori_id=:kategori_id");
	$kontrol=$sil->execute(array(
		'kategori_id' => $_GET['kategori_id']
	));

	if ($kontrol) {

		Header("Location:../production/kategori.php?durum=ok");

	} else {

		Header("Location:../production/kategori.php?durum=no");
	}
}

// ...existing code...

if (isset($_GET['kategori_ekle']) && $_GET['kategori_ekle'] == "ok") {
    $kategori_ust = $_GET['kategori_ust'];
    $kategori_ad = $_GET['kategori_ad'];

    $kaydet = $db->prepare("INSERT INTO kategori SET
        kategori_ad = :ad,
        kategori_ust = :ust,
        kategori_seourl = :seourl,
        kategori_sira = 0,
        kategori_durum = 1
    ");
    $insert = $kaydet->execute([
        'ad' => $kategori_ad,
        'ust' => $kategori_ust,
        'seourl' => seo($kategori_ad)
    ]);

    if ($insert) {
        Header("Location:../production/kategori.php?durum=ok");
    } else {
        Header("Location:../production/kategori.php?durum=no");
    }
}

if (isset($_GET['kategori_sil']) && $_GET['kategori_sil'] == "ok") {
    $kategori_id = $_GET['kategori_id'];

    $sil = $db->prepare("DELETE FROM kategori WHERE kategori_id = :id");
    $kontrol = $sil->execute(['id' => $kategori_id]);

    if ($kontrol) {
        Header("Location:../production/kategori.php?durum=ok");
    } else {
        Header("Location:../production/kategori.php?durum=no");
    }
}

// ...existing code...

if (isset($_GET['urunsil']) && $_GET['urunsil']=="ok") {
	
	$sil=$db->prepare("DELETE from urun where urun_id=:urun_id");
	$kontrol=$sil->execute(array(
		'urun_id' => $_GET['urun_id']
	));

	if ($kontrol) {

		Header("Location:../production/urun.php?durum=ok");

	} else {

		Header("Location:../production/urun.php?durum=no");
	}

}



if (isset($_POST['urunekle'])) {

    $urun_seourl=seo($_POST['urun_adi']);

    $image_paths = [];
    for ($i = 1; $i <= 6; $i++) {
        if ($_FILES["urun_resim$i"]['size'] > 0) {
            $uploads_dir = '../../images/product';
            $tmp_name = $_FILES["urun_resim$i"]["tmp_name"];
            $name = uniqid() . "_" . $_FILES["urun_resim$i"]["name"];
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
            $image_paths[] = "images/product/$name";
        } else {
            $image_paths[] = '';
        }
    }

  $kaydet = $db->prepare("INSERT INTO urun SET
    kategori_id = :kategori_id,
    urun_durum = :urun_durum,
    urun_marka = :urun_marka,
    urun_adi = :urun_adi,
    urun_kodu = :urun_kodu,
    urun_barkodu = :urun_barkodu,
    urun_aciklama = :urun_aciklama,
    urun_stok = :urun_stok,
    urun_satisfiyati = :urun_satisfiyati,
    urun_piyasafiyati = :urun_piyasafiyati,
    urun_kdvorani = :urun_kdvorani,
    urun_kdvdahil = :urun_kdvdahil,
    urun_doviz = :urun_doviz,
    urun_keyword = :urun_keyword,
    urun_onecikar = :urun_onecikar,
    urun_seourl = :urun_seourl,
    urun_resim1 = :urun_resim1,
    urun_resim2 = :urun_resim2,
    urun_resim3 = :urun_resim3,
    urun_resim4 = :urun_resim4,
    urun_resim5 = :urun_resim5,
    urun_resim6 = :urun_resim6
  ");
  $insert = $kaydet->execute([
    'kategori_id' => $_POST['kategori_id'],
    'urun_durum' => $_POST['urun_durum'],
    'urun_marka' => $_POST['urun_marka'],
    'urun_adi' => $_POST['urun_adi'],
    'urun_kodu' => $_POST['urun_kodu'],
    'urun_barkodu' => $_POST['urun_barkodu'],
    'urun_aciklama' => $_POST['urun_aciklama'],
    'urun_stok' => $_POST['urun_stok'],
    'urun_satisfiyati' => $_POST['urun_satisfiyati'],
    'urun_piyasafiyati' => $_POST['urun_piyasafiyati'],
    'urun_kdvorani' => $_POST['urun_kdvorani'],
    'urun_kdvdahil' => $_POST['urun_kdvdahil'],
    'urun_doviz' => $_POST['urun_doviz'],
    'urun_keyword' => $_POST['urun_keyword'],
    'urun_onecikar' => $_POST['urun_onecikar'],
    'urun_seourl' => $urun_seourl,
    'urun_resim1' => $image_paths[0],
    'urun_resim2' => $image_paths[1],
    'urun_resim3' => $image_paths[2],
    'urun_resim4' => $image_paths[3],
    'urun_resim5' => $image_paths[4],
    'urun_resim6' => $image_paths[5]
  ]);

  $son_id = $db->lastInsertId();
    
  // Filtre ekleme işlemi
  if(isset($_POST['filtre_id'])) {
      foreach($_POST['filtre_id'] as $filtre_id) {
          if(!empty($filtre_id)) {
              $filtreKaydet = $db->prepare("INSERT INTO urun_filtreleri SET 
              filtre_id = :filtre_id,
              urun_id = :urun_id,
              filtre_urun_sira = :sira");
              
              $filtreInsert = $filtreKaydet->execute([
                  'filtre_id' => $filtre_id,
                  'urun_id' => $son_id,
                  'sira' => 0
              ]);
          }
      }
  }

  if ($insert) {
    header("Location:../production/urun-ekle.php?durum=ok");
  } else {
    header("Location:../production/urun-ekle.php?durum=no");
  }
}

if (isset($_POST['urunduzenle'])) {
    $urun_id = $_POST['urun_id'];

    $uploads_dir = '../../images/product';
    $image_fields = ['urun_resim1', 'urun_resim2', 'urun_resim3', 'urun_resim4', 'urun_resim5', 'urun_resim6'];
    $uploaded_images = [];

    foreach ($image_fields as $image_field) {
        if ($_FILES[$image_field]["size"] > 0) {
            @$tmp_name = $_FILES[$image_field]["tmp_name"];
            @$name = $_FILES[$image_field]["name"];
            $benzersizsayi1 = rand(20000, 32000);
            $benzersizsayi2 = rand(20000, 32000);
            $benzersizad = $benzersizsayi1 . $benzersizsayi2;
            $refimgyol = substr($uploads_dir, 6) . "/" . $benzersizad . $name;
            @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");
            $uploaded_images[$image_field] = $refimgyol;
        } else {
            $uploaded_images[$image_field] = isset($_POST["existing_$image_field"]) ? $_POST["existing_$image_field"] : '';
        }
    }

    $duzenle = $db->prepare("UPDATE urun SET
        kategori_id = :kategori_id,
        urun_durum = :urun_durum,
        urun_marka = :urun_marka,
        urun_adi = :urun_adi,
        urun_kodu = :urun_kodu,
        urun_barkodu = :urun_barkodu,
        urun_aciklama = :urun_aciklama,
        urun_stok = :urun_stok,
        urun_satisfiyati = :urun_satisfiyati,
        urun_piyasafiyati = :urun_piyasafiyati,
        urun_kdvorani = :urun_kdvorani,
        urun_kdvdahil = :urun_kdvdahil,
        urun_doviz = :urun_doviz,
        urun_keyword = :urun_keyword,
        urun_onecikar = :urun_onecikar,
        urun_resim1 = :urun_resim1,
        urun_resim2 = :urun_resim2,
        urun_resim3 = :urun_resim3,
        urun_resim4 = :urun_resim4,
        urun_resim5 = :urun_resim5,
        urun_resim6 = :urun_resim6
        WHERE urun_id = :urun_id");

    $update = $duzenle->execute(array(
        'kategori_id' => $_POST['kategori_id'],
        'urun_durum' => $_POST['urun_durum'],
        'urun_marka' => $_POST['urun_marka'],
        'urun_adi' => $_POST['urun_adi'],
        'urun_kodu' => $_POST['urun_kodu'],
        'urun_barkodu' => $_POST['urun_barkodu'],
        'urun_aciklama' => $_POST['urun_aciklama'],
        'urun_stok' => $_POST['urun_stok'],
        'urun_satisfiyati' => $_POST['urun_satisfiyati'],
        'urun_piyasafiyati' => $_POST['urun_piyasafiyati'],
        'urun_kdvorani' => $_POST['urun_kdvorani'],
        'urun_kdvdahil' => $_POST['urun_kdvdahil'],
        'urun_doviz' => $_POST['urun_doviz'],
        'urun_keyword' => $_POST['urun_keyword'],
        'urun_onecikar' => $_POST['urun_onecikar'],
        'urun_resim1' => $uploaded_images['urun_resim1'],
        'urun_resim2' => $uploaded_images['urun_resim2'],
        'urun_resim3' => $uploaded_images['urun_resim3'],
        'urun_resim4' => $uploaded_images['urun_resim4'],
        'urun_resim5' => $uploaded_images['urun_resim5'],
        'urun_resim6' => $uploaded_images['urun_resim6'],
        'urun_id' => $urun_id
    ));

    if($update) {
        // Önce mevcut filtreleri temizle
        $filtreSil = $db->prepare("DELETE FROM urun_filtreleri WHERE urun_id = :urun_id");
        $filtreSil->execute([
            'urun_id' => $_POST['urun_id']
        ]);
        
        // Yeni filtreleri ekle
        if(isset($_POST['filtre_id'])) {
            foreach($_POST['filtre_id'] as $filtre_id) {
                if(!empty($filtre_id)) {
                    $filtreKaydet = $db->prepare("INSERT INTO urun_filtreleri SET 
                    filtre_id = :filtre_id,
                    urun_id = :urun_id,
                    filtre_urun_sira = :sira");
                    
                    $filtreInsert = $filtreKaydet->execute([
                        'filtre_id' => $filtre_id,
                        'urun_id' => $_POST['urun_id'],
                        'sira' => 0
                    ]);
                }
            }
        }
        
        Header("Location:../production/urun-duzenle.php?urun_id=$urun_id&durum=ok");
    } else {
        Header("Location:../production/urun-duzenle.php?urun_id=$urun_id&durum=no");
    }
}


if (isset($_POST['yorumkaydet'])) {


	$gelen_url=$_POST['gelen_url'];

	$ayarekle=$db->prepare("INSERT INTO yorumlar SET
		yorum_detay=:yorum_detay,
		kullanici_id=:kullanici_id,
		urun_id=:urun_id	
		
		");

	$insert=$ayarekle->execute(array(
		'yorum_detay' => $_POST['yorum_detay'],
		'kullanici_id' => $_POST['kullanici_id'],
		'urun_id' => $_POST['urun_id']
		
	));


	if ($insert) {

		Header("Location:$gelen_url?durum=ok");

	} else {

		Header("Location:$gelen_url?durum=no");
	}

}


if (isset($_POST['sepetekle'])) {


	$ayarekle=$db->prepare("INSERT INTO sepet SET
		urun_adet=:urun_adet,
		kullanici_id=:kullanici_id,
		urun_id=:urun_id	
		
		");

	$insert=$ayarekle->execute(array(
		'urun_adet' => $_POST['urun_adet'],
		'kullanici_id' => $_POST['kullanici_id'],
		'urun_id' => $_POST['urun_id']
		
	));


	if ($insert) {

		Header("Location:../../sepet?durum=ok");

	} else {

		Header("Location:../../sepet?durum=no");
	}

}


if (isset($_GET['urun_onecikar']) && $_GET['urun_onecikar']=="ok") {

	

	
	$duzenle=$db->prepare("UPDATE urun SET
		
		urun_onecikar=:urun_onecikar
		
		WHERE urun_id={$_GET['urun_id']}");
	
	$update=$duzenle->execute(array(


		'urun_onecikar' => $_GET['urun_one']
	));



	if ($update) {

		

		Header("Location:../production/urun.php?durum=ok");

	} else {

		Header("Location:../production/urun.php?durum=no");
	}

}

if (isset($_GET['yorum_onay']) && $_GET['yorum_onay']=="ok") {

	$duzenle=$db->prepare("UPDATE yorumlar SET
		
		yorum_onay=:yorum_onay
		
		WHERE yorum_id={$_GET['yorum_id']}");
	
	$update=$duzenle->execute(array(

		'yorum_onay' => $_GET['yorum_one']
	));

	if ($update) {
		Header("Location:../production/yorum.php?durum=ok");
	} else {
		Header("Location:../production/yorum.php?durum=no");
	}

}



if (isset($_GET['yorumsil']) && $_GET['yorumsil']=="ok") {
	
	$sil=$db->prepare("DELETE from yorumlar where yorum_id=:yorum_id");
	$kontrol=$sil->execute(array(
		'yorum_id' => $_GET['yorum_id']
	));

	if ($kontrol) {

		
		Header("Location:../production/yorum.php?durum=ok");

	} else {

		Header("Location:../production/yorum.php?durum=no");
	}

}

if (isset($_POST['yorumduzenle'])) {
    $yorum_id = $_POST['yorum_id'];
    $yorum_detay = $_POST['yorum_detay'];
    $yorum_puan = $_POST['yorum_puan'];
    $yorum_type = $_POST['yorum_type'] === 'yeni' ? $_POST['yeni_yorum_type'] : $_POST['yorum_type'];
    $yorum_onay = $_POST['yorum_onay'];

    $duzenle = $db->prepare("UPDATE yorumlar SET
        yorum_detay = :yorum_detay,
        yorum_puan = :yorum_puan,
        yorum_type = :yorum_type,
        yorum_onay = :yorum_onay
        WHERE yorum_id = :yorum_id
    ");
    $update = $duzenle->execute(array(
        'yorum_detay' => $yorum_detay,
        'yorum_puan' => $yorum_puan,
        'yorum_type' => $yorum_type,
        'yorum_onay' => $yorum_onay,
        'yorum_id' => $yorum_id
    ));

    if ($update) {
        Header("Location:../production/yorum.php?durum=ok");
    } else {
        Header("Location:../production/yorum.php?durum=no");
    }
}

if (isset($_POST['bankaekle'])) {
    $uploads_dir = '../../images/banks';
    $banka_logo = '';

    // Logo yükleme işlemi
    if ($_FILES['banka_logo']['size'] > 0) {
        @$tmp_name = $_FILES['banka_logo']["tmp_name"];
        @$name = uniqid() . "_" . $_FILES['banka_logo']["name"];
        @move_uploaded_file($tmp_name, "$uploads_dir/$name");
        $banka_logo = "images/banks/$name";
    }

    $kaydet = $db->prepare("INSERT INTO banka_hesaplari SET
        banka_ad = :banka_ad,
        banka_durum = :banka_durum,
        banka_sube = :banka_sube,
        banka_hesapno = :banka_hesapno,
        banka_iban = :banka_iban,
        banka_hesapsahibi = :banka_hesapsahibi,
        doviz_turu = :doviz_turu,
        banka_logo = :banka_logo
    ");
    $insert = $kaydet->execute(array(
        'banka_ad' => $_POST['banka_ad'],
        'banka_durum' => $_POST['banka_durum'],
        'banka_sube' => $_POST['banka_sube'],
        'banka_hesapno' => $_POST['banka_hesapno'],
        'banka_iban' => $_POST['banka_iban'],
        'banka_hesapsahibi' => $_POST['banka_hesapsahibi'],
        'doviz_turu' => $_POST['doviz_turu'],
        'banka_logo' => $banka_logo
    ));

    if ($insert) {
        Header("Location:../production/banka.php?durum=ok");
    } else {
        Header("Location:../production/banka.php?durum=no");
    }
}

if (isset($_POST['bankaduzenle'])) {
    $banka_id = $_POST['banka_id'];
    $uploads_dir = '../../images/banks';
    $banka_logo = $_POST['existing_logo'];

    // Logo güncelleme işlemi
    if ($_FILES['banka_logo']['size'] > 0) {
        @$tmp_name = $_FILES['banka_logo']["tmp_name"];
        @$name = uniqid() . "_" . $_FILES['banka_logo']["name"];
        @move_uploaded_file($tmp_name, "$uploads_dir/$name");
        $banka_logo = "images/banks/$name";

        // Eski logo dosyasını sil
        if (!empty($_POST['existing_logo'])) {
            @unlink("../../" . $_POST['existing_logo']);
        }
    }

    $kaydet = $db->prepare("UPDATE banka_hesaplari SET
        banka_ad = :banka_ad,
        banka_durum = :banka_durum,
        banka_sube = :banka_sube,
        banka_hesapno = :banka_hesapno,
        banka_iban = :banka_iban,
        banka_hesapsahibi = :banka_hesapsahibi,
        doviz_turu = :doviz_turu,
        banka_logo = :banka_logo
        WHERE banka_id = :banka_id
    ");
    $update = $kaydet->execute(array(
        'banka_ad' => $_POST['banka_ad'],
        'banka_durum' => $_POST['banka_durum'],
        'banka_sube' => $_POST['banka_sube'],
        'banka_hesapno' => $_POST['banka_hesapno'],
        'banka_iban' => $_POST['banka_iban'],
        'banka_hesapsahibi' => $_POST['banka_hesapsahibi'],
        'doviz_turu' => $_POST['doviz_turu'],
        'banka_logo' => $banka_logo,
        'banka_id' => $banka_id
    ));

    if ($update) {
        Header("Location:../production/banka-duzenle.php?banka_id=$banka_id&durum=ok");
    } else {
        Header("Location:../production/banka-duzenle.php?banka_id=$banka_id&durum=no");
    }
}

if (isset($_GET['bankasil']) && $_GET['bankasil'] == "ok") {
    $banka_id = $_GET['banka_id'];
    $uploads_dir = '../../images/banks';

    // Banka bilgilerini al
    $bankasor = $db->prepare("SELECT * FROM banka_hesaplari WHERE banka_id = :banka_id");
    $bankasor->execute(array('banka_id' => $banka_id));
    $bankacek = $bankasor->fetch(PDO::FETCH_ASSOC);

    // Banka kaydını sil
    $sil = $db->prepare("DELETE FROM banka_hesaplari WHERE banka_id = :banka_id");
    $kontrol = $sil->execute(array('banka_id' => $banka_id));

    if ($kontrol) {
        // Logo dosyasını sil
        if (!empty($bankacek['banka_logo'])) {
            @unlink("$uploads_dir/" . $bankacek['banka_logo']);
        }
        Header("Location:../production/banka.php?durum=ok");
    } else {
        Header("Location:../production/banka.php?durum=no");
    }
}


if (isset($_POST['kullanicisifreguncelle'])) {

	echo $kullanici_eskipassword=trim($_POST['kullanici_eskipassword']); echo "<br>";
	echo $kullanici_passwordone=trim($_POST['kullanici_passwordone']); echo "<br>";
	echo $kullanici_passwordtwo=trim($_POST['kullanici_passwordtwo']); echo "<br>";

	$kullanici_password=md5($kullanici_eskipassword);


	$kullanicisor=$db->prepare("select * from kullanicilar where kullanici_password=:password");
	$kullanicisor->execute(array(
		'password' => $kullanici_password
	));

			//dönen satır sayısını belirtir
	$say=$kullanicisor->rowCount();



	if ($say==0) {

		header("Location:../../sifre-guncelle?durum=eskisifrehata");



	} else {



	//eski şifre doğruysa başla


		if ($kullanici_passwordone==$kullanici_passwordtwo) {


			if (strlen($kullanici_passwordone)>=6) {


				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($kullanici_passwordone);

				$kullanici_yetki=1;

				$kullanicikaydet=$db->prepare("UPDATE kullanici SET
					kullanici_password=:kullanici_password
					WHERE kullanici_id={$_POST['kullanici_id']}");

				
				$insert=$kullanicikaydet->execute(array(
					'kullanici_password' => $password
				));

				if ($insert) {


					header("Location:../../sifre-guncelle.php?durum=sifredegisti");


				//Header("Location:../production/genel-ayarlar.php?durum=ok");

				} else {


					header("Location:../../sifre-guncelle.php?durum=no");
				}





		// Bitiş



			} else {


				header("Location:../../sifre-guncelle.php?durum=eksiksifre");


			}



		} else {

			header("Location:../../sifre-guncelle?durum=sifreleruyusmuyor");

			exit;


		}


	}

	exit;

	if ($update) {

		header("Location:../../sifre-guncelle?durum=ok");

	} else {

		header("Location:../../sifre-guncelle?durum=no");
	}

}


//Sipariş İşlemleri

if (isset($_POST['bankasiparisekle'])) {


	$siparis_tip="Banka Havalesi";


	$kaydet=$db->prepare("INSERT INTO siparis SET
		kullanici_id=:kullanici_id,
		siparis_tip=:siparis_tip,	
		siparis_banka=:siparis_banka,
		siparis_toplam=:siparis_toplam
		");
	$insert=$kaydet->execute(array(
		'kullanici_id' => $_POST['kullanici_id'],
		'siparis_tip' => $siparis_tip,
		'siparis_banka' => $_POST['siparis_banka'],
		'siparis_toplam' => $_POST['siparis_toplam']		
	));

	if ($insert) {

		//Sipariş başarılı kaydedilirse...

		echo $siparis_id = $db->lastInsertId();

		echo "<hr>";


		$kullanici_id=$_POST['kullanici_id'];
		$sepetsor=$db->prepare("SELECT * FROM sepet where kullanici_id=:id");
		$sepetsor->execute(array(
			'id' => $kullanici_id
		));

		while($sepetcek=$sepetsor->fetch(PDO::FETCH_ASSOC)) {

			$urun_id=$sepetcek['urun_id']; 
			$urun_adet=$sepetcek['urun_adet'];

			$urunsor=$db->prepare("SELECT * FROM urun where urun_id=:id");
			$urunsor->execute(array(
				'id' => $urun_id
			));

			$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
			
			echo $urun_fiyat=$uruncek['urun_satisfiyati'];


			
			$kaydet=$db->prepare("INSERT INTO siparis_detay SET
				
				siparis_id=:siparis_id,
				urun_id=:urun_id,	
				urun_satisfiyati=:urun_satisfiyati,
				urun_adet=:urun_adet
				");
			$insert=$kaydet->execute(array(
				'siparis_id' => $siparis_id,
				'urun_id' => $urun_id,
				'urun_satisfiyati' => $urun_fiyat,
				'urun_adet' => $urun_adet

			));


		}

		if ($insert) {

			

			//Sipariş detay kayıtta başarıysa sepeti boşalt

			$sil=$db->prepare("DELETE from sepet where kullanici_id=:kullanici_id");
			$kontrol=$sil->execute(array(
				'kullanici_id' => $kullanici_id
			));

			
			Header("Location:../../siparislerim?durum=ok");
			exit;


		}

		




	} else {

		echo "başarısız";

		//Header("Location:../production/siparis.php?durum=no");
	}



}


if(isset($_POST['urunfotosil'])) {

	$urun_id=$_POST['urun_id'];


	echo $checklist = $_POST['urunfotosec'];

	
	foreach($checklist as $list) {

		$sil=$db->prepare("DELETE from urunfoto where urunfoto_id=:urunfoto_id");
		$kontrol=$sil->execute(array(
			'urunfoto_id' => $list
		));
	}

	if ($kontrol) {

		Header("Location:../production/urun-galeri.php?urun_id=$urun_id&durum=ok");

	} else {

		Header("Location:../production/urun-galeri.php?urun_id=$urun_id&durum=no");
	}


} 


if (isset($_POST['mailayarkaydet'])) {
	
	$ayarkaydet=$db->prepare("UPDATE ayar SET
		ayar_smtphost=:smtphost,
		ayar_smtpuser=:smtpuser,
		ayar_smtppassword=:smtppassword,
		ayar_smtpport=:smtpport
		WHERE ayar_id=0");
	$update=$ayarkaydet->execute(array(
		'smtphost' => $_POST['ayar_smtphost'],
		'smtpuser' => $_POST['ayar_smtpuser'],
		'smtppassword' => $_POST['ayar_smtppassword'],
		'smtpport' => $_POST['ayar_smtpport']
	));

	if ($update) {

		Header("Location:../production/mail-ayar.php?durum=ok");

	} else {

		Header("Location:../production/mail-ayar.php?durum=no");
	}

}

// ...existing code...

if (isset($_POST['ajax']) && $_POST['ajax'] === 'true') {
  $yorum_id = $_POST['yorum_id'];
  $yorum_onay = $_POST['yorum_onay'];

  $update = $db->prepare("UPDATE yorumlar SET yorum_onay=:yorum_onay WHERE yorum_id=:yorum_id");
  $result = $update->execute([
    'yorum_onay' => $yorum_onay,
    'yorum_id' => $yorum_id
  ]);

  if ($result) {
    echo 'success';
  } else {
    echo 'error';
  }
  exit;
}

// ...existing code...

// ...existing code...
if (isset($_GET['vitrinsil']) && $_GET['vitrinsil'] == "ok") {
    $sil = $db->prepare("DELETE FROM vitrin WHERE vitrin_id=:vitrin_id");
    $kontrol = $sil->execute(array(
        'vitrin_id' => $_GET['vitrin_id']
    ));

    if ($kontrol) {
        Header("Location:../production/urun-vitrinleri.php?durum=ok");
    } else {
        Header("Location:../production/urun-vitrinleri.php?durum=no");
    }
}
// ...existing code...

// ...existing code...
if (isset($_POST['vitrinduzenle'])) {
    $vitrin_id = $_POST['vitrin_id'];
    $urun_id_list = implode(',', $_POST['urun_id']);

    $duzenle = $db->prepare("UPDATE vitrin SET
        vitrin_adi=:vitrin_adi,
        vitrin_durum=:vitrin_durum,
        vitrin_dizayn=:vitrin_dizayn,
        vitrin_urun_listeleme_limit=:urun_list
        WHERE vitrin_id=:vitrin_id");
    $update = $duzenle->execute([
        'vitrin_adi' => $_POST['vitrin_adi'],
        'vitrin_durum' => $_POST['vitrin_durum'],
        'vitrin_dizayn' => $_POST['vitrin_dizayn'],
        'urun_list' => $urun_id_list,
        'vitrin_id' => $vitrin_id
    ]);

    if ($update) {
        Header("Location:../production/urun-vitrinleri.php?durum=ok");
    } else {
        Header("Location:../production/urun-vitrinleri.php?durum=no");
    }
}
// ...existing code...

// ...existing code...

if (isset($_POST['vitrineurunekle'])) {
    $vitrin_id = $_POST['vitrin_id'];
    $urun_id = $_POST['urun_id'];

    $ekle = $db->prepare("INSERT INTO vitrin_urun SET vitrin_id=:vitrin_id, urun_id=:urun_id");
    $insert = $ekle->execute(['vitrin_id' => $vitrin_id, 'urun_id' => $urun_id]);

    if ($insert) {
        Header("Location:../production/urun-vitrin-duzenle.php?vitrin_id=$vitrin_id&durum=ok");
    } else {
        Header("Location:../production/urun-vitrin-duzenle.php?vitrin_id=$vitrin_id&durum=no");
    }
}

if (isset($_GET['vitrindenurunkaldir']) && $_GET['vitrindenurunkaldir'] == "ok") {
    $vitrin_id = $_GET['vitrin_id'];
    $urun_id = $_GET['urun_id'];

    $sil = $db->prepare("DELETE FROM vitrin_urun WHERE vitrin_id=:vitrin_id AND urun_id=:urun_id");
    $kontrol = $sil->execute(['vitrin_id' => $vitrin_id, 'urun_id' => $urun_id]);

    if ($kontrol) {
        Header("Location:../production/urun-vitrin-duzenle.php?vitrin_id=$vitrin_id&durum=ok");
    } else {
        Header("Location:../production/urun-vitrin-duzenle.php?vitrin_id=$vitrin_id&durum=no");
    }
}

if (isset($_POST['vitrinresimekle'])) {
    $vitrin_id = $_POST['vitrin_id'];
    $uploads_dir = '../../images/vitrin';
    @$tmp_name = $_FILES['vitrin_resim']["tmp_name"];
    @$name = uniqid() . "_" . $_FILES['vitrin_resim']["name"];
    @move_uploaded_file($tmp_name, "$uploads_dir/$name");
    $resim_yolu = "images/vitrin/$name";

    $ekle = $db->prepare("INSERT INTO vitrin_resimleri SET vitrin_id=:vitrin_id, vitrin_resim=:vitrin_resim");
    $insert = $ekle->execute(['vitrin_id' => $vitrin_id, 'vitrin_resim' => $resim_yolu]);

    if ($insert) {
        Header("Location:../production/urun-vitrin-duzenle.php?vitrin_id=$vitrin_id&durum=ok");
    } else {
        Header("Location:../production/urun-vitrin-duzenle.php?vitrin_id=$vitrin_id&durum=no");
    }
}

if (isset($_GET['vitrinresimsil']) && $_GET['vitrinresimsil'] == "ok") {
    $vitrin_resim_id = $_GET['vitrin_resim_id'];

    $resimsor = $db->prepare("SELECT * FROM vitrin_resimleri WHERE vitrin_resim_id=:vitrin_resim_id");
    $resimsor->execute(['vitrin_resim_id' => $vitrin_resim_id]);
    $resimcek = $resimsor->fetch(PDO::FETCH_ASSOC);

    $sil = $db->prepare("DELETE FROM vitrin_resimleri WHERE vitrin_resim_id=:vitrin_resim_id");
    $kontrol = $sil->execute(['vitrin_resim_id' => $vitrin_resim_id]);

    if ($kontrol) {
        @unlink("../../" . $resimcek['vitrin_resim']);
        Header("Location:../production/urun-vitrin-duzenle.php?vitrin_id=" . $_GET['vitrin_id'] . "&durum=ok");
    } else {
        Header("Location:../production/urun-vitrin-duzenle.php?vitrin_id=" . $_GET['vitrin_id'] . "&durum=no");
    }
}

// ...existing code...

// ...existing code...
if (isset($_POST['vitrin_urun_ekle'])) {
    $vitrin_id = $_POST['vitrin_id'];
    $urun_id = $_POST['urun_id'];

    $query = $db->prepare("INSERT INTO vitrin_urun (vitrin_id, urun_id) VALUES (:vitrin_id, :urun_id)");
    $insert = $query->execute([
        'vitrin_id' => $vitrin_id,
        'urun_id' => $urun_id
    ]);

    if ($insert) {
        header("Location: ../production/urun-vitrin-duzenle.php?durum=ok");
    } else {
        header("Location: ../production/urun-vitrin-duzenle.php?durum=no");
    }
}
// ...existing code...

// ...existing code...

if (isset($_POST['sss_ekle'])) {
    $stmt = $db->prepare("INSERT INTO sss (sss_tittle, sss_icerik, sss_durum) VALUES (:tittle, :icerik, :durum)");
    $insert = $stmt->execute([
        'tittle' => $_POST['sss_tittle'],
        'icerik' => $_POST['sss_icerik'],
        'durum' => $_POST['sss_durum']
    ]);
    header("Location: ../production/sss-ekle.php?durum=" . ($insert ? "ok" : "no"));
}

if (isset($_POST['sss_duzenle'])) {
    $stmt = $db->prepare("UPDATE sss SET sss_tittle = :tittle, sss_icerik = :icerik, sss_durum = :durum WHERE sss_id = :id");
    $update = $stmt->execute([
        'tittle' => $_POST['sss_tittle'],
        'icerik' => $_POST['sss_icerik'],
        'durum' => $_POST['sss_durum'],
        'id' => $_POST['sss_id']
    ]);
    header("Location: ../production/sss-duzenle.php?sss_id=" . $_POST['sss_id'] . "&durum=" . ($update ? "ok" : "no"));
}
// ...existing code...

// ...existing code...

if (isset($_GET['siparisOnayla']) && $_GET['siparisOnayla'] == "ok") {
    $siparis_id = $_GET['siparis_id'];
    
    $guncelle = $db->prepare("UPDATE siparis SET siparis_odeme = :odeme WHERE siparis_id = :id");
    $update = $guncelle->execute([
        'odeme' => 1,
        'id' => $siparis_id
    ]);

    if ($update) {
        Header("Location:../production/siparisler.php?durum=ok");
    } else {
        Header("Location:../production/siparisler.php?durum=no");
    }
}

// ...existing code...

if (isset($_POST['siparis_durum_guncelle'])) {
    $siparis_id = $_POST['siparis_id'];
    $durum_id = $_POST['siparis_durum_id'];

    $guncelle = $db->prepare("UPDATE siparis SET siparis_durum_id = :durum WHERE siparis_id = :id");
    $update = $guncelle->execute([
        'durum' => $durum_id,
        'id' => $siparis_id
    ]);

    if ($update) {
        Header("Location:../production/siparisler.php?durum=ok");
    } else {
        Header("Location:../production/siparisler.php?durum=no"); 
    }
}

// ...existing code...

// Sipariş durum güncelleme
if (isset($_POST['siparis_durum_guncelle'])) {
    try {
        $siparis_id = $_POST['siparis_id'];
        $durum_id = $_POST['siparis_durum_id'];
        
        $guncelle = $db->prepare("UPDATE siparis SET 
                                siparis_durum_id = :durum_id 
                                WHERE siparis_id = :siparis_id");
        
        $sonuc = $guncelle->execute([
            'durum_id' => $durum_id,
            'siparis_id' => $siparis_id
        ]);

        if ($sonuc) {
            Header("Location:../production/siparisler.php?durum=ok");
        } else {
            Header("Location:../production/siparisler.php?durum=no");
        }
        
    } catch(PDOException $e) {
        echo $e->getMessage();
        Header("Location:../production/siparisler.php?durum=no");
    }
}

// ...existing code...

// ...existing code...

if (isset($_POST['siparis_durum_guncelle'])) {
    $durum_guncelle = $db->prepare("UPDATE siparis SET
        siparis_durum_id = :durum_id 
        WHERE siparis_id = :siparis_id");
    
    $update = $durum_guncelle->execute([
        'durum_id' => $_POST['siparis_durum_id'],
        'siparis_id' => $_POST['siparis_id']
    ]);

    if ($update) {
        Header("Location:../production/siparis-detay.php?siparis_id=".$_POST['siparis_id']."&durum=ok");
    } else {
        Header("Location:../production/siparis-detay.php?siparis_id=".$_POST['siparis_id']."&durum=no");
    }
}

// ...existing code...

// Sipariş güncelleme işlemi
if (isset($_POST['siparis_guncelle'])) {
    $siparis_id = $_POST['siparis_id'];
    $siparis_durum_id = $_POST['siparis_durum_id'];
    $siparis_odeme = $_POST['siparis_odeme'];
    
    // Hem sipariş durumunu hem de ödeme durumunu güncelle
    $siparisGuncelle = $db->prepare("UPDATE siparis SET 
        siparis_durum_id = :durum_id,
        siparis_odeme = :odeme 
        WHERE siparis_id = :id");
    
    $guncelle = $siparisGuncelle->execute([
        'durum_id' => $siparis_durum_id,
        'odeme' => $siparis_odeme,
        'id' => $siparis_id
    ]);
    
    if ($guncelle) {
        header("Location:../production/siparis-detay.php?siparis_id=$siparis_id&durum=ok");
        exit;
    } else {
        header("Location:../production/siparis-detay.php?siparis_id=$siparis_id&durum=no");
        exit;
    }
}

// ...existing code...

// ...existing code...

// Tablı Vitrin Ekleme
if (isset($_POST['tabli_vitrin_ekle'])) {
    // Önce aynı vitrin kontrolü yap
    $kontrol = $db->prepare("SELECT COUNT(*) FROM tabli_vitrin WHERE ad = :ad");
    $kontrol->execute(['ad' => $_POST['ad']]);
    
    if ($kontrol->fetchColumn() > 0) {
        Header("Location:../production/tabli-urun-vitrinleri.php?durum=var");
        exit; // Önemli - İşlemi sonlandır
    }
    
    $kaydet = $db->prepare("INSERT INTO tabli_vitrin SET
        ad = :ad,
        sira = :sira,
        durum = :durum
    ");
    
    $insert = $kaydet->execute([
        'ad' => $_POST['ad'],
        'sira' => $_POST['sira'],
        'durum' => $_POST['durum']
    ]);
    
    if ($insert) {
        Header("Location:../production/tabli-urun-vitrinleri.php?durum=ok");
        exit; // Önemli - İşlemi sonlandır
    } else {
        Header("Location:../production/tabli-urun-vitrinleri.php?durum=no");
        exit; // Önemli - İşlemi sonlandır
    }
}

// Tablı Vitrin Düzenleme
if (isset($_POST['tabli_vitrin_duzenle'])) {
    $id = $_POST['id'];
    
    $kaydet = $db->prepare("UPDATE tabli_vitrin SET
        ad = :ad,
        sira = :sira,
        durum = :durum
        WHERE id = :id
    ");
    
    $update = $kaydet->execute([
        'ad' => $_POST['ad'],
        'sira' => $_POST['sira'],
        'durum' => $_POST['durum'],
        'id' => $id
    ]);
    
    if ($update) {
        Header("Location:../production/tabli-urun-vitrin-duzenle.php?id=$id&durum=ok");
        exit; // Önemli - İşlemi sonlandır
    } else {
        Header("Location:../production/tabli-urun-vitrin-duzenle.php?id=$id&durum=no");
        exit; // Önemli - İşlemi sonlandır
    }
}

// Tablı Vitrin Silme
if (isset($_GET['tabli_vitrin_sil']) && $_GET['tabli_vitrin_sil'] == "ok") {
    $id = $_GET['id'];
    
    $sil = $db->prepare("DELETE FROM tabli_vitrin WHERE id = :id");
    $delete = $sil->execute(['id' => $id]);
    
    if ($delete) {
        Header("Location:../production/tabli-urun-vitrinleri.php?durum=ok");
    } else {
        Header("Location:../production/tabli-urun-vitrinleri.php?durum=no");
    }
}

// Tablı Vitrin Sekme Ekleme
if (isset($_POST['tabli_vitrin_sekme_ekle'])) {
    $tabli_vitrin_id = $_POST['tabli_vitrin_id'];
    $vitrin_id = $_POST['vitrin_id'];
    
    // Önce mevcut maksimum sırayı bul
    $sirasor = $db->prepare("SELECT MAX(sira) as maksira FROM tabli_vitrin_sekme WHERE tabli_vitrin_id = :id");
    $sirasor->execute(['id' => $tabli_vitrin_id]);
    $siracek = $sirasor->fetch(PDO::FETCH_ASSOC);
    $yeni_sira = $siracek['maksira'] ? $siracek['maksira'] + 1 : 1;
    
    $ekle = $db->prepare("INSERT INTO tabli_vitrin_sekme SET
        tabli_vitrin_id = :tabli_id,
        vitrin_id = :vitrin_id,
        sira = :sira
    ");
    
    $insert = $ekle->execute([
        'tabli_id' => $tabli_vitrin_id,
        'vitrin_id' => $vitrin_id,
        'sira' => $yeni_sira
    ]);
    
    if ($insert) {
        Header("Location:../production/tabli-urun-vitrin-duzenle.php?id=$tabli_vitrin_id&durum=ok");
    } else {
        Header("Location:../production/tabli-urun-vitrin-duzenle.php?id=$tabli_vitrin_id&durum=no");
    }
}

// Tablı Vitrin Sekme Silme
if (isset($_GET['tabli_vitrin_sekme_sil']) && $_GET['tabli_vitrin_sekme_sil'] == "ok") {
    $id = $_GET['id'];
    $tabli_vitrin_id = $_GET['tabli_vitrin_id'];
    
    $sil = $db->prepare("DELETE FROM tabli_vitrin_sekme WHERE id = :id");
    $delete = $sil->execute(['id' => $id]);
    
    if ($delete) {
        Header("Location:../production/tabli-urun-vitrin-duzenle.php?id=$tabli_vitrin_id&durum=ok");
    } else {
        Header("Location:../production/tabli-urun-vitrin-duzenle.php?id=$tabli_vitrin_id&durum=no");
    }
}

// Tablı Vitrin Sekme Sıralama (Ajax)
if (isset($_POST['tabli_vitrin_sekme_siralama']) && $_POST['tabli_vitrin_sekme_siralama'] == "ok") {
    $items = $_POST['item'];
    
    // Tüm sıralama değerlerini güncelle
    $sira = 1;
    foreach ($items as $item_id) {
        $guncelle = $db->prepare("UPDATE tabli_vitrin_sekme SET sira = :sira WHERE id = :id");
        $guncelle->execute(['sira' => $sira, 'id' => $item_id]);
        $sira++;
    }
    
    echo "ok";
    exit;
}

// ...existing code...

// Kullanıcı düzenleme işlemi
if (isset($_POST['kullaniciduzenle'])) {
    $kullanici_id = $_POST['kullanici_id'];
    
    // Resim yükleme işlemi
    $resim_yolu = isset($_POST['eski_resim']) ? $_POST['eski_resim'] : '';
    
    if ($_FILES['kullanici_resim']['size'] > 0) {
        // Eski resmi sil (eğer varsa)
        if (!empty($_POST['eski_resim']) && file_exists("../../" . $_POST['eski_resim'])) {
            unlink("../../" . $_POST['eski_resim']);
        }
        
        // Yeni resmi yükle
        $uploads_dir = '../../images/kullanicilar';
        @mkdir($uploads_dir, 0777, true);
        
        $tmp_name = $_FILES['kullanici_resim']["tmp_name"];
        $name = $_FILES['kullanici_resim']["name"];
        $benzersiz = uniqid();
        $uzanti = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $resim_yolu = "images/kullanicilar/" . $benzersiz . "." . $uzanti;
        
        move_uploaded_file($tmp_name, "../../" . $resim_yolu);
    }
    
    // TC Kimlik kontrolü - boş ise default değer atama
    $kullanici_tc = !empty($_POST['kullanici_tc']) ? $_POST['kullanici_tc'] : '11111111111';
    
    // Ad Soyad birleştirme
    $kullanici_adsoyad = $_POST['kullanici_ad'] . ' ' . $_POST['kullanici_soyad'];
    
    // Şifre kontrolü
    $password_update = "";
    if (!empty($_POST['kullanici_password'])) {
        $password_update = "kullanici_password = :kullanici_password,";
    }
    
    // Veritabanını güncelle
    $ayarkaydet = $db->prepare("UPDATE kullanicilar SET
        kullanici_resim = :kullanici_resim,
        kullanici_tc = :kullanici_tc,
        kullanici_ad = :kullanici_ad,
        kullanici_soyad = :kullanici_soyad,
        kullanici_mail = :kullanici_mail,
        kullanici_gsm = :kullanici_gsm,
        $password_update
        kullanici_adsoyad = :kullanici_adsoyad,
        kullanici_adres = :kullanici_adres,
        kullanici_il = :kullanici_il,
        kullanici_ilce = :kullanici_ilce,
        kullanici_unvan = :kullanici_unvan,
        kullanici_yetki = :kullanici_yetki,
        kullanici_durum = :kullanici_durum
        WHERE kullanici_id = :kullanici_id
    ");
    
    $update_params = [
        'kullanici_resim' => $resim_yolu,
        'kullanici_tc' => $kullanici_tc,
        'kullanici_ad' => $_POST['kullanici_ad'],
        'kullanici_soyad' => $_POST['kullanici_soyad'],
        'kullanici_mail' => $_POST['kullanici_mail'],
        'kullanici_gsm' => $_POST['kullanici_gsm'],
        'kullanici_adsoyad' => $kullanici_adsoyad,
        'kullanici_adres' => $_POST['kullanici_adres'],
        'kullanici_il' => $_POST['kullanici_il'],
        'kullanici_ilce' => $_POST['kullanici_ilce'],
        'kullanici_unvan' => $_POST['kullanici_unvan'],
        'kullanici_yetki' => $_POST['kullanici_yetki'],
        'kullanici_durum' => $_POST['kullanici_durum'],
        'kullanici_id' => $kullanici_id
    ];
    
    // Şifre girilmişse ekle
    if (!empty($_POST['kullanici_password'])) {
        $update_params['kullanici_password'] = md5($_POST['kullanici_password']);
    }
    
    $update = $ayarkaydet->execute($update_params);
    
    if ($update) {
        Header("Location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=ok");
    } else {
        Header("Location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=no");
    }
}

// Kullanıcı ekleme işlemi
if (isset($_POST['kullaniciekle'])) {
    // TC Kimlik kontrolü - boş ise default değer atama
    $kullanici_tc = !empty($_POST['kullanici_tc']) ? $_POST['kullanici_tc'] : '11111111111';
    
    // Ad Soyad birleştirme
    $kullanici_adsoyad = $_POST['kullanici_ad'] . ' ' . $_POST['kullanici_soyad'];
    
    // Resim yükleme işlemi
    $resim_yolu = '';
    
    if ($_FILES['kullanici_resim']['size'] > 0) {
        $uploads_dir = '../../images/kullanicilar';
        @mkdir($uploads_dir, 0777, true);
        
        $tmp_name = $_FILES['kullanici_resim']["tmp_name"];
        $name = $_FILES['kullanici_resim']["name"];
        $benzersiz = uniqid();
        $uzanti = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $resim_yolu = "images/kullanicilar/" . $benzersiz . "." . $uzanti;
        
        move_uploaded_file($tmp_name, "../../" . $resim_yolu);
    }
    
    // Mail adresi kontrolü - Aynı mail ile kayıt var mı?
    $mailKontrol = $db->prepare("SELECT COUNT(*) FROM kullanicilar WHERE kullanici_mail = :mail");
    $mailKontrol->execute(['mail' => $_POST['kullanici_mail']]);
    
    if ($mailKontrol->fetchColumn() > 0) {
        Header("Location:../production/kullanici-ekle.php?durum=mailvar");
        exit;
    }
    
    // Veritabanına ekle
    $kaydet = $db->prepare("INSERT INTO kullanicilar SET
        kullanici_resim = :kullanici_resim,
        kullanici_tc = :kullanici_tc,
        kullanici_ad = :kullanici_ad,
        kullanici_soyad = :kullanici_soyad,
        kullanici_mail = :kullanici_mail,
        kullanici_gsm = :kullanici_gsm,
        kullanici_password = :kullanici_password,
        kullanici_adsoyad = :kullanici_adsoyad,
        kullanici_adres = :kullanici_adres,
        kullanici_il = :kullanici_il,
        kullanici_ilce = :kullanici_ilce,
        kullanici_unvan = :kullanici_unvan,
        kullanici_yetki = :kullanici_yetki,
        kullanici_durum = :kullanici_durum
    ");
    
    $insert = $kaydet->execute([
        'kullanici_resim' => $resim_yolu,
        'kullanici_tc' => $kullanici_tc,
        'kullanici_ad' => $_POST['kullanici_ad'],
        'kullanici_soyad' => $_POST['kullanici_soyad'],
        'kullanici_mail' => $_POST['kullanici_mail'],
        'kullanici_gsm' => $_POST['kullanici_gsm'],
        'kullanici_password' => md5($_POST['kullanici_password']),
        'kullanici_adsoyad' => $kullanici_adsoyad,
        'kullanici_adres' => $_POST['kullanici_adres'],
        'kullanici_il' => $_POST['kullanici_il'],
        'kullanici_ilce' => $_POST['kullanici_ilce'],
        'kullanici_unvan' => $_POST['kullanici_unvan'],
        'kullanici_yetki' => $_POST['kullanici_yetki'],
        'kullanici_durum' => $_POST['kullanici_durum']
    ]);
    
    if ($insert) {
        Header("Location:../production/kullanici.php?durum=ok");
    } else {
        Header("Location:../production/kullanici-ekle.php?durum=no");
    }
}

// ...existing code...

// ...existing code...

// Admin ekleme işlemi
if (isset($_POST['adminekle'])) {
    // TC Kimlik kontrolü - boş ise default değer atama
    $kullanici_tc = !empty($_POST['kullanici_tc']) ? $_POST['kullanici_tc'] : '11111111111';
    
    // Ad Soyad birleştirme
    $kullanici_adsoyad = $_POST['kullanici_ad'] . ' ' . $_POST['kullanici_soyad'];
    
    // Resim yükleme işlemi
    $resim_yolu = '';
    
    if ($_FILES['kullanici_resim']['size'] > 0) {
        $uploads_dir = '../../images/kullanicilar';
        @mkdir($uploads_dir, 0777, true);
        
        $tmp_name = $_FILES['kullanici_resim']["tmp_name"];
        $name = $_FILES['kullanici_resim']["name"];
        $benzersiz = uniqid();
        $uzanti = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $resim_yolu = "images/kullanicilar/" . $benzersiz . "." . $uzanti;
        
        move_uploaded_file($tmp_name, "../../" . $resim_yolu);
    }
    
    // Mail adresi kontrolü - Aynı mail ile kayıt var mı?
    $mailKontrol = $db->prepare("SELECT COUNT(*) FROM kullanicilar WHERE kullanici_mail = :mail");
    $mailKontrol->execute(['mail' => $_POST['kullanici_mail']]);
    
    if ($mailKontrol->fetchColumn() > 0) {
        Header("Location:../production/admin-ekle.php?durum=mailvar");
        exit;
    }
    
    // Veritabanına ekle
    $kaydet = $db->prepare("INSERT INTO kullanicilar SET
        kullanici_resim = :kullanici_resim,
        kullanici_tc = :kullanici_tc,
        kullanici_ad = :kullanici_ad,
        kullanici_soyad = :kullanici_soyad,
        kullanici_mail = :kullanici_mail,
        kullanici_gsm = :kullanici_gsm,
        kullanici_password = :kullanici_password,
        kullanici_adsoyad = :kullanici_adsoyad,
        kullanici_adres = :kullanici_adres,
        kullanici_il = :kullanici_il,
        kullanici_ilce = :kullanici_ilce,
        kullanici_unvan = :kullanici_unvan,
        kullanici_yetki = :kullanici_yetki,
        kullanici_durum = :kullanici_durum
    ");
    
    $insert = $kaydet->execute([
        'kullanici_resim' => $resim_yolu,
        'kullanici_tc' => $kullanici_tc,
        'kullanici_ad' => $_POST['kullanici_ad'],
        'kullanici_soyad' => $_POST['kullanici_soyad'],
        'kullanici_mail' => $_POST['kullanici_mail'],
        'kullanici_gsm' => $_POST['kullanici_gsm'],
        'kullanici_password' => md5($_POST['kullanici_password']),
        'kullanici_adsoyad' => $kullanici_adsoyad,
        'kullanici_adres' => $_POST['kullanici_adres'],
        'kullanici_il' => $_POST['kullanici_il'],
        'kullanici_ilce' => $_POST['kullanici_ilce'],
        'kullanici_unvan' => $_POST['kullanici_unvan'],
        'kullanici_yetki' => $_POST['kullanici_yetki'],
        'kullanici_durum' => $_POST['kullanici_durum']
    ]);
    
    if ($insert) {
        Header("Location:../production/admin-list.php?durum=ok");
    } else {
        Header("Location:../production/admin-ekle.php?durum=no");
    }
}

// Admin düzenleme işlemi
if (isset($_POST['adminduzenle'])) {
    $kullanici_id = $_POST['kullanici_id'];
    
    // Resim yükleme işlemi
    $resim_yolu = isset($_POST['eski_resim']) ? $_POST['eski_resim'] : '';
    
    if ($_FILES['kullanici_resim']['size'] > 0) {
        // Eski resmi sil (eğer varsa)
        if (!empty($_POST['eski_resim']) && file_exists("../../" . $_POST['eski_resim'])) {
            unlink("../../" . $_POST['eski_resim']);
        }
        
        // Yeni resmi yükle
        $uploads_dir = '../../images/kullanicilar';
        @mkdir($uploads_dir, 0777, true);
        
        $tmp_name = $_FILES['kullanici_resim']["tmp_name"];
        $name = $_FILES['kullanici_resim']["name"];
        $benzersiz = uniqid();
        $uzanti = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $resim_yolu = "images/kullanicilar/" . $benzersiz . "." . $uzanti;
        
        move_uploaded_file($tmp_name, "../../" . $resim_yolu);
    }
    
    // TC Kimlik kontrolü - boş ise default değer atama
    $kullanici_tc = !empty($_POST['kullanici_tc']) ? $_POST['kullanici_tc'] : '11111111111';
    
    // Ad Soyad birleştirme
    $kullanici_adsoyad = $_POST['kullanici_ad'] . ' ' . $_POST['kullanici_soyad'];
    
    // Şifre kontrolü
    $password_update = "";
    if (!empty($_POST['kullanici_password'])) {
        $password_update = "kullanici_password = :kullanici_password,";
    }
    
    // Veritabanını güncelle
    $ayarkaydet = $db->prepare("UPDATE kullanicilar SET
        kullanici_resim = :kullanici_resim,
        kullanici_tc = :kullanici_tc,
        kullanici_ad = :kullanici_ad,
        kullanici_soyad = :kullanici_soyad,
        kullanici_mail = :kullanici_mail,
        kullanici_gsm = :kullanici_gsm,
        $password_update
        kullanici_adsoyad = :kullanici_adsoyad,
        kullanici_adres = :kullanici_adres,
        kullanici_il = :kullanici_il,
        kullanici_ilce = :kullanici_ilce,
        kullanici_unvan = :kullanici_unvan,
        kullanici_yetki = :kullanici_yetki,
        kullanici_durum = :kullanici_durum
        WHERE kullanici_id = :kullanici_id
    ");
    
    $update_params = [
        'kullanici_resim' => $resim_yolu,
        'kullanici_tc' => $kullanici_tc,
        'kullanici_ad' => $_POST['kullanici_ad'],
        'kullanici_soyad' => $_POST['kullanici_soyad'],
        'kullanici_mail' => $_POST['kullanici_mail'],
        'kullanici_gsm' => $_POST['kullanici_gsm'],
        'kullanici_adsoyad' => $kullanici_adsoyad,
        'kullanici_adres' => $_POST['kullanici_adres'],
        'kullanici_il' => $_POST['kullanici_il'],
        'kullanici_ilce' => $_POST['kullanici_ilce'],
        'kullanici_unvan' => $_POST['kullanici_unvan'],
        'kullanici_yetki' => $_POST['kullanici_yetki'],
        'kullanici_durum' => $_POST['kullanici_durum'],
        'kullanici_id' => $kullanici_id
    ];
    
    // Şifre girilmişse ekle
    if (!empty($_POST['kullanici_password'])) {
        $update_params['kullanici_password'] = md5($_POST['kullanici_password']);
    }
    
    $update = $ayarkaydet->execute($update_params);
    
    if ($update) {
        Header("Location:../production/admin-duzenle.php?kullanici_id=$kullanici_id&durum=ok");
    } else {
        Header("Location:../production/admin-duzenle.php?kullanici_id=$kullanici_id&durum=no");
    }
}

// Admin silme işlemi
if (isset($_GET['adminsil']) && $_GET['adminsil'] == "ok") {
  // Kendini silme kontrolü
  if ($_GET['kullanici_id'] == $_SESSION['kullanici_id']) {
    header("location:../production/admin-list.php?durum=kendisilme");
    exit;
  }
  
  $sil = $db->prepare("DELETE from kullanicilar where kullanici_id=:id AND kullanici_yetki=:yetki");
  $kontrol = $sil->execute(array(
    'id' => $_GET['kullanici_id'],
    'yetki' => 5
  ));

  if ($kontrol) {
    header("location:../production/admin-list.php?durum=ok");
  } else {
    header("location:../production/admin-list.php?durum=no");
  }
}

// ...existing code...

// ...existing code...

// Marka ekleme işlemi
if (isset($_POST['markaekle'])) {
    // Marka URL'sini düzenleme
    $marka_url = !empty($_POST['marka_url']) ? $_POST['marka_url'] : seo($_POST['marka_adi']);
    
    // Logo yükleme işlemi
    $uploads_dir = '../../images/brand';
    $marka_resim = '';
    
    if ($_FILES['marka_resim']['size'] > 0) {
        @$tmp_name = $_FILES['marka_resim']["tmp_name"];
        @$name = uniqid() . "_" . $_FILES['marka_resim']["name"];
        @move_uploaded_file($tmp_name, "$uploads_dir/$name");
        $marka_resim = "images/brand/$name";
    }
    
    // Marka ekle
    $kaydet = $db->prepare("INSERT INTO marka SET
        marka_adi = :marka_adi,
        marka_url = :marka_url,
        marka_resim = :marka_resim
    ");
    
    $insert = $kaydet->execute([
        'marka_adi' => $_POST['marka_adi'],
        'marka_url' => $marka_url,
        'marka_resim' => $marka_resim
    ]);
    
    if ($insert) {
        Header("Location:../production/marka-ekle.php?durum=ok");
    } else {
        Header("Location:../production/marka-ekle.php?durum=no");
    }
}

// Marka düzenleme işlemi
if (isset($_POST['markaduzenle'])) {
    $marka_id = $_POST['marka_id'];
    
    // Yeni logo yüklendiyse
    $marka_resim = isset($_POST['eski_resim']) ? $_POST['eski_resim'] : '';
    $uploads_dir = '../../images/brand';
    
    if ($_FILES['marka_resim']['size'] > 0) {
        @$tmp_name = $_FILES['marka_resim']["tmp_name"];
        @$name = uniqid() . "_" . $_FILES['marka_resim']["name"];
        @move_uploaded_file($tmp_name, "$uploads_dir/$name");
        $marka_resim = "images/brand/$name";
        
        // Eski logoyu sil
        if (!empty($_POST['eski_resim'])) {
            @unlink("../../" . $_POST['eski_resim']);
        }
    }
    
    // Markayı güncelle
    $duzenle = $db->prepare("UPDATE marka SET
        marka_adi = :marka_adi,
        marka_url = :marka_url,
        marka_resim = :marka_resim
        WHERE marka_id = :marka_id
    ");
    
    $update = $duzenle->execute([
        'marka_adi' => $_POST['marka_adi'],
        'marka_url' => $_POST['marka_url'],
        'marka_resim' => $marka_resim,
        'marka_id' => $marka_id
    ]);
    
    if ($update) {
        Header("Location:../production/marka-duzenle.php?marka_id=$marka_id&durum=ok");
    } else {
        Header("Location:../production/marka-duzenle.php?marka_id=$marka_id&durum=no");
    }
}

// Marka silme işlemi
if (isset($_GET['markasil']) && $_GET['markasil'] == "ok") {
    $marka_id = $_GET['marka_id'];
    
    // Marka bilgilerini çekiyoruz (logo silmek için)
    $markasor = $db->prepare("SELECT * FROM marka WHERE marka_id = :marka_id");
    $markasor->execute(['marka_id' => $marka_id]);
    $markacek = $markasor->fetch(PDO::FETCH_ASSOC);
    
    // Markayı sil
    $sil = $db->prepare("DELETE FROM marka WHERE marka_id = :marka_id");
    $kontrol = $sil->execute(['marka_id' => $marka_id]);
    
    if ($kontrol) {
        // Logo varsa dosyayı sil
        if (!empty($markacek['marka_resim'])) {
            @unlink("../../" . $markacek['marka_resim']);
        }
        Header("Location:../production/markalar.php?durum=ok");
    } else {
        Header("Location:../production/markalar.php?durum=no");
    }
}

// ...existing code...

// ...existing code...

// SEO URL oluşturma fonksiyonu - Türkçe karakterleri ve boşlukları temizler
function seoUrl($str){
    $str = mb_strtolower($str, 'UTF-8');
    $str = str_replace(
        ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç', ' ', '_'],
        ['i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 's', 'o', 'c', '', ''],
        $str
    );
    $str = preg_replace('/[^a-z0-9]/', '', $str);
    return $str;
}

// Filtre Şablonu Ekleme
if (isset($_POST['filtrekaydet'])) {
    $filtre_adi = $_POST['filtre_adi'];
    // Filtre kodunu otomatik oluştur
    $filtre_code = seoUrl($filtre_adi);
    
    // Filtreyi veritabanına kaydet
    $kaydet = $db->prepare("INSERT INTO filtre_sablonu SET
        filtre_adi = :filtre_adi,
        filtre_durum = :filtre_durum,
        filtre_code = :filtre_code");
    
    $insert = $kaydet->execute(array(
        'filtre_adi' => $filtre_adi,
        'filtre_durum' => $_POST['filtre_durum'],
        'filtre_code' => $filtre_code
    ));

    if ($insert) {
        Header("Location:../production/filtre-sablonu.php?durum=ok");
    } else {
        Header("Location:../production/filtre-sablonu.php?durum=no");
    }
}

// Filtre Şablonu Düzenleme
if (isset($_POST['filtreduzenle'])) {
    $filtre_id = $_POST['filtre_id'];
    
    $duzenle = $db->prepare("UPDATE filtre_sablonu SET
        filtre_adi = :filtre_adi,
        filtre_durum = :filtre_durum
        WHERE filtre_id = :filtre_id");
    
    $update = $duzenle->execute(array(
        'filtre_adi' => $_POST['filtre_adi'],
        'filtre_durum' => $_POST['filtre_durum'],
        'filtre_id' => $filtre_id
    ));

    if ($update) {
        Header("Location:../production/filtre-sablonu-duzenle.php?filtre_id=$filtre_id&durum=ok");
    } else {
        Header("Location:../production/filtre-sablonu-duzenle.php?filtre_id=$filtre_id&durum=no");
    }
}

// Filtre Şablonu Silme
if (isset($_GET['filtresil']) && $_GET['filtresil'] == "ok") {
    $sil = $db->prepare("DELETE FROM filtre_sablonu WHERE filtre_id=:id");
    $kontrol = $sil->execute(array(
        'id' => $_GET['filtre_id']
    ));

    if ($kontrol) {
        Header("Location:../production/filtre-sablonu.php?durum=ok");
    } else {
        Header("Location:../production/filtre-sablonu.php?durum=no");
    }
}

// ...existing code...

// ...existing code...

// Sanal POS Ekleme
if (isset($_POST['sanalpos_ekle'])) {
    // Logo yükleme işlemi
    $uploads_dir = '../../images/ccards';
    $bankapos_resim = '';
    
    if ($_FILES['bankapos_resim']['size'] > 0) {
        $tmp_name = $_FILES['bankapos_resim']["tmp_name"];
        $name = uniqid() . "_" . $_FILES['bankapos_resim']["name"];
        
        if (move_uploaded_file($tmp_name, "$uploads_dir/$name")) {
            $bankapos_resim = "images/ccards/$name";
        }
    }
    
    // POS bilgilerini kaydet
    $kaydet = $db->prepare("INSERT INTO banka_pos SET
        bankapos_adi = :bankapos_adi,
        bankapos_resim = :bankapos_resim,
        bankapos_durum = :bankapos_durum,
        bankapos_taksit_sayisi = :bankapos_taksit_sayisi,
        bankapos_taksit1 = :bankapos_taksit1,
        bankapos_taksit2 = :bankapos_taksit2,
        bankapos_taksit3 = :bankapos_taksit3,
        bankapos_taksit4 = :bankapos_taksit4,
        bankapos_taksit5 = :bankapos_taksit5,
        bankapos_taksit6 = :bankapos_taksit6,
        bankapos_taksit7 = :bankapos_taksit7,
        bankapos_taksit8 = :bankapos_taksit8,
        bankapos_taksit9 = :bankapos_taksit9,
        bankapos_taksit10 = :bankapos_taksit10,
        bankapos_taksit11 = :bankapos_taksit11,
        bankapos_taksit12 = :bankapos_taksit12
    ");
    
    $insert = $kaydet->execute(array(
        'bankapos_adi' => $_POST['bankapos_adi'],
        'bankapos_resim' => $bankapos_resim,
        'bankapos_durum' => $_POST['bankapos_durum'],
        'bankapos_taksit_sayisi' => $_POST['bankapos_taksit_sayisi'],
        'bankapos_taksit1' => $_POST['bankapos_taksit1'],
        'bankapos_taksit2' => $_POST['bankapos_taksit2'],
        'bankapos_taksit3' => $_POST['bankapos_taksit3'],
        'bankapos_taksit4' => $_POST['bankapos_taksit4'],
        'bankapos_taksit5' => $_POST['bankapos_taksit5'],
        'bankapos_taksit6' => $_POST['bankapos_taksit6'],
        'bankapos_taksit7' => $_POST['bankapos_taksit7'],
        'bankapos_taksit8' => $_POST['bankapos_taksit8'],
        'bankapos_taksit9' => $_POST['bankapos_taksit9'],
        'bankapos_taksit10' => $_POST['bankapos_taksit10'],
        'bankapos_taksit11' => $_POST['bankapos_taksit11'],
        'bankapos_taksit12' => $_POST['bankapos_taksit12']
    ));
    
    if ($insert) {
        Header("Location:../production/sanal-pos.php?durum=ok");
    } else {
        Header("Location:../production/sanal-pos.php?durum=no");
    }
}

// Sanal POS Düzenleme
if (isset($_POST['sanalpos_duzenle'])) {
    $bankapos_id = $_POST['bankapos_id'];
    $bankapos_resim = $_POST['mevcut_resim'];
    
    // Logo güncelleme işlemi
    if ($_FILES['bankapos_resim']['size'] > 0) {
        $uploads_dir = '../../images/ccards';
        $tmp_name = $_FILES['bankapos_resim']["tmp_name"];
        $name = uniqid() . "_" . $_FILES['bankapos_resim']["name"];
        
        if (move_uploaded_file($tmp_name, "$uploads_dir/$name")) {
            // Eski resmi sil
            if (!empty($_POST['mevcut_resim'])) {
                @unlink("../../" . $_POST['mevcut_resim']);
            }
            $bankapos_resim = "images/ccards/$name";
        }
    }
    
    // POS bilgilerini güncelle
    $kaydet = $db->prepare("UPDATE banka_pos SET
        bankapos_adi = :bankapos_adi,
        bankapos_resim = :bankapos_resim,
        bankapos_durum = :bankapos_durum,
        bankapos_taksit_sayisi = :bankapos_taksit_sayisi,
        bankapos_taksit1 = :bankapos_taksit1,
        bankapos_taksit2 = :bankapos_taksit2,
        bankapos_taksit3 = :bankapos_taksit3,
        bankapos_taksit4 = :bankapos_taksit4,
        bankapos_taksit5 = :bankapos_taksit5,
        bankapos_taksit6 = :bankapos_taksit6,
        bankapos_taksit7 = :bankapos_taksit7,
        bankapos_taksit8 = :bankapos_taksit8,
        bankapos_taksit9 = :bankapos_taksit9,
        bankapos_taksit10 = :bankapos_taksit10,
        bankapos_taksit11 = :bankapos_taksit11,
        bankapos_taksit12 = :bankapos_taksit12
        WHERE bankapos_id = :bankapos_id
    ");
    
    $update = $kaydet->execute(array(
        'bankapos_adi' => $_POST['bankapos_adi'],
        'bankapos_resim' => $bankapos_resim,
        'bankapos_durum' => $_POST['bankapos_durum'],
        'bankapos_taksit_sayisi' => $_POST['bankapos_taksit_sayisi'],
        'bankapos_taksit1' => $_POST['bankapos_taksit1'],
        'bankapos_taksit2' => $_POST['bankapos_taksit2'],
        'bankapos_taksit3' => $_POST['bankapos_taksit3'],
        'bankapos_taksit4' => $_POST['bankapos_taksit4'],
        'bankapos_taksit5' => $_POST['bankapos_taksit5'],
        'bankapos_taksit6' => $_POST['bankapos_taksit6'],
        'bankapos_taksit7' => $_POST['bankapos_taksit7'],
        'bankapos_taksit8' => $_POST['bankapos_taksit8'],
        'bankapos_taksit9' => $_POST['bankapos_taksit9'],
        'bankapos_taksit10' => $_POST['bankapos_taksit10'],
        'bankapos_taksit11' => $_POST['bankapos_taksit11'],
        'bankapos_taksit12' => $_POST['bankapos_taksit12'],
        'bankapos_id' => $bankapos_id
    ));
    
    if ($update) {
        Header("Location:../production/sanal-pos-duzenle.php?bankapos_id=$bankapos_id&durum=ok");
    } else {
        Header("Location:../production/sanal-pos-duzenle.php?bankapos_id=$bankapos_id&durum=no");
    }
}

// Sanal POS Silme
if (isset($_GET['sanalpos_sil']) && $_GET['sanalpos_sil'] == "ok") {
    // POS bilgilerini al
    $possor = $db->prepare("SELECT * FROM banka_pos WHERE bankapos_id = :id");
    $possor->execute(['id' => $_GET['bankapos_id']]);
    $poscek = $possor->fetch(PDO::FETCH_ASSOC);
    
    // POS kaydını sil
    $sil = $db->prepare("DELETE FROM banka_pos WHERE bankapos_id = :id");
    $kontrol = $sil->execute(['id' => $_GET['bankapos_id']]);
    
    if ($kontrol) {
        // Logo dosyasını sil
        if (!empty($poscek['bankapos_resim'])) {
            @unlink("../../" . $poscek['bankapos_resim']);
        }
        Header("Location:../production/sanal-pos.php?durum=ok");
    } else {
        Header("Location:../production/sanal-pos.php?durum=no");
    }
}

// ...existing code...
?>