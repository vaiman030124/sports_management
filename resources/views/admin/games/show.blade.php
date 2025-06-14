@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Game Details</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $game->id }}</td>
                </tr>
                <tr>
                    <th>Sport</th>
                    <td>{{ $game->sport->sport_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Court</th>
                    <td>{{ $game->court->court_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Group</th>
                    <td>{{ $game->group->group_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Slot</th>
                    <td>
                        @if($game->slot)
                            {{ $game->slot->slot_date->format('Y-m-d') ?? '' }} {{ $game->slot->slot_time ?? '' }} - {{ $game->slot->slot_end_time ?? '' }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($game->status) }}</td>
                </tr>
                <tr>
                    <th>Participants</th>
                    <td>
                        @foreach($game->participants as $participant)
                            {{ $participant->user->name ?? 'User' }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                </tr>
            </table>
            <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
