<ul id="faq">
    @foreach($categories as $categorie)
        <li>
            @if($categorie->children->isNotEmpty())
                <a data-bs-toggle="collapse" data-bs-parent="#faq" 
                   href="#shop-categorie-{{ $categorie->id }}" 
                   class="text-danger {{ $categorie->famille == $categorieSelect->famille ? 'show' : 'collapsed' }}" 
                   aria-expanded="{{ $categorie->famille == $categorieSelect->famille ? 'true' : 'false' }}">
                    <strong class="fs-6">{{ $categorie->name }}</strong> <i class="ion-ios-arrow-down"></i>
                </a>
                <ul id="shop-categorie-{{ $categorie->id }}" 
                    class="panel-collapse collapse {{ $categorie->famille == $categorieSelect->famille ? 'show' : '' }}">
                    @foreach($categorie->children as $child)
                        @include('site.sections.categorie.categorieproduit', ['categories' => [$child], 'categorieSelect' => $categorieSelect])
                    @endforeach
                </ul>
            @else
                <a href="{{route('produit' , $categorie->id)}}" class="{{ $categorie->id == $categorieSelect->id ? 'fw-bold' : '' }}">{{ $categorie->name }}</a>
            @endif
        </li>
    @endforeach
</ul>
