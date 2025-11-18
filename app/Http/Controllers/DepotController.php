<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Models\Container;
use Illuminate\Http\Request;

class DepotController extends Controller
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
        $depots = Depot::paginate(20);
        return view('depots.index', compact('depots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('depots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:depots,name',
            'location' => 'required',
            'address' => 'required',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'type' => 'required|in:CY,WAREHOUSE,YARD',
            'is_active' => 'boolean'
        ]);

        Depot::create($request->all());

        return redirect()->route('depots.index')->with('success', 'Depot created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Depot $depot)
    {
        $depot->load('containers');
        return view('depots.show', compact('depot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depot $depot)
    {
        return view('depots.edit', compact('depot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Depot $depot)
    {
        $request->validate([
            'name' => 'required|unique:depots,name,' . $depot->id,
            'location' => 'required',
            'address' => 'required',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'type' => 'required|in:CY,WAREHOUSE,YARD',
            'is_active' => 'boolean'
        ]);

        $depot->update($request->all());

        return redirect()->route('depots.index')->with('success', 'Depot updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depot $depot)
    {
        $depot->delete();

        return redirect()->route('depots.index')->with('success', 'Depot deleted successfully.');
    }

    /**
     * Display containers in EMPTY IN CY status
     */
    public function emptyInCy()
    {
        $containers = Container::where('status', 'EMPTY_IN_CY')
                              ->with('depo', 'trainShipment')
                              ->paginate(20);
        return view('depots.empty-in-cy', compact('containers'));
    }

    /**
     * Display containers in FULL IN CY status
     */
    public function fullInCy()
    {
        $containers = Container::where('status', 'FULL_IN_CY')
                              ->with('depo', 'trainShipment')
                              ->paginate(20);
        return view('depots.full-in-cy', compact('containers'));
    }

    /**
     * Process empty out for a container
     */
    public function processEmptyOut(Request $request, $containerId)
    {
        $container = Container::find($containerId);
        if (!$container) {
            return redirect()->back()->with('error', 'Container not found.');
        }

        $container->update([
            'status' => 'EMPTY_OUT_CY',
            'purpose' => $request->purpose // 'STUFFING' or 'RETURN'
        ]);

        return redirect()->back()->with('success', 'Container processed for empty out');
    }
}
