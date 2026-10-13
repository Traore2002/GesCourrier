<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workflow;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::with('creator')->orderBy('created_at', 'desc')->get();
        return view('admin.workflows.index', compact('workflows'));
    }

    public function create()
    {
        $roles = Role::where('actif', true)->get();
        return view('admin.workflows.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:arrivee,depart,interne',
            'steps' => 'required|array|min:1',
            'steps.*.order' => 'required|integer',
            'steps.*.type' => 'required|string',
            'steps.*.role_id' => 'nullable|exists:roles,id',
            'steps.*.deadline_hours' => 'nullable|integer|min:1',
            'steps.*.description' => 'nullable|string',
        ]);

        $workflow = Workflow::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'steps' => $validated['steps'], // Stocké en JSON
            'created_by' => Auth::id(),
            'is_active' => true,
        ]);

        return response()->json(['success' => true, 'workflow' => $workflow]);
    }

    public function show(Workflow $workflow)
    {
        return view('admin.workflows.show', compact('workflow'));
    }

    public function destroy(Workflow $workflow)
    {
        $workflow->delete();
        return redirect()->route('admin.workflows.index')
            ->with('success', 'Workflow supprimé avec succès');
    }
}