@extends('adminlte::page')

@section('title', 'Create Train | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Create New Train Shipment</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Train Information</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ route('trains.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="train_number">Train Number</label>
                                    <input type="text" class="form-control @error('train_number') is-invalid @enderror" 
                                           id="train_number" name="train_number" 
                                           value="{{ old('train_number') }}" required>
                                    @error('train_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="train_name">Train Name</label>
                                    <input type="text" class="form-control @error('train_name') is-invalid @enderror" 
                                           id="train_name" name="train_name" 
                                           value="{{ old('train_name') }}" required>
                                    @error('train_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="origin_station">Origin Station</label>
                                    <input type="text" class="form-control @error('origin_station') is-invalid @enderror" 
                                           id="origin_station" name="origin_station" 
                                           value="{{ old('origin_station') }}" required>
                                    @error('origin_station')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destination_station">Destination Station</label>
                                    <input type="text" class="form-control @error('destination_station') is-invalid @enderror" 
                                           id="destination_station" name="destination_station" 
                                           value="{{ old('destination_station') }}" required>
                                    @error('destination_station')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departure_time">Departure Time</label>
                                    <input type="datetime-local" class="form-control @error('departure_time') is-invalid @enderror" 
                                           id="departure_time" name="departure_time" 
                                           value="{{ old('departure_time') }}" required>
                                    @error('departure_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estimated_arrival">Estimated Arrival</label>
                                    <input type="datetime-local" class="form-control @error('estimated_arrival') is-invalid @enderror" 
                                           id="estimated_arrival" name="estimated_arrival" 
                                           value="{{ old('estimated_arrival') }}" required>
                                    @error('estimated_arrival')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wagon_count">Wagon Count</label>
                                    <input type="number" class="form-control @error('wagon_count') is-invalid @enderror" 
                                           id="wagon_count" name="wagon_count" 
                                           value="{{ old('wagon_count', 1) }}" min="1" required>
                                    @error('wagon_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="PENDING" {{ old('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                        <option value="SHIPPED" {{ old('status') == 'SHIPPED' ? 'selected' : '' }}>SHIPPED</option>
                                        <option value="ARRIVED" {{ old('status') == 'ARRIVED' ? 'selected' : '' }}>ARRIVED</option>
                                        <option value="DELIVERED" {{ old('status') == 'DELIVERED' ? 'selected' : '' }}>DELIVERED</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Train</button>
                        <a href="{{ route('trains.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@stop