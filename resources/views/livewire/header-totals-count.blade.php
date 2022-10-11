<div class="card">
    <div class="card-header">
        {{ __('Store review') }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    @foreach ($checklists as $checklist)
                    <div class="col-md-3 mb-4">
                        <strong>{{ $checklist->name }} ({{ $checklist->user_completed_tasks_count }}/{{ $checklist->tasks_count }})</strong>
                        <br>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $checklist->tasks_count > 0 ? ($checklist->user_completed_tasks_count * 100) / $checklist->tasks_count : 0}}%"
                                aria-valuenow="{{ $checklist->tasks_count > 0 ? ($checklist->user_completed_tasks_count * 100) / $checklist->tasks_count : 0}}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            <div class="col-md-3">
                <h1>{{ $checklists->sum('user_completed_tasks_count') }}/{{ $checklists->sum('tasks_count') }}</h1>
            </div>
        </div>
    </div>
</div>
