<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Log;
use App\Imports\ExpensesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\serviceMonitorImport;

class TicketController extends Controller
{
    // Role check for Admin and Manager
    private function checkAccess()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized - You must be logged in.');
        }
    }

    // Display all tickets
    public function index()
    {
        $this->checkAccess();
        $tickets = Ticket::with('user')->get(); // eager load user
        return view('tickets.index', compact('tickets'));
    }

    // Show form to create a ticket
    public function create()
    {
        $this->checkAccess();
        $users = User::all(); // fetch all users to assign tickets if needed
        return view('tickets.create', compact('users'));
    }

    // Store new ticket
    public function store(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // ✅ Create ticket and assign to $ticket
        $ticket = Ticket::create([
            'title'       => $request->title,
            'description' => $request->description,
            'user_id'     => Auth::id(),
            'status'      => 'Open', // default status
        ]);

        // ✅ Log the action
        Log::create([
            'user_id'    => Auth::id(),
            'action'     => 'Created Ticket',
            'description'=> 'Ticket ID: '.$ticket->id.' titled: '.$ticket->title,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
    }

    // Show single ticket
    public function show($id)
    {
        $this->checkAccess();
        $ticket = Ticket::with('user')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    // Edit ticket
    public function edit($id)
    {
        $this->checkAccess();
        $ticket = Ticket::findOrFail($id);
        $users = User::all();
        return view('tickets.edit', compact('ticket', 'users'));
    }

    // Update ticket
    public function update(Request $request, $id)
    {
        $this->checkAccess();

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'required|string|in:Open,In Progress,Resolved,Closed',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        // ✅ Log the update
        Log::create([
            'user_id'    => Auth::id(),
            'action'     => 'Updated Ticket',
            'description'=> 'Ticket ID: '.$ticket->id.' updated to title: '.$ticket->title.' and status: '.$ticket->status,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully!');
    }

    // Delete ticket
    public function destroy($id)
    {
        $this->checkAccess();
        $ticket = Ticket::findOrFail($id);

        // ✅ Log before deleting
        Log::create([
            'user_id'    => Auth::id(),
            'action'     => 'Deleted Ticket',
            'description'=> 'Ticket ID: '.$ticket->id.' titled: '.$ticket->title,
        ]);

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully!');
    }
    //Import serviceMonitor
    public function serviceMonitor(){
        return view("tickets.serviceMonitor");
    }

    //Import serviceOrder
    public function serviceOrder(){
        return view("tickets.serviceOrder");
    }
    //@import serviceMonitor
    public function importServiceMonitor(Request $request){
       $request->validate([
                            'serviceMonitor' => 'required|mimes:csv,txt,xlsx'
                            ], [
                                'serviceMonitor.required' => 'Please select a file to upload.',
                                'serviceMonitor.mimes'    => 'Only Excel (xlsx) or CSV files are allowed.'
                        ]);
        Excel::import(new serviceMonitorImport, $request->file('serviceMonitor'));
        return back()->with('success', 'Service Monitor data imported successfully.');

    }
}



