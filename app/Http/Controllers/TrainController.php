<?php

namespace App\Http\Controllers;

use App\Models\TrainShipment;
use App\Models\Container;
use App\Models\ContainerMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trains = TrainShipment::withCount('containers')->paginate(20);
        return view('trains.index', compact('trains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'train_number' => 'required|unique:train_shipments,train_number',
            'train_name' => 'required',
            'origin_station' => 'required',
            'destination_station' => 'required',
            'departure_time' => 'required|date',
            'estimated_arrival' => 'required|date|after:departure_time',
            'wagon_count' => 'required|integer|min:1',
            'status' => 'required|in:PENDING,SHIPPED,ARRIVED,DELIVERED',
        ]);

        TrainShipment::create($request->all());

        return redirect()->route('trains.index')->with('success', 'Train shipment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainShipment $train)
    {
        $train->load('containers');
        return view('trains.show', compact('train'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainShipment $train)
    {
        return view('trains.edit', compact('train'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainShipment $train)
    {
        $request->validate([
            'train_number' => 'required|unique:train_shipments,train_number,' . $train->id,
            'train_name' => 'required',
            'origin_station' => 'required',
            'destination_station' => 'required',
            'departure_time' => 'required|date',
            'estimated_arrival' => 'required|date|after:departure_time',
            'wagon_count' => 'required|integer|min:1',
            'status' => 'required|in:PENDING,SHIPPED,ARRIVED,DELIVERED',
        ]);

        $train->update($request->all());

        return redirect()->route('trains.index')->with('success', 'Train shipment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainShipment $train)
    {
        $train->delete();

        return redirect()->route('trains.index')->with('success', 'Train shipment deleted successfully.');
    }

    /**
     * Process train arrival
     */
    public function processArrival($trainId)
    {
        $train = TrainShipment::with('containers')->find($trainId);

        if (!$train) {
            return redirect()->route('trains.index')->with('error', 'Train not found.');
        }

        // Update train status
        $train->update([
            'status' => 'ARRIVED',
            'actual_arrival' => now()
        ]);

        // Update all containers to DISCH status
        $train->containers()->update([
            'status' => 'DISCH',
            'previous_status' => 'ON_TRAIN'  // Note: We may need to add previous_status to containers table later
        ]);

        // Log movements
        foreach($train->containers as $container) {
            ContainerMovement::create([
                'container_id' => $container->id,
                'from_status' => 'ON_TRAIN',
                'to_status' => 'DISCH',
                'movement_type' => 'TRAIN_ARRIVAL',
                'user_id' => Auth::id()
            ]);
        }

        return redirect()->route('trains.show', $trainId)
                        ->with('success', 'Train arrival processed successfully');
    }
}
