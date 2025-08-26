-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 13 May 2025, 16:41:14
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `eticaret4`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayar`
--

CREATE TABLE `ayar` (
  `ayar_id` int(11) NOT NULL,
  `ayar_logo` varchar(250) NOT NULL,
  `ayar_favicon` varchar(64) NOT NULL,
  `ayar_url` varchar(50) NOT NULL,
  `ayar_title` varchar(250) NOT NULL,
  `ayar_description` varchar(250) NOT NULL,
  `ayar_keywords` varchar(50) NOT NULL,
  `ayar_author` varchar(50) NOT NULL,
  `ayar_tel` varchar(50) NOT NULL,
  `ayar_gsm` varchar(50) NOT NULL,
  `ayar_faks` varchar(50) NOT NULL,
  `ayar_mail` varchar(250) NOT NULL,
  `ayar_ilce` varchar(50) NOT NULL,
  `ayar_il` varchar(50) NOT NULL,
  `ayar_adres` varchar(250) NOT NULL,
  `ayar_mesai` varchar(64) NOT NULL,
  `ayar_analystic` varchar(255) DEFAULT NULL,
  `ayar_zopim` varchar(255) DEFAULT NULL,
  `ayar_maps` text NOT NULL,
  `ayar_instagram` varchar(128) NOT NULL,
  `ayar_facebook` varchar(128) NOT NULL,
  `ayar_twitter` varchar(128) NOT NULL,
  `ayar_linkedin` varchar(128) NOT NULL,
  `ayar_youtube` varchar(128) NOT NULL,
  `ayar_android_url` varchar(128) NOT NULL,
  `ayar_android_logo` varchar(64) NOT NULL,
  `ayar_ios_url` varchar(128) NOT NULL,
  `ayar_ios_logo` varchar(64) NOT NULL,
  `default_kritik_stok` int(11) NOT NULL,
  `ayar_bakim` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ayar`
--

