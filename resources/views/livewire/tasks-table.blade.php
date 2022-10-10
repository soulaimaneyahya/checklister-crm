<div class="card-body p-3 m-0">
    <div>
        <table class="table table-responsive-sm table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <td scope="col"></td>
                    <td scope="col">{{ __('Name') }}</td>
                    <td scope="col">{{ __('Edit / Delete') }}</td>
                    <td scope="col">{{ __('Added at') }}</td>
                </tr>
            </thead>
            <tbody wire:sortable="updateTaskOrder">
            @forelse ($tasks as $key => $task)
                @include('admin.tasks.partials.task')
            @empty
                <tr>
                    <td colspan="3" class="text-center">{{ __('No Tasks Found') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>                
</div>
<div class="px-3">
    {{ $tasks->links() }}
</div>
