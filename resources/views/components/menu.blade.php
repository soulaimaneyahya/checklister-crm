<li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
    <a class="c-sidebar-nav-link"
    href="{{ $group_href }}"
    >
        <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-folder-open') }}"></use>
        </svg> {{ $group_name }}
    </a>
    <ul class="c-sidebar-nav-dropdown-items">
        {{ $slot }}
        @if (!isset($is_admin) || $is_admin)
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" style="padding: 15px 85px;" href="{{ route('admin.check_list_groups.check_lists.create', $group) }}">
            <svg class="c-sidebar-nav-icon">
                <use
                    xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-note-add') }}"></use>
            </svg>
            {{ __('New List') }}</a>
        </li>
        @endif
    </ul>
</li>