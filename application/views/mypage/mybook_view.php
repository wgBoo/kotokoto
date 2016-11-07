<meta property='og:title' content='페이지 제목'/>
<meta property='og:image' content='http://kotokoto.xyz/public/assets/img/pdf/book-covers.jpg'/>
<meta property="og:type" content="사이트의 성격 : game, article 등"/>
<meta property='og:site_name' content='사이트명'/>
<meta property='og:url' content='http://kotokoto.xyz/Mypage/sharepage/wprnr2402'/>
<meta property='og:description' content='페이지설명'/>



<script>
    var userid = '<?= $diaryInfo[0]->uid ?>';

    function indexToggle(i) {
        $("#index" + i).toggle("fast");
    }

    function permission(){
        $.ajax({
            url: '/Mypage/uprivacyPermission/',
            type: 'POST',
            data: {'permission':'1'},
            success: function(result){
                if(result){
                    window.alert('共有の許可を許可しました！');
                    $('.startP').remove();
                    $('<img class="deny" src="/public/assets/img/share/share.png"'+
                    ' style="width: 25px; height: 25px; float: left; margin: 0 5px; margin-top: 6px;">'+
                        '<img class="deny" src="/public/assets/img/share/facebook.png"'+
                        ' onclick="shareFacebook()"'+
                        ' style="width: 50px; height: 50px; float: left; margin: 0 5px; margin-top: -5px; cursor: pointer;"/>'+
                        '<img class="deny" src="/public/assets/img/share/twitter.png"'+
                        ' onclick="shareTwitter()"'+
                        ' style="width: 50px; height: 50px; float: left; margin: 0 5px; margin-top: -5px; cursor: pointer;"/>'+
                        '<img class="deny" src="/public/assets/img/share/google-plus.png"'+
                        ' onclick="shareGoogle()"'+
                        ' style="width: 50px; height: 50px; float: left; margin: 0 5px; margin-top: -5px; cursor: pointer;"/>'+
                        '<img class="deny" src="/public/assets/img/share/line-icon.png"'+
                        ' onclick="shareLine()"'+
                        ' style="width: 50px; height: 50px; float: left; margin: 0 0 0 5px; margin-top: -5px; cursor: pointer;"/>'+
                        '<span data-tooltip-text="共有の許可を取り消します！"">'+
                        '<img class="deny" src="/public/assets/img/share/lock.png"'+
                        ' onclick="permissionLock()"'+
                        ' style="width: 25px; height: 25px; float: left; margin-top: -15px; cursor: pointer;"/>'+
                        '</span>'
                    ).prependTo('#mybookBtn');
                }
            }
        });
    }

    function permissionLock(){
        $.ajax({
            url: '/Mypage/uprivacyPermission/',
            type: 'POST',
            data: {'permission':'0'},
            success: function(result){
                if(result){
                    window.alert('共有の許可を取り消しました！');
                    $('.deny').remove();
                    $('<button class="startP" type="button" style="float: left; background-color: #0a94e3;"'+
                        ' onclick="permission()">SNS共有許可</button>' +
                        '<img class="startP" src="/public/assets/img/share/unlock.png"'+
                    'style="width: 25px; height: 25px; float: left; margin-top: -15px;">').prependTo('#mybookBtn');
                }
            }
        });
    }

    function connectPDF(){

        $.ajax({
            url: '/Mypage/turnjs/',
            success : function(pageHtml){
                post_to_url('/Mypage/pdfinfo/',{'pageHtml': pageHtml});
            }
        });
    }

    /*
     * path : 전송 URL
     * params : 전송 데이터 {'q':'a','s':'b','c':'d'...}으로 묶어서 배열 입력
     * method : 전송 방식(생략가능)
     */
    function post_to_url(path, params, method) {
        method = method || "post";  //method 부분은 입력안하면 자동으로 post가 된다.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);
        //input type hidden name(key) value(params[key]);
        for(var key in params) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
        document.body.appendChild(form);
        form.submit();
    }

    function shareFacebook() {
        var fullUrl;
        var url = 'http://kotokoto.xyz/Mypage/sharepage/'+userid;
        var image = 'http://kotokoto.xyz/public/assets/img/pdf/book-covers.jpg';
        var title = '페이지 제목';
        var summary = '페이지설명';

        var pWidth = 640;
        var pHeight = 380;
        var pLeft = (screen.width - pWidth) / 2;
        var pTop = (screen.height - pHeight) / 2;

        fullUrl = 'http://www.facebook.com/share.php?s=100&p[url]='+ url
            +'&p[images][0]='+ image
            +'&p[title]='+ title
            +'&p[summary]='+ summary;
        fullUrl = fullUrl.split('#').join('%23');
        fullUrl = encodeURI(fullUrl);
        window.open(fullUrl,'','width='+ pWidth +',height='+ pHeight +',left='+ pLeft +',top='+ pTop +',location=no,menubar=no,status=no,scrollbars=no,resizable=no,titlebar=no,toolbar=no');
    }

    function shareTwitter(){
        var content = "트위터공유";
        var link = "http://kotokoto.xyz/Mypage/sharepage/"+userid;
        var popOption = "width=640, height=380, resizable=no, scrollbars=no, status=no;";
        var wp = window.open("http://twitter.com/share?url=" + encodeURIComponent(link) + "&text=" + encodeURIComponent(content), 'twitter', popOption);
        if ( wp ) {
            wp.focus();
        }
    }

    function shareGoogle(){
        var content = "구글공유";
        var link = "http://kotokoto.xyz/Mypage/sharepage/"+userid;
        var popOption = "resizable=no, scrollbars=no, status=no;";
        var wp = window.open("https://plus.google.com/share?url=" + encodeURIComponent(link) + "&text=" + encodeURIComponent(content), 'google', popOption);
        if ( wp ) {
            wp.focus();
        }
    }

    function shareLine(){
        window.open("http://line.me/R/msg/text/?http://line.me/R/msg/text/?LINE%20it%21%0d%0ahttp%3a%2f%2fline%2enaver%2ejp%2f");
    }

    function protect_delete(){
        var message = confirm("本当に全体のダイアリーを削除しますか？");
        if (message == true)
            location.href='/Mypage/diary_delete';
    }

