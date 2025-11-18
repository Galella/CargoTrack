@extends('adminlte::page')

@section('title', 'Create Container | CargoTrack')

@section('content_header')
    <h1>CargoTrack - Create New Container</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Container Information</h3>
                </div>
                <!-- /.card-header -->
                <form action="{{ route('containers.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="container_number">Container Number</label>
                                    <input type="text" class="form-control @error('container_number') is-invalid @enderror" 
                                           id="container_number" name="container_number" 
                                           value="{{ old('container_number') }}" required>
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
                                        <option value="20ft" {{ old('size') == '20ft' ? 'selected' : '' }}>20ft</option>
                                        <option value="40ft" {{ old('size') == '40ft' ? 'selected' : '' }}>40ft</option>
                                        <option value="45ft" {{ old('size') == '45ft' ? 'selected' : '' }}>45ft</option>
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
                                        <option value="STANDARD" {{ old('type') == 'STANDARD' ? 'selected' : '' }}>STANDARD</option>
                                        <option value="REEFER" {{ old('type') == 'REEFER' ? 'selected' : '' }}>REEFER</option>
                                        <option value="FLATRACK" {{ old('type') == 'FLATRACK' ? 'selected' : '' }}>FLATRACK</option>
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
                                        <option value="ON_TRAIN" {{ old('status') == 'ON_TRAIN' ? 'selected' : '' }}>ON_TRAIN</option>
                                        <option value="DISCH" {{ old('status') == 'DISCH' ? 'selected' : '' }}>DISCH</option>
                                        <option value="FULL_OUT_CY" {{ old('status') == 'FULL_OUT_CY' ? 'selected' : '' }}>FULL_OUT_CY</option>
                                        <option value="EMPTY_IN_CY" {{ old('status') == 'EMPTY_IN_CY' ? 'selected' : '' }}>EMPTY_IN_CY</option>
                                        <option value="EMPTY_OUT_CY" {{ old('status') == 'EMPTY_OUT_CY' ? 'selected' : '' }}>EMPTY_OUT_CY</option>
                                        <option value="FULL_IN_CY" {{ old('status') == 'FULL_IN_CY' ? 'selected' : '' }}>FULL_IN_CY</option>
                                        <option value="LOAD" {{ old('status') == 'LOAD' ? 'selected' : '' }}>LOAD</option>
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
                                           value="{{ old('current_location') }}">
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
                                                    {{ old('train_shipment_id') == $trainShipment->id ? 'selected' : '' }}>
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
                                                    {{ old('depo_id') == $depot->id ? 'selected' : '' }}>
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
                                        <option value="GOOD" {{ old('condition') == 'GOOD' ? 'selected' : '' }}>GOOD</option>
                                        <option value="DAMAGED" {{ old('condition') == 'DAMAGED' ? 'selected' : '' }}>DAMAGED</option>
                                        <option value="MAINTENANCE" {{ old('condition') == 'MAINTENANCE' ? 'selected' : '' }}>MAINTENANCE</option>
                                    </select>
                                    @error('condition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Container</button>
                        <a href="{{ route('containers.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@stop