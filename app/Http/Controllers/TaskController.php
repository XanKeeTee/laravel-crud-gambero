<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('user_id', Auth::id())->get();
        }
        
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required', 
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea creada correctamente.');
    }

    public function edit(Task $task)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'No tienes permiso para editar tareas.');
        }
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acción no autorizada.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada correctamente.');
    }
    public function destroy(Task $task)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'No tienes permiso para eliminar tareas.');
        }
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada correctamente.');
    }
}
