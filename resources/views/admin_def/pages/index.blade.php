@extends('admin_master_def')

@section('title', '| Dashboard')

@section('content')
    @php
    @endphp
    <div class="clearfix">
        <div class="col-xs-12">
            <h3>Dashboard</h3>
        </div>
        <div class="col-xs-9">
            <div class="box box-warning">
                <div class="box-body">
                    <h4 class="lead pull-left"><strong>Date Chart</strong> (Last {{ $date_range }} Days)</h4>
                    <div class="col-xs-3 pull-right">
                        <form action="" method="get">
                            <div class="input-group">
                                <input type="number" name="d_range" value="{{ $date_range }}" min="7" max="30" class="form-control">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-eye"></i> See Result</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="chart">
                        <canvas id="areaChart" style="height:335px"></canvas>
                    </div>
                </div>
            </div>
            <div class="box box-warning">
                <div class="box-body">
                    <h4 class="lead"><strong>Brands Chart</strong> (Last {{ $date_range }} days)</h4>
                    <div class="chart">
                        <canvas id="barChart" style="height:335px"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ vnd_format($total_amount) }} <sup>VNĐ</sup></h3>
                    <p>Total Amount <em>(last {{ $date_range }} days)</em></p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $total_sales }}</h3>
                    <p>Total Sales <em>(last {{ $date_range }} days)</em></p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
            <div class="box box-warning">
                <div class="box-header">
                    <span class="lead"><strong>Top 10 Hot Products </strong><em>(last {{ $date_range }} days)</em></span>
                </div>
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <th width="20px" height="41px"></th>
                            <th>Product Name</th>
                            <th width="30px">Sales</th>
                        </tr>
                        @foreach($top_products as $product)
                        <tr>
                            <th height="50px">{{ $loop->index + 1 }}</th>
                            <td><a href="{{ route('admin.product.show', $product->product_id) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->sales }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('lib-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
@endpush

@push('js')
<script>
    var optionTooltips = {
        callbacks: {
            label: function(tooltipItem, data) {
                var label = data.datasets[tooltipItem.datasetIndex].label || '';
                if (label) {
                    label += ': ';
                }
                if (tooltipItem.datasetIndex == 0) {
                    label = " Amount: " + (tooltipItem.yLabel * 1000).toLocaleString('it', 'IT') + " VNĐ";
                } else {
                    label += tooltipItem.yLabel;
                }
                return label;
            }
        }
    };
    var canvas = document.getElementById('areaChart');
    new Chart(canvas, {
        type: 'line',
        data: {
            labels: [{!! $date !!}],
            datasets: [{
            label: 'Amount (Triệu VNĐ)',
            yAxisID: 'A',
            backgroundColor: 'rgba(20,141,198,0.1)',
            borderColor: 'rgba(60,141,188,0.6)',
            pointBorderColor : 'rgba(60,141,188,0.9)',
            pointBackgroundColor: 'rgba(60,141,188,0.9)',
            lineTension: 0,
            data: [{!! $amount !!}]
            }, {
            label: 'Sales',
            yAxisID: 'S',
            backgroundColor: 'rgba(26,185,54,0.06)',
            borderColor: 'rgba(26,185,54,0.6)',
            pointBorderColor : 'rgba(26,185,54,0.9)',
            pointBackgroundColor: 'rgba(26,185,54,0.9)',
            lineTension: 0,
            data: [{!! $sales !!}]
            }]
        },
        options: {
            scales: {
            yAxes: [{
                id: 'A',
                type: 'linear',
                position: 'left',
                ticks: {
                    max: {!! $max_amount !!},
                    min: 0,
                    callback: function(value, index, values) {
                        return (value / 1000).toLocaleString('it', 'IT');
                    }
                },
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                }
            }, {
                id: 'S',
                type: 'linear',
                position: 'right',
                ticks: {
                max: {!! $max_sale !!},
                min: 0
                },
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                }
            }]
            },
            tooltips: optionTooltips,
        }
    });
    var canvasBar = document.getElementById('barChart');
    new Chart(canvasBar, {
        type: 'bar',
        data: {
            labels: [{!! $brands !!}],
            datasets: [{
            label: 'Amount (Triệu VNĐ)',
            yAxisID: 'A',
            backgroundColor: 'rgba(20,141,198,1)',
            borderColor: 'rgba(60,141,188,0.6)',
            data: [{!! $brand_amount !!}]
            }, {
            label: 'Sales',
            yAxisID: 'S',
            backgroundColor: 'rgba(26,185,54,1)',
            borderColor: 'rgba(26,185,54,0.6)',
            data: [{!! $brand_sale !!}]
            }]
        },
        options: {
            scales: {
            yAxes: [{
                id: 'A',
                type: 'linear',
                position: 'left',
                ticks: {
                    max: {!! $max_brand_amount !!},
                    min: 0,
                    callback: function(value, index, values) {
                        return (value/1000).toLocaleString('it', 'IT');
                    }
                },
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                }
            }, {
                id: 'S',
                type: 'linear',
                position: 'right',
                ticks: {
                max: {!! $max_brand_sale !!},
                min: 0
                },
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                }
            }]
            },
            tooltips: optionTooltips,
        }
    });
</script>
@endpush
