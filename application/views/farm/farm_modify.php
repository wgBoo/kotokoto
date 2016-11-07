<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#Uploadedimg').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<body onload="initialize()">
<section id="farm_modify">
    <form name="submit_farm_modify" method="post" action="/Farm/farmModifyDB" encType="multipart/form-data">
        <input type="hidden" name="fno" value="<?= $farm_info->fno ?>">
        <table>
            <tr align="center">
                <td rowspan="4" style="padding: 15px"><img id="Uploadedimg" src="../public/assets/img/default.jpg"
                                                           width="300" height="300"><br>
                    <input type="file" name="picName" onchange="readURL(this);"></td>
                <td colspan="2">生産地名 <input type="text" name="fname" value="<?= $farm_info->fname ?>"></td>
            </tr>
            <tr align="center">
                <td colspan="2">名前 <input type="text" name="farmer" value="<?= $farm_info->farmer ?>"></td>
                <input type="hidden" name="uno" value="<?= $user_info->uno ?>">
            </tr>
            <tr align="center">
                <td colspan="2">カラー <input type="color" name="fcolor" value="<?= $farm_info->fcolor ?>"></td>
            </tr>
            <tr><td colspan="2">電話番号 <input type="text" name="fphone" value="<?= $farm_info->fphone ?>"></td></tr>
            <tr align="center">
                <td colspan="2">
                    住所
                </td>
            </tr>
            <tr>
                <td><input type="text" size="50" id="flocation" name="flocation" value="<?= $farm_info->flocation ?>" style="height: 10px;"/>
                    <input type="text" id="position" name="position" style="display: none;"></td>
                <td><input style="padding: 5px; font-size: 80%" name="submit" type="submit" value="探す" onclick='codeAddress(); return false;' /></td>
            </tr>
        </table>
        <div id="map_canvas" style="margin-top: 20px; margin-bottom: 50px; width: 900px; height: 500px;"></div>
        <div>
            <p>紹介</p>
            <textarea name="fintro" rows="5"><?= $farm_info->fintro ?></textarea>
        </div>
        <p><input type="submit" name="submit_farm_modify" value="修正する"><input type="button" value="キャンセル"
                                                                           onclick="location.href='/Farm/farm'"></p>
    </form>
</section>

<script type="text/javascript"
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA_axHBxQ6umODvtNYo08r993dpfUTplZ4&language=ja&region=jp">
</script>
<script type = "text/javascript">

    var map;
    var infowindow = new google.maps.InfoWindow();
    var geocoder;
    var geocodemarker = [];

    function initialize(){
        var latlng = new google.maps.LatLng(35.709038, 139.731992);   // 서울 : 37.5240220, 126.9265940  지도의 처음위치 표시 ( 현 도쿄)
        var myOptions = {
            zoom: 16,
            center:latlng,
            mapTypeControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        geocoder =  new google.maps.Geocoder();
        google.maps.event.addListener(map, 'click', codeCoordinate);
        // codeCoordinate함수 = 클릭한 지점의 좌표를 가지고 주소를 찾는 함수
    }

    function Setmarker(latLng) {

        if (geocodemarker.length > 0)
        {
            geocodemarker[0].setMap(null);
        }
// marker.length는 marker라는 배열의 원소의 개수입니다.
// 다른 지점을 클릭할 때 기존의 마커를 제거

        geocodemarker = [];
        geocodemarker.length = 0;
// marker를 빈 배열로 만들고, marker 배열의 개수를 0개로 만들어 marker 배열을 초기화

        geocodemarker.push(new google.maps.Marker({
            position: latLng,
            map: map
        } ));
// marker 배열에 새 marker object를 push 함수로 추가합니다.
    }
    // 클릭한 지점에 마커 표시
    //입력 받은 주소를 지오코딩 요청하고 결과를 마커로 지도에 표시합니다.

    function codeAddress(event) {

        if (geocodemarker.length > 0)
        {
            for (var i=0;i<geocodemarker.length ;i++ )
            {
                geocodemarker[i].setMap(null);
            }
            geocodemarker =[];
            geocodemarker.length = 0;
        }

        var address = document.getElementById("flocation").value;
        //아래의 주소 입력창에서 받은 정보를 address 변수에 저장합니다.;
        //지오코딩하는 부분입니다.
        geocoder.geocode( {'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)  //Geocoding 성공시
            {

                infowindow.setContent(results[0].formatted_address);
                map.setCenter(results[0].geometry.location);
                geocodemarker.push(new google.maps.Marker({
                    center: results[0].geometry.location,
                    position: results[0].geometry.location,
                    map: map
                }));
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map,geocodemarker[0]);
                //결과를 지도에 marker에 표시합니다.
                var cnt = results[0].address_components.length;
                console.log(results[0].address_components[cnt-2].long_name);
                console.log(results[0].address_components[cnt-3].long_name);
                console.log(results[0].address_components[0].long_name);
                console.log(results[0].geometry.location.lat());
                console.log(results[0].geometry.location.lng());

                document.getElementById("flocation").value = results[0].formatted_address;
            }
            else
            { alert("エラー:"  + address);

            }
        });
    }


    //클릭 시 주소 반환
    function codeCoordinate(event) {

        Setmarker(event.latLng);
        //이벤트 발생 시 그 좌표에 마커 생성

        // 좌표를 받아 reverse geocoding 실행
        geocoder.geocode({'latLng' : event.latLng}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK)  {
                if (results[0])
                {
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map,geocodemarker[0]);
                    //infowindow = 주소 표시
                    var cnt = results[0].address_components.length;
                    console.log(results[0].address_components[cnt-2].long_name);
                    console.log(results[0].address_components[cnt-3].long_name);
                    console.log(results[0].address_components[0].long_name);
                    console.log(results[0].geometry.location.lat());
                    console.log(results[0].geometry.location.lng());

                    document.getElementById("flocation").value = results[0].formatted_address;

                }
            }
        });
    }

    function position()
    {
        var pos=geocodemarker[0].getPosition();

        //alert(pos.lat()+"/"+pos.lng());
        //return {x:pos.lat(), y:pos.lng()};

        var position = pos.lat() + "/" + pos.lng();

        document.getElementById("position").value = position;
    }
</script>