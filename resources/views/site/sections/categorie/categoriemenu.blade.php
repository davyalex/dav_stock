<!-- categorie_menu.blade.php -->
<ul id="faq">
    @foreach($categories as $categorie)
        <li>
            @if($categorie->children->isNotEmpty())
                <a data-bs-toggle="collapse" data-bs-parent="#faq" 
                   href="#shop-categorie-{{ $categorie->id }}" 
                   class="" 
                   aria-expanded="true">
                    {{ $categorie->name }} <i class="ion-ios-arrow-down"></i>
                </a>
                <ul id="shop-categorie-{{ $categorie->id }}" 
                    class="panel-collapse collapse show">
                    @foreach($categorie->children as $child)
                        @include('site.sections.categorie.categoriemenu', ['categories' => [$child]])
                    @endforeach
                </ul>
            @else
                <a href="{{route('produit' , $categorie->slug)}}">{{ $categorie->name }}</a>
            @endif
        </li>
    @endforeach
</ul>
