@extends('adminlte::page')

@section('title', 'Train Details | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Train Details - {{ $train->train_number }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Train Information</h3>
                    <div class="card-tools">
                        <a href="{{ route('trains.edit', $train) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('trains.index') }}" class="btn btn-default">Back to List</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Train Number:</label>
                                <p class="form-control-static">{{ $train->train_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Train Name:</label>
                                <p class="form-control-static">{{ $train->train_name }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Origin Station:</label>
                                <p class="form-control-static">{{ $train->origin_station }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Destination Station:</label>
                                <p class="form-control-static">{{ $train->destination_station }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Departure Time:</label>
                                <p class="form-control-static">{{ $train->departure_time->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estimated Arrival:</label>
                                <p class="form-control-static">{{ $train->estimated_arrival->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Actual Arrival:</label>
                                <p class="form-control-static">{{ $train->actual_arrival ? $train->actual_arrival->format('d M Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Wagon Count:</label>
                                <p class="form-control-static">{{ $train->wagon_count }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status:</label>
                                <p class="form-control-static">
                                    <span class="badge 
                                        @if($train->status == 'PENDING') bg-warning
                                        @elseif($train->status == 'SHIPPED') bg-info
                                        @elseif($train->status == 'ARRIVED') bg-success
                                        @elseif($train->status == 'DELIVERED') bg-primary
                                        @else bg-secondary @endif">
                                        {{ $train->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Created At:</label>
                                <p class="form-control-static">{{ $train->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
            @if($train->status !== 'ARRIVED')
            <!-- Process Arrival Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Process Arrival</h3>
                </div>
                <div class="card-body">
                    <p>Process this train's arrival and update all containers to DISCH status?</p>
                    <a href="{{ route('trains.process-arrival', $train->id) }}" 
                       class="btn btn-success" 
                       onclick="return confirm('Are you sure? This will update all containers on this train to DISCH status.')">
                        Process Arrival
                    </a>
                </div>
            </div>
            @endif
            
            <!-- Containers on this Train -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Containers on this Train ({{ $train->containers->count() }})</h3>
                </div>
                <div class="card-body">
                    @if($train->containers->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Container Number</th>
                                <th>Size</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($train->containers as $container)
                            <tr>
                                <td>{{ $container->container_number }}</td>
                                <td>{{ $container->size }}</td>
                                <td>{{ $container->type }}</td>
                                <td>
                                    <span class="badge 
                                        @if($container->status == 'ON_TRAIN') bg-info
                                        @elseif($container->status == 'DISCH') bg-warning
                                        @elseif($container->status == 'FULL_OUT_CY' || $container->status == 'EMPTY_OUT_CY') bg-danger
                                        @elseif($container->status == 'EMPTY_IN_CY' || $container->status == 'FULL_IN_CY') bg-success
                                        @elseif($container->status == 'LOAD') bg-primary
                                        @else bg-secondary @endif">
                                        {{ $container->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($container->condition == 'GOOD') bg-success
                                        @elseif($container->condition == 'DAMAGED') bg-danger
                                        @else bg-warning @endif">
                                        {{ $container->condition }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('containers.show', $container) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No containers assigned to this train.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop