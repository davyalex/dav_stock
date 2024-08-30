<!-- mobile-menu-area-start -->
<li>
    @if ($menu->children->isNotEmpty())
        <a href="">{{ $menu['name'] }}
        </a>
        <ul>
            @foreach ($menu->children as $child)
                @include('site.layouts.menu_mobile.menuchild', ['menu' => $child])
            @endforeach
        </ul>
    @else
        <a href="blog-rightsidebar.html">{{ $menu['name'] }} </a>
    @endif
</li>
<!-- mobile-menu-area-end -->


