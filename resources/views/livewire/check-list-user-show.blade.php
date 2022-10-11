<tbody>
    @forelse ($checkList->tasks->whereNull('user_id') as $task)
    <tr>
        <td>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" 
                    wire:click="complete_task({{ $task->id }})" 
                    @if(in_array($task->id, $completed_tasks)) checked="checked" @endif />
            </div>
        </td>
        <td class="w-75">{{ $task->name }}</td>
        <td class="task-description-toggle" data-id="{{ $task->id }}">
            <svg id="task-caret-bottom-{{ $task->id }}" class="m-0 c-sidebar-nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-caret-bottom') }}"></use>
            </svg>
            <svg id="task-caret-top-{{ $task->id }}" class="m-0 c-sidebar-nav-icon d-none">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-caret-top') }}"></use>
            </svg>
        </td>
    </tr>
    <tr class="d-none" id="task-description-{{ $task->id }}">
        <td colspan="3" class="p-3">{!! $task->description !!}</td>
    </tr>
    @empty
        <tr>
            <td colspan="3" class="text-center">{{ __('No Tasks Found') }}</td>
        </tr>
    @endforelse
</tbody>
