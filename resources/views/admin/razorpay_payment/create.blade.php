@extends('admin.layout')

@section('title', 'Create Booking with Razorpay Payment')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Create Booking with Razorpay Payment</h1>

    <form id="booking-form" method="POST" action="{{ route('admin.razorpay-booking.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="user_id">User</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="sport_id">Sport</label>
            <select name="sport_id" id="sport_id" class="form-control" required>
                <option value="">Select Sport</option>
                @foreach ($sports as $sport)
                <option value="{{ $sport->id }}">{{ $sport->sport_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="court_id">Court</label>
            <select name="court_id" id="court_id" class="form-control" required>
                <option value="">Select Court</option>
                @foreach ($courts as $court)
                <option value="{{ $court->id }}">{{ $court->court_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="slot_id">Slot</label>
            <select name="slot_id" id="slot_id" class="form-control" required>
                <option value="">Select Slot</option>
                @foreach ($slots as $slot)
                <option value="{{ $slot->id }}">{{ $slot->slot_date }} ({{ $slot->slot_time }} - {{ $slot->slot_end_time }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="booking_date">Booking Date</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="number_of_players">Number of Players</label>
            <input type="number" name="number_of_players" id="number_of_players" class="form-control" min="1" required>
        </div>

        <div class="form-group mb-3">
            <label for="amount">Amount (INR)</label>
            <input type="number" name="amount" id="amount" class="form-control" min="1" step="0.01" required>
        </div>

        <button type="button" id="pay-button" class="btn btn-primary">Pay with Razorpay</button>
    </form>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('pay-button').onclick = function(e) {
    e.preventDefault();

    const form = document.getElementById('booking-form');
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message || 'Failed to initiate payment');
            return;
        }

        const options = {
            "key": "{{ config('services.razorpay.key') }}",
            "amount": data.order.amount,
            "currency": data.order.currency,
            "name": "Sports Management",
            "description": "Court Booking Payment",
            "order_id": data.order.id,
            "handler": function (response){
                // Verify payment on server
                fetch("{{ route('admin.razorpay-booking.verify-payment') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_signature: response.razorpay_signature,
                    }),
                })
                .then(res => res.json())
                .then(verifyData => {
                    if (verifyData.success) {
                        alert('Payment successful and booking confirmed!');
                        window.location.href = "{{ route('admin.razorpay-payments.index') }}";
                    } else {
                        alert('Payment verification failed: ' + verifyData.message);
                    }
                })
                .catch(() => alert('Payment verification failed'));
            },
            "prefill": {
                "name": "",
                "email": "",
                "contact": ""
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        const rzp1 = new Razorpay(options);
        rzp1.open();
    })
    .catch(() => alert('Failed to initiate payment'));
};
</script>
@endsection
