<!-- mobile-menu-area-start -->
<li>
    @if ($menu->children->isNotEmpty())
        <a href="{{route('produit' , $menu->slug)}}">{{ $menu['name'] }}
        </a>
        <ul>
            @foreach ($menu->children as $child)
                @include('site.layouts.menu_mobile.menuchild', ['menu' => $child])
            @endforeach
        </ul>
    @else
        <a href="{{route('produit' , $menu->slug)}}">{{ $menu['name'] }} </a>
    @endif
</li>
<!-- mobile-menu-area-end -->


