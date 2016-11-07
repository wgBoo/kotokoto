function ajax(mno, flocation) {

    $('.order_modal-body form:last').remove();

    $.ajax({
        url: '/Admin/materialInfo/' + mno ,
        type: 'POST',
        data: {
            "mno": mno
        },
        dataType:'json',
        success: function(data) {
            if(data.result == 'success') {
                $('.order_modal-body').append(data.modal);
                document.getElementById("flocation2").value = data.flocation;

                var geocoder;

                geocoder =  new google.maps.Geocoder();

                var address = document.getElementById("flocation2").value;

                geocoder.geocode( {'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK)  //Geocoding 성공시
                    {

                        infowindow.setContent(results[0].formatted_address);

                        document.getElementById("flocationX").value = results[0].geometry.location.lat();
                        document.getElementById("flocationY").value = results[0].geometry.location.lng();
                    }});
            }
            else {
                window.alert(data);
            }
        },
        error: function() {
            window.alert('오류가 발생하였습니다.');
        }
    });
}