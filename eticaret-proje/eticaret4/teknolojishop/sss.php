<?php 

include 'settings/baglan.php';

include 'header.php'; 

$sssicerikSor=$db->prepare("SELECT * FROM sss where sss_durum='1'");
$sssicerikSor->execute();
//$sssicerikCek=$sssicerikSor->fetch(PDO::FETCH_ASSOC);


?>
       
          <link rel="stylesheet" href="assets/css/content.css" rel="preload">

            <div id="MainDiv" style="background-color: #f3f6f9; width: 100%;  overflow: hidden  ">
              <div class="page-banner-main">
                <div class="page-banner-in-text">
                  <div class="page-banner-h "> Sık Sorulan Sorular </div>
                  <div class="page-banner-links ">
                    <a href="index.php">
                      <i class="fa fa-home"></i> Anasayfa </a>
                    <span>/</span>
                    <a> Sık Sorulan Sorular </a>
                  </div>
                </div>
                <div style="background: rgba(0,0,0,0.3); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
              </div>


              <!-- <div class="sss-faq-container-main"> -->
                <div class="htmlpage-container-main">
    
 <?php include 'content-left-menu.php'; ?>

                <div class="sss-box-main-div accordion_main js-accordion">
 <?php while ($sssicerikCek=$sssicerikSor->fetch(PDO::FETCH_ASSOC)) {  ?>
                  <div class="accordion__item js-accordion-item active ">
                    <div class="accordion-header js-accordion-header"> <?php echo $sssicerikCek['sss_tittle'] ?> </div>
                    <div class="accordion-body js-accordion-body">
                      <div class="accordion-body__contents">
                        <div class="sss-content-txt"> <?php echo $sssicerikCek['sss_icerik'] ?> </div>
                      </div>
                    </div>
                  </div>
<?php } ?>
                </div>


               </div> 
            </div>
          
           
          
          
        <script id="rendered-js">
          var accordion = function() {
            var $accordion = $('.js-accordion');
            var $accordion_header = $accordion.find('.js-accordion-header');
            var $accordion_item = $('.js-accordion-item');
            var settings = {
              speed: 300,
              oneOpen: false
            };
            return {
              // pass configurable object literal
              init: function($settings) {
                $accordion_header.on('click', function() {
                  accordion.toggle($(this));
                });
                $.extend(settings, $settings);
                // ensure only one accordion is active if oneOpen is true
                if (settings.oneOpen && $('.js-accordion-item.active').length > 1) {
                  $('.js-accordion-item.active:not(:first)').removeClass('active');
                }
                // reveal the active accordion bodies
                $('.js-accordion-item.active').find('> .js-accordion-body').show();
              },
              toggle: function($this) {
                if (settings.oneOpen && $this[0] != $this.closest('.js-accordion').find('> .js-accordion-item.active > .js-accordion-header')[0]) {
                  $this.closest('.js-accordion').
                  find('> .js-accordion-item').
                  removeClass('active').
                  find('.js-accordion-body').
                  slideUp();
                }
                // show/hide the clicked accordion item
                $this.closest('.js-accordion-item').toggleClass('active');
                $this.next().stop().slideToggle(settings.speed);
              }
            };
          }();
          $(document).ready(function() {
            accordion.init({
              speed: 300,
              oneOpen: true
            });
          });
          //# sourceURL=pen.js
        </script>
      
  <?php include("footer.php"); ?>