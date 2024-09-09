{{-- <li>
    <a data-bs-toggle="collapse" href="#subcategory-{{ $categorie->id }}" aria-expanded="false" aria-controls="subcategory-{{ $categorie->id }}">
        {{ $categorie->name }} <i class="ion-ios-arrow-down"></i>
    </a>

    @if ($categorie->children->isNotEmpty())
        <ul id="subcategory-{{ $categorie->id }}" class="panel-collapse collapse">
            @foreach ($categorie->children as $child)
                @include('site.sections.categorie.categoriemenu', ['categorie' => $child])
            @endforeach
        </ul>
    @endif
</li> --}}

{{-- 
<li>
  
    <a data-bs-toggle="collapse" data-bs-parent="#faq" href="#subcategory-{{ $categorie->id }}">
        {{ $categorie->name }}
        <i class="ion-ios-arrow-down"></i>
    </a>

    <!-- Si la catégorie a un parent, on l'affiche -->
   

    <!-- Si la catégorie a des sous-catégories, on les affiche récursivement -->
    @if ($categorie->children && $categorie->children->isNotEmpty())
        <ul id="subcategory-{{ $categorie->id }}" class="panel-collapse collapse">
            @foreach ($categorie->children as $subchild)
                @include('site.sections.categorie.categoriemenu', ['categorie' => $subchild])
            @endforeach
        </ul>
    @endif
</li> --}}


<li>
    
    <!-- Afficher le lien de la catégorie avec un bouton pour la collapse -->
    <a data-bs-toggle="collapse" data-bs-parent="#faq" href="#subcategory-{{ $categorie->id }}">
        


           <a href="/menu?categorie={{$categorie->slug}}"> {{ $categorie->name }}</a>
        {{-- <i class="ion-ios-arrow-down"></i> --}}
    </a>

    <!-- Afficher les enfants de la catégorie actuelle, s'ils existent -->
    @if ($categorie->children && $categorie->children->isNotEmpty())
        <ul id="subcategory-{{ $categorie->id }}" class="panel-collapse collapse">
            @foreach ($categorie->children as $subchild)
                <!-- Inclure la vue récursive pour chaque sous-catégorie -->
                @include('site.sections.categorie.categoriemenu', ['categorie' => $subchild])
            @endforeach
        </ul>
    @endif
</li>


