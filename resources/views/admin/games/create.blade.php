@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create New Game</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.games.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="sport_id">Sport</label>
                    <select name="sport_id" id="sport_id" class="form-control" required>
                        <option value="">Select Sport</option>
                        @foreach(App\Models\Sport::all() as $sport)
                            <option value="{{ $sport->id }}">{{ $sport->sport_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="court_id">Court</label>
                    <select name="court_id" id="court_id" class="form-control" disabled>
                        <option value="">Select Court (optional)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="slot_id">Slot</label>
                    <select name="slot_id" id="slot_id" class="form-control" disabled>
                        <option value="">Select Slot (optional)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="group_id">Group</label>
                    <select name="group_id" id="group_id" class="form-control">
                        <option value="">Select Group (optional)</option>
                        @foreach(App\Models\Group::all() as $group)
                            <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="is_split_payment" id="is_split_payment" class="form-check-input" value="1">
                    <label for="is_split_payment" class="form-check-label">Split Payment</label>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Create Game</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#sport_id').on('change', function() {
        var sport_id = $(this).val();
        if(sport_id) {
            $.ajax({
                url: "{{ route('admin.court.listBySports') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    sport_id: sport_id
                },
                dataType: "json",
                success:function(data) {
                    $('#court_id').empty();
                    $('#court_id').append('<option value="">Select Court (optional)</option>');
                    $.each(data.courts, function(key, value) {
                        $('#court_id').append('<option value="'+ value.id +'">'+ value.court_name +'</option>');
                    });
                    $('#court_id').prop('disabled', false);
                    $('#slot_id').empty();
                    $('#slot_id').append('<option value="">Select Slot (optional)</option>');
                    $('#slot_id').prop('disabled', true);
                }
            });
        } else {
            $('#court_id').empty();
            $('#court_id').append('<option value="">Select Court (optional)</option>');
            $('#court_id').prop('disabled', true);
            $('#slot_id').empty();
            $('#slot_id').append('<option value="">Select Slot (optional)</option>');
            $('#slot_id').prop('disabled', true);
        }
    });

    $('#court_id').on('change', function() {
        var court_id = $(this).val();
        var sport_id = $('#sport_id').val();

        if(court_id && sport_id) {
            $.ajax({
                url: '/api/available-slots',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    sport_id: sport_id,
                    court_id: court_id
                },
                dataType: 'json',
                success: function(data) {
                    $('#slot_id').empty();
                    $('#slot_id').append('<option value="">Select Slot (optional)</option>');
                    $.each(data, function(key, value) {
                        $('#slot_id').append('<option value="'+ value.id +'">'+ value.slot_date + ' ' + value.slot_time + '</option>');
                    });
                    $('#slot_id').prop('disabled', false);
                }
            });
        } else {
            $('#slot_id').empty();
            $('#slot_id').append('<option value="">Select Slot (optional)</option>');
            $('#slot_id').prop('disabled', true);
        }
    });

    $('#game_date').on('change', function() {
        if($('#court_id').val() && $('#sport_id').val()) {
            $('#court_id').trigger('change');
        }
    });
});
</script>
@endsection
