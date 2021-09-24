$( document ).ready(function() {
    $(".leaflet-marker-icon").show();
    maps();
    get_kategori();
    $("#inp_pengaduan").click(function(){
        inp_pengaduan();
   });
   
   $('#i_kasus').select2({
     placeholder: "Select Kategori Kasus",
    });

});
     
function maps(){
    // buat fungsi Cari lokasi
    var map = L.map('mapid', {
        center: [-7.56986, 110.82819],
        zoom: 13 });
        L.control.scale().addTo(map);
        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors' 
        }).
        addTo(map);
        var popup = L.popup();
        var searchControl = new L.esri.Controls.Geosearch().addTo(map);

        var results = new L.LayerGroup().addTo(map);
        searchControl.on('results', function (data) {
        results.clearLayers();
        for (var i = data.results.length - 1; i >= 0; i--) {if (window.CP.shouldStopExecution(0)) break;
            results.addLayer(L.marker(data.results[i].latlng)
            .bindPopup("<table style='margin-left:-3%;'><tr><th>Alamat</th><th>"+data.results[i].text+"</th></tr><tr><td>Detail</td><td id='dis_name'>"+data.results[i].city+"</td></tr><tr><td>Koordinat</td><td>("+data.results[i].latlng.lat+","+data.results[i].latlng.lng+")</td></tr></table>"));
            // .bindPopup(data.results[i].text));
            var alamat = "Alamat : "+data.results[i].text+"\nDetail : "+data.results[i].city ;
            document.getElementById('i_alamat').value = alamat;
            document.getElementById('i_lat').value = data.results[i].latlng.lat;
            document.getElementById('i_lng').value = data.results[i].latlng.lng;  
            var search_latlong = $("#i_lat").val();
            if (search_latlong != '') {   
                $(".leaflet-popup-tip-container").hide();
                $(".leaflet-popup-content-wrapper").hide();
                notif_peringatan(title='',message='Pastikan Titik Koordinat Sesuai !!!',type='danger');
                
            }
            if (data.results[i].city != '') {
                notif_peringatan(title='',message='Harap Lengkapi Detail Alamat!',type='danger');
            }
        }window.CP.exitedLoop(0);
        });
        setTimeout(function () {$('.pointer').fadeOut('slow');}, 3400);

        // buat fungsi popup saat map diklik
        function onMapClick(e) {
            $.get('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='+e.latlng.lat+'&lon='+e.latlng.lng+'', function(data){
                popup
                .setLatLng(e.latlng)
                .setContent(
                    "<table style='margin-left:-3%;'><tr><th>Alamat</th><th>"+data.address.road+"</th></tr><tr><td>Detail</td><td id='dis_name'>"+data.display_name+"</td></tr><tr><td>Koordinat</td><td>("+e.latlng.lat+","+e.latlng.lng+")</td></tr></table>"
                    .toString()
                ) 
                .openOn(map);               
            var search_latlong = $("#i_lat").val();
            if (search_latlong != '') {
                notif_peringatan(title='',message='Pastikan Titik Koordinat Sesuai !!!',type='danger');
            }
            if (typeof(data.address.road) == 'undefined') {
                notif_peringatan(title='',message='Alamat Undefined! Harap di input Manual !!!',type='danger');
            }
            var alamat = "Alamat : "+data.address.road+"\nDetail : "+data.display_name;
            document.getElementById('i_alamat').value = alamat ;
            document.getElementById('i_lat').value = e.latlng.lat;
            document.getElementById('i_lng').value = e.latlng.lng; 

            }); 
        }
        map.on('click', onMapClick);

        
}
// function maps(){
//             var mymap = L.map('mapid').setView([-7.550676, 110.828316], 12);   
//             mymap.removeControl( mymap.zoomControl ); 
//             //setting maps menggunakan api mapbox bukan google maps, daftar dan dapatkan token      
//             L.tileLayer(
//                 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmFiaWxjaGVuIiwiYSI6ImNrOWZzeXh5bzA1eTQzZGxpZTQ0cjIxZ2UifQ.1YMI-9pZhxALpQ_7x2MxHw', {
//                     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
//                     maxZoom: 20,
//                     id: 'mapbox/streets-v11',
//                     tileSize: 512,
//                     zoomOffset: -1,
//                     accessToken: 'your.mapbox.access.token'
//                 }).addTo(mymap);

//             var popup = L.popup();

//             function onMapClick(e) {
//                 popup
//                 .setLatLng(e.latlng)
//                 .setContent("koordinatnya adalah " + e.latlng.toString()) //set isi konten yang ingin ditampilkan, kali ini kita akan menampilkan latitude dan longitude
//                 .openOn(mymap);

//                 // document.getElementById('latlong').value = e.latlng;
//                 document.getElementById('i_lat').value = e.latlng.lat;
//                 document.getElementById('i_lng').value = e.latlng.lng;  
//             }
//             mymap.on('click', onMapClick); //jalankan fungsi

// }

function inp_pengaduan() {
    var url = "../Pengaduan/list_pengaduan ";
    var i_kasus = $("#i_kasus").val();
    var i_alamat= $("#i_alamat").val();
    var i_lat = $("#i_lat").val();
    var i_lng = $("#i_lng").val();
    var i_pelapor = $("#i_pelapor").val();
    var i_peng = $("#i_peng").val();
    var i_nohp = $("#i_nohp").val();
    var i_ket = $("#i_ket").val();
    var postData = {
        "kasus": i_kasus,
        "alamat": i_alamat,
        "lat": i_lat,
        "lng": i_lng,
        "pelapor": i_pelapor,
        "pengaduan": i_peng,
        "nohp": i_nohp,
        "ket": i_ket
    };
   
    if (i_kasus == "" || i_alamat == "" || i_lat =="" ||  i_lng == "" ||i_pelapor == "" ||i_peng == ""  || i_nohp == "" ||i_ket == "" ) {
        notif_peringatan(title='Input Pengaduan Gagal!', message='Silahkan Lengkapi Field Yang Masih Kosong',type='danger')
    }else{
        swal({
            title: "Are you sure?",
            text: "Once entered, the data will be stored in the database",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url : "../Proses/insert_pengaduan",
                    method : "POST",
                    async : true,
                    data: postData, 
                    dataType : 'json',
                    success: function(response){  
                        swal("Holla!, data entered successfully", {
                            icon: "success",
                        },);
                        window.location=url;
                    }
                });
            } else {
              swal("Data not entered!");
            }
          });
    


    }

}


function notif_peringatan(title,message,type) {
    $.notify({
        title: title,
        message: message
     },
     {
        type: type,
        allow_dismiss:false,
        newest_on_top:false ,
        mouse_over:false,
        showProgressbar:false,
        spacing:10,
        timer:2000,
        placement:{
          from:'top',
          align:'right'
        },
        offset:{
          x:30,
          y:30
        },
        delay:1000 ,
        z_index:10000,
        animate:{
          enter:'animated bounce',
          exit:'animated bounce'
      }
    });
}



function get_kategori() {
    var postData ={
        'id' : ''
    };
    $.ajax({
        url : "../backend/Api_kategori/get",
        method : "POST",
        async : true,
        data: postData, 
        dataType : 'json',
        success: function(response){  
            $.each(response, function(index) {
                $("#i_kasus").append('<option value='+response[index].id+'>'+response[index].peng_kategori+'</option>');
                // console.log (index);
                // console.log (response[index]);
                // console.log (response[index].name);
                
            });
        }
    });
    
}
