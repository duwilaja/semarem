var mk = [];
var mymap = L.map('mapid').setView([-7.558865108655025, 110.82722410076913], 13);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoibWF0cmlrbW10IiwiYSI6ImNrb2R3cmtrMzA1aWkydW5xZTMxMGFmYnIifQ.lOy8K-JftfPVgLisOyiMww'
}).addTo(mymap);


// function onEachFeature(feature, layer) {
// 	var popupContent = "";

// 	//jika feature memiliki properties
// 	// dan jika memiliki properties.Kelurahan
// 	if (feature.properties && feature.properties.Kecamatan) {
// 		popupContent += feature.properties.Kecamatan;
// 	}

// 	layer.bindPopup(popupContent);
// }

// // Icon options
// var iconOptions = {
//    iconUrl: '../my/simulasi/car-top.png',
//    iconSize: [30, 40]
// }

// // Creating a custom icon
// // var customIcon = L.icon(iconOptions);

// // const a = L.marker([-7.558865108655025, 110.82722410076913],{icon: customIcon,rotationAngle:90}).addTo(mymap)
// // 		.bindPopup("<b>Hello world!</b><br />I am a popup.");

// // a.on('click', function(e){
// //     mymap.setView(e.latlng, 20);
// // });

// var planes = [
//     [
//         "aLatLng(-7.556845, 110.782013)",
//         -7.55684490468251,
//         110.78201293945314
//     ],
//     [
//         "aLatLng(-7.559738, 110.804501)",
//         -7.559737793090385,
//         110.804500579834
//     ],
//     [
//         "aLatLng(-7.579477, 110.769482)",
//         -7.579476984441851,
//         110.76948165893556
//     ],
//     [
//         "aLatLng(-7.578626, 110.802612)",
//         -7.578626175872434,
//         110.80261230468751
//     ],
//     [
//         "aLatLng(-7.574542, 110.830421)",
//         -7.574542271343764,
//         110.8304214477539
//     ]
//   ];

//   mymap.on('click', function(e) {      
//         var popLocation= e.latlng;
//         mk.push(['a'+e.latlng,e.latlng.lat,e.latlng.lng]);
//         var popup = L.popup()
//         .setLatLng(popLocation)
//         .setContent('<p>Hello world!<br />This is a nice popup.</p>')
//         .openOn(mymap);   

//         console.log(mk);     
//     });

// for (var i = 0; i < planes.length; i++) {
//    marker = new L.marker([planes[i][1],planes[i][2]])
//     .bindPopup(planes[i][0])
//     .addTo(mymap);

//     marker.on('click', function(e){
//         mymap.setView(e.latlng, 17);
//         mymap.removeLayer(marker)
//         console.log(i);
//     });
//   }

// geojson = L.geoJson(ok, {
// 		onEachFeature: onEachFeature
// 	}).addTo(mymap);


var map;
var markers=[];
let black_spot = [];
let ts = [];
var i_polisi = 0;
var i_ambulan = 0;
var cctv_arr = [];
var cctv_link = [];
var infoWindow = null;
var label = '';
var titik_arr = [];
var titik_link = [];

var lokasi_arr = [];
var lokasi_link = [];

var polisi_arr = [];
var polisi_link = [];

var damkar_arr = [];
var damkar_link = [];

var rumah_sakit_arr = [];
var rumah_sakit_link = [];

var dishub_arr = [];
var dishub_link = [];

var kend_indicar = {
  'mobil' : [],
  'route' : []
};

$(document).ready(function() {
  if (Notification.permission !== "granted")
  Notification.requestPermission();

  getData('../Welcome/get_kategori_lokasi')
  .then(data => {
    data.forEach(e => {
      let lokasi = document.getElementById('lokasi_solo');
      lokasi.innerHTML = 'Hello';
    });
  });

});

const createMarker = ({ map, position }) => {
  new google.maps.Marker({ map, position });
};


function rumah_sakit() { 
  
  let arr = [
    [-7.565642859569382, 110.80511693868215],
    // [-7.562747286803227, 110.80179861908191]
  ];
  
  for (let i = 0; i < arr.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(arr[i][0], arr[i][1]),
      map: map,
      icon:{
        url : "../my/simulasi/hospital.png"
      }
    });
    
    // setTimeout(() => {
    //   realtime_ambulan();
    // }, 300);
    
    markers.push(marker);
  }
}

function dishub() { 
  let arr = [
    [-7.554117393969511, 110.8094377859555],
    // [-7.561196262588956, 110.83477438524058]
  ];
  
  for (let i = 0; i < arr.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(arr[i][0], arr[i][1]),
      map: map,
      icon:{
        url : "../my/simulasi/dishub.png"
      }
    });
    
    console.log(arr[i]);
    
    markers.push(marker);
  }
}

function crash(open='') { 
  let arr = [
    [-7.5566230003386785, 110.80478905118466]
  ];
  
  for (let i = 0; i < arr.length; i++) {
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(arr[i][0], arr[i][1]),
      map: map,
      icon:{
        url : "../my/simulasi/crash.png"
      },
      animation: google.maps.Animation.DROP
      
    });
    
    if (open == 'yes') {
      $('#myModal').modal('show')
      map.panTo(marker.position); 
      map.setZoom(18);
    }
    
    google.maps.event.addListener(marker, 'click', function() {
      $('#myModal').modal('show')
      map.panTo(marker.position); 
      map.setZoom(18);
    });
    
    
    console.log('crash' + arr[i]);
    setTimeout(() => {
      toggleBounce(marker);
    }, 300);
    
    markers.push(marker);
  }
}



function polisi() { 
  
  let arr = [
    [-7.57000327393688, 110.80984566501888],
    // [-7.570387716738028, 110.82942015859324]
  ];
  
  for (let i = 0; i < arr.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(arr[i][0], arr[i][1]),
      map: map,
      icon:{
        url : "../my/simulasi/polisi.png"
      }
    });
    
    markers.push(marker);
  }
}

