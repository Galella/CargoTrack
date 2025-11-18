@extends('adminlte::page')

@section('title', 'Empty in CY | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Depot - Empty in CY</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Containers with Status: Empty in CY</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Container Number</th>
                                <th>Size</th>
                                <th>Type</th>
                                <th>Depot</th>
                                <th>Train</th>
                                <th>Condition</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($containers as $container)
                            <tr>
                                <td>{{ $container->container_number }}</td>
                                <td>{{ $container->size }}</td>
                                <td>{{ $container->type }}</td>
                                <td>{{ $container->depo ? $container->depo->name : 'N/A' }}</td>
                                <td>{{ $container->trainShipment ? $container->trainShipment->train_name : 'N/A' }}</td>
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
                                    <a href="{{ route('containers.edit', $container) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <div class="btn-group-vertical" role="group">
                                        <a href="{{ route('depots.process-empty-out', $container) }}?purpose=STUFFING" 
                                           class="btn btn-sm btn-warning" 
                                           onclick="return confirm('Process empty out as STUFFING?')">
                                            STUFFING
                                        </a>
                                        <a href="{{ route('depots.process-empty-out', $container) }}?purpose=RETURN" 
                                           class="btn btn-sm btn-success" 
                                           onclick="return confirm('Process empty out as RETURN?')">
                                            RETURN
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No containers with status Empty in CY found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    {{ $containers->links() }}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@stop