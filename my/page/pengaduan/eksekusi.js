var indicarKey = [];
var arr_realtime_car = [];
var arr_instansi = [];
var arr_petugas = [];

var peng_lat = "-7.560908240809835";
var peng_lng = "110.8146920770371"; 

$(document).ready(function () {
    realtime_car();
    petugas();
    instansi();
});

function list_detail(){
  if($('#list_detail').hasClass('d-none')){
    $('#list_detail').removeClass('d-none');
  }else {
    $('#list_detail').addClass('d-none');
  }
}

function getDistanceFromLatLngInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
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

async function postData(url = '', data = {},token='') {
    // Default options are marked with *
    const response = await fetch(url, {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      mode: 'cors', // no-cors, *cors, same-origin
      cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      credentials: 'same-origin', // include, *same-origin, omit
      headers: {
        'Content-Type': 'application/json',
        'Accept' : 'application/json', 
        'Authorization': 'Bearer '+indicarKey.indicarToken
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow', // manual, *follow, error
      referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: JSON.stringify(data) // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
  }

  // Kendaraan realtime
  function realtime_car() { 
    getData('../../indicar/Api/get_token')
    .then(key => {
      indicarKey = key;
      postData('https://www.indicar.id/platform/public/index.php/sysapi/vehicles/list',{})
        .then(data => {
            arr_realtime_car = [];
            arr_realtime_car = data.dataset;
            data.dataset.forEach(e => {
                $('#list_realtime_car').append(`
                <li class="clearfix"><img class="rounded-circle user-image" src="../../template/cuba/assets/images/user/12.png" alt="">
                    <div class="status-circle ${e.speed > 0 ? 'online' : 'offline'}"></div>
                    <div class="row">
                        <div class="col-8">
                            <div class="name">${e.vehiclename}</div>
                            <div class="status">${e.vehiclegroup}</div>
                        </div>
                        <div class="col-2">
                            <a href="javascript:void(0);" onclick="assign()" class="btn btn-success" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </li>`);
            });

        });  
    });
  }

  function filter_realtime_car(v) {
     let arr = arr_realtime_car.filter( (x) => x.vehiclename.toLowerCase().indexOf(v.toLowerCase()) !== -1)
     $('#list_realtime_car').html('');
     arr.forEach(e => {
        $('#list_realtime_car').append(`
        <li class="clearfix"><img class="rounded-circle user-image" src="../../template/cuba/assets/images/user/12.png" alt="">
            <div class="status-circle ${e.speed > 0 ? 'online' : 'offline'}"></div>
            <div class="row">
                <div class="col-8">
                    <div class="name">${e.vehiclename}</div>
                    <div class="status">${e.vehiclegroup}</div>
                </div>
                <div class="col-2">
                    <a href="javascript:void(0);" onclick="assign()" class="btn btn-success" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </li>`);
    });
  }

  // Petugas
  function petugas() { 
    getData('../../backend/Api_petugas/get')
      .then(data => {
          arr_petugas = [];
          arr_petugas = data;
          data.forEach(e => {
              $('#list_petugas').append(`
              <li class="clearfix"><img class="rounded-circle user-image" src="../../template/cuba/assets/images/user/12.png" alt="">
                  <div class="status-circle ${e.activity == 0 ? 'online' : 'offline'}"></div>
                  <div class="row">
                      <div class="col-8">
                          <div class="name">${e.nama_instansi} - ${e.nama_petugas}</div>
                          <div class="status">${getDistanceFromLatLngInKm(e.lat,e.lng,peng_lat,peng_lng).toFixed(2)} Km</div>
                      </div>
                      <div class="col-2">
                          <a href="#" class="btn btn-success" onclick="assign_petugas(${e.id})" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
                      </div>
                  </div>
              </li>`);
          });

      });  
  }

  function filter_petugas(v) {
    let arr = arr_petugas.filter( (x) => x.nama_instansi.toLowerCase().indexOf(v.toLowerCase()) !== -1)
     $('#list_petugas').html('');
     arr.forEach(e => {
        $('#list_petugas').append(`
        <li class="clearfix"><img class="rounded-circle user-image" src="../../template/cuba/assets/images/user/12.png" alt="">
        <div class="status-circle ${e.activity == 0 ? 'online' : 'offline'}"></div>
        <div class="row">
            <div class="col-8">
                <div class="name">${e.nama_petugas}</div>
                <div class="status">${e.nama_instansi} - ${getDistanceFromLatLngInKm(e.lat,e.lng,peng_lat,peng_lng).toFixed(2)} Km</div>
            </div>
            <div class="col-2">
                <a href="#" class="btn btn-success" onclick="assign_petugas(${e.id})" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
            </div>
        </div>
      </li>`);
    });
  }

  // Intsnasi
  function instansi() { 
    getData('../../backend/Api_lokasi/get_priority')
      .then(data => {
          arr_instansi = [];
          arr_instansi = data;
          data.forEach(e => {
            debugger;
              $('#list_instansi').append(`
              <li class="clearfix"><img class="rounded-circle user-image" src="../../template/cuba/assets/images/user/12.png" alt="">
              <div class="status-circle online"></div>
              <div class="row">
                  <div class="col-8">
                      <div class="name">${e.nama_lokasi}</div>
                      <div class="status">${getDistanceFromLatLngInKm(e.lat,e.lng,peng_lat,peng_lng).toFixed(2)} Km</div>
                  </div>
                  <div class="col-2">
                      <a href="#" class="btn btn-success" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
                  </div>
              </div>
            </li>`);
          });

      });  
  }

  function filter_instansi(v) {
    let arr = arr_instansi.filter( (x) => x.nama_instansi.toLowerCase().indexOf(v.toLowerCase()) !== -1)
     $('#list_instansi').html('');
     arr.forEach(e => {
        $('#list_instansi').append(`
        <li class="clearfix"><img class="rounded-circle user-image" src="../../template/cuba/assets/images/user/12.png" alt="">
        <div class="status-circle online></div>
        <div class="row">
            <div class="col-8">
                <div class="name">${e.nama_lokasi}</div>
                <div class="status">${getDistanceFromLatLngInKm(e.lat,e.lng,peng_lat,peng_lng).toFixed(2)} Km</div>
            </div>
            <div class="col-2">
                <a href="#" class="btn btn-success" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
            </div>
        </div>
      </li>`);
    });
  }

  // Assign Petugas
  function assign_petugas(petugas_id='') {
    swal({
      title: "Konfirmasi",
      text: "Apakah anda yakin ingin menugaskan?",
      icon: "warning",
      buttons: {
          cancel:true,
          confirmButtonText: "Ya",
      },
    }).then((isConfirm) => {
      if (isConfirm) {         
        // Post data assign petugas
      }
    })
  }

  function assign()
 {
    swal({
        title: "Apakah anda yakin ?",
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: "warning",
        buttons: {
            cancel:true,
            confirmButtonText: "Ya!",
            },
      }).then((isConfirm) => {
        if (isConfirm) {         
            var link = ''; 
            $.ajax({
                type: "POST",
                url: link,
                data : {'id' : id},
                dataType: "json",
                success: function (r) {
                    if (r.status) {
                        swal({
                            title:'Berhasil',
                            text:r.msg,
                            icon:'success'
                          });
                        dt();
                    }else{
                        swal({
                            title:'Gagal',
                            text:r.msg,
                            icon:'error'
                          });
                    }
                    
                }
            });
        }
      })
 }
  
