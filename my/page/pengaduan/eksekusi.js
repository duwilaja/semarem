var indicarKey = [];
var arr_realtime_car = [];

$(document).ready(function () {
    realtime_car();
});

function list_detail(){
  if($('#list_detail').hasClass('d-none')){
    $('#list_detail').removeClass('d-none');
  }else {
    $('#list_detail').addClass('d-none');
  }
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
     let arr =  filter(arr_realtime_car,v);
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

  function filter(arr,query) {
    return arr.filter( (x) => x.vehiclename.toLowerCase().indexOf(query.toLowerCase()) !== -1)
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
  
