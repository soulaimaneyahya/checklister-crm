<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="text-center my-3 lead">
        <a href="{{ route('home') }}" class="text-decoration-none text-white">APP</a>
    </div>
    <ul class="c-sidebar-nav">
        @if (auth()->user()->is_admin)
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('home') }}">
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
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" style="padding: 15px 85px;"
                    href="{{ route('admin.pages.edit', $page) }}">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
                        </svg>
                        {{ $page->title }}
                    </a>
                </li>
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
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
            {{-- c-sidebar-nav-dropdown-toggle  --}}
            <a class="c-sidebar-nav-link"
            href="{{ route('admin.check_list_groups.edit', $group) }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-folder-open') }}"></use>
                </svg> {{ $group->name }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @foreach ($group->checklists as $list)
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" style="padding: 15px 85px;"
                       href="{{ route('admin.check_list_groups.check_lists.edit', [$group, $list]) }}">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
                        </svg>
                        {{ $list->name }}
                    </a>
                </li>
                @endforeach
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" style="padding: 15px 85px;"
                       href="{{ route('admin.check_list_groups.check_lists.create', $group) }}">
                        <svg class="c-sidebar-nav-icon">
                            <use
                                xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-note-add') }}"></use>
                        </svg>
                        {{ __('New List') }}</a>
                </li>
            </ul>
        </li>
        @endforeach
        @else
            @foreach($user_menu as $group)
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
                <a class="c-sidebar-nav-link">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-folder-open') }}"></use>
                    </svg>
                    <span>{{ $group['name'] }}</span>
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @foreach ($group['checklists'] as $checklist)
                        <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link">
                                <span>
                                    {{ $checklist['name'] }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
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
