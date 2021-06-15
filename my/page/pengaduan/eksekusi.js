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
    list_assign();
    pengaduan();
});

function refresh() {
  list_assign();
  pengaduan(); 
  realtime_car();
  petugas();
}

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

  // Example POST method implementation:
async function post(url = '', data = {},headers = {'Content-Type': 'application/json'}) {
  // Default options are marked with *
  const response = await fetch(url, {
    method: 'POST', // *GET, POST, PUT, DELETE, etc.
    mode: 'cors', // no-cors, *cors, same-origin
    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
    credentials: 'same-origin', // include, *same-origin, omit
    headers:headers,
    redirect: 'follow', // manual, *follow, error
    referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: data // body data type must match "Content-Type" header
  });
  return response.json(); // parses JSON response into native JavaScript objects
}

  // Kendaraan realtime
  function realtime_car() { 
    $('#list_realtime_car').html('');
    getData('../indicar/Api/get_token')
    .then(key => {
      indicarKey = key;
      postData('https://www.indicar.id/platform/public/index.php/sysapi/vehicles/list',{})
        .then(data => {
            arr_realtime_car = [];
            arr_realtime_car = data.dataset;
            data.dataset.forEach(e => {
                $('#list_realtime_car').append(`
                <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
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
        <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
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
    $('#list_petugas').html('');
    getData('../backend/Api_petugas/get')
      .then(data => {
          arr_petugas = [];
          arr_petugas = data;
          data.forEach(e => {
              $('#list_petugas').append(`
              <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
                  <div class="status-circle ${e.activity == 0 ? 'online' : 'offline'}"></div>
                  <div class="row">
                      <div class="col-8">
                          <div class="name">${e.nama_instansi} - ${e.nama_petugas}</div>
                          <div class="status">${getDistanceFromLatLngInKm(e.lat,e.lng,peng_lat,peng_lng).toFixed(2)} Km</div>
                      </div>
                      <div class="col-2">
                          <a href="#" class="btn btn-success" onclick="assign_petugas(${$('#pengaduan_id').val()},${e.id})" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
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
        <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
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
    getData('../backend/Api_lokasi/get_priority')
      .then(data => {
          arr_instansi = [];
          arr_instansi = data;
          data.forEach(e => {
              $('#list_instansi').append(`
              <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
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
        <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
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
  function assign_petugas(pengaduan_id='',petugas_id='') {
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
        let data = `pengaduan_id=${pengaduan_id}&petugas_id=${petugas_id}`;
        post('../backend/Api_pengaduan/assign_to',data,{'Content-Type': 'application/x-www-form-urlencoded'}).then(data => {
          list_assign();
          list_detail();
        });
      }
    })
  }

  // List assign
  function list_assign() { 
    $('#list_assign').html('');
    post('../backend/Api_pengaduan/peng_assign_list',"pengaduan_id="+$('#pengaduan_id').val(),{'Content-Type': 'application/x-www-form-urlencoded'})
      .then(d => {
          d.data.forEach(e => {
              $('#list_assign').append(`<li class="clearfix mt-2 mb-2"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
              <div class="about">
                  <div class="name">${e.nama_instansi} - ${e.nama_petugas}</div>
                  <div class="status"><i class="fa fa-share font-success"></i>  ${e.status_static}</div>
              </div>
          </li>`);
          });

      });  
  }

  // Pengaduan
  function pengaduan() { 
    post('../backend/Api_pengaduan/pengaduan/'+$('#pengaduan_id').val())
      .then(d => {
         $('#judul').text(d.judul);
         $('#kategori').text('#'+d.peng_kategori);
         $('#status').text(d.status_static);
         $('#tanggal_pengaduan').html(d.tanggal+' '+d.ctdtime);
         $('#kategori_pengaduan').text(d.peng_kategori);
         $('#nama_pelapor').text(d.nama_pelapor);
         $('#task_id').text(d.task_id);
         $('#keterangan_pengaduan').html(d.keterangan);

         task_assign_log(d.task_id);
      });  
  }

  // Pengaduan
  function task_assign_log(task_id='') { 
    $('#status_timeline').html('');
    post('../backend/Api_pengaduan/peng_assign_log',"task_id="+task_id,{'Content-Type': 'application/x-www-form-urlencoded'})
      .then(d => {
          d.data.forEach(e => {
              $('#status_timeline').append(`<div class="media">
              <div class="activity-line"></div>
              <div class="activity-dot-secondary"></div>
              <div class="media-body"><span>${e.nama_instansi} - ${e.nama_petugas}</span>
                  <p class="font-roboto mb-0">${e.status_static}</p>
                  <p class="font-roboto">${e.tanggal} - ${e.ctdtime}</p>
              </div>
          </div>`);
          });
      });  
  }
