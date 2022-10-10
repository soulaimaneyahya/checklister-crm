<tr>
    <td>
        @if ($task->position > 1)
        <a wire:click.prevent="task_up({{ $task->id }})" href="#">
            &uarr;
        </a>
        @endif
        @if ($task->position < $tasks->max('position'))
        <a wire:click.prevent="task_down({{ $task->id }})" href="#">
            &darr;
        </a>
        @endif
    </td>
    <td>
        {{ $task->name }}
        @badge([
            'type' => 'danger',
            'text' => 'white',
            'show' => now()->diffInMinutes($task->created_at) < 5
        ]) new !
        @endbadge
    </td>
    <td>
        <a href="{{ route('admin.check_lists.tasks.edit', [$checkList, $task]) }}" class="btn btn-sm btn-primary"> {{ __('Edit') }}</a>
        <form action="{{ route('admin.check_lists.tasks.destroy', [$checkList, $task]) }}" method="POST" class="mx-2 d-inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('{{ __('Are you sure?') }}')" class="btn btn-sm btn-danger" type="submit"> {{ __('Delete') }}</button>
        </form>
    </td>
    <td>
        {{ $task->created_at->diffForhumans() }}
    </td>
</tr>
