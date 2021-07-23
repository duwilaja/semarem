// A $( document ).ready() block.
$( document ).ready(function() {
    $('#f_date_interval').daterangepicker({
        locale: {
            format: 'Y/MM/DD'
          }
    });
    dt();
});

$('#form-filter').submit(function (e) { 
    e.preventDefault();
    dt();
});

function read_notif(id='') { 
    const body = new FormData();
    body.append('id',id);

    fetch('./backend/Api_notif/read_notif', {
        method: 'POST',
        body: body
    })
    .then(response => response.json())
    .then(result => {
        console.log(result.msg);
        if (result.status) dt();
        window.location.assign(result.link);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Example POST method implementation:
async function postData(url = '', data = {},headers = {  'Content-Type': 'application/x-www-form-urlencoded'}) {
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

function dt() {
    $('#tabel').DataTable({
        // Processing indicator
        "bAutoWidth": false,
        "destroy": true,
        "searching": true,
        "processing": true,
        // DataTables server-side processing mode
        "serverSide": true,
        "scrollX": true,
        // Initial no order.
        "order": [],
        // Load data from an Ajax source
        "ajax": {
            "url": './backend/Api_notif/my_notif_dt',
            "type": "POST",
            "data" : {
                'f_date_interval' : $('#f_date_interval').val(),
            }
        },
        //Set column definition initialisation properties
        "columnDefs": [{
            "targets": [0],
            "orderable": false
        }]
    });
  }