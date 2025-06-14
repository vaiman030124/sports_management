@extends('admin.layout')

@section('content')
<div class="container">
    <h1>Edit Game #{{ $game->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.games.update', $game) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="sport_id">Sport</label>
            <select name="sport_id" id="sport_id" class="form-control" required>
                <option value="">Select Sport</option>
                @foreach(App\Models\Sport::all() as $sport)
                    <option value="{{ $sport->id }}" {{ $game->sport_id == $sport->id ? 'selected' : '' }}>{{ $sport->sport_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Removed game_date input as per user feedback --}}

        <div class="form-group">
            <label for="court_id">Court</label>
            <select name="court_id" id="court_id" class="form-control">
                <option value="">Select Court (optional)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="slot_id">Slot</label>
            <select name="slot_id" id="slot_id" class="form-control">
                <option value="">Select Slot (optional)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="group_id">Group</label>
            <select name="group_id" id="group_id" class="form-control">
                <option value="">Select Group (optional)</option>
                @foreach(App\Models\Group::all() as $group)
                    <option value="{{ $group->id }}" {{ $game->group_id == $group->id ? 'selected' : '' }}>{{ $group->group_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" name="is_split_payment" id="is_split_payment" class="form-check-input" value="1" {{ $game->is_split_payment ? 'checked' : '' }}>
            <label for="is_split_payment" class="form-check-label">Split Payment</label>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ $game->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $game->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="canceled" {{ $game->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                <option value="completed" {{ $game->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Game</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sportSelect = document.getElementById('sport_id');
    const courtSelect = document.getElementById('court_id');
    const slotSelect = document.getElementById('slot_id');
    // Removed gameDateInput as game_date input is removed from the form
    // So no need to check for gameDateInput element

    if (!sportSelect) {
        console.error('Sport select element not found in the DOM.');
        return;
    }
    if (!courtSelect) {
        console.error('Court select element not found in the DOM.');
        return;
    }
    if (!slotSelect) {
        console.error('Slot select element not found in the DOM.');
        return;
    }

    function loadCourts(sportId, selectedCourtId = null, selectedSlotId = null) {
        courtSelect.innerHTML = '<option value="">Loading courts...</option>';
        courtSelect.disabled = true;
        slotSelect.innerHTML = '<option value="">Select Slot (optional)</option>';
        slotSelect.disabled = true;

        if (!sportId) {
            courtSelect.innerHTML = '<option value="">Select Court (optional)</option>';
            courtSelect.disabled = true;
            return;
        }

        fetch('{{ route("admin.court.listBySports") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ sport_id: sportId })
        })
        .then(response => response.json())
        .then(data => {
            courtSelect.innerHTML = '<option value="">Select Court (optional)</option>';
            if ((data.status === '1' || data.status === 1) && Array.isArray(data.courts)) {
                data.courts.forEach(court => {
                    const option = document.createElement('option');
                    option.value = court.id;
                    option.textContent = court.court_name;
                    if (selectedCourtId && selectedCourtId == court.id) {
                        option.selected = true;
                    }
                    courtSelect.appendChild(option);
                });
                courtSelect.disabled = false;
                if (selectedCourtId && selectedSlotId) {
                    loadSlots(sportId, selectedCourtId, selectedSlotId);
                } else if(selectedCourtId){
                    loadSlots(sportId, selectedCourtId);
                }
            } else {
                courtSelect.innerHTML = '<option value="">Error loading courts</option>';
                courtSelect.disabled = true;
            }
        })
        .catch(() => {
            courtSelect.innerHTML = '<option value="">Error loading courts</option>';
            courtSelect.disabled = true;
        });
    }

    function loadSlots(sportId, courtId, selectedSlotId = null) {
        slotSelect.innerHTML = '<option value="">Loading slots...</option>';
        slotSelect.disabled = true;

        if (!courtId || !sportId) {
            slotSelect.innerHTML = '<option value="">Select Slot (optional)</option>';
            slotSelect.disabled = true;
            return;
        }

        fetch('/api/available-slots', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                sport_id: sportId,
                court_id: courtId
            })
        })
        .then(response => response.json())
        .then(data => {
            slotSelect.innerHTML = '<option value="">Select Slot (optional)</option>';
            if (Array.isArray(data)) {
                data.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.id;
                    option.textContent = slot.slot_date + ' ' + slot.slot_time;
                    if (selectedSlotId && selectedSlotId == slot.id) {
                        option.selected = true;
                    }
                    slotSelect.appendChild(option);
                });
                slotSelect.disabled = false;
            } else {
                slotSelect.innerHTML = '<option value="">Error loading slots</option>';
                slotSelect.disabled = true;
            }
        })
        .catch(() => {
            slotSelect.innerHTML = '<option value="">Error loading slots</option>';
            slotSelect.disabled = true;
        });
    }

    sportSelect.addEventListener('change', function () {
        loadCourts(this.value);
    });

    courtSelect.addEventListener('change', function () {
        loadSlots(sportSelect.value, this.value);
    });

    // Initial load for edit form
    loadCourts(sportSelect.value, {{ $game->court_id ?? 'null' }},  {{ $game->slot_id ?? 'null' }});
});
</script>
@endsection
