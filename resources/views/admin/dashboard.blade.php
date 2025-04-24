@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<style type="text/css">
    #sportWiseBookingCountChart {
        height: 550px;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>New Bookings</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53</h3>
                        <p>Active Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Available Venues</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <a href="{{ route('admin.venues.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>$12,345</h3>
                        <p>Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="{{ route('admin.transactions.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main row -->
        <div class="row">
            <section class="col-lg-7 connectedSortable">
                <!-- Recent Bookings -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Bookings</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Venue</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>Main Pool</td>
                                    <td>2025-05-15</td>
                                    <td><span class="badge bg-success">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>Tennis Court 1</td>
                                    <td>2025-05-16</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="col-lg-5 connectedSortable">
                <!-- Recent Transactions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Transactions</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>$120.00</td>
                                    <td><span class="badge bg-success">Completed</span></td>
                                    <td>2025-05-10</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>$85.50</td>
                                    <td><span class="badge bg-danger">Refunded</span></td>
                                    <td>2025-05-09</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="col-lg-12 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sport Booking Count</h3>
                    </div>
                    <div class="card-body">
                        <div id="sportWiseBookingCountChart"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

<script type="text/javascript" src="{{ asset('plugins/highchart/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/highchart/data.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/highchart/drilldown.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/highchart/exporting.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/highchart/export-data.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/highchart/accessibility.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    setTimeout(() => {
        loadSportWiseBooking();
    }, 500);
});

function loadSportWiseBooking() {
    $.ajax({
        url : "{{ route('admin.spBook') }}",
        data : { "_token": "{{ csrf_token() }}" },
        type : 'GET',
        dataType : 'JSON',
        success : function(result) {
            Highcharts.chart('sportWiseBookingCountChart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Sports wise booking'
                },
                subtitle: {
                    text: 'Charts shows the count of booking by Sport which is Pending/Confirmed'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Total booking'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: ' +
                        '<b>{point.y}</b> Booking<br/>'
                },
                series: [
                    {
                        name: 'Sport',
                        colorByPoint: true,
                        data: result
                    }
                ]
            });

            $('.highcharts-credits, .highcharts-no-tooltip').hide();
        }
    });
}
</script>
@endsection
