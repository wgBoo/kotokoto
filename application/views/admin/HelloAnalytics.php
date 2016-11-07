<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
<br><br><br>


<!-- Include Required Prerequisites -->
<script type="text/javascript" src="/public/assets/js/moment.min.js"></script>
<link href="/public/assets/css/bootstrap.css" rel="stylesheet">

<!-- Include Date Range Picker -->
<script type="text/javascript" src="/public/assets/js/daterangepicker.js"></script>
<link href="/public/assets/css/daterangepicker.css" rel="stylesheet">




<!--<input type="text" name="datefilter" value="날짜선택" />-->

<div class="form-group">
    <div class='input-group date' id='datetimepicker1' style="width: 20%;">
        <input type='text' name="daterange" class="form-control" value="" />
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<script type="text/javascript">
    $(function() {

        var today = new Date();


        function caldate(day){

            var caledmonth, caledday, caledYear;
            var loadDt = new Date();
            var v = new Date(Date.parse(loadDt) - day*1000*60*60*24);

            caledYear = v.getFullYear();

            if( v.getMonth() < 9 ){
                caledmonth = '0'+(v.getMonth()+1);
            }else{
                caledmonth = v.getMonth()+1;
            }
            if( v.getDate() < 9 ){
                caledday = '0'+v.getDate();
            }else{
                caledday = v.getDate();
            }
            return caledmonth+'/'+caledday+'/'+caledYear;
        }



        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!

        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }

        var today = mm+'/'+dd+'/'+yyyy;

        // 일주일전 날짜
        var week = caldate(7);
        // alert(week);

        $('#datetimepicker1').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            },
            maxDate: today

        });

        // input[name="datefilter"]
        $('#datetimepicker1').on('apply.daterangepicker', function(ev, picker) {
            $('#datetimepicker1').val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));

            var startDate = picker.startDate.format('YYYY-MM-DD');
            var endDate = picker.endDate.format('YYYY-MM-DD');

            var link =  document.location.href;
            var date = link.split('/');

            var url = "/Admin/adminGraph/" + startDate + "/" + endDate + "/" + date[7];
            location.href = url;
        });

        $('#datetimepicker1').on('cancel.daterangepicker', function(ev, picker) {
            //$(this).val('');
        });


        $('#divSession').click(function(){
            // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
            var link =  document.location.href;
            var date = link.split('/');

            var url = "/Admin/adminGraph/" + date[5] + "/" + date[6] + "/" + "sessions";
            location.href = url;
        });


        $('#divUser').click(function(){
            // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
            var link =  document.location.href;
            var date = link.split('/');

            var url = "/Admin/adminGraph/" + date[5] + "/" + date[6] + "/" + "users";
            location.href = url;
        });


        $('#divPageviews').click(function(){
            // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
            var link =  document.location.href;
            var date = link.split('/');

            var url = "/Admin/adminGraph/" + date[5] + "/" + date[6] + "/" + "pageviews";
            location.href = url;
        });

        $('#divPageviewsSession ').click(function(){
            // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
            var link =  document.location.href;
            var date = link.split('/');

            var url = "/Admin/adminGraph/" + date[5] + "/" + date[6] + "/" + "pageviewsPerSession";
            location.href = url;
        });

        $('#divAvgSession ').click(function(){
            // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
            var link =  document.location.href;
            var date = link.split('/');

            var url = "/Admin/adminGraph/" + date[5] + "/" + date[6] + "/" + "avgSessionDuration";
            location.href = url;
        });

        $('#divBounceRate').click(function(){
            // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
            var link =  document.location.href;
            var date = link.split('/');

            var url = "/Admin/adminGraph/" + date[5] + "/" + date[6] + "/" + "bounceRate";
            location.href = url;
        });

        $('#divPercentNewSessions').click(function(){
            // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
            var link =  document.location.href;
            var date = link.split('/');

            var url = "/Admin/adminGraph/" + date[5] + "/" + date[6] + "/" + "percentNewSessions";
            location.href = url;
        });

        // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
        var link =  document.location.href;
        var date = link.split('/');

        // var url = "/Admin/adminGraph/" + date[5] + "/" + date[6] + "/" + "percentNewSessions";

        if(date[5] == 'default' || date[6] == 'default') {

            $('input[name="daterange"]').val(week + ' - ' + today);
        }
        else {

            // $('#datetimepicker1').html(date[5] + ' - ' + date[6]);
            $('input[name="daterange"]').val(date[5] + ' - ' + date[6]);
        }

    });
