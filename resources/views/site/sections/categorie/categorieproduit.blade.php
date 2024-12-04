<ul id="faq">
    {{-- @foreach ($categories as $categorie)
        <li>
            @if ($categorie->children->isNotEmpty())
                <a data-bs-toggle="collapse" data-bs-parent="#faq" href="#shop-categorie-{{ $categorie->id }}"
                    class="text-danger {{ $categorie->famille == $categorieSelect->famille ? 'show' : 'collapsed' }}"
                    aria-expanded="{{ $categorie->famille == $categorieSelect->famille ? 'true' : 'false' }}">
                    <strong class="fs-6">
                        @if ($categorie->slug === 'bar')
                            Boissons
                        @elseif($categorie->slug === 'cuisine-interne')
                            Restaurant
                        @else
                            {{ $categorie->name }}
                        @endif
                    </strong> <i class="ion-ios-arrow-down"></i>
                </a>
                <ul id="shop-categorie-{{ $categorie->id }}"
                    class="panel-collapse collapse {{ $categorie->famille == $categorieSelect->famille ? 'show' : '' }}">
                    @foreach ($categorie->children as $child)
                        @include('site.sections.categorie.categorieproduit', [
                            'categories' => [$child],
                            'categorieSelect' => $categorieSelect,
                        ])
                    @endforeach
                </ul>
            @else
                <a href="{{ route('produit', $categorie->id) }}"
                    class="{{ $categorie->id == $categorieSelect->id ? 'fw-bold' : '' }}">
                    @if ($categorie->slug === 'bar')
                        Boissons
                    @elseif($categorie->slug === 'cuisine-interne')
                        Restaurant
                    @else
                        <span class="text-capitalize"> {{ $categorie->name }}</span>
                    @endif
                </a>
            @endif

        </li>
    @endforeach --}}


    @foreach ($categories as $categorie)
        <li>
            @if ($categorie->children->isNotEmpty())
                <a data-bs-toggle="collapse" data-bs-parent="#faq" href="#shop-categorie-{{ $categorie->id }}"
                    class="text-danger {{ isset($categorieSelect) && $categorie->famille == $categorieSelect->famille ? 'show' : 'collapsed' }}"
                    aria-expanded="{{ isset($categorieSelect) && $categorie->famille == $categorieSelect->famille ? 'true' : 'false' }}">
                    <strong class="fs-6">
                        @if ($categorie->slug === 'bar')
                            Boissons
                        @elseif($categorie->slug === 'cuisine-interne')
                            Restaurant
                        @else
                            {{ $categorie->name }}
                        @endif
                    </strong> <i class="ion-ios-arrow-down"></i>
                </a>
                <ul id="shop-categorie-{{ $categorie->id }}"
                    class="panel-collapse collapse {{ isset($categorieSelect) && $categorie->famille == $categorieSelect->famille ? 'show' : '' }}">
                    @foreach ($categorie->children as $child)
                        @include('site.sections.categorie.categorieproduit', [
                            'categories' => [$child],
                            'categorieSelect' => $categorieSelect ?? null,
                        ])
                    @endforeach
                </ul>
            @else
                <a href="{{ route('produit', $categorie->id) }}"
                    class="{{ isset($categorieSelect) && $categorie->id == $categorieSelect->id ? 'fw-bold' : '' }}">
                    @if ($categorie->slug === 'bar')
                        Boissons
                    @elseif($categorie->slug === 'cuisine-interne')
                        Restaurant
                    @else
                        <span class="text-capitalize"> {{ $categorie->name }}</span>
                    @endif
                </a>
            @endif
        </li>
    @endforeach

</ul>
