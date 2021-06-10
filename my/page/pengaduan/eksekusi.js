var indicarKey = [];
var arr_realtime_car = [];

$(document).ready(function () {
    realtime_car();
});

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
                  <div class="about">
                    <div class="name">${e.vehiclename}</div>
                    <div class="status">${e.vehiclegroup}</div>
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
          <div class="about">
            <div class="name">${e.vehiclename}</div>
            <div class="status">${e.vehiclegroup}</div>
          </div>
        </li>`);
    });
  }

  function filter(arr,query) {
    return arr.filter( (x) => x.vehiclename.toLowerCase().indexOf(query.toLowerCase()) !== -1)
  }
  
