<link href="/public/assets/css/bootstrap.css" rel="stylesheet">


<div class="container">
    <div class="row-fluid" >
        <div id="content" class="span12">
            <div class="well span3" style="text-align: center; width:20%; margin: 0 auto;">
                <h3>Right Now</h3>
                <h4 id="connections" class="dash-red" style="font-size: 60px;line-height: 96px;">0<i class="glyphicon glyphicon-user"></i></h4>
                <!--<p id="connections" style="font-size: 96px;line-height: 96px;">0</p>-->
                <h1 class="text-muted">Active Users</h1>
            </div>
            <div class="span9">
                <legend>Real Time Activity</legend>
                <div class="row-fluid">
                    <table id="visits" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr><td>URL</td><td>IP</td><td>Timestamp</td></tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <legend>Page Views</legend>
                <div class="row-fluid">
                    <table id="pageViews" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr><td>URL</td><td>Page Views</td></tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="/public/assets/node_js/node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="/public/assets/js/jquery-1.8.3.min.js"></script>
<script>

    var socket = io.connect('http://kotokoto.xyz:8000');
    var pages = {};
    var lastPageId = 0;

    socket.on('connect', function () {

        console.log('Socket connected');

        socket.on('pageview', function (msg) {
            $('#connections').html(msg.connections + '<i class="glyphicon glyphicon-user"></i>');
            if (msg.url) {
                if ($('#visits tr').length > 10) {
                    $('#visits tr:last').remove();
                }
                $('#visits tbody').prepend('<tr><td>' + msg.url + '</td><td>' + msg.ip + '</td><td>' + msg.timestamp + '</td></tr>');

                if (pages[msg.url]) {
                    pages[msg.url].views = pages[msg.url].views + 1;
                    $('#page' + pages[msg.url].pageId).html(pages[msg.url].views);
                } else {
                    pages[msg.url] = {views: 1, pageId: ++lastPageId};
                    $('#pageViews tbody').append('<tr><td>' + msg.url + '</td><td id="page' + lastPageId + '">1</td></tr>');
                }

            }
        });

    });


</script>
