@props(['icontype' => 'regular', 'icon' => false, 'active' => false, 'url', 'routeName', 'routeParams' => []])

<a {{ $attributes->merge(['class' => 'list-group-item list-group-item-action '.($active | request()->routeIs($routeName) ? 'active' : ''), 'href' => route($routeName, $routeParams)]) }}>
    @if($icon)
    <i class="fa-{{ $icontype }} fa-{{ $icon }} fa-lg me-3" style="width:20px;"></i> 
    @endif
    {{ $slot }}
</a>