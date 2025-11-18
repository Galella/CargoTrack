<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\TrainShipment;
use App\Models\Depot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContainerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Container::query();

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by size if provided
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        // Filter by type if provided
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $containers = $query->with(['trainShipment', 'depo'])->paginate(20);

        return view('containers.index', compact('containers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainShipments = TrainShipment::all();
        $depots = Depot::all();

        return view('containers.create', compact('trainShipments', 'depots'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'container_number' => 'required|unique:containers,container_number',
            'size' => 'required|in:20ft,40ft,45ft',
            'type' => 'required|in:STANDARD,REEFER,FLATRACK',
            'status' => 'required|in:ON_TRAIN,DISCH,FULL_OUT_CY,EMPTY_IN_CY,EMPTY_OUT_CY,FULL_IN_CY,LOAD',
            'current_location' => 'nullable|string|max:255',
            'train_shipment_id' => 'nullable|exists:train_shipments,id',
            'depo_id' => 'nullable|exists:depots,id',
            'condition' => 'required|in:GOOD,DAMAGED,MAINTENANCE',
        ]);

        Container::create($request->all());

        return redirect()->route('containers.index')->with('success', 'Container created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Container $container)
    {
        $container->load(['trainShipment', 'depo', 'movements.user']);

        return view('containers.show', compact('container'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Container $container)
    {
        $trainShipments = TrainShipment::all();
        $depots = Depot::all();

        return view('containers.edit', compact('container', 'trainShipments', 'depots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Container $container)
    {
        $request->validate([
            'container_number' => 'required|unique:containers,container_number,' . $container->id,
            'size' => 'required|in:20ft,40ft,45ft',
            'type' => 'required|in:STANDARD,REEFER,FLATRACK',
            'status' => 'required|in:ON_TRAIN,DISCH,FULL_OUT_CY,EMPTY_IN_CY,EMPTY_OUT_CY,FULL_IN_CY,LOAD',
            'current_location' => 'nullable|string|max:255',
            'train_shipment_id' => 'nullable|exists:train_shipments,id',
            'depo_id' => 'nullable|exists:depots,id',
            'condition' => 'required|in:GOOD,DAMAGED,MAINTENANCE',
        ]);

        $container->update($request->all());

        return redirect()->route('containers.index')->with('success', 'Container updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Container $container)
    {
        $container->delete();

        return redirect()->route('containers.index')->with('success', 'Container deleted successfully.');
    }

    /**
     * Update container status
     */
    public function updateStatus(Request $request, $containerId)
    {
        $container = Container::findOrFail($containerId);

        $request->validate([
            'status' => 'required|in:ON_TRAIN,DISCH,FULL_OUT_CY,EMPTY_IN_CY,EMPTY_OUT_CY,FULL_IN_CY,LOAD'
        ]);

        $previousStatus = $container->status;
        $newStatus = $request->status;

        // Update container status
        $container->update([
            'status' => $newStatus
        ]);

        // Log the movement
        \App\Models\ContainerMovement::create([
            'container_id' => $container->id,
            'from_status' => $previousStatus,
            'to_status' => $newStatus,
            'movement_type' => 'MANUAL_UPDATE',
            'user_id' => Auth::id(),
            'notes' => 'Status updated manually'
        ]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