</script>




<?php

    if($startDate == 'default' && $endDate == 'default') {

        $startDate = '7daysAgo';
        $endDate = 'today';
    }


    $sessions = '';

    function getService()
    {
      // Creates and returns the Analytics service object.

      // Load the Google API PHP Client Library.
      require_once '/usr/local/bin/composer/src/Google/autoload.php';

      // Use the developers console and replace the values with your
      // service account email, and relative location of your key file.
      $service_account_email = 'googleanalytics@leesangdeuk-1264.iam.gserviceaccount.com';
      $key_file_location = '/var/www/html/LeeSangDeuk-7f663763fa03.p12';

      // Create and configure a new client object.
      $client = new Google_Client();
      $client->setApplicationName("HelloAnalytics");
      $analytics = new Google_Service_Analytics($client);

      // Read the generated client_secrets.p12 key.
      $key = file_get_contents($key_file_location);
      $cred = new Google_Auth_AssertionCredentials(
          $service_account_email,
          array(Google_Service_Analytics::ANALYTICS_READONLY),
          $key
      );
      $client->setAssertionCredentials($cred);
      if($client->getAuth()->isAccessTokenExpired()) {
        $client->getAuth()->refreshTokenWithAssertion($cred);
      }

      return $analytics;
    }

    function getFirstprofileId(&$analytics) {
      // Get the user's first view (profile) ID.

      // Get the list of accounts for the authorized user.
      $accounts = $analytics->management_accounts->listManagementAccounts();

      if (count($accounts->getItems()) > 0) {
        $items = $accounts->getItems();
        $firstAccountId = $items[0]->getId();

        // Get the list of properties for the authorized user.
        $properties = $analytics->management_webproperties
            ->listManagementWebproperties($firstAccountId);

        if (count($properties->getItems()) > 0) {
          $items = $properties->getItems();
          $firstPropertyId = $items[0]->getId();

          // Get the list of views (profiles) for the authorized user.
          $profiles = $analytics->management_profiles
              ->listManagementProfiles($firstAccountId, $firstPropertyId);

          if (count($profiles->getItems()) > 0) {
            $items = $profiles->getItems();

            // Return the first view (profile) ID.
            return $items[0]->getId();

          } else {
            throw new Exception('No views (profiles) found for this user.');
          }
        } else {
          throw new Exception('No properties found for this user.');
        }
      } else {
        throw new Exception('No accounts found for this user.');
      }
    }


    // 기간 내 총 세션수
    function getResultsTotalSession(&$analytics, $profileId, $startDate, $endDate){

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:sessions'
        );
    }

    // 기간 내 유저
    function getResultsTotalUser(&$analytics, $profileId, $startDate, $endDate){

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:users'
        );
    }



    // 세션 당 페이지 뷰 수
    function getResultsPagesPerSession(&$analytics, $profileId, $startDate, $endDate) {

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:pageviewsPerSession'
        );
    }


    // 기간 내 페이지 뷰 수
    function getResultsTotalPageiews(&$analytics, $profileId, $startDate, $endDate){

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:pageviews'
        );
    }

    // 평균 세션 기간
    function getResultsAvgSessionDuration(&$analytics, $profileId, $startDate, $endDate) {
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:avgSessionDuration'
        );
    }

    // 이탈률
    function getResultsBounceRate(&$analytics, $profileId, $startDate, $endDate){
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:bounceRate'
        );
    }

    // 새로운 세션 %
    function getResultsPercentNewSessions(&$analytics, $profileId, $startDate, $endDate){
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:percentNewSessions'
        );
    }

    // 그래프 - 세션
    function graphGetSession(&$analytics, $profileId, $startDate, $endDate) {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.

        $optParams = array(
            'dimensions' => 'ga:date'
        );
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:sessions',
            $optParams
        );
    }

    // 그래프 - 사용자
    function graphGetResultsTotalUser(&$analytics, $profileId, $startDate, $endDate) {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.

        $optParams = array(
            'dimensions' => 'ga:date'
        );
        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:users',
            $optParams
        );
    }

    // 그래프 - 페이지뷰 수
    function graphGetResultsTotalPageiews(&$analytics, $profileId, $startDate, $endDate){
        $optParams = array(
            'dimensions' => 'ga:date'
        );

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:pageviews',
            $optParams
        );
    }

    // 그래프 - 세션 당 페이지 뷰 수
    function graphGetResultsPagesPerSession(&$analytics, $profileId, $startDate, $endDate) {

        $optParams = array(
            'dimensions' => 'ga:date'
        );

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:pageviewsPerSession',
            $optParams
        );
    }

    // 그래프 - 평균 세션 시간
    function graphGetResultsAvgSessionDuration(&$analytics, $profileId, $startDate, $endDate) {

        $optParams = array(
            'dimensions' => 'ga:date'
        );

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:avgSessionDuration',
            $optParams
        );
    }

    // 그래프 - 이탈률
    function graphGetResultsBounceRate(&$analytics, $profileId, $startDate, $endDate){
        $optParams = array(
            'dimensions' => 'ga:date'
        );

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:bounceRate',
            $optParams
        );
    }

    // 그래프 - 새로운 세션 %
    function graphGetResultsPercentNewSessions(&$analytics, $profileId, $startDate, $endDate){
        $optParams = array(
            'dimensions' => 'ga:date'
        );

        return $analytics->data_ga->get(
            'ga:' . $profileId,
            $startDate,
            $endDate,
            'ga:percentNewSessions',
            $optParams
        );
    }

    function printResults(&$results, &$resultsTotalSession, &$resultsTotalUser,
                          &$resultsTotalPageviews, &$resultsTotalPagesPerSessions,
                          &$resultsAvgSessionDuration, &$resultsBounceRate,
                          &$resultsPercentNewSessions) {

        // Parses the response from the Core Reporting API and prints
        // the profile name and total sessions.

        if (count($results->getRows()) > 0) {
            // Get the profile name.
            $profileName = $results->getProfileInfo()->getProfileName();

            // Get the entry for the first entry in the first row.
            $rows = $results->getRows();

            $rowsTotalSession = $resultsTotalSession->getRows();
            $rowsTotalUser = $resultsTotalUser->getRows();
            $rowsTotalPageviews = $resultsTotalPageviews->getRows();
            $rowsPagesPerSessions = $resultsTotalPagesPerSessions -> getRows();
            $rowsAvgSessionDuration = $resultsAvgSessionDuration -> getRows();
            $rowsBounceRate = $resultsBounceRate -> getRows();
            $rowsPercentNewSessions = $resultsPercentNewSessions -> getRows();

            // $dataSessionsCount = $rows[0][0];


            $dataSessionsCheck = '';
            $dataSessionsDate = '';
            for( $i = 0 ; $i < count($rows) ; $i ++ ){
                $dataSessionsCheck[] =  $rows[$i][1];
                $dataSessionsDate[] = $rows[$i][0];
            }


            $array['session'] = $dataSessionsCheck;
            $array['date'] = $dataSessionsDate;


            $array['totalSession'] = $rowsTotalSession;
            $array['totalUser'] = $rowsTotalUser;
            $array['totalPageview'] = $rowsTotalPageviews;
            $array['pagesPerSessions'] = $rowsPagesPerSessions;
            $array['avgSessionDuration'] = $rowsAvgSessionDuration;
            $array['bounceRate'] = $rowsBounceRate;
            $array['percentNewSessions'] = $rowsPercentNewSessions;


            // Print the results.
            // print "First view (profile) found: $profileName\n";
            // print "Total sessions: $dataSessionsCount\n";
            echo "<br><br><br><br>";
            //var_dump($array['session']);
            //var_dump($array['date']);
            return $array;

        } else {
            print "No results found.\n";
            return null;
        }
    }

    $analytics = getService();
    $profile = getFirstProfileId($analytics);

    $resultsTotalUser = getResultsTotalUser($analytics, $profile, $startDate, $endDate);
    $resultsTotalSession = getResultsTotalSession($analytics, $profile, $startDate, $endDate);
    $resultsTotalPageviews = getResultsTotalPageiews($analytics, $profile, $startDate, $endDate);
    $resultsTotalPagesPerSessions = getResultsPagesPerSession($analytics, $profile, $startDate, $endDate);
    $resultsAvgSessionDuration = getResultsAvgSessionDuration($analytics, $profile, $startDate, $endDate);
    $resultsBounceRate = getResultsBounceRate($analytics, $profile, $startDate, $endDate);

    $resultsPercentNewSessions = getResultsPercentNewSessions($analytics, $profile, $startDate, $endDate);


    // 현재 타입에 따라 그래프
    if($type == 'sessions') {
        $results = graphGetSession($analytics, $profile, $startDate, $endDate);
    }
    elseif($type == 'users') {
        $results = graphGetResultsTotalUser($analytics, $profile, $startDate, $endDate);
    }
    elseif($type == 'pageviews') {
        $results = graphGetResultsTotalPageiews($analytics, $profile, $startDate, $endDate);
    }
    elseif($type == 'pageviewsPerSession') {
        $results = graphGetResultsPagesPerSession($analytics, $profile, $startDate, $endDate);
    }
    elseif($type == 'avgSessionDuration') {
        $results = graphGetResultsAvgSessionDuration($analytics, $profile, $startDate, $endDate);
    }
    elseif($type == 'avgSessionDuration') {
        $results = graphGetResultsAvgSessionDuration($analytics, $profile, $startDate, $endDate);
    }
    elseif($type == 'bounceRate') {
        $results = graphGetResultsBounceRate($analytics, $profile, $startDate, $endDate);
    }
    elseif($type == 'percentNewSessions') {
        $results = graphGetResultsPercentNewSessions($analytics, $profile, $startDate, $endDate);
    }

    $arrData = printResults($results, $resultsTotalSession, $resultsTotalUser,
                                $resultsTotalPageviews, $resultsTotalPagesPerSessions,
                                $resultsAvgSessionDuration, $resultsBounceRate,
                                $resultsPercentNewSessions);