function realtime_polisi() { 
  let arr = [
    [-7.57000327393688, 110.80984566501888]
  ];
  
  m_polisi = new google.maps.Marker({
    position: new google.maps.LatLng(arr[0][0], arr[0][1]),
    map: map,
    icon:{
      url : "../my/simulasi/car_rt.png"
    }
  });
  
  let arr_jalan = [
    [-7.569843754774201, 110.8105323481501],
    [-7.56875894643799, 110.81069327561657],
    [-7.567737549564123, 110.81090211489756],
    [-7.566829762110162, 110.81106299800506],
    [-7.566455112607616, 110.80967508607549],
    [-7.566113653781232, 110.8088947400619],
    [-7.565800330315063, 110.80780598659592],
    [-7.565347749488063, 110.80597969979023],
    [-7.565347749488063, 110.80597969979023],
    [-7.563606994517506, 110.80640113868401],
    [-7.5621099409165415, 110.80682257778913],
    [-7.56061288168898, 110.80724401638611],
    [-7.559533601764703, 110.80756009545436],
    [-7.558837292180255, 110.80759521262114],
    [-7.557618763764246, 110.80626063257333],
    [-7.556643935675371, 110.80471533724233],
    [-7.5566230003386785, 110.80478905118466],
  ];
  
  myLoop(arr_jalan,m_polisi,i_polisi,'#2d2d2d');
}  

function realtime_ambulan() { 
  let arr = [
    [-7.565176225824827, 110.80535675982146]
  ];
  
  m_ambulan = new google.maps.Marker({
    position: new google.maps.LatLng(arr[0][0], arr[0][1]),
    map: map,
    icon:{
      url : "../my/simulasi/ambulan_rt.png"
    }
  });
  
  let arr_jalan = [
    [-7.565323495073493, 110.80587673905954],
    [-7.565058404615492, 110.80609215780208],
    [-7.5645576794056035, 110.80620357970139],
    [-7.563239592987016, 110.8065155643903],
    [-7.562311774581239, 110.80679783727179],
    [-7.561243309522798, 110.80712073441916],
    [-7.559602378432047, 110.80757484035203],
    [-7.558992484784104, 110.80769202928408],
    [-7.558121213225833, 110.80690099323921],
    [-7.5571628074290365, 110.80548007413196],
    [-7.5566230003386785, 110.80478905118466]
  ];
  
  myLoop(arr_jalan,m_ambulan,i_ambulan,'#bc090c');
}  

function updateMarker(marker, latitude, longitude,color,angel,vehiclename) {
    var newLatLng = new L.LatLng(latitude, longitude);
     marker.setLatLng(newLatLng); 
     marker.setRotationAngle(angel);
     createLabel(marker,vehiclename);
 }

    
    
    //  set your counter to 1
    function myLoop(arr_jalan,m,i1,color) { 
      setTimeout(function() {   //  call a 3s setTimeout when the loop is called
        i1++;                    //  increment the counter
        if (i1 < arr_jalan.length) {           //  if the counter < 10, call the loop function
          myLoop(arr_jalan,m,i1,color); 
          // m.setPosition(new google.maps.LatLng(arr_jalan[i1][0],arr_jalan[i1][1]));     
          updateMarker(m,arr_jalan[i1][0],arr_jalan[i1][1],color)       //  ..  again which will trigger another 
        }                       //  ..  setTimeout()
      }, 1000)
    }
    
    // function mobil_gerak() { 
    //   const directionsRenderer = new google.maps.DirectionsRenderer({
    //     polylineOptions: {
    //       strokeColor: "red"
    //     }
    //   });
    //   const directionsService = new google.maps.DirectionsService();
    //   directionsRenderer.setMap(map);
    //   kalkulasi_jalan(directionsService, directionsRenderer);
    // }
    
    // function kalkulasi_jalan(directionsService,directionsRenderer) { 
    //   directionsService.route(
    //     {
    //       origin: { lat:-7.57000327393688, lng: 110.80984566501888 },
    //       destination: { lat: -7.5566230003386785, lng: 110.80478905118466 },
    //       // waypoints: waypoint_sub,
    //       optimizeWaypoints: true,
    //       // Note that Javascript allows us to access the constant
    //       // using square brackets and a string value as its
    //       // "property."
    //       travelMode: google.maps.TravelMode['DRIVING'],
    //     },
    //     (response, status) => {
    //       if (status == "OK") {
    //         directionsRenderer.setDirections(response);
    //       } else {
    //         window.alert("Directions request failed due to " + status);
    //       }
    //     }
    //   );
    
    // }
    
    function toggleBounce(marker) {
      if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
      } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
      }
      console.log('dsa');
    }
    
    function jalankan(x) { 
      if (x == 'polisi') {
        realtime_polisi();
        $('#modal_progress').modal('show');
        setTimeout(() => {
          $('#modal_progress').modal('hide');
        }, 1000);
      }else if(x == 'ambulan'){
        $('#modal_progress').modal('show');
        setTimeout(() => {
          $('#modal_progress').modal('hide');
        }, 1000);
        realtime_ambulan();
      }
    }
    
    async function postData(url = '', data = {}) {
      // Default options are marked with *
      const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
          'Content-Type': 'application/json',
          'Accept' : 'application/json', 
          'Authorization': 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1laWRlbnRpZmllciI6IjE3MyIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL25hbWUiOiJJT1QuS09STEFOVEFTQEdNQUlMLkNPTSIsIkFzcE5ldC5JZGVudGl0eS5TZWN1cml0eVN0YW1wIjoiYTZhNjI0YzMtZDhmYi00NzI4LTdlN2MtMzlmYjJlNjdkNjQyIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9yb2xlIjoiQWRtaW5HcnVwIiwic3ViIjoiMTczIiwianRpIjoiYTQ1ODUzYWMtOTYwMy00ZDhjLTliZGEtY2Q3Mzc4Njc4MjkxIiwiaWF0IjoxNjIzMTIwMTM1LCJ1c2VybmFtZSI6IklPVC5LT1JMQU5UQVNAR01BSUwuQ09NIiwiZnVsbG5hbWUiOiJJbmRpY2FyIERlbW8gIiwic3RhdHVzIjoiQWN0aXZlIiwicm9sZV9uYW1lIjoiQWRtaW5HcnVwLEFkbWluR3J1cCIsImV4cGlyZWQiOiIwNi8wOS8yMDIxIDAyOjQyOjE1IiwidHlwZV91c2VyIjoiQ3VzdG9tZXIiLCJ0ZW5hbnQiOiJEZWZhdWx0IiwiZ3JvdXAiOiJpb3Qua29ybGFudGFzQGdtYWlsLmNvbSxpb3Qua29ybGFudGFzQGdtYWlsLmNvbSIsImN1c3RvbWVyY29kZSI6IjhhYzhiYjY5MWI4OWFkNDk1Y2Q5NTkzZWZhMWZhMmRhIiwidGVuYW50Y29kZSI6IiIsInVzZXJjb2RlIjoiOTg5MDIzZDIwMTAxODU3ZjE4ZWU0OWU3NmYzNGRmZmUiLCJuYmYiOjE2MjMxMjAxMzUsImV4cCI6MTYyMzIwNjUzNSwiaXNzIjoiSW5kaUNhckJhY2tlbmQiLCJhdWQiOiJJbmRpQ2FyQmFja2VuZCJ9.paO3HI5EvW8HKTrc7_tIZpPUEua3rkyjAOSqa37LvMo'
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data) // body data type must match "Content-Type" header
      });
      return response.json(); // parses JSON response into native JavaScript objects
    }

    function realtime_indicar() { 
      if(kend_indicar.mobil.length < 1){
        getMakeMarkerIndicar().then((x) => {
          x.mobil.forEach(m => {
            updateMarker(m,m.position.lat(),m.position.lng(),'#795548',m.rotation,m.vehiclename);
          });
        }).catch((err) => {
          
        });
      }else{
        var i = 0;
        postData('https://www.indicar.id/platform/public/index.php/sysapi/vehicles/list',{})
        .then(data => {
          data.dataset.forEach(m => {
            updateMarker(kend_indicar.mobil[m.vehicleid],m.latitude,m.longitude,'#795548',m.angle,m.vehiclename);
          });
        });  
      }

    }

    function createLabel(layer, text){
      removeLabel(layer);
       var icon = createStaticLabelIcon(text);
       var testspan = document.createElement("div");
       document.body.appendChild(testspan); 
       
       testspan.className = "textwidth";
       testspan.style.fontSize = "10px";
       testspan.style.width = "max-content";
       testspan.innerHTML = text;
       var width = testspan.clientWidth/2;
       icon.options.iconAnchor = [width, -5]; //That the label is centered
         
       var label = L.marker(layer.getLatLng(),{icon: icon}).addTo(mymap);
       layer.appendedLabel = label;
       
       document.body.removeChild(testspan); 
     }
     
     function createStaticLabelIcon(labelText) {
         return L.divIcon({
             className: "leaflet-marker-label",
             html: '<div class="leaflet-marker-iconlabel" style="background: #fff;color: #000;width:max-content;padding: 0px 6px;border-radius: 10px;margin-top: 8px;opacity: 0.8;border: solid 1px #AAA;font-weight: bold;">'+labelText+'</div>',
             text : labelText,
         });
     }

     
