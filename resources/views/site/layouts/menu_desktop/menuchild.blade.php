<li class="top-hover">
    @if ($menu->children->isNotEmpty())
        <a href="#">{{ $menu['name'] }}
            <i class="ion-chevron-down"></i>
        </a>
        <ul class="submenu">
            @foreach($menu->children as $child)
            @include('site.layouts.menu_desktop.menuchild', ['menu' => $child])
        @endforeach
        </ul>
    @else
        <a href="{{route('menu')}}">{{ $menu['name'] }} </a>
    @endif
</li>



<!-- mobile-menu-area-start -->
{{-- @include('site.layouts.menu_mobile.menuchild') --}}
<!-- mobile-menu-area-end -->
