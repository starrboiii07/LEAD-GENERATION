<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Task; 
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $leads = Lead::when($search, function ($query, $search) {
                            return $query->where('name', 'like', "%{$search}%")
                                         ->orWhere('email', 'like', "%{$search}%")
                                         ->orWhere('phone', 'like', "%{$search}%");
                        })->latest()->get();

        // Fetch open tasks for the sidebar
        $tasks = Task::where('status', 'open')->orderBy('due_date')->get();

        if ($request->ajax()) {
            return response()->json(['leads' => $leads, 'tasks' => $tasks]);
        }

        return view('leads.index', compact('leads', 'tasks'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:leads,email',
            'phone'     => 'nullable|string|max:20',
            'position'  => 'nullable|string|max:100',
            'profile'   => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lead = new Lead($request->except('profile'));

        if ($request->hasFile('profile')) {
            $lead->profile = $request->file('profile')->store('profiles', 'public');
        }

        $lead->save();

        return response()->json(['message' => 'Lead added successfully', 'lead' => $lead]);
    }

    public function edit(Lead $lead)
    {
        return response()->json($lead);
    }

    public function update(Request $request, Lead $lead)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:leads,email,' . $lead->id,
            'phone'     => 'nullable|string|max:20',
            'position'  => 'nullable|string|max:100',
            'profile'   => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lead->fill($request->except('profile'));

        if ($request->hasFile('profile')) {
            $lead->profile = $request->file('profile')->store('profiles', 'public');
        }

        $lead->save();

        return response()->json(['message' => 'Lead updated successfully', 'lead' => $lead]);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return response()->json(['message' => 'Lead deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $leads = Lead::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%")
                    ->get();
        return response()->json($leads);
    }
}