INSERT INTO `ayar` (`ayar_id`, `ayar_logo`, `ayar_favicon`, `ayar_url`, `ayar_title`, `ayar_description`, `ayar_keywords`, `ayar_author`, `ayar_tel`, `ayar_gsm`, `ayar_faks`, `ayar_mail`, `ayar_ilce`, `ayar_il`, `ayar_adres`, `ayar_mesai`, `ayar_analystic`, `ayar_zopim`, `ayar_maps`, `ayar_instagram`, `ayar_facebook`, `ayar_twitter`, `ayar_linkedin`, `ayar_youtube`, `ayar_android_url`, `ayar_android_logo`, `ayar_ios_url`, `ayar_ios_logo`, `default_kritik_stok`, `ayar_bakim`) VALUES
(0, 'images/logo/84159-107-logo.png', 'images/favicon.ico', '', 'Shop7 E-Ticaret', 'Shop7 E-Ticaret', 'Ticaret,Website,E-ticaret,test', 'Gelişim Üniversitesi', '0850 500 00 00', '0545 500 00 00', '0850 500 00 002', 'bilgi@gelisim.edu.tr', 'Avcılar', 'İstanbul', 'Cihangir Mah. Şehit Jandarma Komando Er Hakan Öner Sk. No:1', '7 Gün / 24 Saat Hizmetinizdeyiz', NULL, NULL, 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6022.4889912835215!2d28.6894481!3d40.9980215!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa0f5088d375d%3A0xfc55898b29bc7b33!2zxLBzdGFuYnVsIEdlbGnFn2ltIMOcbml2ZXJzaXRlc2k!5e0!3m2!1str!2str!4v1735151603471!5m2!1str!2str', 'https://www.instagram.com/igugelisim', 'https://tr-tr.facebook.com/gelisimedu', 'https://x.com/gelisimedu?mx=2', 'https://tr.linkedin.com/company/geli%C5%9Fim-%C3%BCniversitesi', 'https://www.youtube.com/@GelisimUniversitesi', 'https://play.google.com/store/apps/details?id=com.IGU.Mobile.Obis&hl=tr&gl=US', 'images/uploads/android.png', 'https://apps.apple.com/tr/app/i-g%C3%BC-obi-s-mobil/id1386071350?l=tr', 'images/uploads/ios.png', 10, '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banka_hesaplari`
--

CREATE TABLE `banka_hesaplari` (
  `banka_id` int(11) NOT NULL,
  `banka_ad` varchar(64) NOT NULL,
  `banka_sube` varchar(64) NOT NULL,
  `banka_hesapno` varchar(64) NOT NULL,
  `doviz_turu` varchar(16) NOT NULL,
  `banka_iban` varchar(64) NOT NULL,
  `banka_hesapsahibi` varchar(128) NOT NULL,
  `banka_logo` varchar(128) NOT NULL,
  `banka_durum` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `banka_hesaplari`
--

INSERT INTO `banka_hesaplari` (`banka_id`, `banka_ad`, `banka_sube`, `banka_hesapno`, `doviz_turu`, `banka_iban`, `banka_hesapsahibi`, `banka_logo`, `banka_durum`) VALUES
(1, 'TÜRKİYE İŞ BANKASI', '111', '555555', 'TL', 'TR 34 0011 1111 1111 1111 1111 11', 'Vedat Aydın ŞEN', 'images/banks/681e21fc3aca8_isbank_logo.jpg', '1'),
(2, 'YAPI KREDİ', '333', '999999', 'TL', 'TR 34 2222 2222 2222 2222 2222 22', 'Vedat Aydın ŞEN', 'images/banks/yapi_kredi_logo.png', '1'),
(3, 'ZİRAAT BANKASI', '888', '7777777', 'TL', 'TR 34 6666 6666 6666 6666 6666 66', 'Vedat Aydın ŞEN', 'images/banks/ziraat_bankasi_logo.png', '1'),
(4, 'GARANTİ BANKASI', '222', '555555', 'USD', 'TR 34 9999 9999 9999 9999 9999 99', 'Vedat Aydın ŞEN', 'images/banks/garanti_bank_logo.jpg', '1'),
(5, 'ENPARA', '676', '676676', 'TL', 'TR 34 3434 3434 3434 3434 3434 34', 'Vedat Aydın ŞEN', 'images/banks/enpara_logo.jpg', '1'),
(6, 'PAYTR', '444', '444444', 'TL', 'TR 34 4444 4444 4444 4444 4444 44', 'Vedat Aydın ŞEN', 'images/banks/681e21cf958f3_paytr-uai-258x116.png', '1'),
(8, 'Deneme2', '111', '444444', 'TL', 'TR 34 3434 3434 3434 3434 3434 34', 'Vedat Aydın ŞEN', 'images/banks/681e22c749eb9_garanti_bank_logo.jpg', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banka_pos`
--

CREATE TABLE `banka_pos` (
  `bankapos_id` int(11) NOT NULL,
  `bankapos_adi` varchar(128) NOT NULL,
  `bankapos_resim` varchar(256) NOT NULL,
  `bankapos_durum` enum('0','1') NOT NULL DEFAULT '1',
  `bankapos_taksit1` decimal(6,2) NOT NULL,
  `bankapos_taksit2` decimal(6,2) NOT NULL,
  `bankapos_taksit3` decimal(6,2) NOT NULL,
  `bankapos_taksit4` decimal(6,2) NOT NULL,
  `bankapos_taksit5` decimal(6,2) NOT NULL,
  `bankapos_taksit6` decimal(6,2) NOT NULL,
  `bankapos_taksit7` decimal(6,2) NOT NULL,
  `bankapos_taksit8` decimal(6,2) NOT NULL,
  `bankapos_taksit9` decimal(6,2) NOT NULL,
  `bankapos_taksit10` decimal(6,2) NOT NULL,
  `bankapos_taksit11` decimal(6,2) NOT NULL,
  `bankapos_taksit12` decimal(6,2) NOT NULL,
  `bankapos_taksit_sayisi` int(11) NOT NULL DEFAULT 12
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `banka_pos`
--

INSERT INTO `banka_pos` (`bankapos_id`, `bankapos_adi`, `bankapos_resim`, `bankapos_durum`, `bankapos_taksit1`, `bankapos_taksit2`, `bankapos_taksit3`, `bankapos_taksit4`, `bankapos_taksit5`, `bankapos_taksit6`, `bankapos_taksit7`, `bankapos_taksit8`, `bankapos_taksit9`, `bankapos_taksit10`, `bankapos_taksit11`, `bankapos_taksit12`, `bankapos_taksit_sayisi`) VALUES
(1, 'Garanti Bankası', 'images/ccards/bonus.png', '1', 0.00, 1.50, 1.70, 1.90, 2.10, 2.30, 2.50, 2.70, 2.90, 3.10, 3.40, 3.90, 12),
(2, 'İş Bankası', 'images/ccards/maximum.png', '1', 0.00, 1.50, 1.70, 1.90, 2.10, 2.30, 2.50, 2.70, 2.90, 3.10, 3.40, 3.90, 12),
(3, 'Akbank', 'images/ccards/axess.png', '1', 0.00, 1.50, 1.70, 1.90, 2.10, 2.30, 2.50, 2.70, 2.90, 3.10, 3.40, 3.90, 12),
(4, 'Yapı Kredi', 'images/ccards/world.png', '1', 0.00, 1.50, 1.70, 1.90, 2.10, 2.30, 2.50, 2.70, 2.90, 0.00, 0.00, 0.00, 12),
(5, 'deneme', 'images/ccards/682139556d036_yeni logosu gold.png', '1', 0.00, 1.00, 1.50, 2.00, 2.50, 3.00, 3.50, 4.00, 4.50, 5.00, 5.50, 6.00, 12);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `favoriler`
--

CREATE TABLE `favoriler` (
  `favori_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `favori_tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `favoriler`
--

INSERT INTO `favoriler` (`favori_id`, `kullanici_id`, `urun_id`, `favori_tarih`) VALUES
(29, 176, 23, '2025-05-12 01:00:02'),
(30, 176, 18, '2025-05-12 01:00:04'),
(31, 176, 16, '2025-05-12 01:00:07'),
(32, 176, 15, '2025-05-12 01:00:12'),
(33, 176, 22, '2025-05-12 01:00:16'),
(34, 176, 19, '2025-05-12 01:00:19'),
(65, 168, 21, '2025-05-12 19:55:52');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `filtre_sablonu`
--

CREATE TABLE `filtre_sablonu` (
  `filtre_id` int(11) NOT NULL,
  `filtre_adi` varchar(256) NOT NULL,
  `filtre_durum` enum('0','1') NOT NULL DEFAULT '1',
  `filtre_code` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `filtre_sablonu`
--

INSERT INTO `filtre_sablonu` (`filtre_id`, `filtre_adi`, `filtre_durum`, `filtre_code`) VALUES
(1, 'Ücretsiz Kargo', '1', 'uk'),
(2, 'Yeni Gelenler', '1', 'new'),
(3, 'Fırsat Ürünleri', '1', 'firsat'),
(4, 'İndirimdeki Ürünler', '1', 'indirim'),
(5, 'Taksit Seçeneği olanlar', '1', 'taksit'),
(6, 'Hızlı Gönderi', '1', 'hizlikargo'),
(7, 'Editörün Seçimi', '1', 'editorsecimi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `icerikler`
--

CREATE TABLE `icerikler` (
  `icerik_id` int(11) NOT NULL,
  `icerik_durum` int(11) NOT NULL,
  `icerik_sira` int(11) NOT NULL DEFAULT 0,
  `icerik_baslik` varchar(128) NOT NULL,
  `icerik_metni` text NOT NULL,
  `icerik_seourl` varchar(128) NOT NULL,
  `icerik_type` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `icerikler`
--

INSERT INTO `icerikler` (`icerik_id`, `icerik_durum`, `icerik_sira`, `icerik_baslik`, `icerik_metni`, `icerik_seourl`, `icerik_type`) VALUES
(1, 1, 0, 'Hakkımızda', '<p>Suspendisse enim turpis, dictum sed, iaculis a, condimentum nec, nisi. Proin pretium, leo ac pellentesque mollis, felis nunc ultrices eros, sed gravida augue augue mollis justo. Fusce risus nisl, viverra et, tempor et, pretium in, sapien. Cras sagittis. Duis vel nibh at velit scelerisque suscipit.</p>\r\n<p>Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Phasellus a est. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Phasellus a est. Sed in libero ut nibh placerat accumsan.</p>\r\n<p>Etiam feugiat lorem non metus. In dui magna, posuere eget, vestibulum et, tempor auctor, justo. Praesent ut ligula non mi varius sagittis. Etiam ut purus mattis mauris sodales aliquam. Sed hendrerit.</p>\r\n<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam adipiscing. Pellentesque egestas, neque sit amet convallis pulvinar, justo nulla eleifend augue, ac auctor orci leo non est. In consectetuer turpis ut velit. Fusce egestas elit eget lorem.</p> ', 'hakkimizda', 'sayfalar'),
(2, 1, 0, 'Üyelik Sözleşmesi', '<p align=\"center\" class=\"MsoNormal\" style=\"text-align:center\"><strong><u>&Uuml;YELİK S&Ouml;ZLEŞMESİ</u></strong><br />\r\n<strong>&nbsp;<br />\r\n<strong>1. TARAFLAR</strong><br />\r\nİşbu Kullanıcı/&Uuml;yelik S&ouml;zleşmesi (&Uuml;yelik S&ouml;zleşmesi), iletişim sayfamızda yer alan adres&nbsp; de faaliyette olan firmamız ile web sitesine girerek &uuml;ye olan kullanıcı arasında, firmamız tarafından web sitesinde sunulan hizmetlerin ve bu hizmetlerden kullanıcı tarafından yararlanılmasına ilişkin şart ve koşulların belirlenmesi, bu doğrultuda tarafların hak ve y&uuml;k&uuml;ml&uuml;l&uuml;klerinin tespitidir.<br />\r\nKullanıcı, &Uuml;yelik S&ouml;zleşmesi&#39;nin tamamını okuduğunu, i&ccedil;eriğini tam anlamı ile anladığını ve t&uuml;m h&uuml;k&uuml;mlerini kabul ettiğini ve onayladığını beyan eder.<br />\r\n&nbsp;<br />\r\n<strong>2. TANIMLAR</strong><br />\r\n<strong>Hizmet/Hizmetler:</strong>&nbsp; &quot;Alıcı&quot; &uuml;yelerin s&ouml;z konusu s&ouml;zleşme i&ccedil;erisinde tanımlı olan iş ve işlemlerini ger&ccedil;ekleştirmelerini sağlamak amacıyla firmamız tarafından ortaya konulan servisler.<br />\r\n<strong>Kullanıcı/Kullanıcılar:</strong>&nbsp;Web sitesine erişen ger&ccedil;ek veya t&uuml;zel kişiler.<br />\r\n<strong>Alıcı:</strong>&nbsp;Web sitesi &uuml;zerinde &quot;Satıcı&quot; tarafından satışa arz edilen mal veya hizmetleri satın alan ger&ccedil;ek veya t&uuml;zel kişi &quot;&Uuml;ye&quot;.<br />\r\n<strong>Satıcı:</strong>&nbsp;Web sitesi &uuml;zerinde mal veya hizmet satışı arz eden t&uuml;zel kişi.<br />\r\n<strong>&Uuml;ye Sayfası:</strong>&nbsp;Alıcının, web sitesinde yer alan &ccedil;eşitli servis ve uygulamalardan yararlanabilmesi i&ccedil;in gerekli işlemleri ger&ccedil;ekleştirebildiği, kişisel bilgilerini ve uygulama bazında kendisinden istenen bilgilerini girdiği, sadece Alıcı tarafından belirlenen kullanıcı adı ve şifre ile erişilebilen ve Alıcı &uuml;yeye &ouml;zel sayfa, &ldquo;Hesabım&rdquo; altındaki sayfalar.<br />\r\n&nbsp;<br />\r\n<strong>3. S&Ouml;ZLEŞMENİN KONUSU VE KAPSAMI</strong><br />\r\nS&ouml;z konusu s&ouml;zleşmenin konusu, web sitesinde firmamız tarafından sunulan hizmetlerin, bu hizmetlerden Alıcı tarafından yararlanılmasına ilişkin şartlar ve koşulların belirlenmesi ve bu doğrultuda tarafların hak ve y&uuml;k&uuml;ml&uuml;l&uuml;klerinin tespitidir.<br />\r\nİşbu s&ouml;zleşmenin kapsamı ise, web sitesinde yer alan t&uuml;m hizmet, uygulama ve i&ccedil;eriğe ilişkin şart ve koşulların belirlenmesi olup; web sitesinde firmamız tarafından sağlanan servis ve hizmetlere ilişkin, kullanıma, i&ccedil;eriklere, uygulamalara, t&uuml;m &uuml;yelere ve kullanıcılara y&ouml;nelik her t&uuml;rl&uuml; beyan işbu s&ouml;zleşmenin ayrılmaz par&ccedil;ası olarak kabul edilecektir. İşbu s&ouml;zleşmenin Alıcı tarafından kabul edilmesi ile Alıcı web sitesinde yer alan veya alacak olan firma tarafından yapılan hizmetlere, kullanıma, i&ccedil;eriklere, uygulamalara, &uuml;yelere ve kullanıcılara y&ouml;nelik her t&uuml;rl&uuml; beyanı da kabul etmiş olduğunu kabul, beyan ve taahh&uuml;t eder.<br />\r\n&nbsp;<br />\r\n<strong>4. HAK VE Y&Uuml;K&Uuml;ML&Uuml;L&Uuml;KLER</strong><br />\r\n<strong>4.1.</strong>&nbsp;Alıcılık stat&uuml;s&uuml;n&uuml;n kazanılması i&ccedil;in, Alıcı &uuml;ye olmak isteyen kullanıcının web sitesinde bulunan &uuml;yelik formunu firmamız &Uuml;yelik S&ouml;zleşmesini onaylayarak, &uuml;yelik formunda talep edilen bilgiler doğrultusunda ger&ccedil;ek bilgilerle doldurması, &uuml;yelik başvurusunun firmamız tarafından değerlendirilerek onaylanması ve &uuml;ye olmak isteyen Kullanıcının/&Uuml;yenin ger&ccedil;ek kişi ise 18 yaşını doldurmuş olması gerekmektedir. Onaylanma işleminin tamamlanması ile birlikte ve Alıcı&#39; ya bildirilmesi ile Alıcılık stat&uuml;s&uuml; başlamakta ve b&ouml;ylece Alıcı işbu s&ouml;zleşme ve web sitesinin ilgili yerlerinde belirtilen hak ve y&uuml;k&uuml;ml&uuml;l&uuml;klere kavuşmaktadır. S&ouml;z konusu &uuml;yelik şartlarını ger&ccedil;eğe uygun olarak sağlamayan ve yanlış bilgiler verilmesi nedeniyle doğabilecek t&uuml;m zararlardan bizzat &quot;Kullanıcı/&Uuml;ye&quot; sorumludur. Alıcılık hak ve y&uuml;k&uuml;ml&uuml;l&uuml;kleri sadece Alıcılık başvurusunda bulunan kişi &uuml;zerinde doğmakta olup Alıcı kesinlikle bu hak ve y&uuml;k&uuml;ml&uuml;l&uuml;klerini kısmen veya tamamen herhangi bir &uuml;&ccedil;&uuml;nc&uuml; kişiye devredemez ve aktaramaz. Alıcılık hak ve y&uuml;k&uuml;ml&uuml;l&uuml;klerinin hangi ger&ccedil;ek veya t&uuml;zel kişiye ait olduğu konusunda anlaşmazlık bulunması ve bu konuda s&ouml;z konusu kişilerin firmamızdan istekte bulunması halinde firmamız, ilgili &uuml;yelik hesabı kullanılarak herhangi bir hizmet i&ccedil;in en son firmamıza &ouml;deme yapan ger&ccedil;ek veya t&uuml;zel kişinin ilgili &uuml;yelik hesabının Alıcı hak ve y&uuml;k&uuml;ml&uuml;l&uuml;klerine sahip olduğunu kabul edecek ve bu doğrultuda işlem yapacaktır. B&ouml;yle bir durumda firmamızın &uuml;yelik bilgileri, &uuml;ye işlemleri ve benzeri bilgiler doğrultusunda işbu madde i&ccedil;erisinde belirtilen kuraldan bağımsız olarak hareket etme hakkı saklıdır.<br />\r\n<strong>4.2.</strong>&nbsp;Alıcı, web sitesi &uuml;zerinden g&ouml;r&uuml;nt&uuml;lediği ilanlarla ilgili herhangi bir hukuki işlem veya satın alma s&uuml;reci başlatmak istemesi halinde web sitesindekiler de d&acirc;hil olmak &uuml;zere t&uuml;m gerekli yasal y&uuml;k&uuml;ml&uuml;l&uuml;kleri ve yasal gereklilikleri yerine getirmek zorunda olduğunu, s&ouml;z konusu y&uuml;k&uuml;ml&uuml;l&uuml;kler ve şartlarla ilgili olarak firmamızın herhangi bir bilgi ve sorumluluğunun bulunmadığını kabul ve beyan eder.<br />\r\n<strong>4.4.</strong>&nbsp;Alıcı, web sitesine kendisi tarafından y&uuml;klenen veri, i&ccedil;erik ve ilanların doğru ve hukuka uygun olduğunu, karalama, k&ouml;t&uuml;leme, itibar zedeleyici beyan, hakaret, iftira atma, tehdit etme veya taciz gibi hukuka veya ahlaka aykırı nitelik taşımayacağını, bu bilgi ve i&ccedil;eriklerin web sitesi &uuml;zerinde yayınlanmasının veya ilanlarda belirttiği mal ve hizmetlerin satışının ve teşhirinin y&uuml;r&uuml;rl&uuml;kteki mevzuat doğrultusunda herhangi bir hukuka aykırılık yaratmadığını, hak ihlaline sebep olmadığını, s&ouml;z konusu ilan ve i&ccedil;eriklerin ilgili olduğu mal ve hizmetlerin internet &uuml;zerinde yayınlanması, satışa arz edilmesi ve satılması i&ccedil;in t&uuml;m hak ve yetkilerin kendisinde olduğunu kabul ve taahh&uuml;t etmektedir.<br />\r\n<strong>4.5.</strong>&nbsp;&quot;Alıcı&quot;, &quot;&Uuml;ye&quot; ve &quot;Kullanıcı&quot; stat&uuml;lerindeyken firmamız &uuml;zerinde ger&ccedil;ekleştirdiği işlemlerde ve yazışmalarda; s&ouml;z konusu s&ouml;zleşmenin h&uuml;k&uuml;mlerine, web sitesinde belirtilen t&uuml;m şart ve koşullara ve y&uuml;r&uuml;rl&uuml;kteki mevzuata, ahlak kurallarına uygun olarak hareket edeceğini, web sitesi &uuml;zerinden kendisi tarafından ger&ccedil;ekleştirilen t&uuml;m işlemlerde reklam veren, satıcı, vergi m&uuml;kellefi veya benzeri sıfatlarla ilgili mevzuatın gerektirdiği &ouml;nlem ve usule ilişkin işlemleri yerine getirmek zorunda olduğunu, bu kural ve koşulları anladığını ve kabul ettiğini beyan eder. Alıcının web sitesi d&acirc;hilinde yaptığı her işlem ve eylemde hukuki ve cezai sorumluluk kendisine ait olacaktır.<br />\r\n<strong>4.6.</strong>&nbsp;firmamız, y&uuml;r&uuml;rl&uuml;kteki mevzuat dikkatince yetkili makamlardan talep gelmesi takdirde Alıcının kendisinde bulunan bilgilerini ilgili yetkili makamlarla paylaşabilir. Bu bilgiler &uuml;yeler arasında &ccedil;ıkan uyuşmazlıklarda diğer kullanıcıların yasal haklarını kullanabilmeleri amacıyla ve sadece bu kapsamda sınırlı olmak şartıyla uyuşmazlığa taraf olabilecek diğer kullanıcılara iletilebilecektir.<br />\r\n<strong>4.7.</strong>&nbsp;Alıcının, &ldquo;Hesabım&rdquo; ve altındaki sayfalara erişmek ve web sitesi &uuml;zerinden bazı işlemleri ger&ccedil;ekleştirebilmek i&ccedil;in ihtiya&ccedil; duyduğu kullanıcı adı ve şifre bilgileri, Alıcı tarafından oluşturulmakta olup, s&ouml;z konusu bilgilerin g&uuml;venliği ve gizliliği tamamen &uuml;yenin sorumluluğundadır.<br />\r\nAlıcı, kendisine ait kullanıcı adı ve şifre ile ger&ccedil;ekleştirilen işlemlerin kendisi tarafından ger&ccedil;ekleştirilmiş olduğunu, bu işlemlerden kaynaklanan sorumluluğunun peşinen kendisine ait olduğunu; bu şekilde ger&ccedil;ekleştirilen iş ve işlemleri kendisinin ger&ccedil;ekleştirmediği yolunda herhangi bir def&#39;i ya da itiraz ileri s&uuml;remeyeceğini veya bu def&#39;i ve itiraza dayanarak y&uuml;k&uuml;ml&uuml;l&uuml;klerini yerine getirmekten ka&ccedil;ınmayacağını kabul, beyan ve taahh&uuml;t eder.<br />\r\n<strong>4.8.</strong>&nbsp;firmamız, web sitesinin herhangi bir şekilde hukuka aykırı kullanımına ve &ouml;zellikle aşağıda belirtilen şekillerde web sitesinin her t&uuml;rl&uuml; kullanımına ve &uuml;zerindeki i&ccedil;eriğin b&uuml;t&uuml;n&uuml;n&uuml;n veya bir b&ouml;l&uuml;m&uuml;n&uuml;n her t&uuml;rl&uuml; elde edilmesine, kopyalanmasına, işlenmesine, kullanılmasına ve web sitesi &uuml;zerindeki i&ccedil;eriğe link verilmesine izin vermemektedir.<br />\r\nWeb sitesinin, Alıcı veya &uuml;&ccedil;&uuml;nc&uuml; bir kişi tarafından kendisine ya da başka bir kişiye ait veri tabanı, kayıt veya rehber oluşturmak, kontrol etmek, g&uuml;ncellemek, değiştirmek amacıyla kullanılması;<br />\r\nWeb sitesinin b&uuml;t&uuml;n&uuml;n&uuml;n veya herhangi bir b&ouml;l&uuml;m&uuml;n&uuml;n bozma, değiştirme veya ters m&uuml;hendislik yapma suretiyle kullanılması;<br />\r\nYanlış bilgiler vererek veya başka bir kişinin bilgilerini kullanarak işlem yapılması, yalan, yanlış veya yanıltıcı kişisel bilgiler, ikametg&acirc;h adresi, e-posta adresi, iletişim, hesap bilgileri ve &ouml;deme bilgileri vermek sebebiyle ger&ccedil;ek olmayan kullanıcı hesapları oluşturulması ve bu hesaplar &uuml;zerinden hukuka aykırı şekilde web sitesinin işbu kullanım koşulları ya da &uuml;yelik s&ouml;zleşmesi ve ekleri kapsamında ya da kapsamı dışında kullanılması, başka bir kullanıcının hesabının izinsiz kullanılması, başka birinin yerine ge&ccedil;ilerek ya da yanlış bir isimle işlemlere taraf veya katılımcı olunması ya da hesap oluşturulması,<br />\r\n&nbsp;Web sitesinin her t&uuml;rl&uuml; yasaya uygun olmayan veya hile amacı ile kullanılması,<br />\r\nKişisel gizlilik ve yayın hakları da d&acirc;hil olmak &uuml;zere telif hakkı alınmış, hukuken korunan ve web sitesine ya da 3. kişiye ait i&ccedil;eriğin tamamını veya bir kısmını sahibi olmadan veya izinsiz kullanılması, kopyalanması, değiştirilmesi, iletilmesi ya da yerine yenisinin yerleştirilmesi;<br />\r\nHerhangi bir işlemin fiyatını manip&uuml;le etmek suretiyle değiştirmek, &uuml;zerine oynama yapmak ya da diğer kullanıcıların işlemlerine m&uuml;dahalede bulunulması;<br />\r\nYorum ve puanlama sistemlerinin firmamız web sitesinin dışında başka ama&ccedil;lar i&ccedil;in kullanılması;<br />\r\n&nbsp;Zincirleme mektup veya istenmeyen e-posta (spam) yayılması;<br />\r\nVir&uuml;s ya da web sitesine, web sitesinin veri tabanına, web sitesi &uuml;zerinde bulunan herhangi bir i&ccedil;eriğe zarar verici başka bir teknoloji yayılması;<br />\r\nKullanıcılar hakkında izinleri olmadan, e-posta adresleri d&acirc;hil olmak &uuml;zere, herhangi bir bilgi ve veri toplanması;<br />\r\n&nbsp;firmamızın &ouml;nceden yazılı izni alınmaksızın web sitesi &uuml;zerinde otomatik program, robot, bot, web crawler, &ouml;r&uuml;mcek, spider, veri madenciliği (data mining) veri taraması (data crawling) vb. &quot;screen scraping&quot; yazılım yahut sistemleri kullanılması ve bu şekilde web sitesi &uuml;zerinde yer alan herhangi bir i&ccedil;eriğin tamamının veya bir kısmının izinsiz kopyalanarak, yayınlanması, kullanılması; işbu s&ouml;zleşme ile belirlenen kullanım sınırları dışında web sitesi &uuml;zerindeki i&ccedil;eriğin kullanılması hukuka aykırı olup; firmamız ilgili talep, dava ve takip hakları saklıdır.<br />\r\n<strong>4.9</strong>&nbsp;firmamız, Alıcı tarafından web sitesine beyan edilen &quot;&Uuml;ye&quot; bilgilerini, Gizlilik Politikasına uygun olarak, işbu s&ouml;zleşme ile belirlenen y&uuml;k&uuml;ml&uuml;l&uuml;klerini ve web sitesinin işletilmesi i&ccedil;in gereken uygulamaların y&uuml;r&uuml;t&uuml;lmesini yerine getirmek ve kendisi tarafından belirlenen istatistiki değerlendirmeler, reklam, pazarlama ve sair ticari iletişim faaliyetleri amacıyla kendisi veya iş ortakları adına kullanabilir, saklayabilir ve paylaşılabilir. &quot;&Uuml;ye/Alıcı&quot;, bilgilerinin firmamız tarafından bu şekilde kullanımına ve saklanmasına izin g&ouml;sterdiğini kabul ve beyan eder. firmamız s&ouml;z konusu bilgilerin g&uuml;venli şekilde saklanması i&ccedil;in gereken her t&uuml;rl&uuml; tedbiri alacaktır. Alıcı kişisel bilgileri &uuml;zerinde dilediği zaman değişiklik yapma hakkına sahip olacaktır. Bununla beraber Alıcı, paylaşmış olduğu bilgilerinin kendisine &ouml;zel avantajların sunulabilmesi, satış, pazarlama ve benzer ama&ccedil;lı her t&uuml;rl&uuml; iletişim faaliyetlerinin bildirimi maksatlarıyla, t&uuml;m firmamız girişimleri ile de paylaşımına izin vermektedir.<br />\r\n&nbsp;<br />\r\n<strong>4.10</strong>&nbsp;&quot;Alıcı&quot; kendisi tarafından web sitesine sağlanan her t&uuml;rl&uuml; veri, bilgi, i&ccedil;erik, materyal veya verinin vir&uuml;s, casus yazılım, k&ouml;t&uuml; niyetli yazılım, Truva atı, vs. gibi web sitesinde veya herhangi bir par&ccedil;asına zarar verecek nitelikte materyaller i&ccedil;ermemesi i&ccedil;in gerekli her t&uuml;rl&uuml; &ouml;nlemi (gerekli anti-vir&uuml;s yazılımlarını kullanmak d&acirc;hil olmak &uuml;zere) aldığını kabul, beyan ve taahh&uuml;t eder.<br />\r\n&nbsp;<br />\r\n<strong>5. FİKRİ M&Uuml;LKİYET HAKLARI</strong><br />\r\nAlıcı, web sitesi &uuml;zerinden sunulan servisleri firmamız bilgilerini ve firmamızın telif haklarına tabi &ccedil;alışmalarını yeniden satamaz, paylaşamaz, dağıtamaz, sergileyemez, &ccedil;oğaltamaz, bunlardan t&uuml;remiş &ccedil;alışmalar yapamaz veya hazırlayamaz ya da başkasının bu hizmetlere erişmesine veya kullanmasına izin veremez; aksi takdirde, lisans verenler de d&acirc;hil olmak &uuml;zere ancak bunlarla sınırlı olmaksızın, &uuml;&ccedil;&uuml;nc&uuml; kişilerin uğradıkları zararlardan dolayı firmamızdan talep edilen tazminat miktarını ve mahkeme masrafları ve avukatlık &uuml;creti de d&acirc;hil ancak bununla sınırlı olmamak &uuml;zere diğer her t&uuml;rl&uuml; y&uuml;k&uuml;ml&uuml;l&uuml;kleri karşılamakla sorumlu olacaklardır.<br />\r\n&nbsp;<br />\r\n<strong>6. S&Ouml;ZLEŞME DEĞİŞİKLİKLERİ</strong><br />\r\nfirmamız, tamamen kendi takdirine bağlı ve tek taraflı olarak işbu s&ouml;zleşmeyi uygun g&ouml;receği herhangi bir zamanda web sitesinde yayınlayarak değiştirebilir. S&ouml;z konusu bu s&ouml;zleşmenin değişen h&uuml;k&uuml;mleri, ilan edildikleri tarihte ge&ccedil;erlilik kazanacak, geri kalan h&uuml;k&uuml;mler aynen y&uuml;r&uuml;rl&uuml;kte kalarak h&uuml;k&uuml;m ve sonu&ccedil;larını doğurmaya devam edecektir. İşbu s&ouml;zleşme, &quot;Alıcı&quot; &uuml;yenin tek taraflı beyanları ile değiştirilmesi m&uuml;mk&uuml;n değildir.<br />\r\n&nbsp;<br />\r\n<strong>7. M&Uuml;CBİR SEBEPLER</strong><br />\r\nHukuken m&uuml;cbir sebep sayılan t&uuml;m durumlarda, firmamız işbu s&ouml;zleşme ile belirlenen edimlerinden herhangi birini ge&ccedil; veya eksik ifa etme veya ifa etmeme nedeniyle sorumlu değildir. M&uuml;cbir sebep hallerinde; gecikme, eksik ifa etme veya ifa etmeme veya temerr&uuml;t addedilmeyecek veya bu durumlar i&ccedil;in Alıcı tarafından firmamızdan herhangi bir nam altında tazminat talep edilemeyecektir.<br />\r\nM&uuml;cbir sebep terimi; doğal afetler, isyanlar, savaş, grev, siber saldırı, iletişim problemleri, altyapı ve internet arızaları, sisteme ilişkin iyileştirme veya yenileştirme &ccedil;alışmaları ve bu sebeple meydana gelebilecek arızalar, elektrik kesintisi ve k&ouml;t&uuml; hava koşulları da d&acirc;hil ve fakat bunlarla sınırlı olmamak kaydıyla firmanın kontrol&uuml; dışında ve gerekli &ouml;zeni g&ouml;stermesine rağmen &ouml;nlenemeyen ka&ccedil;ınılamaz olaylar olarak yorumlanacaktır.<br />\r\n&nbsp;<br />\r\n<strong>8. UYGULANACAK HUKUK VE YETKİ</strong><br />\r\nİşbu s&ouml;zleşmenin uygulanmasında, yorumlanmasında ve işbu s&ouml;zleşme d&acirc;hilinde doğan hukuki ilişkilerin y&ouml;netiminde T&uuml;rk Hukuku uygulanacaktır. İşbu s&ouml;zleşmeden dolayı doğan veya doğabilecek her t&uuml;rl&uuml; ihtilafın hallinde İstanbul Mahkemeleri ve İcra Daireleri yetkilidir.<br />\r\n&nbsp;<br />\r\n<strong>9. WEBSİTE KAYITLARININ GE&Ccedil;ERLİLİĞİ</strong><br />\r\n&quot;Alıcı&quot;, işbu s&ouml;zleşmeden doğabilecek ihtilaflarda firmanın kendi veri tabanında, sunucularında tuttuğu her t&uuml;rl&uuml; elektronik ve sistem kayıtlarının, ticari kayıtlarının, defter kayıtlarının, elektronik veriler, mikrofilm, mikro fiş ve bilgisayar kayıtlarının muteber bağlayıcı, kesin ve m&uuml;nhasır delil teşkil edeceğini, firmayı&nbsp; yemin teklifinden ber&#39;i kıldığını ve bu maddenin HMK 193. Madde anlamında delil s&ouml;zleşmesi niteliğinde olduğunu kabul, beyan ve taahh&uuml;t eder.<br />\r\n&nbsp;<br />\r\n<strong>10. B&Uuml;T&Uuml;NL&Uuml;K</strong><br />\r\nİşbu s&ouml;zleşmenin herhangi bir h&uuml;km&uuml;n&uuml;n veya s&ouml;zleşmede yer alan herhangi bir ifadenin ge&ccedil;ersizliği, yasaya aykırılığı ve uygulanamadığı durumlar, s&ouml;zleşmenin geri kalan h&uuml;k&uuml;mlerinin y&uuml;r&uuml;rl&uuml;ğ&uuml;n&uuml; ve ge&ccedil;erliliğini bozmayacak veya etkilemeyecektir.<br />\r\n&nbsp;<br />\r\n<strong>11. BİLDİRİM</strong><br />\r\n&Uuml;yeler ile kayıt olurken bildirdikleri e-posta aracılığıyla ya da web sitesinde yer alan genel bilgilendirme aracılığıyla iletişim kurulacaktır. E-posta ile yapılan iletişim yazılı iletişimin yerini tutar. E-mail adresini g&uuml;ncel tutmak ve firmamızın bilgilendirmeleri i&ccedil;in d&uuml;zenli kontrol etmek &Uuml;ye&rsquo;nin sorumluluğundadır.<br />\r\n&nbsp;<br />\r\n<strong>&Uuml;ye, &uuml;ye olduğu tarih itibari ile, işbu s&ouml;zleşmeyi elektronik ortamda onaylamak suretiyle, s&ouml;zleşme h&uuml;k&uuml;mlerine &uuml;yeliği s&uuml;resi boyunca bağlı kalacağını, kabul, beyan ve taahh&uuml;t eder.</strong></strong></p>\r\n\r\n<p class=\"MsoNormal\"><o:p></o:p></p>\r\n\r\n<p class=\"MsoNormal\"><o:p></o:p></p>\r\n', 'uyelik_sozlesmesi', 'sayfalar'),
(3, 1, 0, 'Mesafeli Satış Sözleşmesi', '<div class=\"categoryOverlay\" style=\"display: none;\">\r\n  <div id=\"loader\"></div>\r\n</div>\r\n<div id=\"mainHolder_divBlocks\">\r\n  <div id=\"divCenterBlock\" class=\"centerCount col-sm-12 col-md-12 col-lg-12 col-xs-12\">\r\n    <div class=\"middleTopBlock\"></div>\r\n    <div>\r\n      <script type=\"text/javascript\">\r\n        var pageContentId;\r\n        var sayfaIcerikUrunler = [];\r\n\r\n        function getOnerilenUrunler(filterModel) {\r\n          ticimaxApi.product.getProductList({\r\n            FilterJson: JSON.stringify(filterModel.filter),\r\n            PagingJson: JSON.stringify(filterModel.paging)\r\n          }, function(response) {\r\n            sayfaIcerikUrunler.pushArray(response.products);\r\n            if (sayfaIcerikUrunler.length > 0) {\r\n              getSayfaIcerikUrunCompleted();\r\n              $(\'#divIcerikUrunleri\').show();\r\n            }\r\n          });\r\n        };\r\n\r\n        function getSayfaIcerikUrunCompleted() {\r\n          var element = $(\'.IcerikUrunleri[init=false]:eq(0)\');\r\n          var source1 = $(\"#scriptTemplateIcerikUrunleri\").html();\r\n          var template1 = Handlebars.compile(source1);\r\n          element.attr(\"init\", \"true\");\r\n          var urunlerContainer = {\r\n            products: sayfaIcerikUrunler\r\n          };\r\n          $(element).find(\'.ulUrunSlider\').html(template1(urunlerContainer));\r\n          setTimeout(function() {\r\n            if (typeof urunListCallback != \"undefined\") urunListCallback();\r\n            lazyLoad();\r\n          }, 100);\r\n        }\r\n        $(document).ready(function() {\r\n          var sayfaIcerikUrunler = createProductFilterModel();\r\n          sayfaIcerikUrunler.filter.PageContentId = pageContentId;\r\n          sayfaIcerikUrunler.paging.PageItemCount = 30;\r\n          getOnerilenUrunler(sayfaIcerikUrunler);\r\n        });\r\n      </script>\r\n      <p>\r\n        <strong>MESAFELİ SATIŞ SÖZLEŞMESİ</strong>\r\n      </p>\r\n      <p>\r\n        <strong>1.TARAFLAR</strong>\r\n      </p>\r\n      <p>İşbu Sözleşme aşağıdaki taraflar arasında aşağıda belirtilen hüküm ve şartlar çerçevesinde imzalanmıştır.</p>\r\n      <p>A.‘ALICI’ ; (sözleşmede bundan sonra “ALICI” olarak anılacaktır)</p>\r\n      <p>B.‘Yeliz Güğerçin’ ; (sözleşmede bundan sonra “SATICI” olarak anılacaktır)</p>\r\n      <p>Ünvan:&nbsp;</p>\r\n      <p>ADRES:&nbsp;</p>\r\n      <p>İş bu sözleşmeyi kabul etmekle ALICI, sözleşme konusu siparişi onayladığı takdirde sipariş konusu bedeli ve varsa kargo ücreti, vergi gibi belirtilen ek ücretleri ödeme yükümlülüğü altına gireceğini ve bu konuda bilgilendirildiğini peşinen kabul eder.</p>\r\n      <p>\r\n        <strong>2.TANIMLAR</strong>\r\n      </p>\r\n      <p>İşbu sözleşmenin uygulanmasında ve yorumlanmasında aşağıda yazılı terimler karşılarındaki yazılı açıklamaları ifade edeceklerdir.</p>\r\n      <p>BAKAN: Gümrük ve Ticaret Bakanı’nı,</p>\r\n      <p>BAKANLIK: Gümrük ve Ticaret &nbsp;Bakanlığı’nı,</p>\r\n      <p>KANUN: 6502 sayılı Tüketicinin Korunması Hakkında Kanun’u,</p>\r\n      <p>YÖNETMELİK: Mesafeli Sözleşmeler Yönetmeliği’ni (RG:27.11.2014/29188)</p>\r\n      <p>HİZMET: Bir ücret veya menfaat karşılığında yapılan ya da yapılması taahhüt edilen mal sağlama dışındaki her türlü tüketici işleminin konusunu ,</p>\r\n      <p>SATICI: Ticari veya mesleki faaliyetleri kapsamında tüketiciye mal sunan veya mal sunan adına veya hesabına hareket eden şirketi,</p>\r\n      <p>ALICI: Bir mal veya hizmeti ticari veya mesleki olmayan amaçlarla edinen, kullanan veya yararlanan gerçek ya da tüzel kişiyi,</p>\r\n      <p>SİTE: SATICI’ya ait internet sitesini,</p>\r\n      <p>SİPARİŞ VEREN: Bir mal veya hizmeti SATICI’ya ait internet sitesi üzerinden talep eden gerçek ya da tüzel kişiyi,</p>\r\n      <p>TARAFLAR: SATICI ve ALICI’yı,</p>\r\n      <p>SÖZLEŞME: SATICI ve ALICI arasında akdedilen işbu sözleşmeyi,</p>\r\n      <p>MAL: Alışverişe konu olan taşınır eşyayı ve elektronik ortamda kullanılmak üzere hazırlanan yazılım, ses, görüntü ve benzeri gayri maddi malları ifade eder.</p>\r\n      <p>\r\n        <strong>3.KONU</strong>\r\n      </p>\r\n      <p>İşbu Sözleşme, ALICI’nın, SATICI’ya ait internet sitesi üzerinden elektronik ortamda siparişini verdiği aşağıda nitelikleri ve satış fiyatı belirtilen ürünün satışı ve teslimi ile ilgili olarak 6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmelere Dair Yönetmelik hükümleri gereğince tarafların hak ve yükümlülüklerini düzenler.</p>\r\n      <p>Listelenen ve sitede ilan edilen fiyatlar satış fiyatıdır. İlan edilen fiyatlar ve vaatler güncelleme yapılana ve değiştirilene kadar geçerlidir. Süreli olarak ilan edilen fiyatlar ise belirtilen süre sonuna kadar geçerlidir.</p>\r\n      <p>4. SATICI BİLGİLERİ</p>\r\n      <p>Ünvanı:&nbsp;YELİZ GUĞERÇİN</p>\r\n      <p>Eposta: info@yelishestore.com</p>\r\n      <p>&nbsp;</p>\r\n      <p>\r\n        <strong>5. ALICI BİLGİLERİ</strong>\r\n      </p>\r\n      <p>Teslim edilecek kişi</p>\r\n      <p>Teslimat Adresi</p>\r\n      <p>Telefon</p>\r\n      <p>Faks</p>\r\n      <p>Eposta/kullanıcı adı</p>\r\n      <p>\r\n        <strong>6. SİPARİŞ VEREN KİŞİ BİLGİLERİ</strong>\r\n      </p>\r\n      <p>Ad/Soyad/Unvan</p>\r\n      <p>Adres</p>\r\n      <p>Telefon</p>\r\n      <p>Faks</p>\r\n      <p>Eposta/kullanıcı adı</p>\r\n      <p>\r\n        <strong>7. SÖZLEŞME KONUSU ÜRÜN/ÜRÜNLER BİLGİLERİ</strong>\r\n      </p>\r\n      <p>1. Malın /Ürün/Ürünlerin/ Hizmetin temel özelliklerini (türü, miktarı, marka/modeli, rengi, adedi) SATICI’ya ait internet sitesinde yayınlanmaktadır. Satıcı tarafından kampanya düzenlenmiş ise ilgili ürünün temel özelliklerini kampanya süresince inceleyebilirsiniz. Kampanya tarihine kadar geçerlidir.</p>\r\n      <p>7.2. Listelenen ve sitede ilan edilen fiyatlar satış fiyatıdır. İlan edilen fiyatlar ve vaatler güncelleme yapılana ve değiştirilene kadar geçerlidir. Süreli olarak ilan edilen fiyatlar ise belirtilen süre sonuna kadar geçerlidir.</p>\r\n      <p>7.3. Sözleşme konusu mal ya da hizmetin tüm vergiler dâhil satış fiyatı aşağıda gösterilmiştir.</p>\r\n      <p>Ürün AçıklamasıAdetBirim FiyatıAra Toplam</p>\r\n      <p>(KDV Dahil)</p>\r\n      <p>Kargo Tutarı</p>\r\n      <p>Toplam :</p>\r\n      <p>Ödeme Şekli ve Planı</p>\r\n      <p>Teslimat Adresi</p>\r\n      <p>Teslim Edilecek kişi</p>\r\n      <p>Fatura Adresi</p>\r\n      <p>Sipariş Tarihi</p>\r\n      <p>Teslimat tarihi</p>\r\n      <p>Teslim şekli</p>\r\n      <p>7.4. &nbsp;Ürün sevkiyat masrafı olan kargo ücreti ALICI tarafından ödenecektir.</p>\r\n      <p>\r\n        <strong>8. FATURA BİLGİLERİ</strong>\r\n      </p>\r\n      <p>Ad/Soyad/Unvan</p>\r\n      <p>Adres</p>\r\n      <p>Telefon</p>\r\n      <p>Faks</p>\r\n      <p>Eposta/kullanıcı adı</p>\r\n      <p>Fatura teslim : Fatura sipariş teslimatı sırasında fatura adresine sipariş ile birlikte</p>\r\n      <p>teslim edilecektir.</p>\r\n      <p>&nbsp;</p>\r\n      <p>\r\n        <strong>9. GENEL HÜKÜMLER</strong>\r\n      </p>\r\n      <p>9.1. ALICI, SATICI’ya ait internet sitesinde sözleşme konusu ürünün temel nitelikleri, satış fiyatı ve ödeme şekli ile teslimata ilişkin ön bilgileri okuyup, bilgi sahibi olduğunu, elektronik ortamda gerekli teyidi verdiğini kabul, beyan ve taahhüt eder. ALICI’nın; Ön Bilgilendirmeyi elektronik ortamda teyit etmesi, mesafeli satış sözleşmesinin kurulmasından evvel, SATICI tarafından ALICI’ ya verilmesi gereken adresi, siparişi verilen ürünlere ait temel özellikleri, ürünlerin vergiler dâhil fiyatını, ödeme ve teslimat bilgilerini de doğru ve eksiksiz olarak edindiğini kabul, beyan ve taahhüt eder.</p>\r\n      <p>9.2. Sözleşme konusu her bir ürün, 30 günlük yasal süreyi aşmamak kaydı ile ALICI’ nın yerleşim yeri uzaklığına bağlı olarak internet sitesindeki ön bilgiler kısmında belirtilen süre zarfında ALICI veya ALICI’nın gösterdiği adresteki kişi ve/veya kuruluşa teslim edilir. Bu süre içinde ürünün ALICI’ya teslim edilememesi durumunda, ALICI’nın sözleşmeyi feshetme hakkı saklıdır.</p>\r\n      <p>9.3. SATICI, Sözleşme konusu ürünü eksiksiz, siparişte belirtilen niteliklere uygun ve varsa garanti belgeleri, kullanım kılavuzları işin gereği olan bilgi ve belgeler ile teslim etmeyi, her türlü ayıptan arî olarak yasal mevzuat gereklerine göre sağlam, standartlara uygun bir şekilde işi doğruluk ve dürüstlük esasları dâhilinde ifa etmeyi, hizmet kalitesini koruyup yükseltmeyi, işin ifası sırasında gerekli dikkat ve özeni göstermeyi, ihtiyat ve öngörü ile hareket etmeyi kabul, beyan ve taahhüt eder.</p>\r\n      <p>9.4. SATICI, sözleşmeden doğan ifa yükümlülüğünün süresi dolmadan ALICI’yı bilgilendirmek ve açıkça onayını almak suretiyle eşit kalite ve fiyatta farklı bir ürün tedarik edebilir.</p>\r\n      <p>9.5. SATICI, sipariş konusu ürün veya hizmetin yerine getirilmesinin imkânsızlaşması halinde sözleşme konusu yükümlülüklerini yerine getiremezse, bu durumu, öğrendiği tarihten itibaren 3 gün içinde yazılı olarak tüketiciye bildireceğini, 14 günlük süre içinde toplam bedeli ALICI’ya iade edeceğini kabul, beyan ve taahhüt eder.</p>\r\n      <p>9.6. ALICI, Sözleşme konusu ürünün teslimatı için işbu Sözleşme’yi elektronik ortamda teyit edeceğini, herhangi bir nedenle sözleşme konusu ürün bedelinin ödenmemesi ve/veya banka kayıtlarında iptal edilmesi halinde, SATICI’nın sözleşme konusu ürünü teslim yükümlülüğünün sona ereceğini kabul, beyan ve taahhüt eder.</p>\r\n      <p>9.7. ALICI, Sözleşme konusu ürünün ALICI veya ALICI’nın gösterdiği adresteki kişi ve/veya kuruluşa tesliminden sonra ALICI’ya ait kredi kartının yetkisiz kişilerce haksız kullanılması sonucunda sözleşme konusu ürün bedelinin ilgili banka veya finans kuruluşu tarafından SATICI’ya ödenmemesi halinde, ALICI Sözleşme konusu ürünü 3 gün içerisinde nakliye gideri SATICI’ya ait olacak şekilde SATICI’ya iade edeceğini kabul, beyan ve taahhüt eder.</p>\r\n      <p>9.8. SATICI, tarafların iradesi dışında gelişen, önceden öngörülemeyen ve tarafların borçlarını yerine getirmesini engelleyici ve/veya geciktirici hallerin oluşması gibi mücbir sebepler halleri nedeni ile sözleşme konusu ürünü süresi içinde teslim edemez ise, durumu ALICI’ya bildireceğini kabul, beyan ve taahhüt eder. ALICI da siparişin iptal edilmesini, sözleşme konusu ürünün varsa emsali ile değiştirilmesini ve/veya teslimat süresinin engelleyici durumun ortadan kalkmasına kadar ertelenmesini SATICI’dan talep etme hakkını haizdir. ALICI tarafından siparişin iptal edilmesi halinde ALICI’nın nakit ile yaptığı ödemelerde, ürün tutarı 14 gün içinde kendisine nakden ve defaten ödenir. ALICI’nın kredi kartı ile yaptığı ödemelerde ise, ürün tutarı, siparişin ALICI tarafından iptal edilmesinden sonra 14 gün içerisinde ilgili bankaya iade edilir. ALICI, SATICI tarafından kredi kartına iade edilen tutarın banka tarafından ALICI hesabına yansıtılmasına ilişkin ortalama sürecin 2 ile 3 haftayı bulabileceğini, bu tutarın bankaya iadesinden sonra ALICI’nın hesaplarına yansıması halinin tamamen banka işlem süreci ile ilgili olduğundan, ALICI, olası gecikmeler için SATICI’yı sorumlu tutamayacağını kabul, beyan ve taahhüt eder.</p>\r\n      <p>9.9. SATICININ, ALICI tarafından siteye kayıt formunda belirtilen veya daha sonra kendisi tarafından güncellenen adresi, e-posta adresi, sabit ve mobil telefon hatları ve diğer iletişim bilgileri üzerinden mektup, e-posta, SMS, telefon görüşmesi ve diğer yollarla iletişim, pazarlama, bildirim ve diğer amaçlarla ALICI’ya ulaşma hakkı bulunmaktadır. ALICI, işbu sözleşmeyi kabul etmekle SATICI’nın kendisine yönelik yukarıda belirtilen iletişim faaliyetlerinde bulunabileceğini kabul ve beyan etmektedir.</p>\r\n      <p>9.10. ALICI, sözleşme konusu mal/hizmeti teslim almadan önce muayene edecek; ezik, kırık, ambalajı yırtılmış vb. hasarlı ve ayıplı mal/hizmeti kargo şirketinden teslim almayacaktır. Teslim alınan mal/hizmetin hasarsız ve sağlam olduğu kabul edilecektir. Teslimden sonra mal/hizmetin özenle korunması borcu, ALICI’ya aittir. Cayma hakkı kullanılacaksa mal/hizmet kullanılmamalıdır. Fatura iade edilmelidir.</p>\r\n      <p>9.11. ALICI ile sipariş esnasında kullanılan kredi kartı hamilinin aynı kişi olmaması veya ürünün ALICI’ya tesliminden evvel, siparişte kullanılan kredi kartına ilişkin güvenlik açığı tespit edilmesi halinde, SATICI, kredi kartı hamiline ilişkin kimlik ve iletişim bilgilerini, siparişte kullanılan kredi kartının bir önceki aya ait ekstresini yahut kart hamilinin bankasından kredi kartının kendisine ait olduğuna ilişkin yazıyı ibraz etmesini ALICI’dan talep edebilir. ALICI’nın talebe konu bilgi/belgeleri temin etmesine kadar geçecek sürede sipariş dondurulacak olup, mezkur taleplerin 24 saat içerisinde karşılanmaması halinde ise SATICI, siparişi iptal etme hakkını haizdir.</p>\r\n      <p>9.12. ALICI, SATICI’ya ait internet sitesine üye olurken verdiği kişisel ve diğer sair bilgilerin gerçeğe uygun olduğunu, SATICI’nın bu bilgilerin gerçeğe aykırılığı nedeniyle uğrayacağı tüm zararları, SATICI’nın ilk bildirimi üzerine derhal, nakden ve defaten tazmin edeceğini beyan ve taahhüt eder.</p>\r\n      <p>9.13. ALICI, SATICI’ya ait internet sitesini kullanırken yasal mevzuat hükümlerine riayet etmeyi ve bunları ihlal etmemeyi baştan kabul ve taahhüt eder. Aksi takdirde, doğacak tüm hukuki ve cezai yükümlülükler tamamen ve münhasıran ALICI’yı bağlayacaktır.</p>\r\n      <p>9.14. ALICI, SATICI’ya ait internet sitesini hiçbir şekilde kamu düzenini bozucu, genel ahlaka aykırı, başkalarını rahatsız ve taciz edici şekilde, yasalara aykırı bir amaç için, başkalarının maddi ve manevi haklarına tecavüz edecek şekilde kullanamaz. Ayrıca, üye başkalarının hizmetleri kullanmasını önleyici veya zorlaştırıcı faaliyet (spam, virus, truva atı, vb.) işlemlerde bulunamaz.</p>\r\n      <p>9.15. SATICI’ya ait internet sitesinin üzerinden, SATICI’nın kendi kontrolünde olmayan ve/veya başkaca üçüncü kişilerin sahip olduğu ve/veya işlettiği başka web sitelerine ve/veya başka içeriklere link verilebilir. Bu linkler ALICI’ya yönlenme kolaylığı sağlamak amacıyla konmuş olup herhangi bir web sitesini veya o siteyi işleten kişiyi desteklememekte ve Link verilen web sitesinin içerdiği bilgilere yönelik herhangi bir garanti niteliği taşımamaktadır.</p>\r\n      <p>9.16. İşbu sözleşme içerisinde sayılan maddelerden bir ya da birkaçını ihlal eden üye işbu ihlal nedeniyle cezai ve hukuki olarak şahsen sorumlu olup, SATICI’yı bu ihlallerin hukuki ve cezai sonuçlarından ari tutacaktır. Ayrıca; işbu ihlal nedeniyle, olayın hukuk alanına intikal ettirilmesi halinde, SATICI’nın üyeye karşı üyelik sözleşmesine uyulmamasından dolayı tazminat talebinde bulunma hakkı saklıdır.</p>\r\n      <p>\r\n        <strong>10. CAYMA HAKKI</strong>\r\n      </p>\r\n      <p>10.1. ALICI; mesafeli sözleşmenin mal satışına ilişkin olması durumunda, ürünün kendisine veya gösterdiği adresteki kişi/kuruluşa teslim tarihinden itibaren 3 (üç) gün içerisinde, SATICI’ya bildirmek şartıyla yalnızca üründe bir kusur olması durumunda sözleşmeden cayma hakkını kullanabilir. Hizmet sunumuna ilişkin mesafeli sözleşmelerde ise, bu süre sözleşmenin imzalandığı tarihten itibaren başlar. Cayma hakkı süresi sona ermeden önce, tüketicinin onayı ile hizmetin ifasına başlanan hizmet sözleşmelerinde cayma hakkı kullanılamaz. Cayma hakkının kullanımından kaynaklanan masraflar SATICI’ ya aittir. ALICI, iş bu sözleşmeyi kabul etmekle, cayma hakkı konusunda bilgilendirildiğini peşinen kabul eder.</p>\r\n      <p>10.2. Cayma hakkının kullanılması için 3(üç) günlük süre içinde SATICI’ ya iadeli taahhütlü posta, faks veya eposta ile yazılı bildirimde bulunulması ve ürünün işbu sözleşmede düzenlenen “Cayma Hakkı Kullanılamayacak Ürünler” hükümleri çerçevesinde kullanılmamış olması şarttır. Bu hakkın kullanılması halinde,</p>\r\n      <p>a) 3. kişiye veya ALICI’ ya teslim edilen ürünün faturası, (İade edilmek istenen ürünün faturası kurumsal ise, iade ederken kurumun düzenlemiş olduğu iade faturası ile birlikte gönderilmesi gerekmektedir. Faturası kurumlar adına düzenlenen sipariş iadeleri İADE FATURASI kesilmediği takdirde tamamlanamayacaktır.)</p>\r\n      <p>b) İade formu,</p>\r\n      <p>c) İade edilecek ürünlerin kutusu, ambalajı, varsa standart aksesuarları ile birlikte eksiksiz ve hasarsız olarak teslim edilmesi gerekmektedir.</p>\r\n      <p>d) SATICI, cayma bildiriminin kendisine ulaşmasından itibaren en geç 10 günlük süre içerisinde toplam bedeli ve ALICI’yı borç altına sokan belgeleri ALICI’ ya iade etmek ve 20 günlük süre içerisinde malı iade almakla yükümlüdür.</p>\r\n      <p>e) ALICI’ nın kusurundan kaynaklanan bir nedenle malın değerinde bir azalma olursa veya iade imkânsızlaşırsa ALICI kusuru oranında SATICI’ nın zararlarını tazmin etmekle yükümlüdür. Ancak cayma hakkı süresi içinde malın veya ürünün usulüne uygun kullanılması sebebiyle meydana gelen değişiklik ve bozulmalardan ALICI sorumlu değildir.</p>\r\n      <p>f) Cayma hakkının kullanılması nedeniyle SATICI tarafından düzenlenen kampanya limit tutarının altına düşülmesi halinde kampanya kapsamında faydalanılan indirim miktarı iptal edilir.</p>\r\n      <p>11. CAYMA HAKKI KULLANILAMAYACAK ÜRÜNLER</p>\r\n      <p>ALICI’nın isteği veya açıkça kişisel ihtiyaçları doğrultusunda hazırlanan ve geri gönderilmeye müsait olmayan, iç giyim alt parçaları, mayo ve bikini altları, makyaj malzemeleri, tek kullanımlık ürünler, çabuk bozulma tehlikesi olan veya son kullanma tarihi geçme ihtimali olan mallar, ALICI’ya teslim edilmesinin ardından ALICI tarafından ambalajı açıldığı takdirde iade edilmesi sağlık ve hijyen açısından uygun olmayan ürünler, teslim edildikten sonra başka ürünlerle karışan ve doğası gereği ayrıştırılması mümkün olmayan ürünler, Abonelik sözleşmesi kapsamında sağlananlar dışında, gazete ve dergi gibi süreli yayınlara ilişkin mallar, Elektronik ortamda anında ifa edilen hizmetler veya tüketiciye anında teslim edilen gayrimaddi mallar, ile ses veya görüntü kayıtlarının, kitap, dijital içerik, yazılım programlarının, veri kaydedebilme ve veri depolama cihazlarının, &nbsp;bilgisayar sarf malzemelerinin, ambalajının ALICI tarafından açılmış olması halinde iadesi Yönetmelik gereği mümkün değildir. Ayrıca Cayma hakkı süresi sona ermeden önce, tüketicinin onayı ile ifasına başlanan hizmetlere ilişkin cayma hakkının kullanılması da Yönetmelik gereği mümkün değildir.</p>\r\n      <p>Kozmetik ve kişisel bakım ürünleri, iç giyim ürünleri, mayo, bikini, kitap, kopyalanabilir yazılım ve programlar, DVD, VCD, CD ve kasetler ile kırtasiye sarf malzemeleri (toner, kartuş, şerit vb.) iade edilebilmesi için ambalajlarının açılmamış, denenmemiş, bozulmamış ve kullanılmamış olmaları gerekir.</p>\r\n      <p>12. TEMERRÜT HALİ VE HUKUKİ SONUÇLARI</p>\r\n      <p>ALICI, ödeme işlemlerini &nbsp;kredi kartı ile yaptığı durumda temerrüde düştüğü takdirde, kart sahibi banka ile arasındaki kredi kartı sözleşmesi çerçevesinde faiz ödeyeceğini ve bankaya karşı sorumlu olacağını kabul, beyan ve taahhüt eder. Bu durumda ilgili banka hukuki yollara başvurabilir; doğacak masrafları ve vekâlet ücretini ALICI’dan talep edebilir ve her koşulda ALICI’nın borcundan dolayı temerrüde düşmesi halinde, ALICI, borcun gecikmeli ifasından dolayı SATICI’nın uğradığı zarar ve ziyanını ödeyeceğini kabul, beyan ve taahhüt eder.</p>\r\n      <p>13. YETKİLİ MAHKEME</p>\r\n      <p>İşbu sözleşmeden doğan uyuşmazlıklarda şikayet ve itirazlar, aşağıdaki kanunda belirtilen parasal sınırlar dâhilinde tüketicinin yerleşim yerinin bulunduğu veya tüketici işleminin yapıldığı yerdeki tüketici sorunları hakem heyetine veya tüketici mahkemesine yapılacaktır. Parasal sınıra ilişkin bilgiler aşağıdadır:</p>\r\n      <p>01/01/2017 tarihinden itibaren geçerli olmak üzere, 2017 yılı için tüketici hakem heyetlerine yapılacak başvurularda değeri:</p>\r\n      <p>a) 2.400 (iki bin dört yüz) Türk Lirasının altında bulunan uyuşmazlıklarda ilçe tüketici hakem heyetleri,</p>\r\n      <p>b) Büyükşehir statüsünde olan illerde 2.400 (iki bin dört yüz) Türk Lirası ile 3.610 (üç bin altı yüz on) Türk Lirası arasındaki uyuşmazlıklarda il tüketici hakem heyetleri,</p>\r\n      <p>c) Büyükşehir statüsünde olmayan illerin merkezlerinde 3.610 (üç bin altı yüz on) Türk Lirasının altında bulunan uyuşmazlıklarda il tüketici hakem heyetleri,</p>\r\n      <p>ç) Büyükşehir statüsünde olmayan illere bağlı ilçelerde 2.400 (iki bin dört yüz) Türk Lirası ile 3.610 (üç bin altı yüz on) Türk Lirası arasındaki uyuşmazlıklarda il tüketici hakem heyetleri görevli kılınmışlardır.</p>\r\n      <p>İşbu Sözleşme ticari amaçlarla yapılmaktadır.</p>\r\n      <p>14. YÜRÜRLÜK</p>\r\n      <p>ALICI, Site üzerinden verdiği siparişe ait ödemeyi gerçekleştirdiğinde işbu sözleşmenin tüm şartlarını kabul etmiş sayılır. SATICI, siparişin gerçekleşmesi öncesinde işbu sözleşmenin sitede ALICI tarafından okunup kabul edildiğine dair onay alacak şekilde gerekli yazılımsal düzenlemeleri yapmakla yükümlüdür.</p>\r\n      <p>SATICI:</p>\r\n      <p>ALICI:</p>\r\n      <p>TARİH:</p>\r\n      <div id=\"mainHolder_SayfaIcerik_pnlIlgiliUrunler\">\r\n        <script id=\"scriptTemplateIcerikUrunleri\" type=\"text/x-handlebars-template\">\r\n          {{#each products}}\r\n            <li>\r\n              <div class=\"productItem\">\r\n                {{> productItem }}\r\n              </div>\r\n            </li>\r\n          {{/each}}\r\n        </script>\r\n        <div class=\"IcerikUrunleri\" id=\"divIcerikUrunleri\" init=\"false\" style=\"display:none;\">\r\n          <div class=\"ProductList sort_4\">\r\n            <div class=\"jCarouselLite\">\r\n              <div class=\"JKatAdi categoryTitle\">\r\n                <span class=\"bold\">\r\n                  <span class=\"satir1 ilgiliUrunlerTitle\">İlgili Ürünler</span>\r\n                </span>\r\n              </div>\r\n              <div class=\"clear\"></div>\r\n              <ul class=\"ulUrunSlider sliderOpacity\"></ul>\r\n            </div>\r\n          </div>\r\n        </div>\r\n      </div>\r\n    </div>\r\n    <div class=\"middleBottomBlock\"></div>\r\n  </div>\r\n</div>', 'mesafeli_satis_sozlesmesi', 'sayfalar'),
(4, 1, 0, 'Kullanıcı Sözleşmesi', '<div id=\"wt_page_detail\" class=\"content_inner_wrapper\">\r\n  <div class=\"container\">\r\n    <div class=\"section-content\">\r\n      <div class=\"content-description\">\r\n        <div class=\"rich_content rich_content_page_detail jq_rich_content\">\r\n          <h4>MADDE 1: TARAFLAR</h4>\r\n          <p> 1.1 İşbu KULLANICI SÖZLEŞMESİ (“SÖZLEŞME”), (“SİTE”)bu internet adresinde ürün alımı yapmak üzere (“ALICI”) veya ürün satışı yapmak üzere (“SATICI”) yer alan tüm özel ve tüzel kişi ve kurumlar (Aşağıda ALICI ve SATICI beraber KULLANICI veya KULLANICILAR olarak anılacaktır) ile MAĞAZA arasında, üye kayıt aşamasında yapılmıştır. Bu sözleşme KULLANICILAR ile MAĞAZA arasında, KULLANICILARIN sözleşmeyi onaylaması sırasında yapılmıştır. KULLANICILAR bu sözleşmeyi onaylayarak, sözleşmenin tamamını okuduklarını, içeriğini bütünü ile anladıklarını ve bütün hükümlerini kabul ettiklerini ve onayladıklarını peşinen kabul ve taahhüt ederler. </p>\r\n          <p> 1.2 MAĞAZA, değiştirilen maddeleri SİTE’deki duyuru imkanları ile yayınlamak kaydıyla, SÖZLEŞME’yi tek taraflı değiştirme veya tadil etme hakkına sahiptir. Yapılan tüm değişiklikler SİTE’deki duyuru imkanları ile ilan edildikten 7 gün sonra geçerlilik kazanır. </p>\r\n          <h4> MADDE 2: SÖZLEŞMENİN KONUSU </h4>\r\n          <p> 2.1 İşbu KULLANICI sözleşmesinin konusu, KULLANICILARIN, SİTE’de sunulan hizmetleri kullanma ve yararlanma şartlarının ve tarafların hak ve yükümlülüklerinin tespitidir. </p>\r\n          <h4> MADDE 3: KULLANICI HAK VE YÜKÜMLÜLÜKLERİ </h4>\r\n          <p> 3.1 SİTE’ye üye olmak için T.C. kanunları çerçevesinde reşit olmak ve istenen kimlik bilgilerini eksiksiz olarak sunmak yeterlidir. </p>\r\n          <p> 3.2 KULLANICI, SİTE’den yararlanırken yürürlükte bulunan T.C. kanun ve mevzuatlarına ve kullanıcı sözleşmesi ve ekinde yer alan tüm şartlara uygun hareket edeceğini, kabul, beyan ve taahhüt eder. </p>\r\n          <p> 3.3 KULLANICI, SİTE’de paylaştığı bilgiler, yaptığı işlemler ve hareketleri ile ilgili kayıt altında tuttuğu her türlü bilgi veriyi, yetkili makamlarca istenmesi ve yükümlü olduğu durumlarda resmi makamlarca paylaşılabileceğini ve bu durumda her ne ad altında olursa olsun tazminat talep edemeyeceğini kabul, beyan ve taahhüt eder. </p>\r\n          <p> 3.4 SİTE üzerinde yapılan alım ve satış işlemleri direk olarak KULLANICILAR arasında gerçekleşmektedir. SİTE, KULLANICILAR arasında gerçekleşen para, ürün ve mal transferinin hiçbir aşamasında yer almamaktadır. Söz konusu işlemler nedeniyle doğabilecek her türlü yasal, mali ve idari sorumluluk KULLANICILARA aittir. KULLANICILAR, bu sözleşmeyi kabul ederek bu şartları kabul etmiş olurlar. </p>\r\n          <p> 3.5 KULLANICI, satılan mal ve/veya hizmete ilişkin olarak 4077 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmelere Dair Yönetmelik kapsamında tek sorumlunun kendileri olduğunu ve MAĞAZA’nın, KULLANICILAR arasındaki satım akdinin ve/veya hizmet akdinin veya sair hukuki ilişkinin herhangi şekil ve sıfat ile tarafı olmadığını kabul, beyan ve taahhüt eder. </p>\r\n          <p> 3.6 KULLANICI, MAĞAZA’nın 4077 sayılı Tüketicinin Korunması Hakkındaki Kanun kapsamında, satıcı, sağlayıcı, imalatçı, üretici, bayi, acente, reklamcı, mecra kuruluşu olmadığını kabul, beyan ve taahhüt eder. </p>\r\n          <p> 3.7 KULLANICI, MAĞAZA’nın herhangi bir sebep göstermeksizin işbu sözleşme kapsamında SİTE ile gerçekleşen işlemlerinin durdurabileceğini ve işlemin durdurulması sebebiyle MAĞAZA’dan herhangi hak, alacak veya zarar talebinde bulunmayacağını kabul, beyan ve taahhüt eder. </p>\r\n          <p> 3.8 KULLANICI’nın SİTE’de işlem yapmak için kullandığı kullanıcı adı, şifre, özel anahtar, API anahtarı ve benzeri her türlü özel bilgiyi saklamakla yükümlüdür. </p>\r\n          <p> 3.9 KULLANICI, MAĞAZA’nın sunduğu hizmetlerin hiçbirini, yürürlükte bulunan kanun ve/veya mevzuatlara aykırı içeriğin ve/veya hizmetin saklanması, satılması için kullanamayacağını kabul, beyan ve taahhüt eder. </p>\r\n          <p> 3.10 KULLANICI, SİTE’ye yüklemiş olduğu her türlü içerik, dosya, görsel ve dijital varlığın telif hakkının kendine ait olduğunu ve resmi makamlar ve/veya telif hakkı sahibi tarafından yapılacak bir başvuruda MAĞAZA’nın hiçbir uyarı yapmadan bu içeriklerini erişime kapatabileceğini ve/veya silebileceğini, bunun sonucunda MAĞAZA’dan herhangi hak, alacak veya zarar talebinde bulunmayacağını kabul, beyan ve taahhüt eder. </p>\r\n          <p> 3.11 KULLANICI, SİTE’ye yüklemiş olduğu içeriklerin sebep gösterilmeksizin silinebileceğini, KULLANICI’nın bu içeriklerin orijinal kopyalarını kendisinin saklamakla yükümlü olduğunu ve bu varlıklara erişememesi durumunda, MAĞAZA’dan herhangi hak, alacak veya zarar talebinde bulunmayacağını kabul, beyan ve taahhüt eder. </p>\r\n          <h4> MADDE 4: MAĞAZA’NIN HAK VE YÜKÜMLÜLÜKLERİ </h4>\r\n          <p> 4.1 MAĞAZA, SİTE’de verdiği hizmet süresince KULLANICI’nın paylaşmış olduğu içerik, dosya, bilgi ve her türlü dijital varlığın erişilebilirliği, sürekli erişilebilirliği ve kullanılabilirliği ile ilgili bir taahhüt vermemektedir. </p>\r\n          <h4> MADDE 5: MÜCBİR SEBEPLER </h4>\r\n          <p> 5.1 Hukuken “mücbir sebep” sayılan tüm hallerde, MAĞAZA, işbu Kullanıcı Sözleşmesi ile belirlenen yükümlülüklerinden herhangi birini geç veya eksik yerine getirme veya yerine getirememe nedeniyle yükümlü değildir. Bu ve bunun gibi durumlar, MAĞAZA için, gecikme, eksik yerine getirmen veya yerine getirememe veya temerrüt addedilmeyecek veya bu durumlar için MAĞAZA’dan herhangi bir nam altında tazminat talep edilemeyecektir. “Mücbir sebep” terimi, doğal afet, isyan, savaş, grev, iletişim sorunları, altyapı ve internet arızaları, elektrik kesintisi ve kötü hava koşulları da dahil ve fakat bunlarla sınırlı olmamak kaydıyla, ilgili tarafın makul kontrolü haricinde ve gerekli özeni göstermesine rağmen önleyemediği, kaçınılamayacak olaylar olarak yorumlanacaktır. </p>\r\n          <h4> MADDE 6: HUKUK KAPSAMI VE YETKİLİ MERCİLER </h4>\r\n          <p> 6.1 İşbu Kullanıcı Sözleşmesi’nin uygulanmasında, yorumlanmasında ve hükümleri dahilinde doğan hukuki ilişkilerin yönetiminde Türkiye Cumhuriyeti Devleti Hukuku, kanun ve mevzuatları uygulanacaktır. İşbu Kullanıcı Sözleşmesi’nden doğan veya doğabilecek her türlü ihtilafın hallinde, Ankara Mahkemeleri ve İcra Daireleri yetkilidir. </p>\r\n          <h4></h4>\r\n          <h4> MADDE 7: SÖZLEŞMENİN SÜRESİ VE FESİH </h4>\r\n          <p> 7.1 İşbu Kullanıcı Sözleşmesi, KULLANICI, SİTE\'ye üye olduğu sürece yürürlükte kalacak ve taraflar arası hüküm olarak kabul edilecek ve sonuçlarını doğurmaya devam edecektir. MAĞAZA, Kullanıcıların işbu Kullanıcı Sözleşmesi\'ni ve/veya, SİTE içinde yer alan kullanıma, üyeliğe ve SİTE’de sunulan hizmetlere ilişkin benzeri kuralları ihlal etmeleri durumunda sözleşmeyi tek taraflı olarak feshederek kullanıcıların hesaplarını kapatma hakkına sahiptir. Bu durumda, KULLANICI\'lar, fesih sebebiyle, MAĞAZA’nın uğradığı tüm zararları tazmin etmekle yükümlü olacaktır. </p>\r\n          <h4> MADDE 8: KAYITLARIN GEÇERLİLİĞİ </h4>\r\n          <p> 8.1 KULLANICI, bu sözleşmeden doğabilecek ihtilaflarda MAĞAZA’nın bilgisayar kayıtlarının H.M.K 193. madde anlamında muteber, bağlayıcı, kesin ve münhasır delil teşkil edeceğini ve bu maddenin delil sözleşmesi niteliğinde olduğunu belirten MAĞAZA kayıtlarına her türlü itiraz ve bunların usulüne uygun tutulduğu hususunda yemin teklif hakkından peşinen feragat ettiğini kabul, beyan ve taahhüt eder. İşbu 8 (sekiz) madde ve “EK-1 Gizlilik İlkeleri Sözleşmesi” belgesinden oluşan sözleşme, KULLANICI\'nın elektronik olarak onay vermesi ile karşılıklı olarak kabul edilerek yürürlüğe girmiştir. EK1: Güvenlik ve Gizlilik İlkeleri Sözleşmesi </p>\r\n        </div>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</div>', 'kullanici_sozlesmesi', 'sayfalar');
INSERT INTO `icerikler` (`icerik_id`, `icerik_durum`, `icerik_sira`, `icerik_baslik`, `icerik_metni`, `icerik_seourl`, `icerik_type`) VALUES
(5, 1, 0, 'İptal ve İade Koşulları', '<div class=\"col-md-8 col-12 post-item-wrapper-left\">\r\n    <div class=\"betterdocs-document-content post-item-content\">\r\n\r\n        <div>&nbsp;</div>\r\n\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">TÜKETİCİ HAKLARI – CAYMA – İPTAL İADE KOŞULLARI</span>\r\n        </p>\r\n        <p class=\"western\" align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">GENEL:</span>\r\n        </p>\r\n        <ol>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Kullanmakta olduğunuz web sitesi üzerinden elektronik ortamda sipariş verdiğiniz takdirde, size sunulan ön bilgilendirme formunu ve mesafeli satış sözleşmesini kabul etmiş sayılırsınız.</p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Alıcılar, satın aldıkları ürünün satış ve teslimi ile ilgili olarak 6502 sayılı Tüketicinin Korunması Hakkında Kanun ve Mesafeli Sözleşmeler Yönetmeliği (RG:27.11.2014/29188) hükümleri ile yürürlükteki diğer yasalara tabidir. </p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Ürün sevkiyat masrafı olan kargo ücretleri alıcılar tarafından ödenecektir.</p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Satın alınan her bir ürün, 30 günlük yasal süreyi aşmamak kaydı ile alıcının gösterdiği adresteki kişi ve/veya kuruluşa teslim edilir. Bu süre içinde ürün teslim edilmez ise, Alıcılar sözleşmeyi sona erdirebilir. </p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Satın alınan ürün, eksiksiz ve siparişte belirtilen niteliklere uygun ve varsa garanti belgesi, kullanım klavuzu gibi belgelerle teslim edilmek zorundadır. </p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Satın alınan ürünün satılmasının imkansızlaşması durumunda, satıcı bu durumu öğrendiğinden itibaren 3 gün içinde yazılı olarak alıcıya bu durumu bildirmek zorundadır. 14 gün içinde de toplam bedel Alıcı’ya iade edilmek zorundadır. </p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">SATIN ALINAN ÜRÜN BEDELİ ÖDENMEZ İSE: </span>\r\n        </p>\r\n        <ol start=\"7\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Alıcı, satın aldığı ürün bedelini ödemez veya banka kayıtlarında iptal ederse, Satıcının ürünü teslim yükümlülüğü sona erer.</p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">KREDİ KARTININ YETKİSİZ KULLANIMI İLE YAPILAN ALIŞVERİŞLER:</span>\r\n        </p>\r\n        <ol start=\"8\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Ürün teslim edildikten sonra, alıcının ödeme yaptığı kredi kartının yetkisiz kişiler tarafından haksız olarak kullanıldığı tespit edilirse ve satılan ürün bedeli ilgili banka veya finans kuruluşu tarafından Satıcı\'ya ödenmez ise, Alıcı, sözleşme konusu ürünü 3 gün içerisinde nakliye gideri SATICI’ya ait olacak şekilde SATICI’ya iade etmek zorundadır. </p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">ÖNGÖRÜLEMEYEN SEBEPLERLE ÜRÜN SÜRESİNDE TESLİM EDİLEMEZ İSE: </span>\r\n        </p>\r\n        <ol start=\"9\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Satıcı’nın öngöremeyeceği mücbir sebepler oluşursa ve ürün süresinde teslim edilemez ise, durum Alıcı’ya bildirilir. Alıcı, siparişin iptalini, ürünün benzeri ile değiştirilmesini veya engel ortadan kalkana dek teslimatın ertelenmesini talep edebilir. Alıcı siparişi iptal ederse; ödemeyi nakit ile yapmış ise iptalinden itibaren 14 gün içinde kendisine nakden bu ücret ödenir. Alıcı, ödemeyi kredi kartı ile yapmış ise ve iptal ederse, bu iptalden itibaren yine 14 gün içinde ürün bedeli bankaya iade edilir, ancak bankanın alıcının hesabına 2-3 hafta içerisinde aktarması olasıdır. </p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">ALICININ ÜRÜNÜ KONTROL ETME YÜKÜMLÜLÜĞÜ: </span>\r\n        </p>\r\n        <ol start=\"10\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Alıcı, sözleşme konusu mal/hizmeti teslim almadan önce muayene edecek; ezik, kırık, ambalajı yırtılmış vb. hasarlı ve ayıplı mal/hizmeti kargo şirketinden teslim almayacaktır. Teslim alınan mal/hizmetin hasarsız ve sağlam olduğu kabul edilecektir. ALICI , Teslimden sonra mal/hizmeti özenle korunmak zorundadır. Cayma hakkı kullanılacaksa mal/hizmet kullanılmamalıdır. Ürünle birlikte Fatura da iade edilmelidir.</p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">CAYMA HAKKI:</span>\r\n        </p>\r\n        <ol start=\"11\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">ALICI; satın aldığı ürünün kendisine veya gösterdiği adresteki kişi/kuruluşa teslim tarihinden itibaren 14 (on dört) gün içerisinde, SATICI’ya aşağıdaki iletişim bilgileri üzerinden bildirmek şartıyla hiçbir hukuki ve cezai sorumluluk üstlenmeksizin ve hiçbir gerekçe göstermeksizin malı reddederek sözleşmeden cayma hakkını kullanabilir.</p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <ol start=\"12\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">\r\n                    <span style=\"font-weight: bold;\">SATICININ CAYMA HAKKI BİLDİRİMİ YAPILACAK İLETİŞİM BİLGİLERİ:</span>\r\n                </p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">ŞİRKET </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">ADI/UNVANI: <br> ADRES: <br> EPOSTA: <br> TEL: <br> FAKS: </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">CAYMA HAKKININ SÜRESİ:</span>\r\n        </p>\r\n        <ol start=\"13\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Alıcı, satın aldığı eğer bir hizmet ise, bu 14 günlük süre sözleşmenin imzalandığı tarihten itibaren başlar. Cayma hakkı süresi sona ermeden önce, tüketicinin onayı ile hizmetin ifasına başlanan hizmet sözleşmelerinde cayma hakkı kullanılamaz. </p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Cayma hakkının kullanımından kaynaklanan masraflar SATICI’ ya aittir.</p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Cayma hakkının kullanılması için 14 (ondört) günlük süre içinde SATICI\' ya iadeli taahhütlü posta, faks veya eposta ile yazılı bildirimde bulunulması ve ürünün işbu sözleşmede düzenlenen \"Cayma Hakkı Kullanılamayacak Ürünler\" hükümleri çerçevesinde kullanılmamış olması şarttır. </p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">CAYMA HAKKININ KULLANIMI:&nbsp;</span>\r\n        </p>\r\n        <ol start=\"16\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">3. kişiye veya ALICI’ ya teslim edilen ürünün faturası, (İade edilmek istenen ürünün faturası kurumsal ise, iade ederken kurumun düzenlemiş olduğu iade faturası ile birlikte gönderilmesi gerekmektedir. Faturası kurumlar adına düzenlenen sipariş iadeleri İADE FATURASI kesilmediği takdirde tamamlanamayacaktır.)</p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">İade formu, İade edilecek ürünlerin kutusu, ambalajı, varsa standart aksesuarları ile birlikte eksiksiz ve hasarsız olarak teslim edilmesi gerekmektedir.</p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">İADE KOŞULLARI:</span>\r\n        </p>\r\n        <ol start=\"18\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">SATICI, cayma bildiriminin kendisine ulaşmasından itibaren en geç 10 günlük süre içerisinde toplam bedeli ve ALICI’yı borç altına sokan belgeleri ALICI’ ya iade etmek ve 20 günlük süre içerisinde malı iade almakla yükümlüdür.</p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">ALICI’ nın kusurundan kaynaklanan bir nedenle malın değerinde bir azalma olursa veya iade imkânsızlaşırsa ALICI kusuru oranında SATICI’ nın zararlarını tazmin etmekle yükümlüdür. Ancak cayma hakkı süresi içinde malın veya ürünün usulüne uygun kullanılması sebebiyle meydana gelen değişiklik ve bozulmalardan ALICI sorumlu değildir.&nbsp;</p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Cayma hakkının kullanılması nedeniyle SATICI tarafından düzenlenen kampanya limit tutarının altına düşülmesi halinde kampanya kapsamında faydalanılan indirim miktarı iptal edilir.</p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">CAYMA HAKKI KULLANILAMAYACAK ÜRÜNLER: </span>\r\n        </p>\r\n        <ol start=\"21\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">ALICI’nın isteği veya açıkça kişisel ihtiyaçları doğrultusunda hazırlanan ve geri gönderilmeye müsait olmayan, iç giyim alt parçaları, mayo ve bikini altları, makyaj malzemeleri, tek kullanımlık ürünler, çabuk bozulma tehlikesi olan veya son kullanma tarihi geçme ihtimali olan mallar, ALICI’ya teslim edilmesinin ardından ALICI tarafından ambalajı açıldığı takdirde iade edilmesi sağlık ve hijyen açısından uygun olmayan ürünler, teslim edildikten sonra başka ürünlerle karışan ve doğası gereği ayrıştırılması mümkün olmayan ürünler, Abonelik sözleşmesi kapsamında sağlananlar dışında, gazete ve dergi gibi süreli yayınlara ilişkin mallar, Elektronik ortamda anında ifa edilen hizmetler veya tüketiciye anında teslim edilen&nbsp;gayrimaddi&nbsp;mallar, ile ses veya görüntü kayıtlarının, kitap, dijital içerik, yazılım programlarının, veri kaydedebilme ve veri depolama cihazlarının, bilgisayar sarf malzemelerinin, ambalajının ALICI tarafından açılmış olması halinde iadesi Yönetmelik gereği mümkün değildir. Ayrıca Cayma hakkı süresi sona ermeden önce, tüketicinin onayı ile ifasına başlanan hizmetlere ilişkin cayma hakkının kullanılması da Yönetmelik gereği mümkün değildir.</p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Kozmetik ve kişisel bakım ürünleri, iç giyim ürünleri, mayo, bikini, kitap, kopyalanabilir yazılım ve programlar, DVD, VCD, CD ve kasetler ile kırtasiye sarf malzemeleri (toner, kartuş, şerit vb.) iade edilebilmesi için ambalajlarının açılmamış, denenmemiş, bozulmamış ve kullanılmamış olmaları gerekir. </p>\r\n            </li>\r\n        </ol>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">TEMERRÜT HALİ VE HUKUKİ SONUÇLARI</span>\r\n        </p>\r\n        <ol start=\"23\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">ALICI, ödeme işlemlerini kredi kartı ile yaptığı durumda temerrüde düştüğü takdirde, kart sahibi banka ile arasındaki kredi kartı sözleşmesi çerçevesinde faiz ödeyeceğini ve bankaya karşı sorumlu olacağını kabul, beyan ve taahhüt eder. Bu durumda ilgili banka hukuki yollara başvurabilir; doğacak masrafları ve vekâlet ücretini ALICI’dan talep edebilir ve her koşulda ALICI’nın borcundan dolayı temerrüde düşmesi halinde, ALICI, borcun gecikmeli ifasından dolayı SATICI’nın uğradığı zarar ve ziyanını ödeyeceğini kabul eder. </p>\r\n            </li>\r\n        </ol>\r\n        <p class=\"western\" align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n        <p align=\"justify\" style=\"margin-left: 0.25in; margin-bottom: 0in; line-height: 100%\">\r\n            <span style=\"font-weight: bold;\">ÖDEME VE TESLİMAT</span>\r\n        </p>\r\n        <ol start=\"24\">\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Banka Havalesi veya EFT (Elektronik Fon Transferi) yaparak, ............, ........., bankası hesaplarımızdan (TL) herhangi birine yapabilirsiniz.</p>\r\n            </li>\r\n            <li>\r\n                <p align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">Sitemiz üzerinden kredi kartlarınız ile, Her türlü kredi kartınıza online tek ödeme ya da&nbsp;online taksit imkânlarından yararlanabilirsiniz. Online ödemelerinizde siparişiniz sonunda kredi kartınızdan tutar çekim işlemi gerçekleşecektir. <br>\r\n                    <br>\r\n                </p>\r\n            </li>\r\n        </ol>\r\n        <p class=\"western\" align=\"justify\" style=\"margin-bottom: 0in; line-height: 100%\">\r\n            <br>\r\n        </p>\r\n               \r\n    </div>\r\n</div>', 'iptal_ve_iade_kosullari', 'sayfalar');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ilceler`
--

CREATE TABLE `ilceler` (
  `ilce_id` int(11) NOT NULL,
  `sehir_id` int(11) NOT NULL,
  `ilce_ad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ilceler`
--

INSERT INTO `ilceler` (`ilce_id`, `sehir_id`, `ilce_ad`) VALUES
(1, 34, 'Adalar'),
(2, 34, 'Arnavutköy'),
(3, 34, 'Ataşehir'),
(4, 34, 'Avcılar'),
(5, 34, 'Bağcılar'),
(6, 34, 'Bahçelievler'),
(7, 34, 'Bakırköy'),
(8, 34, 'Başakşehir'),
(9, 34, 'Bayrampaşa'),
(10, 34, 'Beşiktaş'),
(11, 34, 'Beykoz'),
(12, 34, 'Beylikdüzü'),
(13, 34, 'Beyoğlu'),
(14, 34, 'Büyükçekmece'),
(15, 34, 'Çatalca'),
(16, 34, 'Çekmeköy'),
(17, 34, 'Esenler'),
(18, 34, 'Esenyurt'),
(19, 34, 'Eyüp'),
(20, 34, 'Fatih'),
(21, 34, 'Gaziosmanpaşa'),
(22, 34, 'Güngören'),
(23, 34, 'Kadıköy'),
(24, 34, 'Kağıthane'),
(25, 34, 'Kartal'),
(26, 34, 'Küçükçekmece'),
(27, 34, 'Maltepe'),
(28, 34, 'Pendik'),
(29, 34, 'Sancaktepe'),
(30, 34, 'Sarıyer'),
(31, 34, 'Silivri'),
(32, 34, 'Sultanbeyli'),
(33, 34, 'Sultangazi'),
(34, 34, 'Şile'),
(35, 34, 'Şişli'),
(36, 34, 'Tuzla'),
(37, 34, 'Ümraniye'),
(38, 34, 'Üsküdar'),
(39, 34, 'Zeytinburnu'),
(40, 6, 'Akyurt'),
(41, 6, 'Altındağ'),
(42, 6, 'Ayaş'),
(43, 6, 'Bala'),
(44, 6, 'Beypazarı'),
(45, 6, 'Çamlıdere'),
(46, 6, 'Çankaya'),
(47, 6, 'Çubuk'),
(48, 6, 'Elmadağ'),
(49, 6, 'Etimesgut'),
(50, 6, 'Evren'),
(51, 6, 'Gölbaşı'),
(52, 6, 'Güdül'),
(53, 6, 'Haymana'),
(54, 6, 'Kahramankazan'),
(55, 6, 'Kalecik'),
(56, 6, 'Keçiören'),
(57, 6, 'Kızılcahamam'),
(58, 6, 'Mamak'),
(59, 6, 'Nallıhan'),
(60, 6, 'Polatlı'),
(61, 6, 'Pursaklar'),
(62, 6, 'Sincan'),
(63, 6, 'Şereflikoçhisar'),
(64, 6, 'Yenimahalle');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_ad` varchar(100) NOT NULL,
  `kategori_ust` int(11) NOT NULL,
  `kategori_seourl` varchar(250) NOT NULL,
  `kategori_sira` int(11) NOT NULL,
  `kategori_durum` enum('0','1') NOT NULL DEFAULT '1',
  `ust_kategori_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_ad`, `kategori_ust`, `kategori_seourl`, `kategori_sira`, `kategori_durum`, `ust_kategori_id`) VALUES
(12, 'iPhone', 11, 'iphone', 0, '1', 11),
(11, 'Akıllı Telefonlar', 10, 'akilli-telefonlar/index.html', 0, '1', 10),
(10, 'TELEFONLAR', 0, 'telefonlar', 0, '1', 0),
(13, 'Galaxy', 11, 'galaxy/index.html', 0, '1', 11),
(14, 'BİLGİSAYAR,TABLET', 0, 'bilgisayar-tablet/index.html', 0, '1', 0),
(15, 'Tablet Modelleri', 14, 'tabletler/index.html', 0, '1', 14),
(16, 'iPad', 15, 'ipad/index.html', 0, '1', 15),
(17, 'Galaxy Tab', 15, 'galaxy-tab/index.html', 0, '1', 15),
(18, 'TV ÜRÜNLERİ', 0, 'tv-urunleri/index.html', 0, '1', 0),
(19, 'AKSESUARLAR', 0, 'aksesuar/index.html', 0, '1', 0),
(20, 'BEYAZ EŞYA', 0, 'beyaz-esya/index.html', 0, '1', 0),
(21, 'APARATLAR', 0, 'aparatlar', 0, '1', 0),
(22, 'KABLO & ADAPTÖR', 0, 'kablo-adaptor', 0, '1', 0),
(23, 'Buzdolabı', 20, 'buzdolabi', 0, '1', 20),
(52, 'Kılıflar', 19, 'k脹l脹flar', 0, '1', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_zaman` datetime NOT NULL DEFAULT current_timestamp(),
  `kullanici_resim` varchar(250) NOT NULL,
  `kullanici_tc` varchar(50) NOT NULL,
  `kullanici_ad` varchar(50) NOT NULL,
  `kullanici_soyad` varchar(64) NOT NULL,
  `kullanici_mail` varchar(100) NOT NULL,
  `kullanici_gsm` varchar(50) NOT NULL,
  `kullanici_password` varchar(50) NOT NULL,
  `kullanici_adsoyad` varchar(50) NOT NULL,
  `kullanici_adres` varchar(250) NOT NULL,
  `kullanici_il` int(11) DEFAULT NULL,
  `kullanici_ilce` int(11) DEFAULT NULL,
  `kullanici_unvan` varchar(100) NOT NULL,
  `kullanici_yetki` varchar(50) NOT NULL,
  `kullanici_durum` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `kullanici_zaman`, `kullanici_resim`, `kullanici_tc`, `kullanici_ad`, `kullanici_soyad`, `kullanici_mail`, `kullanici_gsm`, `kullanici_password`, `kullanici_adsoyad`, `kullanici_adres`, `kullanici_il`, `kullanici_ilce`, `kullanici_unvan`, `kullanici_yetki`, `kullanici_durum`) VALUES
(147, '2024-10-27 00:00:00', '', '11111111111', 'Vedat Aydın', 'Şen', 'vdt-aydn@windowslive.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Vedat Aydın ŞEN', 'Deneme adres', 34, 14, 'Admin', '5', 1),
(166, '2024-10-29 10:57:36', '', '11111111111', 'Vedat Aydın', 'şen', 'vedat@vedat.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Vedat Aydın ŞEN', 'Deneme adres', 34, 15, 'vedat', '1', 0),
(168, '2024-10-29 00:18:06', 'images/kullanicilar/gelisim-universitesi-logo.png', '11111111111', 'Vedat Aydın', 'ŞEN', 'aydin@deneme.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Vedat Aydın ŞEN', 'deneme adresi', 34, 16, 'Admin', '5', 1),
(169, '2024-12-26 03:15:45', 'images/kullanicilar/oktay_kaynarca.jfif', '11111111111', 'Oktay', 'Kaynarca', 'oktay_kaynarca@oktay.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Oktay Kaynarca', 'Oktay adres 1', 34, 17, 'oktay', '1', 0),
(170, '2024-12-26 03:24:30', 'images/kullanicilar/johnwick.jfif', '11111111111', 'John', 'Wick', 'johnwick@deneme.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'John Wick', 'Deneme adresidir', 34, 18, 'johwick123', '1', 0),
(171, '2024-12-26 03:27:47', 'images/kullanicilar/johstatham.jfif', '11111111111', 'John', 'Statham', 'johnstatham@deneme.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'John Statham', 'Deneme adres', 34, 19, 'johnstatham', '1', 0),
(172, '2024-12-26 03:33:52', 'images/kullanicilar/elonmusk.jfif', '11111111111', 'Elon', 'Musk', 'elonmusk@deneme.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Elon Musk', 'Deneme adresidir deneme adresidir', 34, 20, 'elonmusk', '1', 0),
(174, '2024-12-29 22:57:18', 'images/kullanicilar/68232706ef70b.png', '11111111111', 'Vedat', 'ŞEN', 'vdt-aydn@windowslive.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Vedat ŞEN', '', 34, 0, '', '1', 0),
(175, '2025-01-04 19:58:50', '', '11111111111', 'Vedat Aydın', 'ŞEN', 'vdt@deneme1.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Vedat Aydın ŞEN', '', 34, 16, '', '1', 0),
(176, '2025-05-11 14:56:39', 'images/kullanicilar/6820908f72283.jpg', '11111111111', 'Vedat', 'ŞEN', 'vedatsen@deneme.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Vedat Aydın ŞEN', 'deneme adresidir2', 34, 15, 'vedat123', '1', 0),
(177, '2025-05-11 15:20:10', '', '11111111111', 'vedat', 'sen', 'vedat@aydinsen.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'Vedat Aydın ŞEN', 'deneme adres', 34, 16, 'vedat3212', '1', 1),
(179, '2025-05-12 10:00:21', '', '11111111111', 'test', 'deneme', 'testdeneme@deneme.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'deneme deneme', '', 34, 16, '', '1', 0),
(180, '2025-05-12 10:07:53', '', '11111111111', 'deneme1', 'deneme1', 'deneme1@deneme.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'deneme1 deneme1', '', 34, 15, '', '1', 0),
(181, '2025-05-12 10:09:21', '', '11111111111', 'deneme2', 'test', 'deneme2@deneme.com', '5555555555', 'e10adc3949ba59abbe56e057f20f883e', 'deneme2 test', '', 34, 14, '', '1', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lang`
--

CREATE TABLE `lang` (
  `lang_id` tinyint(3) UNSIGNED NOT NULL,
  `lang_code` char(2) NOT NULL DEFAULT '',
  `lang_name` char(16) NOT NULL DEFAULT '',
  `lang_status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Tablo döküm verisi `lang`
--

INSERT INTO `lang` (`lang_id`, `lang_code`, `lang_name`, `lang_status`) VALUES
(0, 'TR', 'Türkçe', 1),
(1, 'EN', 'English', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `marka`
--

CREATE TABLE `marka` (
  `marka_id` int(11) NOT NULL,
  `marka_adi` varchar(64) NOT NULL,
  `marka_url` varchar(256) NOT NULL,
  `marka_resim` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `marka`
--

INSERT INTO `marka` (`marka_id`, `marka_adi`, `marka_url`, `marka_resim`) VALUES
(1, 'Apple', 'marka/apple/index.html', 'images/uploads/brand_home_images66246122954703.png'),
(2, 'Samsung', 'marka/samsung/index.html', 'images/uploads/brand_home_sams25256014539482.png'),
(3, 'Xiaomi', 'marka/xiaomi/index.html', 'images/uploads/brand_home_Xiaomi-Logo46992443561462.png'),
(4, 'Huawei', 'marka/huawei/index.html', 'images/uploads/brand_home_huawei-logo11169931668161.png'),
(5, 'Oppo', 'marka/oppo/index.html', 'images/uploads/brand_home_oppo-green-logo-transparent-014889166232139.png'),
(6, 'LG', 'marka/lg/index.html', 'images/uploads/brand_home_800px-LG_logo_-2015.svg41150996311400.png'),
(7, 'Alcatel', 'marka/alcatel/index.html', 'images/uploads/brand_home_Alcatel-Logo24644224580307.png'),
(8, 'Philips', 'marka-philips', 'images/brand/68209c883e507_681e22c749eb9_garanti_bank_logo.jpg'),
(12, 'Nikon', 'marka-nikon', 'images/brand/68209ca888827_enpara_logo.jpg'),
(13, 'Arçelik', 'marka-arcelik', 'images/brand/68209ca888827_enpara_logo.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sehir`
--

CREATE TABLE `sehir` (
  `sehir_id` int(11) NOT NULL,
  `sehir_ad` varchar(50) NOT NULL,
  `sehir_kod` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `sehir`
--

INSERT INTO `sehir` (`sehir_id`, `sehir_ad`, `sehir_kod`) VALUES
(1, 'Adana', '01'),
(2, 'Adıyaman', '02'),
(3, 'Afyonkarahisar', '03'),
(4, 'Ağrı', '04'),
(5, 'Amasya', '05'),
(6, 'Ankara', '06'),
(7, 'Antalya', '07'),
(8, 'Artvin', '08'),
(9, 'Aydın', '09'),
(10, 'Balıkesir', '10'),
(11, 'Bilecik', '11'),
(12, 'Bingöl', '12'),
(13, 'Bitlis', '13'),
(14, 'Bolu', '14'),
(15, 'Burdur', '15'),
(16, 'Bursa', '16'),
(17, 'Çanakkale', '17'),
(18, 'Çankırı', '18'),
(19, 'Çorum', '19'),
(20, 'Denizli', '20'),
(21, 'Diyarbakır', '21'),
(22, 'Edirne', '22'),
(23, 'Elazığ', '23'),
(24, 'Erzincan', '24'),
(25, 'Erzurum', '25'),
(26, 'Eskişehir', '26'),
(27, 'Gaziantep', '27'),
(28, 'Giresun', '28'),
(29, 'Gümüşhane', '29'),
(30, 'Hakkari', '30'),
(31, 'Hatay', '31'),
(32, 'Isparta', '32'),
(33, 'Mersin', '33'),
(34, 'İstanbul', '34'),
(35, 'İzmir', '35'),
(36, 'Kars', '36'),
(37, 'Kastamonu', '37'),
(38, 'Kayseri', '38'),
(39, 'Kırklareli', '39'),
(40, 'Kırşehir', '40'),
(41, 'Kocaeli', '41'),
(42, 'Konya', '42'),
(43, 'Kütahya', '43'),
(44, 'Malatya', '44'),
(45, 'Manisa', '45'),
(46, 'Kahramanmaraş', '46'),
(47, 'Mardin', '47'),
(48, 'Muğla', '48'),
(49, 'Muş', '49'),
(50, 'Nevşehir', '50'),
(51, 'Niğde', '51'),
(52, 'Ordu', '52'),
(53, 'Rize', '53'),
(54, 'Sakarya', '54'),
(55, 'Samsun', '55'),
(56, 'Siirt', '56'),
(57, 'Sinop', '57'),
(58, 'Sivas', '58'),
(59, 'Tekirdağ', '59'),
(60, 'Tokat', '60'),
(61, 'Trabzon', '61'),
(62, 'Tunceli', '62'),
(63, 'Şanlıurfa', '63'),
(64, 'Uşak', '64'),
(65, 'Van', '65'),
(66, 'Yozgat', '66'),
(67, 'Zonguldak', '67'),
(68, 'Aksaray', '68'),
(69, 'Bayburt', '69'),
(70, 'Karaman', '70'),
(71, 'Kırıkkale', '71'),
(72, 'Batman', '72'),
(73, 'Şırnak', '73'),
(74, 'Bartın', '74'),
(75, 'Ardahan', '75'),
(76, 'Iğdır', '76'),
(77, 'Yalova', '77'),
(78, 'Karabük', '78'),
(79, 'Kilis', '79'),
(80, 'Osmaniye', '80'),
(81, 'Düzce', '81');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sepet`
--

CREATE TABLE `sepet` (
  `sepet_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_adet` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `sepet`
--

INSERT INTO `sepet` (`sepet_id`, `kullanici_id`, `urun_id`, `urun_adet`) VALUES
(39, 175, 17, 1),
(52, 0, 23, 3),
(47, 0, 15, 2),
(51, 0, 14, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis`
--

CREATE TABLE `siparis` (
  `siparis_id` int(11) NOT NULL,
  `siparis_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `siparis_no` varchar(16) DEFAULT NULL,
  `kullanici_id` int(11) NOT NULL,
  `siparis_toplam` float(9,2) NOT NULL,
  `siparis_tip` varchar(50) NOT NULL,
  `siparis_banka` varchar(50) NOT NULL,
  `siparis_odeme` enum('0','1') NOT NULL,
  `siparis_durum_id` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `siparis`
--

INSERT INTO `siparis` (`siparis_id`, `siparis_zaman`, `siparis_no`, `kullanici_id`, `siparis_toplam`, `siparis_tip`, `siparis_banka`, `siparis_odeme`, `siparis_durum_id`) VALUES
(75021, '2024-12-25 20:03:54', 'AU122575021', 176, 468.00, 'Banka Havalesi', 'GarantiBBVA', '0', 5),
(75020, '2024-12-25 20:05:35', 'AU122575020', 176, 46.00, 'Banka Havalesi', 'İş Bank', '0', 1),
(75022, '2025-05-12 10:47:35', '576954', 176, 16077.00, 'Kredi Kartı', 'TÜRKİYE İŞ BANKASI', '0', 1),
(75023, '2025-05-12 10:49:54', '555811', 176, 3555.00, 'Banka Havalesi', 'TÜRKİYE İŞ BANKASI', '0', 2),
(75024, '2025-05-12 11:01:15', '968663', 176, 7998.00, 'Kapıda Ödeme', 'TÜRKİYE İŞ BANKASI', '0', 1),
(75025, '2025-05-12 19:57:12', '210597', 168, 21000.00, 'Banka Havalesi', 'TÜRKİYE İŞ BANKASI', '0', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis_detay`
--

CREATE TABLE `siparis_detay` (
  `siparisdetay_id` int(11) NOT NULL,
  `siparis_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_fiyat` float(9,2) NOT NULL,
  `urun_adet` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `siparis_detay`
--

INSERT INTO `siparis_detay` (`siparisdetay_id`, `siparis_id`, `urun_id`, `urun_fiyat`, `urun_adet`) VALUES
(9, 75021, 14, 11950.64, 1),
(8, 75020, 15, 6522.00, 1),
(10, 75022, 18, 3555.00, 1),
(11, 75022, 15, 6522.00, 1),
(12, 75022, 17, 6000.00, 1),
(13, 75023, 18, 3555.00, 1),
(14, 75024, 23, 3999.00, 2),
(15, 75025, 21, 21000.00, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis_durumlari`
--

CREATE TABLE `siparis_durumlari` (
  `durum_id` int(11) NOT NULL,
  `durum_adi` varchar(50) NOT NULL,
  `durum_aciklama` text DEFAULT NULL,
  `durum_renk` varchar(20) DEFAULT NULL,
  `durum_sira` int(11) DEFAULT 0,
  `durum_aktif` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `siparis_durumlari`
--

INSERT INTO `siparis_durumlari` (`durum_id`, `durum_adi`, `durum_aciklama`, `durum_renk`, `durum_sira`, `durum_aktif`) VALUES
(1, 'Sipariş Alındı', 'Sipariş sisteme kaydedildi', 'warning', 1, 1),
(2, 'Onaylandı', 'Sipariş onaylandı', 'info', 2, 1),
(3, 'Hazırlanıyor', 'Ürünler hazırlanıyor', 'primary', 3, 1),
(4, 'Kargoda', 'Sipariş kargoya verildi', 'success', 4, 1),
(5, 'Tamamlandı', 'Sipariş teslim edildi', 'success', 5, 1),
(6, 'İptal Edildi', 'Sipariş iptal edildi', 'danger', 6, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sss`
--

CREATE TABLE `sss` (
  `sss_id` int(11) NOT NULL,
  `sss_tittle` varchar(256) NOT NULL,
  `sss_icerik` text NOT NULL,
  `sss_durum` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `sss`
--

INSERT INTO `sss` (`sss_id`, `sss_tittle`, `sss_icerik`, `sss_durum`) VALUES
(1, 'Deneme soru', 'Donec posuere vulputate arcu. Praesent ac sem eget est egestas volutpat. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Pellentesque dapibus hendrerit tortor. Suspendisse enim turpis, dictum sed, iaculis a, condimentum nec, nisi. Morbi mattis ullamcorper velit. Vestibulum fringilla pede sit amet augue. Sed lectus. Etiam vitae tortor.', '1'),
(2, 'Sorulacak soru başlığı', 'Donec posuere vulputate arcu. Praesent ac sem eget est egestas volutpat. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Pellentesque dapibus hendrerit tortor. Suspendisse enim turpis, dictum sed, iaculis a, condimentum nec, nisi. Morbi mattis ullamcorper velit. Vestibulum fringilla pede sit amet augue. Sed lectus. Etiam vitae tortor.', '1'),
(3, 'Sorulacak soru başlığı', 'Donec posuere vulputate arcu. Praesent ac sem eget est egestas volutpat. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Pellentesque dapibus hendrerit tortor. Suspendisse enim turpis, dictum sed, iaculis a, condimentum nec, nisi. Morbi mattis ullamcorper velit. Vestibulum fringilla pede sit amet augue. Sed lectus. Etiam vitae tortor.', '1'),
(4, 'Sık Sorulan Sorulardan Birisi', 'Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas malesuada. Curabitur turpis. Phasellus consectetuer vestibulum elit. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Etiam sit amet orci eget eros faucibus tincidunt. Nullam dictum felis eu pede mollis pretium. Cras ultricies mi eu turpis hendrerit fringilla. Donec mollis hendrerit risus. Etiam iaculis nunc ac metus. Vestibulum suscipit nulla quis orci. Quisque ut nisi. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Ut tincidunt tincidunt erat. Aenean viverra rhoncus pede. Etiam feugiat lorem non metus. Phasellus blandit leo ut odio. Phasellus accumsan cursus velit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque commodo eros a enim.', '1'),
(5, 'Sık Sorulan Sorulardan Birisi', 'Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas malesuada. Curabitur turpis. Phasellus consectetuer vestibulum elit. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Etiam sit amet orci eget eros faucibus tincidunt. Nullam dictum felis eu pede mollis pretium. Cras ultricies mi eu turpis hendrerit fringilla. Donec mollis hendrerit risus. Etiam iaculis nunc ac metus. Vestibulum suscipit nulla quis orci. Quisque ut nisi. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Ut tincidunt tincidunt erat. Aenean viverra rhoncus pede. Etiam feugiat lorem non metus. Phasellus blandit leo ut odio. Phasellus accumsan cursus velit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque commodo eros a enim.', '1'),
(6, 'Deneme soru222', 'deneme içerik 222', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tabli_vitrin`
--

CREATE TABLE `tabli_vitrin` (
  `id` int(11) NOT NULL,
  `ad` varchar(255) NOT NULL,
  `sira` int(11) NOT NULL DEFAULT 0,
  `durum` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tabli_vitrin`
--

INSERT INTO `tabli_vitrin` (`id`, `ad`, `sira`, `durum`) VALUES
(7, 'Tablı Vitrin', 0, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tabli_vitrin_items`
--

CREATE TABLE `tabli_vitrin_items` (
  `id` int(11) NOT NULL,
  `tabli_vitrin_id` int(10) UNSIGNED NOT NULL,
  `vitrin_id` int(10) UNSIGNED NOT NULL,
  `sira` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tabli_vitrin_items`
--

INSERT INTO `tabli_vitrin_items` (`id`, `tabli_vitrin_id`, `vitrin_id`, `sira`) VALUES
(1, 77, 72, 1),
(2, 77, 84, 2),
(3, 77, 75, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tabli_vitrin_sekme`
--

CREATE TABLE `tabli_vitrin_sekme` (
  `id` int(11) NOT NULL,
  `tabli_vitrin_id` int(11) NOT NULL,
  `vitrin_id` int(10) UNSIGNED NOT NULL,
  `sira` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tabli_vitrin_sekme`
--

INSERT INTO `tabli_vitrin_sekme` (`id`, `tabli_vitrin_id`, `vitrin_id`, `sira`) VALUES
(5, 7, 77, 1),
(6, 7, 83, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun`
--

CREATE TABLE `urun` (
  `urun_id` int(11) UNSIGNED NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `urun_kodu` varchar(64) NOT NULL,
  `urun_barkodu` varchar(16) DEFAULT NULL,
  `urun_marka` varchar(64) NOT NULL,
  `urun_adi` varchar(250) NOT NULL,
  `urun_seourl` varchar(250) NOT NULL,
  `urun_aciklama` text NOT NULL,
  `urun_piyasafiyati` decimal(16,2) NOT NULL,
  `urun_satisfiyati` decimal(16,2) NOT NULL,
  `urun_kdvorani` int(11) NOT NULL DEFAULT 20,
  `urun_kdvdahil` enum('0','1') DEFAULT NULL,
  `urun_doviz` varchar(8) NOT NULL,
  `urun_keyword` varchar(250) NOT NULL,
  `urun_stok` int(11) NOT NULL,
  `urun_durum` enum('0','1') NOT NULL DEFAULT '1',
  `urun_onecikar` enum('0','1') NOT NULL DEFAULT '0',
  `urun_resim1` varchar(256) NOT NULL,
  `urun_resim2` varchar(256) NOT NULL,
  `urun_resim3` varchar(256) NOT NULL,
  `urun_resim4` varchar(256) NOT NULL,
  `urun_resim5` varchar(256) NOT NULL,
  `urun_resim6` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urun`
--

INSERT INTO `urun` (`urun_id`, `kategori_id`, `urun_kodu`, `urun_barkodu`, `urun_marka`, `urun_adi`, `urun_seourl`, `urun_aciklama`, `urun_piyasafiyati`, `urun_satisfiyati`, `urun_kdvorani`, `urun_kdvdahil`, `urun_doviz`, `urun_keyword`, `urun_stok`, `urun_durum`, `urun_onecikar`, `urun_resim1`, `urun_resim2`, `urun_resim3`, `urun_resim4`, `urun_resim5`, `urun_resim6`) VALUES
(14, 13, '578', NULL, 'Samsung', 'Samsung Galaxy Note20 Ultra Black Akıllı Telefon', 'samsung-galaxy-note20-ultra-black-akilli-telefon-P578.html', '', 0.00, 11950.64, 20, '1', 'TL', 'telefon', 45, '1', '0', 'images/product/product_4_3_Teaser_Samsung_Galaxy_Note20_Ultra_5G_SM-N986B_MysticWhite93667403037717.jpg', '', '', '', '', ''),
(15, 17, '579', NULL, 'Samsung', 'Galaxy Tab S7+ WiFi', 'galaxy-tab-s7-wifi-P579.html', '', 0.00, 6522.00, 20, '1', 'TL', 'tablet', 150, '1', '0', 'images/product/579_1.jpg', 'images/product/579_2.jpg', 'images/product/579_3.jpg', 'images/product/579_4.jpg', 'images/product/579_5.jpg', 'images/product/579_6.jpg'),
(16, 17, '580', NULL, 'Samsung', 'Galaxy Tab S6 Lite', 'galaxy-tab-s6-lite-P580.html', '', 0.00, 18000.00, 20, '1', 'TL', 'tablet', 0, '1', '0', 'images/product/product_ff5097a7-a8ca-42eb-89ab-bb1d60c55c6836564025580872.jpg', '', '', '', '', ''),
(17, 18, '583', NULL, 'Nikon', 'Nikon D5600 AF-P 18-55 MM VR Fotoğraf Makinesi (Nikon Türkiye Garantili)', 'nikon-d5600-af-p-18-55-mm-vr-fotograf-makinesi-nikon-turkiye-garantili-P583.html', '', 0.00, 6000.00, 20, '1', 'TL', '', 341, '1', '0', 'images/product/product_9089771851075726935335.webp', '', '', '', '', ''),
(18, 23, '581', NULL, 'Arçelik', 'Arçelik 570430 MI No Frost Buzdolabı', 'arcelik-570430-mi-no-frost-buzdolabi-P581.html', '', 0.00, 3555.00, 20, '1', 'TL', '', 682, '1', '0', 'images/product/product_arcelik-570430-mi-no-frost-buzdolabi65897186380469.webp', '', '', '', '', ''),
(19, 13, '575', NULL, 'Samsung', 'Galaxy Note10', 'galaxy-note10-P575.html', '', 9500.00, 6099.00, 20, '1', 'TL', '', 41, '1', '0', 'images/product/575_1.jpg', 'images/product/575_2.jpg', 'images/product/575_3.jpg', 'images/product/575_4.jpg', 'images/product/575_5.jpg', 'images/product/575_6.jpg'),
(20, 16, '577', NULL, 'Apple', 'Apple iPad Pro 12.9 inç Wi-Fi Tablet', 'apple-ipad-pro-129-inc-wi-fi-tablet-P577.html', '', 0.00, 8999.00, 20, '1', 'TL', '', 65, '1', '0', 'images/product/product_641265749_052016137978483.jpg', '', '', '', '', ''),
(21, 12, '576', '', 'Apple', 'iPhone 12 Pro 256 GB', 'iphone-12-pro-256-gb-P576.html', '', 25000.00, 21000.00, 20, '1', 'TL', '', 19, '1', '0', 'images/product/576_1.jpg', 'images/product/576_2.jpg', 'images/product/576_3.jpg', 'images/product/576_4.jpg', 'images/product/576_5.jpg', 'images/product/576_6.jpg'),
(22, 12, '574', NULL, 'Apple', 'iPhone 12 Mini', 'iphone-12-mini-P574.html', '', 11220.00, 9999.00, 20, '1', 'TL', '', 9, '1', '0', 'images/product/574_1.jpg', 'images/product/574_2.jpg', 'images/product/574_3.jpg', 'images/product/574_4.jpg', 'images/product/574_5.jpg', 'images/product/574_6.jpg'),
(23, 18, '582', NULL, 'Philips', 'Philips 50 PUS 8505/62 ONE 4K UHD Televizyon', 'philips-50-pus-8505-62-one-4k-uhd-televizyon', '<p>cdcsd</p>\r\n', 0.00, 3999.00, 20, '1', 'TL', 'dcdsc', 514, '1', '0', 'images/product/product_43PUS7505_62-IMS-tr_TR75493573248247.webp', '', '', '', '', ''),
(29, 14, 'TEST', 'sfdcsd', 'Apple', 'Deneme2', '', 'vfftgrfds', 700.00, 500.00, 20, '1', 'TL', 'testttttttttttttttt', 1, '1', '0', 'images/product/2074023728deneme.jpg', 'images/product/2841221265dikkat.jpg', 'images/product/681d2c3b96247_cok-yakinda-satista.png', 'images/product/2344130383amex.png', 'images/product/681d2c3b96643_projesoft-logo.png', 'images/product/2493730284ucretsizkargo.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_filtreleri`
--

CREATE TABLE `urun_filtreleri` (
  `id` int(11) NOT NULL,
  `filtre_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `filtre_urun_sira` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urun_filtreleri`
--

INSERT INTO `urun_filtreleri` (`id`, `filtre_id`, `urun_id`, `filtre_urun_sira`) VALUES
(1, 1, 16, 0),
(2, 1, 17, 0),
(4, 2, 22, 0),
(5, 2, 18, 0),
(6, 2, 0, 19),
(7, 3, 14, 0),
(8, 3, 16, 0),
(9, 3, 15, 0),
(11, 4, 22, 0),
(12, 4, 18, 0),
(13, 5, 19, 0),
(14, 6, 23, 0),
(15, 6, 24, 0),
(16, 6, 26, 0),
(17, 6, 25, 0),
(18, 6, 18, 0),
(19, 7, 15, 0),
(20, 7, 16, 0),
(24, 3, 21, 0),
(25, 5, 21, 0),
(30, 7, 30, 0),
(31, 4, 30, 0),
(32, 7, 31, 0),
(33, 4, 31, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vitrin`
--

CREATE TABLE `vitrin` (
  `vitrin_id` int(10) UNSIGNED NOT NULL,
  `vitrin_adi` char(64) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL DEFAULT '',
  `vitrin_aciklama` varchar(256) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `vitrin_durum` tinyint(3) UNSIGNED DEFAULT 1,
  `vitrin_adi_gorunurluk_durum` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `vitrin_sira` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `vitrin_urun_listeleme_limit` int(10) UNSIGNED NOT NULL,
  `vitrin_dizayn` char(32) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Tablo döküm verisi `vitrin`
--

INSERT INTO `vitrin` (`vitrin_id`, `vitrin_adi`, `vitrin_aciklama`, `vitrin_durum`, `vitrin_adi_gorunurluk_durum`, `vitrin_sira`, `vitrin_urun_listeleme_limit`, `vitrin_dizayn`) VALUES
(72, 'Anasayfa Banner Slider', '', 1, 1, 0, 20, 'slider_display1'),
(73, 'Üçlü Banner', '', 1, 0, 0, 0, 'uclu_banner'),
(74, 'Banner Slider', '', 1, 0, 0, 0, 'banner_slider'),
(75, 'ELEKTRONİK ÜRÜNLER', 'Evinize en ideal ürünleri bir araya topladık', 1, 1, 0, 20, 'vitrin_urun_slider'),
(76, 'ÖNEMLİ FIRSATLAR', 'Son teknoloji ile ürtelilmiş en yeni akıllı ürünlerde indirim fırsatı', 1, 0, 0, 0, 'firsat_vitrin_banner'),
(77, 'YENİ GELENLER', 'yeni', 1, 0, 1, 0, 'tabli_vitrin'),
(78, 'ÇOK İNCELENENLER', 'populer', 1, 0, 2, 0, 'tabli_vitrin'),
(79, 'İNDİRİMDEKİ ÜRÜNLER', 'indirimli', 1, 0, 3, 0, 'tabli_vitrin'),
(80, 'FIRSAT ÜRÜNLERİ', 'firsat', 1, 0, 4, 0, 'tabli_vitrin'),
(81, 'EDİTÖRÜN SEÇİMİ', 'editor', 1, 0, 5, 0, 'tabli_vitrin'),
(82, 'ÜCRETSİZ KARGO', 'bedavakargo', 1, 0, 6, 0, 'tabli_vitrin'),
(83, 'HIZLI GÖNDERİ', 'hizlikargo', 1, 0, 7, 0, 'tabli_vitrin'),
(84, 'MARKALAR', 'Markalar', 1, 0, 0, 0, 'markalar'),
(85, 'Test Markalar', '', 1, 0, 0, 20, 'uclu_banner');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vitrin_resimleri`
--

CREATE TABLE `vitrin_resimleri` (
  `vitrin_resim_id` int(10) UNSIGNED NOT NULL,
  `vitrin_id` int(10) UNSIGNED DEFAULT NULL,
  `lang_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `vitrin_resim` varchar(255) DEFAULT NULL,
  `vitrin_resim2` varchar(255) DEFAULT NULL,
  `vitrin_resim_sira` int(11) DEFAULT 0,
  `vitrin_resim_url` varchar(255) DEFAULT NULL,
  `vitrin_resim_adi` varchar(255) DEFAULT NULL,
  `vitrin_resim_aciklama` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Tablo döküm verisi `vitrin_resimleri`
--

INSERT INTO `vitrin_resimleri` (`vitrin_resim_id`, `vitrin_id`, `lang_id`, `vitrin_resim`, `vitrin_resim2`, `vitrin_resim_sira`, `vitrin_resim_url`, `vitrin_resim_adi`, `vitrin_resim_aciklama`) VALUES
(1, 72, 0, 'images/slider/slider_ezgif-3-9f22fecf9d4076278430852731.webp', NULL, 1, NULL, NULL, NULL),
(2, 72, 0, 'images/slider/slider_ezgif-3-354ac9ed39bc72545443696299.webp', NULL, 2, NULL, NULL, NULL),
(3, 72, 0, 'images/slider/slider_ezgif-3-7f04ca087e2763262463645454.webp', NULL, 3, NULL, NULL, NULL),
(4, 72, 0, 'images/slider/slider_ezgif-3-7fc02837a35593731727631526.webp', NULL, 4, NULL, NULL, NULL),
(5, 73, 0, 'images/uploads/banner1_banner1_154326182588598-min82474144944266.png', NULL, 1, NULL, NULL, NULL),
(6, 73, 0, 'images/uploads/banner1_banner1_22214883123897-min47731251279637.png', NULL, 2, NULL, NULL, NULL),
(7, 73, 0, 'images/uploads/banner1_ezgif-3-1b4587da644a18936820450753.webp', NULL, 3, NULL, NULL, NULL),
(8, 74, 0, 'images/slider/slider_ezgif-3-21d24de173cf84333554027340.webp', 'images/slider/slider_a8760778350524.jpg', 1, NULL, NULL, NULL),
(9, 74, 0, 'images/slider/slider_ezgif-3-dbbf64f07c7a83023821929363.webp', 'images/slider/slider_b11343608098340.jpg', 1, NULL, NULL, NULL),
(10, 74, 0, 'images/slider/slider_ezgif-3-9104b77440a473152219750341.webp', 'images/slider/slider_ezgif-3-9104b77440a473152219750341.webp', 3, NULL, NULL, NULL),
(11, 76, 0, 'images/uploads/banner_c30598118564791.png', NULL, 1, NULL, NULL, NULL),
(12, 84, 0, 'images/uploads/brand_home_images66246122954703.png', NULL, 0, NULL, 'Apple', 'Apple'),
(13, 84, 0, 'images/uploads/brand_home_sams25256014539482.png', NULL, 0, NULL, 'Samsung', 'Samsung'),
(14, 84, 0, 'images/uploads/brand_home_Xiaomi-Logo46992443561462.png', NULL, 0, NULL, 'Xiaomi', 'Xiaomi'),
(15, 84, 0, 'images/uploads/brand_home_huawei-logo11169931668161.png', NULL, 0, NULL, 'Huawei', 'Huawei'),
(16, 84, 0, 'images/uploads/brand_home_oppo-green-logo-transparent-014889166232139.png', NULL, 0, NULL, 'Oppo', 'Oppo'),
(17, 84, 0, 'images/uploads/brand_home_800px-LG_logo_-2015.svg41150996311400.png', NULL, 0, NULL, 'LG', 'LG'),
(18, 84, 0, 'images/uploads/brand_home_Alcatel-Logo24644224580307.png', NULL, 0, 'alcatel', 'Alcatel', 'Alcatel'),
(47, 85, 0, 'images/vitrin/681fd035c7f40_681e22c749eb9_garanti_bank_logo.jpg', NULL, 0, NULL, NULL, NULL),
(48, 85, 0, 'images/vitrin/681fd0dad9567_681e21cf958f3_paytr-uai-258x116.png', NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vitrin_urun`
--

CREATE TABLE `vitrin_urun` (
  `vitrin_id` int(10) UNSIGNED NOT NULL,
  `urun_id` int(11) UNSIGNED NOT NULL,
  `vitrin_urun_sira` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Tablo döküm verisi `vitrin_urun`
--

INSERT INTO `vitrin_urun` (`vitrin_id`, `urun_id`, `vitrin_urun_sira`) VALUES
(72, 20, NULL),
(75, 14, 1),
(75, 15, 2),
(75, 16, 3),
(75, 17, 4),
(75, 18, 5),
(75, 19, 6),
(76, 14, 3),
(76, 15, 2),
(76, 16, 6),
(76, 18, NULL),
(76, 20, 1),
(76, 21, 4),
(76, 22, 5),
(76, 23, NULL),
(77, 14, 6),
(77, 15, 5),
(77, 16, 4),
(77, 17, 1),
(77, 18, 3),
(77, 19, 9),
(77, 20, 7),
(77, 21, 8),
(77, 22, 10),
(77, 23, 2),
(78, 14, 9),
(78, 15, 7),
(78, 16, 6),
(78, 17, 4),
(78, 18, NULL),
(78, 19, 5),
(78, 21, 3),
(78, 22, 8),
(78, 23, 2),
(79, 19, NULL),
(79, 22, 1),
(80, 14, 6),
(80, 15, 5),
(80, 16, 4),
(80, 17, 1),
(80, 18, 3),
(80, 19, 9),
(80, 20, 7),
(80, 21, 8),
(80, 22, 10),
(80, 23, 2),
(81, 17, 1),
(81, 20, 2),
(81, 22, 3),
(82, 14, 6),
(82, 15, 5),
(82, 16, 4),
(82, 17, 1),
(82, 18, 3),
(82, 19, 9),
(82, 20, 7),
(82, 21, 8),
(82, 22, 10),
(82, 23, 2),
(83, 14, 2),
(83, 21, 3),
(83, 22, 4),
(83, 23, 1),
(84, 16, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `yorum_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `yorum_onay` enum('0','1') NOT NULL DEFAULT '0',
  `yorum_detay` text NOT NULL,
  `yorum_puan` enum('1','2','3','4','5') NOT NULL,
  `yorum_type` varchar(64) NOT NULL,
  `yorum_zaman` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`yorum_id`, `kullanici_id`, `urun_id`, `yorum_onay`, `yorum_detay`, `yorum_puan`, `yorum_type`, `yorum_zaman`) VALUES
(51, 176, 21, '0', 'Bu ürüne bayıldım. Harikaa !!', '1', '', '2025-05-12 03:49:06'),
(39, 168, 17, '1', 'htrghs', '1', '', '2024-12-17 13:26:11'),
(40, 168, 18, '1', 'dsadas', '1', '', '2024-12-17 13:35:20'),
(38, 168, 15, '1', 'hgfhf', '1', '', '2024-11-14 16:08:21'),
(42, 168, 19, '1', 'aaaaaaaaaaaaaaaaa', '1', '', '2024-11-14 16:08:21'),
(44, 41, 0, '0', 'Web siteniz inanılmaz hızlı yükleniyor, bu da kullanıcı deneyimini olumlu etkiliyor. Sayfalar arasında geçiş yapmak çok kolay ve akıcı. Ziyaretçilerin zaman kaybetmeden içeriklere ulaşabilmesi büyük bir avantaj.', '5', 'website', '2024-11-26 00:06:23'),
(45, 169, 0, '0', 'Sitenizin tasarımı oldukça modern ve şık. Kullanıcı dostu bir arayüz sunuyor, bu da ziyaretçilerin aradıklarını kolayca bulmalarını sağlıyor. Renk uyumu ve yazı tipleri gözü yormuyor, aksine profesyonel bir hava katıyor.', '3', 'website', '2024-11-26 00:35:31'),
(46, 170, 0, '0', 'Siteniz mobil cihazlarda da kusursuz çalışıyor. Menülerin kolay erişilebilir olması ve tüm içeriklerin düzgün görünmesi, kullanıcıların her yerden rahatça erişmesini sağlıyor.', '4', 'website', '2024-11-26 00:36:16'),
(47, 147, 0, '0', 'Web sitenizdeki içerikler hem bilgilendirici hem de ilgi çekici. Görseller yüksek kaliteli, yazılar anlaşılır ve profesyonelce hazırlanmış. Ziyaretçileri sitenizde daha uzun süre tutacak kadar etkileyici!', '5', 'website', '2024-12-20 00:36:35'),
(48, 171, 0, '1', 'Siteniz, güvenlik açısından oldukça profesyonel görünüyor. Gerek iletişim bölümü gerekse gizlilik politikası detaylı hazırlanmış, bu da kullanıcılar için ekstra bir güven sağlıyor.', '5', 'website', '2024-12-20 00:37:08'),
(49, 172, 0, '1', 'Siteniz ziyaretçileri ilk bakışta etkiliyor. Anasayfanın düzeni ve kullanılan görseller, profesyonel ve özenli bir çalışma olduğunu hissettiriyor. Ziyaretçileri kendine çeken bir yapıya sahip.', '4', 'website', '2024-12-20 00:37:29'),
(50, 174, 21, '0', 'Why do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '3', 'website', '2025-01-04 23:15:06'),
(52, 176, 21, '0', 'Çok hızlı elime ulaştı. Teşekkürler', '1', '', '2025-05-12 03:57:19'),
(53, 176, 21, '0', 'Deneme deneme yorum', '5', '', '2025-05-12 05:22:33'),
(54, 176, 21, '0', 'test test', '4', '', '2025-05-12 05:22:48'),
(55, 176, 21, '0', 'test deneme', '2', '', '2025-05-12 05:23:15');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ayar`
--
ALTER TABLE `ayar`
  ADD PRIMARY KEY (`ayar_id`);

--
-- Tablo için indeksler `banka_hesaplari`
--
ALTER TABLE `banka_hesaplari`
  ADD PRIMARY KEY (`banka_id`);

--
-- Tablo için indeksler `banka_pos`
--
ALTER TABLE `banka_pos`
  ADD PRIMARY KEY (`bankapos_id`);

--
-- Tablo için indeksler `favoriler`
--
ALTER TABLE `favoriler`
  ADD PRIMARY KEY (`favori_id`),
  ADD UNIQUE KEY `kullanici_id` (`kullanici_id`,`urun_id`);

--
-- Tablo için indeksler `filtre_sablonu`
--
ALTER TABLE `filtre_sablonu`
  ADD PRIMARY KEY (`filtre_id`);

--
-- Tablo için indeksler `icerikler`
--
ALTER TABLE `icerikler`
  ADD PRIMARY KEY (`icerik_id`);

--
-- Tablo için indeksler `ilceler`
--
ALTER TABLE `ilceler`
  ADD PRIMARY KEY (`ilce_id`),
  ADD KEY `sehir_id` (`sehir_id`);

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Tablo için indeksler `lang`
--
ALTER TABLE `lang`
  ADD PRIMARY KEY (`lang_id`) USING BTREE;

--
-- Tablo için indeksler `marka`
--
ALTER TABLE `marka`
  ADD PRIMARY KEY (`marka_id`);

--
-- Tablo için indeksler `sehir`
--
ALTER TABLE `sehir`
  ADD PRIMARY KEY (`sehir_id`);

--
-- Tablo için indeksler `sepet`
--
ALTER TABLE `sepet`
  ADD PRIMARY KEY (`sepet_id`),
  ADD UNIQUE KEY `sepet_id` (`sepet_id`);

--
-- Tablo için indeksler `siparis`
--
ALTER TABLE `siparis`
  ADD PRIMARY KEY (`siparis_id`),
  ADD UNIQUE KEY `siparis_id` (`siparis_id`);

--
-- Tablo için indeksler `siparis_detay`
--
ALTER TABLE `siparis_detay`
  ADD PRIMARY KEY (`siparisdetay_id`),
  ADD UNIQUE KEY `siparis_detay_id` (`siparisdetay_id`);

--
-- Tablo için indeksler `siparis_durumlari`
--
ALTER TABLE `siparis_durumlari`
  ADD PRIMARY KEY (`durum_id`);

--
-- Tablo için indeksler `sss`
--
ALTER TABLE `sss`
  ADD PRIMARY KEY (`sss_id`);

--
-- Tablo için indeksler `tabli_vitrin`
--
ALTER TABLE `tabli_vitrin`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tabli_vitrin_items`
--
ALTER TABLE `tabli_vitrin_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tabli_vitrin_id` (`tabli_vitrin_id`),
  ADD KEY `vitrin_id` (`vitrin_id`);

--
-- Tablo için indeksler `tabli_vitrin_sekme`
--
ALTER TABLE `tabli_vitrin_sekme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tabli_vitrin_id` (`tabli_vitrin_id`),
  ADD KEY `vitrin_id` (`vitrin_id`);

--
-- Tablo için indeksler `urun`
--
ALTER TABLE `urun`
  ADD PRIMARY KEY (`urun_id`);

--
-- Tablo için indeksler `urun_filtreleri`
--
ALTER TABLE `urun_filtreleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `vitrin`
--
ALTER TABLE `vitrin`
  ADD PRIMARY KEY (`vitrin_id`) USING BTREE;

--
-- Tablo için indeksler `vitrin_resimleri`
--
ALTER TABLE `vitrin_resimleri`
  ADD PRIMARY KEY (`vitrin_resim_id`) USING BTREE,
  ADD KEY `FK_vitrin_resim_did` (`vitrin_id`),
  ADD KEY `FK_vitrin_resim_lang_did` (`lang_id`);

--
-- Tablo için indeksler `vitrin_urun`
--
ALTER TABLE `vitrin_urun`
  ADD PRIMARY KEY (`vitrin_id`,`urun_id`) USING BTREE,
  ADD KEY `urun_id9` (`urun_id`) USING BTREE;

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`yorum_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `banka_hesaplari`
--
ALTER TABLE `banka_hesaplari`
  MODIFY `banka_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `banka_pos`
--
ALTER TABLE `banka_pos`
  MODIFY `bankapos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `favoriler`
--
ALTER TABLE `favoriler`
  MODIFY `favori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Tablo için AUTO_INCREMENT değeri `filtre_sablonu`
--
ALTER TABLE `filtre_sablonu`
  MODIFY `filtre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `icerikler`
--
ALTER TABLE `icerikler`
  MODIFY `icerik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `ilceler`
--
ALTER TABLE `ilceler`
  MODIFY `ilce_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- Tablo için AUTO_INCREMENT değeri `marka`
--
ALTER TABLE `marka`
  MODIFY `marka_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `sehir`
--
ALTER TABLE `sehir`
  MODIFY `sehir_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Tablo için AUTO_INCREMENT değeri `sepet`
--
ALTER TABLE `sepet`
  MODIFY `sepet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Tablo için AUTO_INCREMENT değeri `siparis`
--
ALTER TABLE `siparis`
  MODIFY `siparis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75026;

--
-- Tablo için AUTO_INCREMENT değeri `siparis_detay`
--
ALTER TABLE `siparis_detay`
  MODIFY `siparisdetay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `siparis_durumlari`
--
ALTER TABLE `siparis_durumlari`
  MODIFY `durum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `sss`
--
ALTER TABLE `sss`
  MODIFY `sss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `tabli_vitrin`
--
ALTER TABLE `tabli_vitrin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `tabli_vitrin_items`
--
ALTER TABLE `tabli_vitrin_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `tabli_vitrin_sekme`
--
ALTER TABLE `tabli_vitrin_sekme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `urun`
--
ALTER TABLE `urun`
  MODIFY `urun_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `urun_filtreleri`
--
ALTER TABLE `urun_filtreleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `vitrin`
--
ALTER TABLE `vitrin`
  MODIFY `vitrin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Tablo için AUTO_INCREMENT değeri `vitrin_resimleri`
--
ALTER TABLE `vitrin_resimleri`
  MODIFY `vitrin_resim_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `yorum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `tabli_vitrin_items`
--
ALTER TABLE `tabli_vitrin_items`
  ADD CONSTRAINT `tabli_vitrin_items_ibfk_1` FOREIGN KEY (`tabli_vitrin_id`) REFERENCES `vitrin` (`vitrin_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tabli_vitrin_items_ibfk_2` FOREIGN KEY (`vitrin_id`) REFERENCES `vitrin` (`vitrin_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `tabli_vitrin_sekme`
--
ALTER TABLE `tabli_vitrin_sekme`
  ADD CONSTRAINT `tabli_vitrin_sekme_ibfk_1` FOREIGN KEY (`tabli_vitrin_id`) REFERENCES `tabli_vitrin` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tabli_vitrin_sekme_ibfk_2` FOREIGN KEY (`vitrin_id`) REFERENCES `vitrin` (`vitrin_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `vitrin_resimleri`
--
ALTER TABLE `vitrin_resimleri`
  ADD CONSTRAINT `FK_vitrin_resim_did` FOREIGN KEY (`vitrin_id`) REFERENCES `vitrin` (`vitrin_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_vitrin_resim_lang_did` FOREIGN KEY (`lang_id`) REFERENCES `lang` (`lang_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `vitrin_urun`
--
ALTER TABLE `vitrin_urun`
  ADD CONSTRAINT `vitrin_urun_ibfk_1` FOREIGN KEY (`vitrin_id`) REFERENCES `vitrin` (`vitrin_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vitrin_urun_ibfk_2` FOREIGN KEY (`urun_id`) REFERENCES `urun` (`urun_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
