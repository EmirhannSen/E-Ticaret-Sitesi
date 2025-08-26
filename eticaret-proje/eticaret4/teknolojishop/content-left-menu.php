
 <!-- Mobile Nav Bar !-->
<div class="mb-3 w-100 subpage-nav-mobile-main">
            <a class="subpage-nav-mobile-toggle  " data-toggle="collapse" data-target="#naviAccordion" aria-expanded="false" aria-controls="collapseForm"> + Navigasyonu Göster </a>
            <div id="accordion" class="accordion">
                <div class="collapse" id="naviAccordion" data-parent="#accordion">
                    <div class="subpage-mobile-nav mt-2">
                        <div class="subpage_navigation" style="font-family : 'Open Sans',Sans-serif ;">
                            <div class="subpage_navigation-box">
                                <a class="subpage_navigation_header">
                                    <i class="las la-copy"></i> Sayfalar </a>
                                <a class="subpage_navigation_a" href="content-hakkimizda" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> Hakkımızda </a>
                                <a class="subpage_navigation_a" href="musteri_yorumlari.php" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> Müşterilerimizin Yorumları </a>
                                <a class="subpage_navigation_a" href="sss.php" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> Sık Sorulan Sorular </a>
                                <a class="subpage_navigation_a" href="banka-hesaplarimiz.php" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> Hesap Numaralarımız </a>
                                <a class="subpage_navigation_a" href="iletisim.php" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> İletişim </a>
                            </div>
                            <div class="subpage_navigation-box">
                                <a class="subpage_navigation_header">
                                    <i class="las la-pencil-alt"></i> Sözleşmeler </a>
                                <a class="subpage_navigation_a" href="content-mesafeli_satis_sozlesmesi" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> Mesafeli Satış Sözleşmesi </a>
                                <a class="subpage_navigation_a" href="content-kullanici_sozlesmesi" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> Kullanıcı Sözleşmesi </a>
                                <a class="subpage_navigation_a" href="content-uyelik_sozlesmesi" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> Üyelik Sözleşmesi </a>

                            </div>
                            <div class="subpage_navigation-box">
                                <a class="subpage_navigation_header">
                                    <i class="fa fa-info-circle"></i> Bilgilendirmeler </a>
                                <a class="subpage_navigation_a" href="content-iptal_ve_iade_kosullari" /*target="_blank"*/>
                                    <i class="las la-angle-double-right"></i> İptal ve İade Koşulları </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(function() {
                $('#naviAccordion').on('shown.bs.collapse', function(e) {
                    $('html,body').animate({
                        scrollTop: $('#naviAccordion').offset().top - 80
                    }, 500);
                });
            });
        </script>
        <!--  <========SON=========>>> Mobile Nav Bar SON !-->


          <div class="subpage-nav-desktop">
            <div class="subpage_navigation" style="font-family : 'Open Sans',Sans-serif ;">
                <div class="subpage_navigation-box">
                    <a class="subpage_navigation_header">
                        <i class="las la-copy"></i> Sayfalar </a>
                    <a class="subpage_navigation_a" href="content-hakkimizda" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> Hakkımızda </a>
                    <a class="subpage_navigation_a" href="musteri_yorumlari.php" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> Müşterilerimizin Yorumları </a>
                    <a class="subpage_navigation_a" href="sss.php" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> Sık Sorulan Sorular </a>
                    <a class="subpage_navigation_a" href="banka-hesaplarimiz.php" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> Hesap Numaralarımız </a>
                    <a class="subpage_navigation_a" href="iletisim.php" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> İletişim </a>
                </div>
                <div class="subpage_navigation-box">
                    <a class="subpage_navigation_header">
                        <i class="las la-pencil-alt"></i> Sözleşmeler </a>
                    <a class="subpage_navigation_a" href="content-mesafeli_satis_sozlesmesi" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> Mesafeli Satış Sözleşmesi </a>
                    <a class="subpage_navigation_a" href="content-kullanici_sozlesmesi" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> Kullanıcı Sözleşmesi </a>
                    <a class="subpage_navigation_a" href="content-uyelik_sozlesmesi" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> Üyelik Sözleşmesi </a>
                    <a class="subpage_navigation_a" href="content-iptal_ve_iade_kosullari" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> İptal ve İade Koşulları </a>
                </div>
                <div class="subpage_navigation-box">
                    <a class="subpage_navigation_header">
                        <i class="fa fa-info-circle"></i> Bilgilendirmeler </a>
                    <a class="subpage_navigation_a" href="content-iptal_ve_iade_kosullari" /*target="_blank"*/>
                        <i class="las la-angle-double-right"></i> İptal ve İade Koşulları </a>
                </div>
            </div>
        </div>