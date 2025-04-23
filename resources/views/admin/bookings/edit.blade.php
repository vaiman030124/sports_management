@extends('admin.layout')

@section('title', 'Edit Booking')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Booking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="user_id">User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="group_id">Group</label>
                        <select name="group_id" id="group_id" class="form-control">
                            <option value="">Select Group</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ $booking->group_id == $group->id ? 'selected' : '' }}>
                                    {{ $group->group_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trainer_id">Trainer</label>
                        <select name="trainer_id" id="trainer_id" class="form-control">
                            <option value="">Select Trainer</option>
                            @foreach($trainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ $booking->trainer_id == $trainer->id ? 'selected' : '' }}>
                                    {{ $trainer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="venue_id">Venue</label>
                        <select name="venue_id" id="venue_id" class="form-control">
                            <option value="">Select Venue</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ $booking->venue_id == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->venue_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="court_id">Court</label>
                        <select name="court_id" id="court_id" class="form-control" required>
                            @foreach($courts as $court)
                            <option value="{{ $court->id }}" {{ $booking->court_id == $court->id ? 'selected' : '' }}>
                                {{ $court->court_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sport_id">Sport</label>
                        <select name="sport_id" id="sport_id" class="form-control" required>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->id }}" {{ $booking->sport_id == $sport->id ? 'selected' : '' }}>
                                    {{ $sport->sport_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="slot_id">Time Slot</label>
                        <select name="slot_id" id="slot_id" class="form-control" required>
                            @foreach($slots as $slot)
                                <option value="{{ $slot->id }}" {{ $booking->slot_id == $slot->id ? 'selected' : '' }}>
                                    {{ $slot->slot_date }} ({{ $slot->slot_time }} - {{ $slot->slot_end_time }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="game_id">Game</label>
                        <select name="game_id" id="game_id" class="form-control">
                            <option value="">Select Game</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ $booking->game_id == $game->id ? 'selected' : '' }}>
                                    {{ $game->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="membership_id">Membership</label>
                        <select name="membership_id" id="membership_id" class="form-control">
                            <option value="">Select Membership</option>
                            @foreach($memberships as $membership)
                                <option value="{{ $membership->id }}" {{ $booking->membership_id == $membership->id ? 'selected' : '' }}>
                                    {{ $membership->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="booking_date">Date</label>
<input type="date" name="booking_date" id="booking_date" class="form-control" value="{{ $booking->booking_date ? $booking->booking_date->format('Y-m-d') : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="number_of_players">Number of Players</label>
                        <input type="number" name="number_of_players" id="number_of_players" class="form-control" min="1" value="{{ $booking->number_of_players }}" required>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="is_member_booking" id="is_member_booking" class="form-check-input" value="1" {{ $booking->is_member_booking ? 'checked' : '' }}>
                        <label for="is_member_booking" class="form-check-label">Is Member Booking</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="is_group_game" id="is_group_game" class="form-check-input" value="1" {{ $booking->is_group_game ? 'checked' : '' }}>
                        <label for="is_group_game" class="form-check-label">Is Group Game</label>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_id">Payment</label>
                        <select name="payment_id" id="payment_id" class="form-control">
                            <option value="">Select Payment</option>
                            @foreach($payments as $payment)
                                <option value="{{ $payment->id }}" {{ $booking->payment_id == $payment->id ? 'selected' : '' }}>
                                    {{ $payment->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_status">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="form-control" required>
                            <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $booking->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="refund_id">Refund</label>
                        <select name="refund_id" id="refund_id" class="form-control">
                            <option value="">Select Refund</option>
                            @foreach($refunds as $refund)
                                <option value="{{ $refund->id }}" {{ $booking->refund_id == $refund->id ? 'selected' : '' }}>
                                    {{ $refund->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Booking</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
