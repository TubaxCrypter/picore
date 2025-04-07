<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Görevlerin listesini görüntüle
     */
    public function index()
    {
        $tasks = Task::query()
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('priority'), function ($query, $priority) {
                $query->where('priority', $priority);
            })
            ->when(request('sort'), function ($query, $sort) {
                $parts = explode('_', $sort);
                if (count($parts) === 2) {
                    [$column, $direction] = $parts;
                    $query->orderBy($column, $direction);
                }
            }, function ($query) {
                $query->latest();
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'filters' => request()->only(['search', 'status', 'priority', 'sort']),
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }

    /**
     * Yeni görev oluşturma formunu göster
     */
    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    /**
     * Yeni görevi veritabanına kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create([
            ...$validated,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Görev başarıyla oluşturuldu.');
    }

    /**
     * Belirli bir görevi göster
     */
    public function show(Task $task)
    {
        // Yetkilendirme kontrolü
        $this->authorize('view', $task);

        return Inertia::render('Tasks/Show', [
            'task' => $task
        ]);
    }

    /**
     * Görev düzenleme formunu göster
     */
    public function edit(Task $task)
    {
        // Yetkilendirme kontrolü
        $this->authorize('update', $task);

        return Inertia::render('Tasks/Edit', [
            'task' => $task
        ]);
    }

    /**
     * Görevi güncelle
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return back()->with('success', 'Görev başarıyla güncellendi.');
    }

    /**
     * Görevi sil
     */
    public function destroy(Task $task)
    {
        // Yetkilendirme kontrolü
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->back()->with('success', 'Görev başarıyla silindi.');
    }
} 