?>


<script src="/public/assets/js/highchart.js"></script>
<script src="/public/assets/js/exporting.js"></script>


<!--
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
-->

<style>
    [data-tooltip-text]:hover {
        position: relative;
    }

    [data-tooltip-text]:after {
        -webkit-transition: bottom .3s ease-in-out, opacity .3s ease-in-out;
        -moz-transition: bottom .3s ease-in-out, opacity .3s ease-in-out;
        transition: bottom .3s ease-in-out, opacity .3s ease-in-out;
        background-color: #000000;
        background-color: rgba(0, 0, 0, 0.8);
        -webkit-box-shadow: 0px 0px 3px 1px rgba(50, 50, 50, 0.4);
        -moz-box-shadow: 0px 0px 3px 1px rgba(50, 50, 50, 0.4);
        box-shadow: 0px 0px 3px 1px rgba(50, 50, 50, 0.4);
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        color: #FFFFFF;
        font-size: 12px;
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

    /*mouse over css*/
    .hover {
        max-width:400px;
        height:80px;
        line-height:35px;
        margin:10px auto;
        background-color:white;
        transition:all 0.8s, color 0.3s 0.3s;
        color:#504f4f; cursor: pointer;
    }
    .hover:hover{
        color:#fff;
    }
    .effect1:hover{
        box-shadow:400px 0 0 0 rgba(0,0,0,0.5) inset;
    }

</style>

<div id="container" style="width: 100%; height: 400px; margin: 0 auto"></div>

<div id = "divSession" class="hover effect1" style="border-right: 1px solid darkgray; padding : 15px; width: 13%; height: 100px; margin-left: 5%;">
    <span data-tooltip-text="期間内の合計セッション数です。 セッションとはユーザーがウェブサイトやアプリなどに積極的に関わっている期間を指します。" style="font-size: 15px;">
        セッション
    </span>
    <p id = "totalSession" style="font-weight: bold; font-size: 25px;"></p>
</div>

<div id="divUser" class="hover effect1" style="border-right: 1px solid darkgray; padding : 15px; width: 13%; height: 100px;">
    <span data-tooltip-text="選択した期間内に 1 回以上セッションが発生したユーザー数。新規とリピーターの両方を含みます" style="font-size: 15px;">
        ユーザー
    </span>
    <p id = "totalUser" style="font-weight: bold; font-size: 25px;"></p>
</div>

<div id="divPageviews" class="hover effect1" style="border-right: 1px solid darkgray; padding : 15px; width: 13%; height: 100px;">
    <span data-tooltip-text="閲覧されたページの合計数です。同じページが繰り返し表示された場合も集計されます" style="font-size: 15px;">
        ページビュー数
    </span>
    <p id = "totalPageview" style="font-weight: bold; font-size: 25px;"></p>
</div>

<div id="divPageviewsSession" class="hover effect1" style="border-right: 1px solid darkgray; padding : 15px; width: 13%; height: 100px; font-size: 15px;">
    <span data-tooltip-text="セッション中に表示された平均ページ数です。同じページが繰り返し表示された場合も集計されます。" style="font-size: 15px;">
        ページ/セッション
    </span>

    <p id = "pagesPerSessions" style="font-weight: bold; font-size: 25px;"></p>
</div>

<div id="divAvgSession" class="hover effect1" style="border-right: 1px solid darkgray; padding : 15px; width: 13%; height: 100px;">
    <span data-tooltip-text="セッションの平均時間です。" style="font-size: 15px;">
        平均セッション時間
    </span>
    <p id = "avgSessionDuration" style="font-weight: bold; font-size: 25px;"></p>
</div>

<div id="piechart" style="width: 30%; height: 30%; float: right; padding-top: 0px;"></div>


<div id="divBounceRate" class="hover effect1" style="border-right: 1px solid darkgray; padding : 15px; width: 13%; height: 100px; margin-left: 5%; margin-top: 2%">
    <span data-tooltip-text="直帰率とは、1 ページだけを閲覧した訪問数（ランディング ページでサイトを離脱したユーザーの訪問）の割合です。" style="font-size: 15px;">
        離脱率
    </span>
    <p id = "bounceRate" style="font-weight: bold; font-size: 25px;"></p>
</div>


<div id="divPercentNewSessions" class="hover effect1" style="border-right: 1px solid darkgray; padding : 15px; width: 13%; height: 100px; margin-top: 2%;">

    <span data-tooltip-text="新規訪問の割合（推定値）です。" style="font-size: 15px;">
        新規セッション率
    </span>
    <p id = "percentNewSessions" style="font-weight: bold; font-size: 25px;"></p>
</div>

<script>

    $(function () {

        // 새로운 세션 %
        var percentNewSessions = new Array("<?=implode("\",\"" , $arrData['percentNewSessions'][0]);?>");
        var percentNewSessions = percentNewSessions[0].substring(0,4);
        $('#percentNewSessions').text(percentNewSessions + "%");

        // 이탈률
        var bounceRate = new Array("<?=implode("\",\"" , $arrData['bounceRate'][0]);?>");
        var bounceRate = bounceRate[0].substring(0, 4);
        $('#bounceRate').text(bounceRate + "%");

        // 평균 세션 시간
        var avgSessionDuration = new Array("<?=implode("\",\"" , $arrData['avgSessionDuration'][0]);?>");
        var avgSessionDuration = avgSessionDuration[0];
        var line = avgSessionDuration.indexOf(".");
        var avgSessionDuration = avgSessionDuration.substring(0,line);
        var hour = parseInt(avgSessionDuration/3600);
        if(hour == 0) {
            hour = '00';
        }
        var min = parseInt((avgSessionDuration%3600)/60);
        var sec = avgSessionDuration%60;
        if(sec < 10) {
            sec += '0';
        }
        $('#avgSessionDuration').text(hour + ":" + min + ":" + sec);


        // 세션당 페이지 수
        var pagesPerSessions = new Array("<?=implode("\",\"" , $arrData['pagesPerSessions'][0]);?>");
        var pagesPerSessions = pagesPerSessions[0].substring(0, 4);
        $('#pagesPerSessions').text(pagesPerSessions);

        // 페이지 뷰 수
        var totalPageview = new Array("<?=implode("\",\"" , $arrData['totalPageview'][0]);?>");
        var totalPageview = totalPageview[0].substring(0, 4);
        $('#totalPageview').text(totalPageview);


        // 총 세션
        var totalSession = new Array("<?=implode("\",\"" , $arrData['totalSession'][0]);?>");
        var totalSession = Number(totalSession[0]);
        $('#totalSession').text(totalSession);


        // 총 유저
        var totalUser = new Array("<?=implode("\",\"" , $arrData['totalUser'][0]);?>");
        var totalUser = totalUser[0];
        $('#totalUser').text(totalUser);

        // 리터닝 유저
        var returningUser = totalSession - totalUser + 1;
        /*
        alert('totalSession : ' + totalSession);
        alert('totalUser : ' + totalUser);
        alert('returningUser : ' + returningUser);
        */
        returningUser = Number(returningUser);

        // pie chart % 계산
        var percentReturningUser = returningUser / totalSession * 100;
        var percentTotalUser = (totalUser - 1) / totalSession * 100;

        // alert(percentReturningUser);
        percentReturningUser = Math.round(percentReturningUser * 10) / 10;
        percentTotalUser = Math.round(percentTotalUser * 10) / 10;
        //alert(percentReturningUser);
        //alert(percentTotalUser);


        // 날짜
        var date = new Array("<?=implode("\",\"" , $arrData['date']);?>");
        for( var i = 0 ; i < date.length ; i++ ) {
            var month = date[i].substring(4, 6);
            var day = date[i].substring(6, 10);
            date[i] = month + '月' + day + '日';
        }


        // 기간별 세션
        var session = new Array("<?=implode("\",\"" , $arrData['session']);?>");
        var sessionNumChange = new Array();
        for(var i = 0 ; i < session.length ; i++ ) {
          sessionNumChange[i] = Number(session[i]);
        }

        // 현재 url을 이용해서 지정해놓은 날짜값 가져옴
        var link =  document.location.href;
        var utl_type = link.split('/');
        //console.log(date);

        // 그래프
        $('#container').highcharts({
            chart: {
                type: 'area',
                spacingBottom: 30
            },
            title: {
                text: utl_type[7]
            },
            subtitle: {
                text: '',
                floating: true,
                align: 'right',
                verticalAlign: 'bottom',
                y: 15
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            xAxis: {
                categories: date
            },
            yAxis: {
                title: {
                   text: utl_type[7]
                },
                labels: {
                    formatter: function () {
                        return this.value;
                    }
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                          this.x + ': ' + this.y;
                }
            },
            plotOptions: {
                area: {
                    fillOpacity: 0.5
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: utl_type[7],
                data: sessionNumChange
            }]
        });

        // 파이차트
        $(function () {

            $(document).ready(function () {

                // Build the chart
                $('#piechart').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Brands',
                        colorByPoint: true,
                        data: [
                                {
                                    name: 'New Visitor',
                                    y: percentTotalUser
                                },

                                {
                                    name: 'Returning Visitor',
                                    y: percentReturningUser
                                }
                        ]
                    }]
                });
            });
        });
    });

</script>
