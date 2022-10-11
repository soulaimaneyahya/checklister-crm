<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="text-center my-3 lead">
        <a href="{{ route('welcome') }}" class="text-decoration-none text-white">APP</a>
    </div>
    <ul class="c-sidebar-nav">
        @if (auth()->user()->is_admin)
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-copy') }}"></use>
                </svg> <span>{{ __('Manage Users') }}</span>
            </a>
        </li>
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
            <a class="c-sidebar-nav-link">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-copy') }}"></use>
                </svg> <span>{{ __('Pages') }}</span>
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @foreach ($pages as $page)
                @page(['page' => $page])
                @endpage
                @endforeach
            </ul>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('admin.check_list_groups.create') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-copy') }}"></use>
                </svg> <span>{{ __('Manage Check List Groups') }}</span>
            </a>
        </li>
        @foreach ($admin_menu as $group)
        @menu([
            'group' => $group,
            'group_name' => $group->name,
            'is_admin' => TRUE,
            ])
            @slot('group_href')
             {{ route('admin.check_list_groups.edit', $group) }}
            @endslot
            @foreach ($group->checklists as $list)
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" 
                style="padding: 12px 65px;"
                href="{{ route('admin.check_list_groups.check_lists.edit', [$group, $list]) }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
                    </svg>
                    <span>{{ $list->name }}</span>
                </a>
            </li>
            @endforeach
        @endmenu
        @endforeach
        @else
            @foreach($user_menu as $group)
            @menu([
                'group' => $group,
                'group_name' => $group['name'],
                'is_admin' => FALSE,
                'group_href' => '#',
                ])
                @foreach ($group['checklists'] as $list)
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" style="padding: 12px 65px;" href="{{ route('users.check_lists.show', $list['id']) }}">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
                        </svg>
                        <span>{{ $list['name'] }}</span>
                        @badge([
                            'type' => 'danger',
                            'text' => 'white',
                            'show' => $list['is_new']
                        ]) NEW
                        @endbadge
                        @badge([
                            'type' => 'danger',
                            'text' => 'white',
                            'show' => $list['is_updated']
                        ]) UPT
                        @endbadge
                        @livewire('completed-tasks-counter', [
                            'tasks_count' => count($list['tasks']),
                            'completed_tasks_count' => count($list['completed_tasks_count']),
                            'check_list_id' => $list['id'],
                        ])
                    </a>
                </li>
                @endforeach
            @endmenu
            @endforeach
        @endif

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}"></use>
                </svg> <span>{{ __('Logout') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
