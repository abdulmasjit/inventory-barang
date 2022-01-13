<div id="line-chart" style="width:100%;"></div>
<script>
  Highcharts.chart('line-chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Chart Barang Masuk dan Keluar'
    },
    credits: {
      enabled: false
    },
    subtitle: {
        text: 'Tahun <?= $tahun ?>'
    },
    xAxis: {
        categories: [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">Bulan {point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} Item</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    colors: [
      '#F7A35C',
      '#00ff00',
      '#8085E9',
    ],
    series: [
    <?php  
      foreach ($chart as $row) { ?>
      {
        name: '<?= $row['name']; ?>',
        data: [<?= implode(",", $row['data']); ?>]
      },
      <?php } ?>
    ]
});
</script>