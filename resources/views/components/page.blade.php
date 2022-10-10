<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('admin.pages.edit', $page) }}" style="padding: 15px 85px;">
        <svg class="c-sidebar-nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
        </svg>
        {{ $page->title }}
    </a>
</li>
