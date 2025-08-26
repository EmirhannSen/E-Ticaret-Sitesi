<?php include 'header.php'; ?>

<div id="MainDiv" style="background-color: #ffffff; width: 100%; font-family : 'Roboto',Sans-serif ;    overflow: hidden;
    ">
    <div class="page-banner-main">
        <div class="page-banner-in-text">
            <div class="page-banner-h "> Bildirimler </div>
            <div class="page-banner-links ">
                <a href="index.php">
                    <i class="fa fa-home"></i> Anasayfa </a>
                <span>/</span>
                <a> Bildirimler </a>
            </div>
        </div>
    </div>
    <div class="bildirimler-container-main">
        <div class="bildirimler-box-main">
            <div class="bildirim_tabs_main">
                <ul id="bildirim_tabs">
                    <li>
                        <a href="#pushing" style="border-right: 0;">
                            <i class="las la-bullhorn"></i> Herkese Açık Bildirimler </a>
                    </li>
                </ul>
            </div>
            <div class="bildirimler-bilgi-box"> Bu alanda sistemin size göndermiş olduğu bildirimleri görebilirsiniz. Kampanyalar, size özel indirimler, özel fırsatlar ve benzeri bir çok aksiyon ile ilgili bilgilendirildiğiniz alandır. </div>
            <div class="bildirim_tab_content" id="pushing">
                <div class="bildirimler-box" style="padding: 15px;">
                    <div class="bildirimler-box-no-count">
                        <i class="las la-bell-slash"></i> Herkese açık bildirim bulunamadı!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //
    < ![CDATA[var tabLinks = new Array();
    var contentDivs = new Array();

    function init() {
        // Grab the tab links and content divs from the page
        var tabListItems = document.getElementById('bildirim_tabs').childNodes;
        for (var i = 0; i < tabListItems.length; i++) {
            if (tabListItems[i].nodeName == "LI") {
                var tabLink = getFirstChildWithTagName(tabListItems[i], 'A');
                var id = getHash(tabLink.getAttribute('href'));
                tabLinks[id] = tabLink;
                contentDivs[id] = document.getElementById(id);
            }
        }
        // Assign onclick events to the tab links, and
        // highlight the first tab
        var i = 0;
        for (var id in tabLinks) {
            tabLinks[id].onclick = showTab;
            tabLinks[id].onfocus = function() {
                this.blur()
            };
            if (i == 0) tabLinks[id].className = 'selected';
            i++;
        }
        // Hide all content divs except the first
        var i = 0;
        for (var id in contentDivs) {
            if (i != 0) contentDivs[id].className = 'bildirim_tab_content hide';
            i++;
        }
    }

    function showTab() {
        var selectedId = getHash(this.getAttribute('href'));
        // Highlight the selected tab, and dim all others.
        // Also show the selected content div, and hide all others.
        for (var id in contentDivs) {
            if (id == selectedId) {
                tabLinks[id].className = 'selected';
                contentDivs[id].className = 'bildirim_tab_content';
            } else {
                tabLinks[id].className = '';
                contentDivs[id].className = 'bildirim_tab_content hide';
            }
        }
        // Stop the browser following the link
        return false;
    }

    function getFirstChildWithTagName(element, tagName) {
        for (var i = 0; i < element.childNodes.length; i++) {
            if (element.childNodes[i].nodeName == tagName) return element.childNodes[i];
        }
    }

    function getHash(url) {
        var hashPos = url.lastIndexOf('#');
        return url.substring(hashPos + 1);
    }
    init();
    //]]>
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.ozelbildirim-showmorespan', function() {
            var ID = $(this).attr('id');
            $('.ozelbildirim-showmorespan').hide();
            $('.ozelbildirim_loding').show();
            $.ajax({
                type: 'POST',
                url: 'bildirim-ozel-more',
                data: {
                    id: ID
                },
                success: function(html) {
                    $('#ozelbildirim-show-more-button' + ID).remove();
                    $('#member').append(html);
                }
            });
        });
    });
    $(document).ready(function() {
        $(document).on('click', '.herkesebildirim-showmorespan', function() {
            var ID = $(this).attr('id');
            $('.herkesebildirim-showmorespan').hide();
            $('.herkesebildirim_loding').show();
            $.ajax({
                type: 'POST',
                url: 'bildirim-herkese-more',
                data: {
                    id: ID
                },
                success: function(html) {
                    $('#herkesebildirim-show-more-button' + ID).remove();
                    $('#pushing').append(html);
                }
            });
        });
    });
    $(document).ready(function() {
        $(document).on('click', '.uyelerebildirim-showmorespan', function() {
            var ID = $(this).attr('id');
            $('.uyelerebildirim-showmorespan').hide();
            $('.uyelerebildirim_loding').show();
            $.ajax({
                type: 'POST',
                url: 'bildirim-uyelere-more',
                data: {
                    id: ID
                },
                success: function(html) {
                    $('#uyelerebildirim-show-more-button' + ID).remove();
                    $('#members').append(html);
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>