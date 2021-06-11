$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();  
    total();
    vendor();
    grafik_pengaduan();
});


function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function total() {
  // new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});
  // var start = $("#f_date_start").val();
  // var end =   $("#f_date_end").val();
  // var selected = [];
  // var checks = document.querySelectorAll("input[type='checkbox']:checked");
  // for(var i=0; i<checks.length; i++){
  //     selected.push(checks[i].value); // or do what you want
  // };
  // if (start == '' || end == '') {
  //     var postData = {
  //         "start" : '',
  //         "end" : '',
  //         "object" : [],
  //     };
  // }else{
  //     var postData = {
  //         "start" : start,
  //         "end" : end,
  //         "object" : selected,
  //     };
  // }
  
  var postData = {
      "start" : '',
      "end" : '',
  };
  $.ajax({
      url : "http://localhost/intan/Dashboard/total",
      method : "POST",
      async : true,
      data: postData, 
      dataType : 'json',
      success: function(response){  
          var x  = 0;
              x  = numberWithCommas(response['masuk']);
          document.getElementById("masuk").innerHTML = x;
          var x  = 0;
              x  = numberWithCommas(response['konfirmasi']);
          document.getElementById("konfirmasi").innerHTML = x;
          var x  = 0;
              x  = numberWithCommas(response['proses']);
          document.getElementById("proses").innerHTML = x;
          var x  = 0;
          x  = numberWithCommas(response['selesai']);
          document.getElementById("selesai").innerHTML = x;
      }
  }); 
}
// function kategori() {
  
// }
function vendor() {
  var postData = {
    "start" : '',
    "end" : '',
  };
  $.ajax({
      url : "http://localhost/intan/Dashboard/vendor",
      method : "POST",
      async : true,
      data: postData, 
      dataType : 'json',
      success: function(response){  
          var x  = 0;
              x  = numberWithCommas(response['vend_0']);
          document.getElementById("vend_0").innerHTML = x + " Pengaduan";
          var x  = 0;
              x  = numberWithCommas(response['vend_1']);
          document.getElementById("vend_1").innerHTML = x + " Pengaduan";
          var x  = 0;
              x  = numberWithCommas(response['vend_2']);
          document.getElementById("vend_2").innerHTML = x + " Pengaduan";
      }
  }); 
  
}
function grafik_pengaduan() {

    var postData = {
        "start" : '',
        "end" : '',
    };
    $.ajax({
        url : "http://localhost/intan/Dashboard/grafik_pengaduan",
        method : "POST",
        async : true,
        dataType : 'json',
        data: postData, 
        success: function(response){  
              var options7 = {
                series: [{
                    data: response.data
              }],
                chart: {
                height: 350,
                type: 'bar',
                events: {
                  click: function(chart, w, e) {
                    // console.log(chart, w, e)
                  }
                }
              },
              colors: ['#F44336', '#a927f9', '#f8d62b','#51bb25'],
              plotOptions: {
                bar: {
                  columnWidth: '45%',
                  distributed: true,
                }
              },
              dataLabels: {
                enabled: false
              },
              legend: {
                show: false
              },
              xaxis: {
                categories: ['Pengaduan Masuk','Dikonfirmasi','Diproses','Selesai'],
                labels: {
                  style: {
                    colors: ['#000000'],
                    fontSize: '12px'
                  }
                }
              }
              };
        
            
            var grafik_pengaduan = new ApexCharts(
                document.querySelector("#grafik_pengaduan"),
                options7
            );
            
            grafik_pengaduan.render(); 
        }
    });     
}
