<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // List tasks + filter by status
    public function index(Request $request)
    {
        $status = $request->query('status'); //  'in_progress' | 'done' | null

        $tasks = Task::query()
            ->where('user_id', $request->user()->id)
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tasks.index', compact('tasks','status'));
    }

    // Add task
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required','string','max:255'],
            'description' => ['nullable','string','max:2000'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['status']  = 'pending';

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task added.');
    }

    // Update task (status and/or title/description)
    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $data = $request->validate([
            'title'       => ['sometimes','string','max:255'],
            'description' => ['sometimes','nullable','string','max:2000'],
            'status'      => ['sometimes','in:in_progress,done'],
        ]);

        $task->update($data);

        return back()->with('success', 'Task updated.');
    }

    // Optional: delete
    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);
        $task->delete();
        return back()->with('success', 'Task deleted.');
    }

    private function authorizeTask(Request $request, Task $task): void
    {
        abort_unless($task->user_id === $request->user()->id, 403);
    }
}
