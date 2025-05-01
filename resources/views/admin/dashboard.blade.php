@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/fullcalendar/css/fullcalendar.min.css') }}">
<style type="text/css">
    #sportWiseBookingCountChart {
        height: 550px;
    }

    .eventBody {
        padding: 20px;
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
                        <h3>{{ $_totalBookings }}</h3>
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
                        <h3>{{ $_totalUser }}</h3>
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
                        <h3>{{ $_totalVenue }}</h3>
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
                        <h3><i class="fas fa-rupee-sign"></i>{{ number_format($_totalBookingRevenue, 2) }}</h3>
                        <p>Booking Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <a href="{{ route('admin.transactions.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><i class="fas fa-rupee-sign"></i>{{ number_format($_totalMemberShipRevenue, 2) }}</h3>
                        <p>Membership Revenue</p>
                    </div>
                    <div class="icon">
                    <i class="fas fa-rupee-sign"></i>
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
                        <h3 class="card-title">
                            <a href="{{ route('admin.bookings.index') }}" class="small-box-footer">
                                Recent Bookings
                            </a>
                        </h3>
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
                                @foreach($_recentBooking as $bk => $booking)
                                    <tr>
                                        <td>{{ $bk + 1 }}</td>
                                        <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                        <td>{{ $booking->venue->venue_name ?? 'N/A' }}</td>
                                        <td>{{ $booking->booking_date->format('Y-m-d') }} {{ $booking->slot->slot_time ?? '' }} - {{ $booking->slot->slot_end_time ?? '' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
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
                                @foreach($_recentTransaction as $tk => $trans)
                                    <tr>
                                        <td>{{ $tk + 1 }}</td>
                                        <td>{{ '$' . number_format($trans->amount) ?? 'N/A' }}</td>
                                        <td>{{ $trans->transaction_date ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $trans->status == 'completed' ? 'success' : 'danger' }}">
                                                {{ ucfirst($trans->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
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

            <section class="col-lg-12 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bookings</h3>
                    </div>
                    <div class="card-body">
                        <div id="booking-calendar"></div>
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
<script type="text/javascript" src="{{ asset('plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    setTimeout(() => {
        loadSportWiseBooking();
        renderBookingCalendar();
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

function renderBookingCalendar() {
    var calendarEl = document.getElementById('booking-calendar');

    $.ajax({
        url : "{{ route('admin.calBookings') }}",
        data : { "_token": "{{ csrf_token() }}" },
        type : 'GET',
        dataType : 'JSON',
        success : function(result) {
            var _ev = {};

            if(result.status == "1") {
                _ev = result.events;
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: _ev,
                eventClick: function (info) {
                    var _html = `<p><strong>Venue</strong> : `+ info.event.extendedProps.venue +`</p>
                    <p><strong>Court</strong> : `+ info.event.extendedProps.court +`</p>
                    <p><strong>Sport</strong> : `+ info.event.extendedProps.sport +`</p>
                    <p><strong>Time Slot</strong> : `+ info.event.extendedProps.time_slot +`</p>`;

                    $('.eventBody').html('');
                    $('.eventBody').html(_html);

                    $("#eventModal").modal('show');
                }
            });

            calendar.render();
        }
    });
}

$(document).on('click', '.closeEvent', function() {
    $("#eventModal").modal('hide');
});
</script>

<div class="modal fade" id="eventModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Booking Info</h4>
                <button type="button" class="close closeEvent" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="eventBody">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default closeEvent" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
