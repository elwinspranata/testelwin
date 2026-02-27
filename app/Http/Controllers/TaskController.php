<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('owner')->get();
        $users = User::all();
        return view('tasks.index', compact('tasks','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'owner_id' => 'required|exists:users,id'
        ]);

        Task::create([
            'title' => $request->title,
            'status' => 'pending',
            'owner_id' => $request->owner_id
        ]);

        return redirect()->back()->with('success', 'Task berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'owner_id' => 'required|exists:users,id'
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'owner_id' => $request->owner_id
        ]);

        return redirect()->back()->with('success', 'Task berhasil diperbarui!');
    }

    public function start($id)
    {
        $task = Task::findOrFail($id);
        $task->start_time = now();
        $task->status = 'in_progress';
        $task->save();

        return redirect()->back()->with('success', 'Task dimulai!');
    }

    public function end($id)
    {
        $task = Task::findOrFail($id);

        $task->end_time = now();
        $task->status = 'completed';

        if ($task->start_time) {
            $task->duration_minutes =
                Carbon::parse($task->start_time)
                ->diffInMinutes($task->end_time);
        }

        $task->save();

        return redirect()->back()->with('success', 'Task selesai!');
    }

    public function delete($id)
    {
        Task::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Task berhasil dihapus!');
    }
}