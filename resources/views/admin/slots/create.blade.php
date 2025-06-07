@extends('admin.layout')

@section('title', 'Create New Slot')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create New Slot</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.slots.index') }}">Slots</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Slot Details</h3>
            </div>
            <form action="{{ route('admin.slots.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sport_id">Sport</label>
                                <select class="form-control @error('sport_id') is-invalid @enderror" id="sport_id" name="sport_id" required>
                                    <option value="">Select Sport</option>
                                    @foreach($sports as $k => $sport)
                                        <option value="{{ $k }}">{{ $sport }}</option>
                                    @endforeach
                                </select>
                                @error('sport_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="court_id">Court</label>
                                <select class="form-control @error('court_id') is-invalid @enderror" id="court_id" name="court_id" required>
                                    <option value="">Select Court</option>
                                </select>
                                @error('court_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="slot_date">Date</label>
                                <input type="date" class="form-control @error('slot_date') is-invalid @enderror" id="slot_date" name="slot_date" required>
                                @error('slot_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="slot_time">Start Time</label>
                                <input type="time" class="form-control @error('slot_time') is-invalid @enderror" id="slot_time" name="slot_time" required>
                                @error('slot_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="slot_end_time">End Time</label>
                                <input type="time" class="form-control @error('slot_end_time') is-invalid @enderror" id="slot_end_time" name="slot_end_time" required>
                                @error('slot_end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="is_member_slot">Is Member Slot</label>
                                <select class="form-control @error('is_member_slot') is-invalid @enderror" id="is_member_slot" name="is_member_slot" required>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('is_member_slot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="max_players">Max Player</label>
                                <input type="number" class="form-control @error('max_players') is-invalid @enderror" id="max_players" name="max_players" required>
                                @error('max_players')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="available_slots">Available Slots</label>
                                <input type="number" class="form-control @error('available_slots') is-invalid @enderror" id="available_slots" name="available_slots" required>
                                @error('available_slots')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="is_peak_hour">Peak Hour</label>
                                <select class="form-control @error('is_peak_hour') is-invalid @enderror" id="is_peak_hour" name="is_peak_hour" required>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('is_peak_hour')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="available">Available</option>
                                    <option value="booked">Booked</option>
                                    <option value="blocked">Blocked</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.slots.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).on('change', '#sport_id', function() {
    var sport_id = $(this).val();
    
    if(parseInt(sport_id)) {
        $.ajax({
            url : "{{ route('admin.court.listBySports') }}",
            data : { "_token": "{{ csrf_token() }}", 'sport_id' : sport_id },
            type : 'POST',
            dataType : 'JSON',
            success : function(result) {
                $('#court_id').empty();
                $('#court_id').append('<option value="">Select Court</option>'); 
                if(result != undefined && result != null) {
                    if(result.status == "1") {
                        if(result.courts != undefined && result.courts != null && result.courts.length > 0) {
                            result.courts.forEach(function(court) {
                                $('#court_id').append('<option value="' + court.id + '">' + court.court_name + '</option>'); 
                            });
                        }
                    }
                }
            }
        });
    } else {
        $('#court_id').empty();
        $('#court_id').append('<option value="">Select Court</option>');
    }
});
</script>
@endsection
