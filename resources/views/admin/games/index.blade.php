@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Games List</h3>
            <a href="{{ route('admin.games.create') }}" class="btn btn-primary">Create New Game</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sport</th>
                        <th>Court</th>
                        <th>Group</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                    <tr>
                        <td>{{ $game->id }}</td>
                        <td>{{ $game->sport->sport_name ?? 'N/A' }}</td>
                        <td>{{ $game->court->court_name ?? 'N/A' }}</td>
                        <td>{{ $game->group->group_name ?? 'N/A' }}</td>
                        <td>
                            @if($game->slot)
                                {{ $game->slot->slot_date->format('Y-m-d') ?? '' }} {{ $game->slot->slot_time ?? '' }} - {{ $game->slot->slot_end_time ?? '' }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ ucfirst($game->status) }}</td>
                        <td>
                            <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.games.destroy', $game) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $games->links() }}
        </div>
    </div>
</div>
@endsection
