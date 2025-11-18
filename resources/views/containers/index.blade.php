@extends('adminlte::page')

@section('title', 'Containers | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Container Management</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Containers</h3>
                    <div class="card-tools">
                        <a href="{{ route('containers.create') }}" class="btn btn-primary">Add New Container</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control" id="filter-status" onchange="filterByStatus()">
                                <option value="">All Status</option>
                                <option value="ON_TRAIN" {{ request('status') == 'ON_TRAIN' ? 'selected' : '' }}>ON_TRAIN</option>
                                <option value="DISCH" {{ request('status') == 'DISCH' ? 'selected' : '' }}>DISCH</option>
                                <option value="FULL_OUT_CY" {{ request('status') == 'FULL_OUT_CY' ? 'selected' : '' }}>FULL_OUT_CY</option>
                                <option value="EMPTY_IN_CY" {{ request('status') == 'EMPTY_IN_CY' ? 'selected' : '' }}>EMPTY_IN_CY</option>
                                <option value="EMPTY_OUT_CY" {{ request('status') == 'EMPTY_OUT_CY' ? 'selected' : '' }}>EMPTY_OUT_CY</option>
                                <option value="FULL_IN_CY" {{ request('status') == 'FULL_IN_CY' ? 'selected' : '' }}>FULL_IN_CY</option>
                                <option value="LOAD" {{ request('status') == 'LOAD' ? 'selected' : '' }}>LOAD</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="filter-size" onchange="filterBySize()">
                                <option value="">All Sizes</option>
                                <option value="20ft" {{ request('size') == '20ft' ? 'selected' : '' }}>20ft</option>
                                <option value="40ft" {{ request('size') == '40ft' ? 'selected' : '' }}>40ft</option>
                                <option value="45ft" {{ request('size') == '45ft' ? 'selected' : '' }}>45ft</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="filter-type" onchange="filterByType()">
                                <option value="">All Types</option>
                                <option value="STANDARD" {{ request('type') == 'STANDARD' ? 'selected' : '' }}>STANDARD</option>
                                <option value="REEFER" {{ request('type') == 'REEFER' ? 'selected' : '' }}>REEFER</option>
                                <option value="FLATRACK" {{ request('type') == 'FLATRACK' ? 'selected' : '' }}>FLATRACK</option>
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Container Number</th>
                                <th>Size</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Current Location</th>
                                <th>Train</th>
                                <th>Depot</th>
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
                                <td>{{ $container->current_location }}</td>
                                <td>{{ $container->trainShipment ? $container->trainShipment->train_name : '-' }}</td>
                                <td>{{ $container->depo ? $container->depo->name : '-' }}</td>
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
                                    <form action="{{ route('containers.destroy', $container) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No containers found</td>
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

@push('js')
<script>
    function filterByStatus() {
        const status = document.getElementById('filter-status').value;
        let url = '{{ route('containers.index') }}';
        if (status) {
            url += '?status=' + status;
        }
        window.location.href = url;
    }

    function filterBySize() {
        const size = document.getElementById('filter-size').value;
        const status = document.getElementById('filter-status').value;
        let url = '{{ route('containers.index') }}';
        let params = [];
        
        if (status) params.push('status=' + status);
        if (size) params.push('size=' + size);
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        window.location.href = url;
    }

    function filterByType() {
        const type = document.getElementById('filter-type').value;
        const status = document.getElementById('filter-status').value;
        const size = document.getElementById('filter-size').value;
        let url = '{{ route('containers.index') }}';
        let params = [];
        
        if (status) params.push('status=' + status);
        if (size) params.push('size=' + size);
        if (type) params.push('type=' + type);
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        window.location.href = url;
    }
</script>
@endpush