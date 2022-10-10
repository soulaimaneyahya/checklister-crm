<tr>
    <td>
        <a wire:click.prevent="task_up({{ $task->id }})" href="#">
            &uarr;
        </a>
        <a wire:click.prevent="task_down({{ $task->id }})" href="#">
            &darr;
        </a>
    </td>
    <td>{{ $task->name }}</td>
    {{-- <td>{!! $task->description !!}</td> --}}
    <td>
        <a href="{{ route('admin.check_lists.tasks.edit', [$checkList, $task]) }}" class="btn btn-sm btn-primary"> {{ __('Edit') }}</a>
        <form action="{{ route('admin.check_lists.tasks.destroy', [$checkList, $task]) }}" method="POST" class="mx-2 d-inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('{{ __('Are you sure?') }}')" class="btn btn-sm btn-danger" type="submit"> {{ __('Delete') }}</button>
        </form>
    </td>
</tr>