</script>
<style>
    [data-tooltip-text]:hover {
        position: relative; right: 110px ;
    }

    [data-tooltip-text]:after {
        -webkit-transition: bottom .3s ease-in-out, opacity .3s ease-in-out;
        -moz-transition: bottom .3s ease-in-out, opacity .3s ease-in-out;
        transition: bottom .3s ease-in-out, opacity .3s ease-in-out;
        background-color: #0a94e3;
        background-color: rgba(10, 148, 227, 0.8);
        -webkit-box-shadow: 0px 0px 3px 1px rgba(50, 50, 50, 0.4);
        -moz-box-shadow: 0px 0px 3px 1px rgba(50, 50, 50, 0.4);
        box-shadow: 0px 0px 3px 1px rgba(50, 50, 50, 0.4);
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
        bottom: 90%;
        padding: 7px 12px;
        position: absolute;
        width: auto;
        min-width: 50px;
        max-width: 1000px;
        word-wrap: break-word;
        white-space: pre;
        z-index: 9999;

        opacity: 0;
        left: -9999px;

        content: attr(data-tooltip-text);
    }

    [data-tooltip-text]:hover:after {
        bottom: 100%;
        left: 0;
        opacity: 1;
    }

    ul, ol {
        margin-bottom: 0em;
    }

    h2 {
        margin: 0;
    }

    button {
        padding: 0.85em 1.5em 0.85em 1.5em;
    }

    @font-face {
        font-family: 'hooncat';
        src: url('/public/assets/fonts/HoonWhitecatR.ttf');
    }

    @font-face {
        font-family: 'mamelon';
        src: url('/public/assets/fonts/Mamelon.otf');
    }

    @font-face {
        font-family: 'TAKUMIYFONT';
        src: url('/public/assets/fonts/TAKUMIYFONT.ttf');
    }

    @font-face {
        font-family: 'TAKUMIYFONT_P';
        src: url('/public/assets/fonts/TAKUMIYFONT_P.ttf');
    }

    @font-face {
        font-family: 'TAKUMIYFONTMINI';
        src: url('/public/assets/fonts/TAKUMIYFONTMINI.ttf');
    }

    @font-face {
        font-family: 'TAKUMIYFONTMINI_P';
        src: url('/public/assets/fonts/TAKUMIYFONTMINI_P.ttf');
    }

    @media screen and (min-width: 737px) {

        .row > * {
            padding: 20px 0 0 20px;
        }
    }
</style>


