@if (!isset($show) || $show)
<span class="mx-2 badge bg-{{ $type }} text-{{ $text }}">
    {{ $slot }}
</span>
@endif