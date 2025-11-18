@extends('adminlte::page')

@section('title', 'Depots | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Depot Management</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Depots</h3>
                    <div class="card-tools">
                        <a href="{{ route('depots.create') }}" class="btn btn-primary">Add New Depot</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Address</th>
                                <th>Type</th>
                                <th>Contact Person</th>
                                <th>Active</th>
                                <th>Containers</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($depots as $depot)
                            <tr>
                                <td>{{ $depot->name }}</td>
                                <td>{{ $depot->location }}</td>
                                <td>{{ $depot->address }}</td>
                                <td>
                                    <span class="badge 
                                        @if($depot->type == 'CY') bg-info
                                        @elseif($depot->type == 'WAREHOUSE') bg-warning
                                        @else bg-primary @endif">
                                        {{ $depot->type }}
                                    </span>
                                </td>
                                <td>{{ $depot->contact_person ?: '-' }}</td>
                                <td>
                                    @if($depot->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $depot->containers->count() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('depots.show', $depot) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('depots.edit', $depot) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('depots.destroy', $depot) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                    <a href="{{ route('depots.empty-in-cy') }}?depot={{ $depot->id }}" class="btn btn-sm btn-success">Empty in CY</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No depots found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    {{ $depots->links() }}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@stop