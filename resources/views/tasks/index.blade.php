<x-layout title="Activities">

  <style>
    body {
      background-color: #f8f9fa;
    }
    .todo-container {
      max-width: 600px;
      margin: 2rem auto;
      background: white;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      padding: 1.5rem;
    }
    .todo-header {
      font-weight: 600;
      font-size: 1.25rem;
      margin-bottom: 1rem;
    }
    .todo-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.6rem 0.75rem;
      border-bottom: 1px solid #eee;
    }
    .todo-item:last-child {
      border-bottom: none;
    }
    .todo-label {
      flex: 1;
      margin-left: 0.75rem;
      font-size: 1rem;
      cursor: pointer;
    }
    .todo-label.done {
      text-decoration: line-through;
      color: #999;
    }
    .todo-edit-input {
      flex: 1;
      margin-left: 0.75rem;
      border: none;
      font-size: 1rem;
      padding: 0.25rem 0.5rem;
      outline: none;
    }
    .todo-add {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
      border-bottom: 1px solid #eee;
      padding-bottom: 0.75rem;
    }
    .todo-add input {
      border: none;
      flex: 1;
      outline: none;
      font-size: 1rem;
      padding: 0.5rem 0.75rem;
    }
    .todo-add button {
      border: none;
      background: none;
      color: #007bff;
      font-weight: 600;
      cursor: pointer;
      font-size: 1.25rem;
    }
    .todo-actions form {
      display: inline;
    }
  </style>

  <div class="todo-container">
    <div class="todo-header">To Do List</div>

    {{-- Add new task first --}}
    <form method="POST" action="{{ route('tasks.store') }}" class="todo-add">
      @csrf
      <input type="text" name="title" placeholder="Add new activity..." required>
      <button type="submit">＋</button>
    </form>

    {{-- Existing tasks --}}
    @foreach($tasks as $task)
      <div class="todo-item" data-task-id="{{ $task->id }}">
        {{-- Checkbox + label (click to edit) --}}
        <form method="POST" action="{{ route('tasks.update', $task) }}" class="status-form" style="display:flex; align-items:center; width:100%;">
          @csrf
          @method('PATCH')
          <input type="hidden" name="status" value="in_progress">
          <input type="checkbox" name="status" value="done" onchange="this.form.submit()" {{ $task->status === 'done' ? 'checked' : '' }}>

          {{-- Label (becomes editable on double-click) --}}
          <span class="todo-label {{ $task->status === 'done' ? 'done' : '' }}" ondblclick="enableEdit({{ $task->id }}, '{{ addslashes($task->title) }}')">
            {{ $task->title }}
          </span>
        </form>

        {{-- Delete button --}}
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this item?')" style="margin-left: 0.5rem;">
          @csrf
          @method('DELETE')
          <button class="btn btn-sm text-muted" style="border:none; background:none;">✕</button>
        </form>
      </div>
    @endforeach

    @if($tasks->count())
      <div class="mt-3 text-muted small text-center">
        {{ $tasks->where('status', 'done')->count() }} Checked items
      </div>
    @endif
  </div>

  <script>
    // Enable inline editing
    function enableEdit(id, currentTitle) {
      const item = document.querySelector(`[data-task-id="${id}"]`);
      const label = item.querySelector('.todo-label');

      // Replace label with input field
      const input = document.createElement('input');
      input.type = 'text';
      input.value = currentTitle;
      input.className = 'todo-edit-input';
      label.replaceWith(input);
      input.focus();

      // Handle save on Enter or blur
      input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') saveEdit(id, input.value);
      });
      input.addEventListener('blur', () => saveEdit(id, input.value));
    }

    function saveEdit(id, newTitle) {
      if (!newTitle.trim()) return;

      // Create a hidden form dynamically to submit the update
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/tasks/${id}`;
      form.innerHTML = `
        @csrf
        @method('PATCH')
        <input type="hidden" name="title" value="${newTitle.replace(/"/g, '&quot;')}">
      `;
      document.body.appendChild(form);
      form.submit();
    }
  </script>

</x-layout>
