@extends('adminlte::page')

@section('title', 'Edit Container | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Edit Container - {{ $container->container_number }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Container Information</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ route('containers.update', $container) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="container_number">Container Number</label>
                                    <input type="text" class="form-control @error('container_number') is-invalid @enderror" 
                                           id="container_number" name="container_number" 
                                           value="{{ old('container_number', $container->container_number) }}" required>
                                    @error('container_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="size">Size</label>
                                    <select class="form-control @error('size') is-invalid @enderror" 
                                            id="size" name="size" required>
                                        <option value="">Select Size</option>
                                        <option value="20ft" {{ old('size', $container->size) == '20ft' ? 'selected' : '' }}>20ft</option>
                                        <option value="40ft" {{ old('size', $container->size) == '40ft' ? 'selected' : '' }}>40ft</option>
                                        <option value="45ft" {{ old('size', $container->size) == '45ft' ? 'selected' : '' }}>45ft</option>
                                    </select>
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select class="form-control @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="STANDARD" {{ old('type', $container->type) == 'STANDARD' ? 'selected' : '' }}>STANDARD</option>
                                        <option value="REEFER" {{ old('type', $container->type) == 'REEFER' ? 'selected' : '' }}>REEFER</option>
                                        <option value="FLATRACK" {{ old('type', $container->type) == 'FLATRACK' ? 'selected' : '' }}>FLATRACK</option>
                                    </select>
                                    @error('type')
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
                                        <option value="ON_TRAIN" {{ old('status', $container->status) == 'ON_TRAIN' ? 'selected' : '' }}>ON_TRAIN</option>
                                        <option value="DISCH" {{ old('status', $container->status) == 'DISCH' ? 'selected' : '' }}>DISCH</option>
                                        <option value="FULL_OUT_CY" {{ old('status', $container->status) == 'FULL_OUT_CY' ? 'selected' : '' }}>FULL_OUT_CY</option>
                                        <option value="EMPTY_IN_CY" {{ old('status', $container->status) == 'EMPTY_IN_CY' ? 'selected' : '' }}>EMPTY_IN_CY</option>
                                        <option value="EMPTY_OUT_CY" {{ old('status', $container->status) == 'EMPTY_OUT_CY' ? 'selected' : '' }}>EMPTY_OUT_CY</option>
                                        <option value="FULL_IN_CY" {{ old('status', $container->status) == 'FULL_IN_CY' ? 'selected' : '' }}>FULL_IN_CY</option>
                                        <option value="LOAD" {{ old('status', $container->status) == 'LOAD' ? 'selected' : '' }}>LOAD</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_location">Current Location</label>
                                    <input type="text" class="form-control @error('current_location') is-invalid @enderror" 
                                           id="current_location" name="current_location" 
                                           value="{{ old('current_location', $container->current_location) }}">
                                    @error('current_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="train_shipment_id">Train Shipment</label>
                                    <select class="form-control @error('train_shipment_id') is-invalid @enderror" 
                                            id="train_shipment_id" name="train_shipment_id">
                                        <option value="">Not on Train</option>
                                        @foreach($trainShipments as $trainShipment)
                                            <option value="{{ $trainShipment->id }}" 
                                                    {{ old('train_shipment_id', $container->train_shipment_id) == $trainShipment->id ? 'selected' : '' }}>
                                                {{ $trainShipment->train_number }} - {{ $trainShipment->train_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('train_shipment_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="depo_id">Depot</label>
                                    <select class="form-control @error('depo_id') is-invalid @enderror" 
                                            id="depo_id" name="depo_id">
                                        <option value="">No Depot</option>
                                        @foreach($depots as $depot)
                                            <option value="{{ $depot->id }}" 
                                                    {{ old('depo_id', $container->depo_id) == $depot->id ? 'selected' : '' }}>
                                                {{ $depot->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('depo_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="condition">Condition</label>
                                    <select class="form-control @error('condition') is-invalid @enderror" 
                                            id="condition" name="condition" required>
                                        <option value="">Select Condition</option>
                                        <option value="GOOD" {{ old('condition', $container->condition) == 'GOOD' ? 'selected' : '' }}>GOOD</option>
                                        <option value="DAMAGED" {{ old('condition', $container->condition) == 'DAMAGED' ? 'selected' : '' }}>DAMAGED</option>
                                        <option value="MAINTENANCE" {{ old('condition', $container->condition) == 'MAINTENANCE' ? 'selected' : '' }}>MAINTENANCE</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_borrowed">Borrowed</label>
                                    <select class="form-control @error('is_borrowed') is-invalid @enderror" 
                                            id="is_borrowed" name="is_borrowed">
                                        <option value="0" {{ old('is_borrowed', $container->is_borrowed) == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('is_borrowed', $container->is_borrowed) == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('is_borrowed')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="borrowed_to">Borrowed To</label>
                                    <input type="text" class="form-control @error('borrowed_to') is-invalid @enderror" 
                                           id="borrowed_to" name="borrowed_to" 
                                           value="{{ old('borrowed_to', $container->borrowed_to) }}">
                                    @error('borrowed_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="borrowed_at">Borrowed At</label>
                                    <input type="datetime-local" class="form-control @error('borrowed_at') is-invalid @enderror" 
                                           id="borrowed_at" name="borrowed_at" 
                                           value="{{ old('borrowed_at', $container->borrowed_at ? $container->borrowed_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('borrowed_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purpose">Purpose</label>
                                    <input type="text" class="form-control @error('purpose') is-invalid @enderror" 
                                           id="purpose" name="purpose" 
                                           value="{{ old('purpose', $container->purpose) }}">
                                    @error('purpose')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Container</button>
                        <a href="{{ route('containers.show', $container) }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@stop