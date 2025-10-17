<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procurement;
use App\Models\Spare;

class ProcurementController extends Controller
{
    // Display all procurements
    public function index()
    {
        $procurements = Procurement::with('spare')->get();
        return view('procurements.index', compact('procurements'));
    }

    // Show form to create a procurement
    public function create()
    {
        $spares = Spare::all();
        return view('procurements.create', compact('spares'));
    }

    // Store new procurement
    public function store(Request $request)
    {
        $request->validate([
            'spare_id' => 'required|exists:spares,id',
            'quantity' => 'required|integer',
            'supplier' => 'required|string',
            'status' => 'required|in:Ordered,Received,Cancelled',
            'description' => 'nullable',
        ]);

        Procurement::create($request->all());

        return redirect()->route('procurements.index')->with('success', 'Procurement added successfully!');
    }

    // Show single procurement
    public function show($id)
    {
        $procurement = Procurement::with('spare')->findOrFail($id);
        return view('procurements.show', compact('procurement'));
    }

    // Edit procurement
    public function edit($id)
    {
        $procurement = Procurement::findOrFail($id);
        $spares = Spare::all();
        return view('procurements.edit', compact('procurement', 'spares'));
    }

    // Update procurement
    public function update(Request $request, $id)
    {
        $request->validate([
            'spare_id' => 'required|exists:spares,id',
            'quantity' => 'required|integer',
            'supplier' => 'required|string',
            'status' => 'required|in:Ordered,Received,Cancelled',
            'description' => 'nullable',
        ]);

        $procurement = Procurement::findOrFail($id);
        $procurement->update($request->all());

        return redirect()->route('procurements.index')->with('success', 'Procurement updated successfully!');
    }

    // Delete procurement
    public function destroy($id)
    {
        $procurement = Procurement::findOrFail($id);
        $procurement->delete();

        return redirect()->route('procurements.index')->with('success', 'Procurement deleted successfully!');
    }
}


