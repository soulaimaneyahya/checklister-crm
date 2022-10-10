<tbody>
    @foreach ($checkList->tasks as $task)
    <tr class="task-description-toggle" data-id="{{ $task->id }}">
        <td>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="check" id="check">
            </div>  
        </td>
        <td class="w-75">{{ $task->name }}</td>
        <td>
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
    @endforeach
</tbody>