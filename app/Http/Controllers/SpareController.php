<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spare;

class SpareController extends Controller
{
    // Anyone can access
    public function index()
    {
        $spares = Spare::all();
        return view('spares.index', compact('spares'));
    }

    public function create()
    {
        return view('spares.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Spare::create($request->all());

        return redirect()->route('spares.index')->with('success', 'Spare created successfully!');
    }

    public function edit($id)
    {
        $spare = Spare::findOrFail($id);
        return view('spares.edit', compact('spare'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $spare = Spare::findOrFail($id);
        $spare->update($request->all());

        return redirect()->route('spares.index')->with('success', 'Spare updated successfully!');
    }

    public function destroy($id)
    {
        $spare = Spare::findOrFail($id);
        $spare->delete();

        return redirect()->route('spares.index')->with('success', 'Spare deleted successfully!');
    }
}


