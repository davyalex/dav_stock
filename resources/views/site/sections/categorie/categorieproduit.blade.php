<ul id="faq">
    @foreach($categories as $categorie)
        <li>
            @if($categorie->children->isNotEmpty())
                <a data-bs-toggle="collapse" data-bs-parent="#faq" 
                   href="#shop-categorie-{{ $categorie->id }}" 
                   class=" text-danger{{ $categorieSelect->id == $categorie->id ? '' : 'collapsed' }}" 
                   aria-expanded="{{ $categorieSelect->id == $categorie->id ? 'true' : 'false' }}">
                    {{ $categorie->name }} <i class="ion-ios-arrow-down"></i>
                </a>
                <ul id="shop-categorie-{{ $categorie->id }}" 
                    class="panel-collapse collapse show">
                    @foreach($categorie->children as $child)
                        @include('site.sections.categorie.categorieproduit', ['categories' => [$child], 'categorieSelect' => $categorieSelect])
                    @endforeach
                </ul>
            @else
                <a href="{{route('produit' , $categorie->slug)}}">{{ $categorie->name }}</a>
            @endif
        </li>
    @endforeach
</ul>
