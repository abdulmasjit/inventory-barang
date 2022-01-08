@extends('layouts.main')
@section('content')
<!-- /**
hallo {{ Auth::user()->name }}
{{ var_dump($data['total_user']); }}
{{ $data['total_user'] }}
*/ -->
<div>
    <div class="row g-4 mb-5">
        <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
            <div class="d-flex card-dashboard">
                <div class="bg-success left-border"></div>
                <div class="d-flex p-3 align-items-center" style="width: 100%;">
                    <div class="" style="width: 50%;">
                        <p class="title text-success">TOTAL BARANG</p>
                        <h3 class="align-middle text-success"><?= $data['total_barang'] ?></h3>
                    </div>
                    <div class="" style="text-align: center; width: 50%;">
                        <i class="fa fa-th-large text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
            <div class="d-flex card-dashboard">
                <div class="bg-primary left-border"></div>
                <div class="d-flex p-3 align-items-center" style="width: 100%;">
                    <div class="" style="width: 50%;">
                        <p class="title text-primary">TOTAL SUPPLIER</p>
                        <h3 class="align-middle text-primary"><?= $data['total_supplier'] ?></h3>
                    </div>
                    <div class="" style="text-align: center; width: 50%;">
                        <i class="fa fa-user-plus text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 col-lg-4">
            <div class="d-flex card-dashboard">
                <div class="bg-warning left-border"></div>
                <div class="d-flex p-3 align-items-center" style="width: 100%;">
                    <div class="" style="width: 50%;">
                        <p class="title text-warning">TOTAL USER</p>
                        <h3 class="align-middle text-warning"><?= $data['total_user'] ?></h3>
                    </div>
                    <div class="" style="text-align: center; width: 50%;">
                        <i class="fa fa-users text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row g-4">
        <div class="col-xs-12 col-lg-8">
            <figure class="highcharts-figure">
                <div id="container"></div>
                <p class="highcharts-description">
                    This demo shows a smoothed area chart with an x-axis plot band
                    highlighting an area of interest at the last two points. Plot bands
                    and plot lines are commonly used to draw attention to certain areas or
                    thresholds.
                </p>
            </figure>
        </div>
    </div> -->
</div>
@endsection

@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.chart('container', {
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'Average fruit consumption during one week'
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
        },
        xAxis: {
            categories: [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ],
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'rgba(68, 170, 213, .2)'
            }]
        },
        yAxis: {
            title: {
                text: 'Fruit units'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' units'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'John',
            data: [3, 4, 3, 5, 4, 10, 12]
        }, {
            name: 'Jane',
            data: [1, 3, 4, 3, 3, 5, 4]
        }]
    });
</script>
@endsection

<style>
    .card-dashboard {
        box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.25);
        background: #FFFFFF;
        border-radius: 8px;
    }

    .card-dashboard .left-border {
        width: 10px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .card-dashboard .title {
        font-size: 1.25rem;
        line-height: 1.75rem;
        font-weight: 600;
    }

    .card-dashboard i {
        font-size: 50px;
    }
</style>