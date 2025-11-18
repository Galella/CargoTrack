@extends('adminlte::page')

@section('title', 'Container Details | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Container Details - {{ $container->container_number }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Container Information</h3>
                    <div class="card-tools">
                        <a href="{{ route('containers.edit', $container) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('containers.index') }}" class="btn btn-default">Back to List</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Container Number:</label>
                                <p class="form-control-static">{{ $container->container_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Size:</label>
                                <p class="form-control-static">{{ $container->size }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type:</label>
                                <p class="form-control-static">{{ $container->type }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status:</label>
                                <p class="form-control-static">
                                    <span class="badge 
                                        @if($container->status == 'ON_TRAIN') bg-info
                                        @elseif($container->status == 'DISCH') bg-warning
                                        @elseif($container->status == 'FULL_OUT_CY' || $container->status == 'EMPTY_OUT_CY') bg-danger
                                        @elseif($container->status == 'EMPTY_IN_CY' || $container->status == 'FULL_IN_CY') bg-success
                                        @elseif($container->status == 'LOAD') bg-primary
                                        @else bg-secondary @endif">
                                        {{ $container->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Current Location:</label>
                                <p class="form-control-static">{{ $container->current_location ?: 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Condition:</label>
                                <p class="form-control-static">
                                    <span class="badge 
                                        @if($container->condition == 'GOOD') bg-success
                                        @elseif($container->condition == 'DAMAGED') bg-danger
                                        @else bg-warning @endif">
                                        {{ $container->condition }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Train Shipment:</label>
                                <p class="form-control-static">{{ $container->trainShipment ? $container->trainShipment->train_name : 'Not on Train' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Depot:</label>
                                <p class="form-control-static">{{ $container->depo ? $container->depo->name : 'No Depot' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Borrowed:</label>
                                <p class="form-control-static">
                                    {{ $container->is_borrowed ? 'Yes' : 'No' }}
                                    @if($container->is_borrowed)
                                        <br><small>By: {{ $container->borrowed_to }}</small>
                                        <br><small>On: {{ $container->borrowed_at ? $container->borrowed_at->format('d M Y H:i') : '' }}</small>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purpose:</label>
                                <p class="form-control-static">{{ $container->purpose ?: 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Created At:</label>
                                <p class="form-control-static">{{ $container->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
            <!-- Status Update Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Status</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('containers.update-status', $container->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-8">
                                <select class="form-control" name="status" required>
                                    <option value="">Select New Status</option>
                                    <option value="ON_TRAIN">ON_TRAIN</option>
                                    <option value="DISCH">DISCH</option>
                                    <option value="FULL_OUT_CY">FULL_OUT_CY</option>
                                    <option value="EMPTY_IN_CY">EMPTY_IN_CY</option>
                                    <option value="EMPTY_OUT_CY">EMPTY_OUT_CY</option>
                                    <option value="FULL_IN_CY">FULL_IN_CY</option>
                                    <option value="LOAD">LOAD</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success btn-block">Update Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Movement History Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Movement History</h3>
                </div>
                <div class="card-body">
                    @if($container->movements->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>From Status</th>
                                <th>To Status</th>
                                <th>Movement Type</th>
                                <th>User</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($container->movements->sortByDesc('created_at') as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('d M Y H:i') }}</td>
                                <td><span class="badge bg-secondary">{{ $movement->from_status }}</span></td>
                                <td><span class="badge bg-info">{{ $movement->to_status }}</span></td>
                                <td>{{ $movement->movement_type }}</td>
                                <td>{{ $movement->user ? $movement->user->name : 'System' }}</td>
                                <td>{{ $movement->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No movement history available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop