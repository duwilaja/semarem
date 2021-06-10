$( document ).ready(function() {
    grafik_pengaduan();
});

function grafik_pengaduan() {
    var options7 = {
        series: [{
        data: [5, 3, 2, 1]
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

    
    var chart7 = new ApexCharts(
        document.querySelector("#grafik_pengaduan"),
        options7
    );
    
    chart7.render();    
}
