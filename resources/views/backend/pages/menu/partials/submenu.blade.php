<ul>
    @foreach ($menus_child as $menu)
        <li>
            <a href="{{ $menu->url }}">{{ $menu->name }}</a>
            <a href="{{ route('menu.edit', $menu['id']) }}" class="fs-5" style="margin-left:30px"> <i
                    class=" ri ri-edit-2-fill ml-4"></i></a>

            <a href="{{ route('menu.add-item', $menu['id']) }}" class="fs-5"> <i class=" ri ri-add-circle-fill ml-4"></i>
            </a>
            @if (count($menu->children) ==0)
                
            <a href="{{route('menu.delete' ,$menu['id'] )}}" class="fs-5"> <i class="ri ri-delete-bin-2-line text-danger"></i>
            </a>
            @endif
            @if ($menu->children->count() > 0)
                @include('backend.pages.menu.partials.submenu', ['menus_child' => $menu->children])
            @endif
        </li>
    @endforeach
</ul>
