@extends('adminlte::page')

@section('title', 'Trains | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Train Management</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Train Shipments</h3>
                    <div class="card-tools">
                        <a href="{{ route('trains.create') }}" class="btn btn-primary">Add New Train</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Train Number</th>
                                <th>Train Name</th>
                                <th>Origin</th>
                                <th>Destination</th>
                                <th>Departure</th>
                                <th>Est. Arrival</th>
                                <th>Actual Arrival</th>
                                <th>Status</th>
                                <th>Containers</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trains as $train)
                            <tr>
                                <td>{{ $train->train_number }}</td>
                                <td>{{ $train->train_name }}</td>
                                <td>{{ $train->origin_station }}</td>
                                <td>{{ $train->destination_station }}</td>
                                <td>{{ $train->departure_time ? $train->departure_time->format('d M Y H:i') : '-' }}</td>
                                <td>{{ $train->estimated_arrival ? $train->estimated_arrival->format('d M Y H:i') : '-' }}</td>
                                <td>{{ $train->actual_arrival ? $train->actual_arrival->format('d M Y H:i') : '-' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($train->status == 'PENDING') bg-warning
                                        @elseif($train->status == 'SHIPPED') bg-info
                                        @elseif($train->status == 'ARRIVED') bg-success
                                        @elseif($train->status == 'DELIVERED') bg-primary
                                        @else bg-secondary @endif">
                                        {{ $train->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $train->containers_count }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('trains.show', $train) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('trains.edit', $train) }}" class="btn btn-sm btn-primary">Edit</a>
                                    @if($train->status !== 'ARRIVED')
                                    <a href="{{ route('trains.process-arrival', $train->id) }}" 
                                       class="btn btn-sm btn-success" 
                                       onclick="return confirm('Process arrival for this train?')">
                                        Process Arrival
                                    </a>
                                    @endif
                                    <form action="{{ route('trains.destroy', $train) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">No trains found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    {{ $trains->links() }}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@stop