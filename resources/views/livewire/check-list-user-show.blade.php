<tbody>
    @forelse ($checkList->tasks->whereNull('user_id') as $task)
    @if ($loop->iteration == 6 && (!auth()->user()->payment || auth()->user()->payment->payment_status != "approved"))
    <tr>
        <td colspan="3" class="text-center py-4">
            <h3 class="my-0 p-0">{{ __('You are limited at 5 tasks per checklist') }}</h3>
            <div>
                <a href="{{ route('checkout') }}" class="btn btn-dark my-3">{{ __('Unlock all now') }}</a>
            </div>
        </td>
    </tr>
    @elseif($loop->iteration < 6 || (auth()->user()->payment && auth()->user()->payment->payment_status == "approved"))
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
    @endif
    @empty
        <tr>
            <td colspan="3" class="text-center">{{ __('No Tasks Found') }}</td>
        </tr>
    @endforelse
</tbody>