function removeLabel(layer){
  if(layer.appendedLabel){
     mymap.removeLayer(layer.appendedLabel); //Remove label that connected with marker, else the label will not removed
   }
 }

    function getMakeMarkerIndicar() { 
      return new Promise(function(resolve, reject) {
        var marker = {};
        postData('https://www.indicar.id/platform/public/index.php/sysapi/vehicles/list',{})
        .then(data => {
          
          var myIcon = L.icon({
              iconUrl: "../my/simulasi/car-top-view.png",
              iconSize: [20, 20],
              // iconAnchor: [22, 94],
              // popupAnchor: [-3, -76],
            // // shadowUrl: 'my-icon-shadow.png',
            // shadowSize: [68, 95],
            // shadowAnchor: [22, 94]
        });

          data.dataset.forEach(e => {
            marker = new L.marker([e.latitude, e.longitude],{icon : myIcon,rotationAngle: e.angle})
            .addTo(mymap);

            createLabel(marker,e.vehiclename);
            kend_indicar.mobil[e.vehicleid] = marker;
            kend_indicar.route[e.vehicleid] = e.angle;
          });

          resolve(kend_indicar);
        });    
      })
    }
    
    function get_kend(kend='polisi') { 
      var i = 0;
      const ok = new Promise(function(resolve, reject) {
      postData('https://www.indicar.id/platform/public/index.php/sysapi/vehicles/list',{})
      .then(data => {
        data.dataset.forEach(m => {
          $('.owl-carousel')
          .trigger('add.owl.carousel', [`<div class="item"><a href="#" onclick="tes(${m.vehicleid},'${m.vehiclename}','${m.vehiclegroup}')"><img class="avatar brround w-80" src="../aronox/assets/images/users/1.jpg" alt="image" style="height:3rem!important;"></a></div>`])
          .trigger('refresh.owl.carousel');
        });
      });
      });
    }

    // $('.owl-carousel').owlCarousel({
    //   // loop:true,
    //   margin:10,
    //   nav:false,
    //   dots:false,
    //   responsive:{
    //       0:{
    //           items:1
    //       },
    //       600:{
    //           items:3
    //       },
    //       1000:{
    //           items:5
    //       }
    //   }
    // })

    $(function(){
      
      realtime_indicar();
      
      setTimeout(() => {
        setInterval(() => {
          realtime_indicar();
        }, 8000);
      }, 1000);

      // var socket = io.connect('http://36.91.103.46:3000')
      
      // var myCloseInfo = function(){
      //   alert('this is a callback function that runs after close the notification.');
      // };
      
      // //Listen on new_message
      // socket.on("new_message", (data) => {
      //   notifikasi(data.message);
      // })
      
      // function notifikasi(msg) {
      
      //   if (!Notification) {
      //       alert('Browsermu tidak mendukung Web Notification.'); 
      //       return;
      //   }
      
      //   if (Notification.permission !== "granted")
      //       Notification.requestPermission();
      //   else 
      //       console.log('dassa');

      //       var notifikasi = new Notification('Laporan Kecelakaan', {
      //           icon: 'http://36.91.103.46/sm-bi/my/images/logo.png',
      //           body: msg,
      //       });
      
      //       notifikasi.onclick = function () {
      //         crash('yes');
      //         rumah_sakit();
      //         polisi();
      //         dishub();
      //         notifikasi.close();
      //       };
      
      //       setTimeout(function(){
      //           notifikasi.close();
      //       }, 5000);
      // };
      
    });
    
    
    // CCTV 
    function cctv(param='') { 
      prom_get_cctv().then(function(data) {
        list_cctv();
      });
    }
    
    function create_cctv_map(arrx,item,icon) { 
      // cctv_arr = [];
      
      // arr = cctv_link;
      // if(arrx) arr = arrx; 
      
      // for (let i = 0; i < arr.length; i++) {
      //   marker = new google.maps.Marker({
      //     position: new google.maps.LatLng(arr[i].kordinat[0], arr[i].kordinat[1]),
      //     map: map,
      //     icon:{
      //       url: "../my/images/cctv.png", // url
      //       scaledSize: new google.maps.Size(20, 20), // scaled size
      //       origin: new google.maps.Point(0,0), // origin
      //       anchor: new google.maps.Point(0,0) // anchor
      //     }
      //   });
      //   cctv_arr.push(marker);
      // }
      
      // setTimeout(() => {
      //   setInfoWindowCCTV(item);
      // }, 500);
      
      prom_create_cctv_map(arrx,item,icon).then(function(data) {
        setInfoWindowCCTV(item);
      });
    }
    
    function prom_create_cctv_map(arrx,item,icon=null) {
      return new Promise(function(resolve, reject) {
        cctv_arr = [];
        arr = cctv_link;
        if(arrx) arr = arrx; 
        if(icon) icons = icon;

        var myIcon = L.icon({
            iconUrl: icon,
            iconSize: [20, 20],
            // iconAnchor: [22, 94],
            // popupAnchor: [-3, -76],
          // // shadowUrl: 'my-icon-shadow.png',
          // shadowSize: [68, 95],
          // shadowAnchor: [22, 94]
      });
     
        for (let i = 0; i < arr.length; i++) {

          const total = arr[i].total;
          marker = new L.marker([arr[i].kordinat[0],arr[i].kordinat[1]],{icon: myIcon})
          .addTo(mymap);

          // marker = new google.maps.Marker({
          //   position: new google.maps.LatLng(arr[i].kordinat[0], arr[i].kordinat[1]),
          //   map: map,
          //   icon: icons,
          //   Label: {
          //     className:'my-custom-class-for-label',
          //     text:  item == 'traffic_counting' ? `${total}` : ( item == 'average_speed' ? `0 km/h` : (item == 'length_ocupantion' ? `0 m` : ` `)) ,
          //     // fontWeight: 'bold',
          //     // fontSize: '9px',
          //     // fontFamily: '"Courier New", Courier,Monospace',
          //     // color: 'white',
          //   }
          // });
          cctv_arr.push(marker);
        }
        
        resolve(cctv_arr);
      })
    }
    
    function setInfoWindowCCTV(item2='',n_titik='CCTV') {
      var info = '';
      for (let i = 0; i < cctv_arr.length; i++) {

        if (n_titik=='CCTV' && item2=='traffic_counting') {
              const item2 = 'Traffic Counting'; 
              info = `<div><p><b>${n_titik} - ${item2}</b></p>
              <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
              <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
              <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
              </div>
              <div class="mt-3">
              <table class="w-100">
              <tr>
              <td><b>Nama</b></td>
              <td>:</td>
              <td>${cctv_link[i].nama}</td>
              </tr>
              <tr>
              <td><b>Kordinat</b></td>
              <td>:</td>
              <td>${cctv_link[i].kordinat}</td>
              </tr>
              <tr>
              <td><b>Total Kendaraan</b></td>
              <td>:</td>
              <td>${cctv_link[i].total}</td>
              </tr>
              </table>
              </div>
              <div class="row" style="margin-right:0 !important;">
              <div class="ml-auto">
              <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=traffic_counting" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
              </div>
              </div>
              </div>
              `;
            }else if (n_titik=='CCTV' && item2=='traffic_category') {
              const item2 = 'Traffic Category'; 
              info = `<div><p><b>${n_titik} - ${item2}</b></p>
              <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
              <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
              <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
              </div>
              <div class="mt-3">
              <table class="w-100">
              <tr>
              <td><b>Nama</b></td>
              <td>:</td>
              <td>${cctv_link[i].nama}</td>
              </tr>
              <tr>
              <td><b>Kordinat</b></td>
              <td>:</td>
              <td>${cctv_link[i].kordinat}</td>
              </tr>
              </table>
              <table class="table table-bordered mt-3">
              <thead>
              <tr>
              <th>Kendaraan</th>
              <th>Jumlah</th>
              </tr>
              </thead>
              <tbody id="t${cctv_link[i].id}">
              </tbody>
              </table>
              </div>
              <div class="row" style="margin-right:0 !important;">
              <div class="ml-auto">
              <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=traffic_category" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
              </div>
              </div>
              </div>
              `;
              
              setTimeout(() => {
                to_table_traffic_category('#t'+cctv_link[i].id,cctv_link[i].kategori);
              }, 1000);
            }else if (n_titik=='CCTV' && item2=='average_speed') {
              const item2 = 'Average Speed'; 
              info = `<div><p><b>${n_titik} - ${item2}</b></p>
              <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
              <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
              <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
              </div>
              <div class="mt-3">
              <table class="w-100">
              <tr>
              <td><b>Nama</b></td>
              <td>:</td>
              <td>${cctv_link[i].nama}</td>
              </tr>
              <tr>
              <td><b>Kordinat</b></td>
              <td>:</td>
              <td>${cctv_link[i].kordinat}</td>
              </tr>
              <tr>
              <td><b>Kecepatan Rata Rata</b></td>
              <td>:</td>
              <td></td>
              </tr>
              </table>
              </div>
              <div class="row" style="margin-right:0 !important;">
              <div class="ml-auto">
              <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=average_speed" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
              </div>
              </div>
              </div>
              `;
            }else if (n_titik=='CCTV' && item2=='length_ocupantion') {
              const item2 = 'Length Ocupation'; 
              info = `<div><p><b>${n_titik} - ${item2}</b></p>
              <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
              <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
              <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
              </div>
              <div class="mt-3">
              <table class="w-100">
              <tr>
              <td><b>Nama</b></td>
              <td>:</td>
              <td>${cctv_link[i].nama}</td>
              </tr>
              <tr>
              <td><b>Kordinat</b></td>
              <td>:</td>
              <td>${cctv_link[i].kordinat}</td>
              </tr>
              <tr>
              <td><b>Panjang Kemacetan</b></td>
              <td>:</td>
              <td></td>
              </tr>
              </table>
              </div>
              <div class="row" style="margin-right:0 !important;">
              <div class="ml-auto">
              <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=length_ocupantion" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
              </div>
              </div>
              </div>
              `;
            }else{
              info = `<div><p><b>${n_titik}</b></p>
              <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
              <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
              <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
              </div>
              <div class="mt-3">
              <table class="w-100">
              <tr>
              <td><b>Nama</b></td>
              <td>:</td>
              <td>${cctv_link[i].nama}</td>
              </tr>
              <tr>
              <td><b>Kordinat</b></td>
              <td>:</td>
              <td>${cctv_link[i].kordinat}</td>
              </tr>
              </table>
              </div>
              <div class="row" style="margin-right:0 !important;">
              <div class="ml-auto">
              <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=length_ocupantion" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
              </div>
              </div>
              </div>
              `;
            }

            cctv_arr[i].bindPopup(info,{
              minWidth : 420
            });

            cctv_arr[i].on('click', function(e){
              mymap.setView(e.latlng, 17);
              console.log(i);
            });

        // cctv_arr[i].setMap(map);
        // google.maps.event.addListener(cctv_arr[i], 'click', function() {
        //   // window.location.href = this.url;
        //   map.setCenter(cctv_arr[i].getPosition());
        //   map.setZoom(15);
        //   if (n_titik=='CCTV' && item2=='traffic_counting') {
        //     const item2 = 'Traffic Counting'; 
        //     info = `<div><p><b>${n_titik} - ${item2}</b></p>
        //     <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
        //     <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
        //     <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
        //     </div>
        //     <div class="mt-3">
        //     <table class="w-100">
        //     <tr>
        //     <td><b>Nama</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].nama}</td>
        //     </tr>
        //     <tr>
        //     <td><b>Kordinat</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].kordinat}</td>
        //     </tr>
        //     <tr>
        //     <td><b>Total Kendaraan</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].total}</td>
        //     </tr>
        //     </table>
        //     </div>
        //     <div class="row" style="margin-right:0 !important;">
        //     <div class="ml-auto">
        //     <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=traffic_counting" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
        //     </div>
        //     </div>
        //     </div>
        //     `,
        //     );
        //     infoWindow.open(map,cctv_arr[i]);
        //   }else if (n_titik=='CCTV' && item2=='traffic_category') {
        //     const item2 = 'Traffic Category'; 
        //     info = `<div><p><b>${n_titik} - ${item2}</b></p>
        //     <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
        //     <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
        //     <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
        //     </div>
        //     <div class="mt-3">
        //     <table class="w-100">
        //     <tr>
        //     <td><b>Nama</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].nama}</td>
        //     </tr>
        //     <tr>
        //     <td><b>Kordinat</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].kordinat}</td>
        //     </tr>
        //     </table>
        //     <table class="table table-bordered mt-3">
        //     <thead>
        //     <tr>
        //     <th>Kendaraan</th>
        //     <th>Jumlah</th>
        //     </tr>
        //     </thead>
        //     <tbody id="t${cctv_link[i].id}">
        //     </tbody>
        //     </table>
        //     </div>
        //     <div class="row" style="margin-right:0 !important;">
        //     <div class="ml-auto">
        //     <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=traffic_category" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
        //     </div>
        //     </div>
        //     </div>
        //     `,
        //     );
            
        //     infoWindow.open(map,cctv_arr[i]);
        //     setTimeout(() => {
        //       to_table_traffic_category('#t'+cctv_link[i].id,cctv_link[i].kategori);
        //     }, 1000);
        //   }else if (n_titik=='CCTV' && item2=='average_speed') {
        //     const item2 = 'Average Speed'; 
        //     info = `<div><p><b>${n_titik} - ${item2}</b></p>
        //     <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
        //     <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
        //     <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
        //     </div>
        //     <div class="mt-3">
        //     <table class="w-100">
        //     <tr>
        //     <td><b>Nama</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].nama}</td>
        //     </tr>
        //     <tr>
        //     <td><b>Kordinat</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].kordinat}</td>
        //     </tr>
        //     <tr>
        //     <td><b>Kecepatan Rata Rata</b></td>
        //     <td>:</td>
        //     <td></td>
        //     </tr>
        //     </table>
        //     </div>
        //     <div class="row" style="margin-right:0 !important;">
        //     <div class="ml-auto">
        //     <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=average_speed" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
        //     </div>
        //     </div>
        //     </div>
        //     `,
        //     );
        //     infoWindow.open(map,cctv_arr[i]);
        //   }else if (n_titik=='CCTV' && item2=='length_ocupantion') {
        //     const item2 = 'Length Ocupation'; 
        //     info = `<div><p><b>${n_titik} - ${item2}</b></p>
        //     <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
        //     <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
        //     <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
        //     </div>
        //     <div class="mt-3">
        //     <table class="w-100">
        //     <tr>
        //     <td><b>Nama</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].nama}</td>
        //     </tr>
        //     <tr>
        //     <td><b>Kordinat</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].kordinat}</td>
        //     </tr>
        //     <tr>
        //     <td><b>Panjang Kemacetan</b></td>
        //     <td>:</td>
        //     <td></td>
        //     </tr>
        //     </table>
        //     </div>
        //     <div class="row" style="margin-right:0 !important;">
        //     <div class="ml-auto">
        //     <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=length_ocupantion" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
        //     </div>
        //     </div>
        //     </div>
        //     `,
        //     );
        //     infoWindow.open(map,cctv_arr[i]);
        //   }else{
        //     info = `<div><p><b>${n_titik}</b></p>
        //     <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
        //     <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
        //     <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
        //     </div>
        //     <div class="mt-3">
        //     <table class="w-100">
        //     <tr>
        //     <td><b>Nama</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].nama}</td>
        //     </tr>
        //     <tr>
        //     <td><b>Kordinat</b></td>
        //     <td>:</td>
        //     <td>${cctv_link[i].kordinat}</td>
        //     </tr>
        //     </table>
        //     </div>
        //     <div class="row" style="margin-right:0 !important;">
        //     <div class="ml-auto">
        //     <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=length_ocupantion" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
        //     </div>
        //     </div>
        //     </div>
        //     `,
        //     );
        //   }
        //   map.panTo(cctv_arr[i].position);
        // });
      }
      
    }
    
    function list_cctv() { 
      $('#list_cctv').html('');
      setTimeout(() => {
        var no = 0;
        cctv_link.forEach(e => {
          $('#list_cctv').append(`<div class="list-group-item list-group-item-action">
          <input type="checkbox" class="mr-2 check-cctv-korlantas" onchange="check_cctv()" name="cctv[]" value="${no++}">
          <span class="name_cctv">${e.nama} </span></div>`);
        });
      }, 300);
    }
    
    function check_cctv() { 
      
      // setTimeout(() => {
      //   $('input[name="cctv[]"]:checked').each(function() {
      //     check_cctv.push(cctv_link[this.value]);
      //   });
      //   setTimeout(() => {
      //     clearMarkerCctv()
      //     setTimeout(() => {
      //       cctv = check_cctv;
      //       create_cctv_map(cctv);
      //     }, 700);
      //   }, 500);
      // }, 500);
      
      prom_check_cctv().then(function(hasil) {
        prom_clearMarkerCctv().then(function(data) {
          cctv = hasil;
          create_cctv_map(cctv,label,'../my/images/cctv.png');
        });
      });
    }
    
    function prom_clearMarkerCctv() {
      return new Promise(function(resolve, reject) {
        if (cctv_arr) {
          for (let i = 0; i < cctv_arr.length; i++) {
            // cctv_arr[i].setMap(null);
            mymap.removeLayer(cctv_arr[i])
          }
          resolve(cctv_arr);
        }
      })
    }
    
    function prom_check_cctv() {
      return new Promise(function(resolve, reject) {
        var check_cctv = [];
        setTimeout(() => {
          $('input[name="cctv[]"]:checked').each(function() {
            check_cctv.push(cctv_link[this.value]);
          });
          resolve(check_cctv);
        }, 300);
      })
    }
    
    
    function get_cctv(s='',item='') { 
      $.ajax({
        type: "POST",
        url: "get_cctv",
        dataType: "json",
        data : {
          a : item
        },
        success: function (r) {
          cctv_link = r;
        }
      });
    }

    function prom_get_cctv(s='',item='') { 
      return new Promise(function(resolve, reject) {
        $.ajax({
          type: "POST",
          url: "get_cctv",
          dataType: "json",
          data : {
            a : item
          },
          success: function (r) {
            cctv_link = r;
            resolve(cctv_arr);
          }
        });
      })
    }
    
    function clearMarkerCctv(arr) {
      if (cctv_arr) {
        for (let i = 0; i < cctv_arr.length; i++) {
          cctv_arr[i].setMap(null);
        }
      }
    }

    function to_table_traffic_category(table='',data='') { 
      $(table).html('');
      data.forEach(e => {
        $(table).append('<tr><td>'+e.type_kend+'</td><td>'+e.jml+'</td></tr>');
      });
    }
    
    // Titik
    
    function show_titik(item='',item2='') { 
      
      setTimeout(() => {
        var varr;
        // var icon = {
        //   scaledSize: new google.maps.Size(20, 20), // scaled size
        //   origin: new google.maps.Point(0,0), // origin
        //   anchor: new google.maps.Point(0,0) // anchor
        // };
        if (item == 'cctv' && (item2 == 'traffic_counting' || item2 == 'traffic_category' || item2 == 'average_speed' || item2 == 'length_ocupantion')) {
    
          prom_get_cctv('CCTV',item2).then(function(data) {
            // list_cctv();
          });
          
          label = item2;
          
          if (item2 == "traffic_counting") icon = "../my/simulasi/trafficcounting.png";
          if (item2 == "traffic_category") icon = "../my/simulasi/trafficcategory.png";
          if (item2 == "average_speed") icon = "../my/simulasi/avgspeed.png";
          if (item2 == "length_ocupantion") icon = "../my/simulasi/lengthocc.png";

          prom_check_cctv().then(function(hasil) {
            prom_clearMarkerCctv().then(function(data) {
              let cctv = cctv_link;
              if (hasil) {
                cctv = hasil;
              }
              create_cctv_map(cctv,item2,icon);
            });
          });
        }
        
        if (item == 'black_spot') {
          varr = black_spot;
          clearMarkerTitik();
          icon = "../my/simulasi/blackspot.png";
          get_titik('Black Spot');
          setTimeout(() => {
            create_titik_map(varr,icon);
            setTimeout(() => {
              setInfoWindows('Black Spot');
            }, 300);
          }, 200);
        }
        
        if(item == 'trouble_spot'){
          varr = ts;
          clearMarkerTitik();
          icon = "../my/simulasi/troublespot.png";
          get_titik('Trouble Spot');
          setTimeout(() => {
            create_titik_map(varr,icon);
            setTimeout(() => {
              setInfoWindows('Trouble Spot');
            }, 300);
          }, 200);
        }
        
        if(item == 'ambang_gangguan'){
          varr = ts;
          clearMarkerTitik();
          icon = "../my/simulasi/ambanggangguan.png";
          get_titik('Ambang Gangguan');
          setTimeout(() => {
            create_titik_map(varr,icon);
            setTimeout(() => {
              setInfoWindows('Ambang Gangguan');
            }, 300);
          }, 200);
        }
        
        if(item == 'giat_masyarakat'){
          varr = ts;
          clearMarkerTitik();
          icon = "../my/simulasi/giatmasyarakat.png";
          get_titik('Kegiatan Masyarakat');
          setTimeout(() => {
            create_titik_map(varr,icon);
            setTimeout(() => {
              setInfoWindows('Kegiatan Masyarakat');
            }, 300);
          }, 200);
        }
        
        if(item == 'vvip'){
          get_route();
          setTimeout(() => {
            vvip();
          }, 200);
        }
      }, 150);
    }
    
    function create_titik_map(arr,img) { 
      titik_arr = [];
      var m_titik = [];


      var myIcon = L.icon({
          iconUrl: img,
          iconSize: [20, 20],
      });
      
      for (i = 0; i < titik_link.length; i++) {  
        m_titik = new L.marker([titik_link[i].lat,titik_link[i].lng],{icon: myIcon})
          .addTo(mymap);
        
        titik_arr.push(m_titik);
      }
    }
    
    function setInfoWindows(n_titik='',item2='') {
      var info = '';
      for (let i = 0; i < titik_arr.length; i++) {
          if (n_titik=='CCTV' && item2=='traffic_counting') {
            const item2 = 'Traffic Counting'; 
            info = `<div><p><b>${n_titik} - ${item2}</b></p>
            <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
            <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
            <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
            </div>
            <div class="mt-3">
            <table class="w-100">
            <tr>
            <td><b>Nama</b></td>
            <td>:</td>
            <td>${cctv_link[i].nama}</td>
            </tr>
            <tr>
            <td><b>Kordinat</b></td>
            <td>:</td>
            <td>${cctv_link[i].kordinat}</td>
            </tr>
            <tr>
            <td><b>Total Kendaraan</b></td>
            <td>:</td>
            <td>${cctv_link[i].total}</td>
            </tr>
            </table>
            </div>
            <div class="row" style="margin-right:0 !important;">
            <div class="ml-auto">
            <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=traffic_counting" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
            </div>
            </div>
            </div>
            `;
            
          }else if (n_titik=='CCTV' && item2=='traffic_category') {
            const item2 = 'Traffic Category'; 
            info = `<div><p><b>${n_titik} - ${item2}</b></p>
            <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
            <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
            <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
            </div>
            <div class="mt-3">
            <table class="w-100">
            <tr>
            <td><b>Nama</b></td>
            <td>:</td>
            <td>${cctv_link[i].nama}</td>
            </tr>
            <tr>
            <td><b>Kordinat</b></td>
            <td>:</td>
            <td>${cctv_link[i].kordinat}</td>
            </tr>
            </table>
            <table class="table table-bordered mt-3">
            <thead>
            <tr>
            <th>Kendaraan</th>
            <th>Jumlah</th>
            </tr>
            </thead>
            <tbody id="t${cctv_link[i].id}">
            </tbody>
            </table>
            </div>
            <div class="row" style="margin-right:0 !important;">
            <div class="ml-auto">
            <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=traffic_category" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
            </div>
            </div>
            </div>
            `;
            
            setTimeout(() => {
              to_table_traffic_category('#t'+cctv_link[i].id,cctv_link[i].kategori);
            }, 1000);
          }else if (n_titik=='CCTV' && item2=='average_speed') {
            const item2 = 'Average Speed'; 
            info = `<div><p><b>${n_titik} - ${item2}</b></p>
            <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
            <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
            <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
            </div>
            <div class="mt-3">
            <table class="w-100">
            <tr>
            <td><b>Nama</b></td>
            <td>:</td>
            <td>${cctv_link[i].nama}</td>
            </tr>
            <tr>
            <td><b>Kordinat</b></td>
            <td>:</td>
            <td>${cctv_link[i].kordinat}</td>
            </tr>
            <tr>
            <td><b>Kecepatan Rata Rata</b></td>
            <td>:</td>
            <td></td>
            </tr>
            </table>
            </div>
            <div class="row" style="margin-right:0 !important;">
            <div class="ml-auto">
            <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=average_speed" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
            </div>
            </div>
            </div>
            `;
            
          }else if (n_titik=='CCTV' && item2=='length_ocupantion') {
            const item2 = 'Length Ocupation'; 
            info = `<div><p><b>${n_titik} - ${item2}</b></p>
            <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
            <div class="embed-responsive embed-responsive-16by9" style="width:100%;">
            <iframe class="embed-responsive-item" src="${"http://"+window.location.hostname+":5000/?u="+cctv_link[i].rtsp}" allowfullscreen></iframe>
            </div>
            <div class="mt-3">
            <table class="w-100">
            <tr>
            <td><b>Nama</b></td>
            <td>:</td>
            <td>${cctv_link[i].nama}</td>
            </tr>
            <tr>
            <td><b>Kordinat</b></td>
            <td>:</td>
            <td>${cctv_link[i].kordinat}</td>
            </tr>
            <tr>
            <td><b>Panjang Kemacetan</b></td>
            <td>:</td>
            <td></td>
            </tr>
            </table>
            </div>
            <div class="row" style="margin-right:0 !important;">
            <div class="ml-auto">
            <a href="../data_analytic/detail_analytic_cctv?id=${cctv_link[i].id}&q=length_ocupantion" class="btn btn-primary">Detail <i class="fa fa-arrow-right"></i></a>
            </div>
            </div>
            </div>
            `;
            
          }else{
            info = `<div><p><b>${n_titik}</b></p>
            <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
            <table class="w-100">
            <tr>
            <td><b>Nama Jalan</b></td>
            <td>:</td>
            <td>${titik_link[i].namajalan}</td>
            </tr>
            <tr>
            <td><b>Kordinat</b></td>
            <td>:</td>
            <td>${titik_link[i].lat+','+titik_link[i].lng}</td>
            </tr>
            <tr>
            <td><b>Status</b></td>
            <td>:</td>
            <td>${titik_link[i].dtm}</td>
            </tr>
            <tr>
            <td><b>Tanggal</b></td>
            <td>:</td>
            <td>${titik_link[i].status}</td>
            </tr>
            <tr>
            <td><b>Jam Mulai</b></td>
            <td>:</td>
            <td>${titik_link[i].jammulai}</td>
            </tr>
            <tr>
            <td><b>Sampai</b></td>
            <td>:</td>
            <td>${titik_link[i].jamsampai}</td>
            </tr>
            <tr>
            <td><b>Penyebab</b></td>
            <td>:</td>
            <td>${titik_link[i].penyebab}</td>
            </tr>
            <tr>
            <td><b>Detail</b></td>
            <td>:</td>
            <td>${titik_link[i].penyebabd}</td>
            </tr>
            <tr>
            <td><b>Sumber Info</b></td>
            <td>:</td>
            <td>${titik_link[i].sumber}</td>
            </tr>
            <tr>
            <td><b>Petugas Lapangan</b></td>
            <td>:</td>
            <td>${titik_link[i].petugas}</td>
            </tr>
            </table>
            </div>
            `;
          }

        mymap.setView({lat : parseFloat(titik_link[i].lat), lng : parseFloat(titik_link[i].lng)}, 13,{animation : true});
        
          titik_arr[i].bindPopup(info,{
          minWidth : 380
        });

        titik_arr[i].on('click', function(e){
          mymap.setView(e.latlng, 17);
        });

      }
      
     
    }
    
    function get_titik(s='') { 
      $.ajax({
        type: "GET",
        url: "get_titik?s="+s,
        dataType: "json",
        success: function (r) {
          titik_link = r;
          $('#n_titik').text(s);
        }
      });
    }
    
    function clearMarkerTitik(arr) {
      if (titik_arr) {
        for (let i = 0; i < titik_arr.length; i++) {
          mymap.removeLayer(titik_arr[i])
        }
      }
    }
    
    // VVIP
    
    function vvip() { 
      var control = L.Routing.control({
        position: 'bottomleft',
        waypoints: waypoint.jalur,
      }).addTo(mymap);

    }
    
    function kalkulasi_jalan(directionsService,directionsRenderer) { 
      directionsService.route(
        {
          origin: { lat:waypoint.jalur.start[0], lng: waypoint.jalur.start[1] },
          destination: { lat: waypoint.jalur.destination[0], lng: waypoint.jalur.destination[1] },
          waypoints: waypoint_sub,
          optimizeWaypoints: true,
          // Note that Javascript allows us to access the constant
          // using square brackets and a string value as its
          // "property."
          travelMode: google.maps.TravelMode['DRIVING'],
        },
        (response, status) => {
          if (status == "OK") {
            directionsRenderer.setDirections(response);
          } else {
            window.alert("Directions request failed due to " + status);
          }
        }
        );
        
      }
      
      function get_route() { 
        waypoint = [];
        waypoint_sub = [];
        
        $.ajax({
          type: "GET",
          url: "get_jalur?id=1",
          dataType: "json",
          success: function (r) {
            waypoint.jalur =  [
              L.latLng(r.jalur.destination[0], r.jalur.destination[1]),
              L.latLng(r.jalur.start[0], r.jalur.start[1])
            ];
          }
        });
      }

    // Lokasi

    function lokasi(name='') { 
      prom_get_lokasi(name).then(function(hasil) {
        list_lokasi(hasil,name);
        // prom_check_lokasi().then(function(hasil2) {
        //   prom_clearMarkerCctv().then(function(data) {
        //     create_lokasi_map(hasil2,label,{
        //       url: "../my/images/cctv.png", // url
        //       scaledSize: new google.maps.Size(20, 20), // scaled size
        //       origin: new google.maps.Point(0,0), // origin
        //       anchor: new google.maps.Point(0,0) // anchor
        //     });
        //   });
        // });
      });
    }

    function list_lokasi(arr=[],name='') { 
      var lokasi_arr = [];
      $('#list_lokasi_all').html('');
      setTimeout(() => {
        var no = 0;
        arr.forEach(e => {
          $('#list_lokasi_all').append(`<div class="list-group-item list-group-item-action">
          <input type="checkbox" class="mr-2 check-lokasi-all" onchange="check_lokasi('${name}')" name="lokasi_all[]" value="${no++}">
          <span class="name_cctv">${e.nama_lokasi} </span></div>`);
        });
      }, 300);
    }

    function prom_get_lokasi(name='') { 
      return new Promise(function(resolve, reject) {
        $.ajax({
          type: "POST",
          url: "get_kategori_lokasi?kategori="+name+'&json=json',
          dataType: "json",
          data : {
            for : name
          },
          success: function (r) {
            if (name == 'polisi') polisi_link = r.data;
            if (name == 'dishub') dishub_link = r.data;
            if (name == 'rumah_sakit') rumah_sakit_link = r.data;
            if (name == 'damkar') damkar_link = r.data;
            lokasi_link = r;
            resolve(r);
          }
        });
      })
    }

    function create_lokasi_map(arrx,name) {
      return new Promise(function(resolve, reject) {
        lokasi_arr = [];
        var icon;
        var marker;
        // arr = lokasi_link;
        if(arrx) arr = arrx; 
        // if(icon) icons = icon;

        if (name == 'polisi') {
          icon = "../my/simulasi/polisi.png"
        }else if (name == 'dishub') {
          icon = "../my/simulasi/dishub.png"
        }else if (name == 'damkar') {
          icon = "../my/simulasi/icon_damkar.png"
        }else if (name == 'rumah_sakit') {
          icon = "../my/simulasi/hospital.png"
        }

        var myIcon = L.icon({
          iconUrl: icon,
          // iconSize: [20, 20],
        });

        for (let i = 0; i < arr.length; i++) {
  
          marker = new L.marker([arr[i].lat,arr[i].lng])
          .addTo(mymap);

          lokasi_arr.push(marker);

        }
        
        resolve(lokasi_arr);
      })
    }

    function create_lokasi_info_window(arr,data_link,name) { 
      return new Promise(function(resolve, reject) {
        var info = '';
        for (let i = 0; i < arr.length; i++) {
          info = `<div><p><b>${data_link[i].nama_lokasi}</b></p>
          <hr style="margin-top:0 !important;margin-bottom:1rem !important;">
          <div class="mt-3">
          <table class="w-100">
          <tr>
          <td><b>Alamat</b></td>
          <td>:</td>
          <td>${data_link[i].deskripsi}</td>
          </tr>
          <tr style="margin-top:10px;">
          <td><b>Kordinat</b></td>
          <td>:</td>
          <td>${data_link[i].lat} , ${data_link[i].lng}</td>
          </tr>
          </table>
          </div>
          </div>`;
  
          mymap.setView({'lat' : parseFloat(data_link[i].lat), 'lng' : parseFloat(data_link[i].lng)}, 13,{animation : true});
        
          arr[i].bindPopup(info,{
            minWidth : 480
          });

          arr[i].on('click', function(e){
            mymap.setView("Hellow");
          });
         
        }


        resolve(true);
      })
    }
    
    function check_lokasi(name='') { 
      prom_check_lokasi(name).then(function(hasil) {

        prom_clearMarkerLokasi(lokasi_arr).then(function(data) {
        //   cctv = hasil;
          // create_lokasi_map(hasil);
          console.log(hasil,name);
          create_lokasi_map(hasil,name).then(function(data1) { 
            create_lokasi_info_window(data1,hasil,name);
          });
        });
      });
    }
    
    function prom_clearMarkerLokasi(arr) {
      return new Promise(function(resolve, reject) {
        if (arr) {
          for (let i = 0; i < arr.length; i++) {
            mymap.removeLayer(arr[i]);
          }
          resolve(arr);
        }
      })
    }
    
    function prom_check_lokasi(name='') {
      return new Promise(function(resolve, reject) {
        var arr = [];
        var lokasi_arr = [];

          if (name == 'polisi') lokasi_arr = polisi_link;
          if (name == 'dishub') lokasi_arr = dishub_link;
          if (name == 'rumah_sakit') lokasi_arr = rumah_sakit_link;
          if (name == 'damkar') lokasi_arr = damkar_link;

          lokasi_arr = lokasi_link;

        setTimeout(() => {
          $('input[name="lokasi_all[]"]:checked').each(function() {
            debugger;
            arr.push(lokasi_arr[this.value]);
          });
          resolve(arr);
        }, 300);
      })
    }
    

    function iframe(url='') {
      document.getElementById('cek_iframe').src = url;
    }

    async function getData(url = '', data = {}) {
      // Default options are marked with *
      const response = await fetch(url, {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
          'Content-Type': 'application/json'
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      });
      return response.json(); // parses JSON response into native JavaScript objects
    }