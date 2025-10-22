<x-layout title="My Tasks">
  
  {{-- Page styles (scoped to this page) --}}
  <style>
    .task-badge { text-transform: capitalize; }
    .truncate-2 {
      display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .list-group-item:hover { background-color: #f9fafb; }
    .status-select { min-width: 150px; }
  </style>

  {{-- Feedback --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  {{-- Header + Filter --}}
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-2">
    <div>
      <h1 class="h4 mb-1">Your Tasks</h1>
      <div class="text-muted small">
        {{ $tasks->total() }} total
        @if($status) • filtered by <strong>{{ str_replace('_',' ', $status) }}</strong> @endif
      </div>
    </div>

    <form method="GET" class="d-flex align-items-center gap-2">
      <label for="status" class="form-label mb-0 visually-hidden">Filter status</label>
      <select id="status" name="status" class="form-select status-select" onchange="this.form.submit()">
        <option value="">All statuses</option>
        <option value="in_progress" {{ $status==='in_progress'?'selected':'' }}>In-Progress</option>
        <option value="done" {{ $status==='done'?'selected':'' }}>Done</option>
      </select>
      @if($status)
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Clear</a>
      @endif
    </form>
  </div>

  {{-- Add Task --}}
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h2 class="h5 mb-3">Add Task</h2>
      <form method="POST" action="{{ route('tasks.store') }}" class="row g-3">
        @csrf

        <div class="col-12 col-md-5">
          <div class="form-floating">
            <input id="title" name="title" class="form-control" placeholder=" " required>
            <label for="title">Task title</label>
          </div>
        </div>

        <div class="col-12 col-md-5">
          <div class="form-floating">
            <input id="description" name="description" class="form-control" placeholder=" ">
            <label for="description">Description (optional)</label>
          </div>
        </div>

        <div class="col-12 col-md-2 d-grid">
          <button class="btn btn-primary" type="submit">Add</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Task List --}}
  @if($tasks->count())
    <div class="list-group list-group-flush border rounded shadow-sm">
      @foreach($tasks as $task)
        <div class="list-group-item">
          <div class="row align-items-center g-3">
            {{-- Title + meta --}}
            <div class="col-12 col-lg-6">
              <div class="d-flex align-items-start justify-content-between gap-2">
                <div>
                  <div class="fw-semibold">{{ $task->title }}</div>
                  @if($task->description)
                    <div class="text-muted small mt-1 truncate-2">{{ $task->description }}</div>
                  @endif
                  <div class="text-muted small mt-1">
                    Created {{ $task->created_at->diffForHumans() }}
                  </div>
                </div>
                {{-- Status badge (read-only visual) --}}
                @php
                  $badgeClass = match($task->status) {
                    'done' => 'bg-success',
                    'in_progress' => 'bg-warning text-dark',
                    default => 'bg-secondary'
                  };
                @endphp
                <span class="badge {{ $badgeClass }} task-badge ms-2">{{ str_replace('_',' ', $task->status) }}</span>
              </div>
            </div>

            {{-- Update Status --}}
            <div class="col-12 col-md-4 col-lg-3">
              <form method="POST" action="{{ route('tasks.update', $task) }}" class="d-flex align-items-center gap-2">
                @csrf @method('PATCH')
                <label for="status-{{ $task->id }}" class="form-label mb-0 small text-muted">Change status</label>
                <select id="status-{{ $task->id }}" name="status" class="form-select form-select-sm"
                        onchange="this.form.submit()" aria-label="Change status for {{ $task->title }}">
                  <option value="pending"     @selected($task->status==='pending')>Pending</option>
                  <option value="in_progress" @selected($task->status==='in_progress')>In-Progress</option>
                  <option value="done"        @selected($task->status==='done')>Done</option>
                </select>
              </form>
            </div>

            {{-- Actions --}}
            <div class="col-12 col-md-2 col-lg-3 d-flex justify-content-lg-end gap-2">
              <!-- Edit Button (opens modal) -->
              <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editTaskModal-{{ $task->id }}">
                Edit
              </button>

              <!-- Delete -->
              <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                    onsubmit="return confirm('Delete this task?');">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
              </form>
            </div>
          </div>
        </div>

        {{-- Edit Modal --}}
        <div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskLabel-{{ $task->id }}" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf @method('PATCH')
                <div class="modal-header">
                  <h5 class="modal-title" id="editTaskLabel-{{ $task->id }}">Edit Task</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="form-floating mb-3">
                    <input type="text" name="title" id="edit-title-{{ $task->id }}" class="form-control" value="{{ $task->title }}" required>
                    <label for="edit-title-{{ $task->id }}">Title</label>
                  </div>
                  <div class="form-floating mb-3">
                    <textarea name="description" id="edit-desc-{{ $task->id }}" class="form-control" style="height: 120px;" placeholder=" ">{{ $task->description }}</textarea>
                    <label for="edit-desc-{{ $task->id }}">Description (optional)</label>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
      {{ $tasks->links() }}
    </div>

  @else
    {{-- Empty state --}}
    <div class="card shadow-sm">
      <div class="card-body text-center py-5">
        <div class="display-6 mb-2">📝</div>
        <h2 class="h5">No tasks yet</h2>
        <p class="text-muted mb-4">Add your first task to get started. You can track progress by changing the status to In-Progress or Done.</p>
        <a href="#title" class="btn btn-primary">Add a task</a>
      </div>
    </div>
  @endif
</x-layout>