<div id="content" class="8u 12u(mobile) important(mobile)">
    <article class="box post">
        <?php
        /*$uno = isset($_SESSION['uno']) ? $_SESSION['uno'] : null;*/
        if ($diaryInfo) { ?>
            <!--<span class='uno' style="display:none"><? /*= $uno */ ?></span>-->

            <div id="canvas">
                <div id="book-zoom">
                    <div class="sj-book">
                        <div depth="5" class="hard">
                            <div class="side"></div>
                        </div>
                        <div depth="5" class="hard front-side">
                            <div class="depth"></div>
                        </div>
                        <div class="own-size"></div>
                        <div class="own-size even"></div>
                        <div class="hard fixed back-side p111">
                            <div class="depth"></div>
                        </div>
                        <div class="hard p112"></div>
                    </div>
                </div>
                <div id="slider-bar" class="turnjs-slider">
                    <div id="slider"></div>
                </div>
                <div id="mybookBtn" style="position: relative; margin-top: 50px">
                    <!--<button style="font-size: 15.5px" type="button" class="btn btn-primary"
                            onclick="location.href='#'">Mygallery
                    </button>&nbsp;&nbsp;-->
                    <button id="button01" type="button" style="background: #f5806a; float: right; margin: 0 10px;"
                    value="삭제" onclick="protect_delete()">全て削除
                    </button>
                    <button id="button02" type="button" style="background: #f5907f; float: right; margin: 0 10px;"
                            value="수정" onclick="location.href='/Mypage/diary_modify_view'">修正
                    </button><!--ff9784-->
                    <button id="button03" type="button" style="background: rgba(252, 179, 83, 0.99); float: right; margin: 0 10px;"
                            onclick="location.href='/Mypage/diary_add_view'">文作成
                    </button><!--fab769-->
                <?php if($diaryInfo[0]->uprivacy){ ?>
                   <img class="deny" src="/public/assets/img/share/share.png"
                         style="width: 25px; height: 25px; float: left; margin: 0 5px; margin-top: 6px;">
                    <img class="deny" src="/public/assets/img/share/facebook.png"
                         onclick="shareFacebook()"
                         style="width: 50px; height: 50px; float: left; margin: 0 5px; margin-top: -5px; cursor: pointer;">
                    <img class="deny" src="/public/assets/img/share/twitter.png"
                         onclick="shareTwitter()"
                         style="width: 50px; height: 50px; float: left; margin: 0 5px; margin-top: -5px; cursor: pointer;">
                    <img class="deny" src="/public/assets/img/share/google-plus.png"
                         onclick="shareGoogle()"
                         style="width: 50px; height: 50px; float: left; margin: 0 5px; margin-top: -5px; cursor: pointer;">
                    <img class="deny" src="/public/assets/img/share/line-icon.png"
                         onclick="shareLine()"
                         style="width: 50px; height: 50px; float: left; margin: 0 0 0 5px; margin-top: -5px; cursor: pointer;">
                    <span data-tooltip-text="共有の許可を取り消します！"">
                    <img class="deny" src="/public/assets/img/share/lock.png"
                         onclick="permissionLock()"
                         style="width: 25px; height: 25px; float: left; margin-top: -15px; cursor: pointer;">
                    </span>
                        <?php }else{ ?>
                    <button class="startP" type="button" style="float: left; background-color: #0a94e3; "
                            onclick="permission()">SNS共有許可
                    </button>
                    <img class="startP" src="/public/assets/img/share/unlock.png"
                         style="width: 25px; height: 25px; float: left; margin-top: -15px;">
                        <?php } ?>
                    <img  src="/public/assets/img/share/printer.png"
                          style="width: 25px; height: 25px; float: left; margin: 0 5px 0 30px; margin-top: 6px;">
                    <img  src="/public/assets/img/pdf/pdf.png"
                          onclick="connectPDF()"
                          style="width: 50px; height: 50px; float: left;  margin-top: -5px; cursor: pointer;">
                </div>
                <br/>
            </div>


            <script type="text/javascript">

                function loadApp() {

                    var flipbook = $('.sj-book');

                    // Check if the CSS was already loaded

                    if (flipbook.width() == 0 || flipbook.height() == 0) {
                        setTimeout(loadApp, 10);
                        return;
                    }

                    // Mousewheel

                    $('#book-zoom').mousewheel(function (event, delta, deltaX, deltaY) {


                        var data = $(this).data(),
                            step = 30,
                            flipbook = $('.sj-book'),
                            actualPos = $('#slider').slider('value') * step;

                        if (typeof(data.scrollX) === 'undefined') {
                            data.scrollX = actualPos;
                            data.scrollPage = flipbook.turn('page');
                        }

                        data.scrollX = Math.min($("#slider").slider('option', 'max') * step,
                            Math.max(0, data.scrollX + deltaX));

                        var actualView = Math.round(data.scrollX / step),
                            page = Math.min(flipbook.turn('pages'), Math.max(1, actualView * 2 - 2));

                        if ($.inArray(data.scrollPage, flipbook.turn('view', page)) == -1) {
                            data.scrollPage = page;
                            flipbook.turn('page', page);
                        }

                        if (data.scrollTimer)
                            clearInterval(data.scrollTimer);

                        data.scrollTimer = setTimeout(function () {
                            data.scrollX = undefined;
                            data.scrollPage = undefined;
                            data.scrollTimer = undefined;
                        }, 1000);

                    });

                    // Slider

                    $("#slider").slider({
                        min: 1,
                        max: 100,

                        start: function (event, ui) {

                            if (!window._thumbPreview) {
                                _thumbPreview = $('<div />', {'class': 'thumbnail'}).html('<div></div>');
                                setPreview(ui.value);
                                _thumbPreview.appendTo($(ui.handle));
                            } else
                                setPreview(ui.value);

                            moveBar(false);

                        },

                        slide: function (event, ui) {

                            setPreview(ui.value);

                        },

                        stop: function () {

                            if (window._thumbPreview)
                                _thumbPreview.removeClass('show');

                            $('.sj-book').turn('page', Math.max(1, $(this).slider('value') * 2 - 2));

                        }
                    });

                    // URIs

                    Hash.on('^page\/([0-9]*)$', {
                        yep: function (path, parts) {

                            var page = parts[1];

                            if (page !== undefined) {
                                if ($('.sj-book').turn('is'))
                                    $('.sj-book').turn('page', page);
                            }

                        },
                        nop: function (path) {

                            if ($('.sj-book').turn('is'))
                                $('.sj-book').turn('page', 1);
                        }
                    });

                    // Arrows

                    $(document).keydown(function (e) {

                        var previous = 37, next = 39;

                        switch (e.keyCode) {
                            case previous:

                                $('.sj-book').turn('previous');

                                break;
                            case next:

                                $('.sj-book').turn('next');

                                break;
                        }

                    });


                    // Flipbook

                    flipbook.bind(($.isTouch) ? 'touchend' : 'click', zoomHandle);

                    flipbook.turn({
                        elevation: 50,
                        acceleration: !isChrome(),
                        autoCenter: true,
                        gradients: true,
                        duration: 1000,
                        pages: 112,
                        when: {
                            turning: function (e, page, view) {

                                var book = $(this),
                                    currentPage = book.turn('page'),
                                    pages = book.turn('pages');

                                if (currentPage > 3 && currentPage < pages - 3) {

                                    if (page == 1) {
                                        book.turn('page', 2).turn('stop').turn('page', page);
                                        e.preventDefault();
                                        return;
                                    } else if (page == pages) {
                                        book.turn('page', pages - 1).turn('stop').turn('page', page);
                                        e.preventDefault();
                                        return;
                                    }
                                } else if (page > 3 && page < pages - 3) {
                                    if (currentPage == 1) {
                                        book.turn('page', 2).turn('stop').turn('page', page);
                                        e.preventDefault();
                                        return;
                                    } else if (currentPage == pages) {
                                        book.turn('page', pages - 1).turn('stop').turn('page', page);
                                        e.preventDefault();
                                        return;
                                    }
                                }

                                updateDepth(book, page);

                                if (page >= 2)
                                    $('.sj-book .p2').addClass('fixed');
                                else
                                    $('.sj-book .p2').removeClass('fixed');

                                if (page < book.turn('pages'))
                                    $('.sj-book .p111').addClass('fixed');
                                else
                                    $('.sj-book .p111').removeClass('fixed');

                                Hash.go('page/' + page).update();

                            },

                            turned: function (e, page, view) {

                                var book = $(this);

                                if (page == 2 || page == 3) {
                                    book.turn('peel', 'br');
                                }

                                updateDepth(book);

                                $('#slider').slider('value', getViewNumber(book, page));

                                book.turn('center');

                            },

                            start: function (e, pageObj) {

                                moveBar(true);

                            },

                            end: function (e, pageObj) {

                                var book = $(this);

                                updateDepth(book);

                                setTimeout(function () {

                                    $('#slider').slider('value', getViewNumber(book));

                                }, 1);

                                moveBar(false);

                            },

                            missing: function (e, pages) {

                                for (var i = 0; i < pages.length; i++) {
                                    addPage(pages[i], $(this));
                                }

                            }
                        }
                    });


                    $('#slider').slider('option', 'max', numberOfViews(flipbook));

                    flipbook.addClass('animated');

                    // Show canvas

                    $('#canvas').css({visibility: ''});
                }

                // Hide canvas

                $('#canvas').css({visibility: 'hidden'});

                // Load turn.js

                yepnope({
                    test: Modernizr.csstransforms,
                    yep: ['/public/assets/js/turnjs/turn.min.js'],
                    nope: ['/public/assets/js/turnjs/turn.html4.min.js', '/public/assets/css/turncss/jquery.ui.html4.css', '/public/assets/css/turncss/steve-jobs-html4.css'],
                    both: ['/public/assets/js/turnjs/steve-jobs.js', '/public/assets/css/turncss/jquery.ui.css', '/public/assets/css/turncss/steve-jobs.css'],
                    complete: loadApp
                });

            </script>

        <?php }else{ ?>
            <p>
                <button type="button" class="btn btn-danger" onclick="location.href='/Mypage/diary_insert_view'">
                    新しい料理ダイアリー登録
                </button>
            <h3>ダイアリーを登録しましょう！</h3>
        <?php } ?>
    </article>
</div>

