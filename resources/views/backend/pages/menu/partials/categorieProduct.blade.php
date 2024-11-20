{{-- <div class="row">
    @foreach ($data_categorie_menu as $categorie)
        <div class="col-md-6">
            <!-- Carte de catégorie -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <!-- Titre de la catégorie -->
                    <h5 class="card-title text-uppercase fw-bold">{{ $categorie->name }}</h5>
                    
                    <!-- Liste des produits -->
                    @if ($categorie->produits->isNotEmpty())
                        <ul class="list-group list-group-flush">
                            @foreach ($categorie->produits as $produit)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input me-2 produit" value="{{ $produit->id }}" name="produits[]" type="checkbox"
                                            id="formCheck{{ $produit->id }}">
                                        <label class="form-check-label text-capitalize" for="formCheck{{ $produit->id }}">
                                            {{ $produit->nom }}
                                        </label>
                                    </div>
                                    <span class="text-danger">
                                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Aucun produit disponible pour cette catégorie.</p>
                    @endif

                    <!-- Sous-catégories -->
                    @if ($categorie->children->isNotEmpty())
                        <div class="mt-3">
                            @include('backend.pages.menu.partials.categorieProduct', [
                                'data_categorie_menu' => $categorie->children,
                            ])
                        </div>
                    @endif
                </div>
            </div>
        </div><!--end col-->
    @endforeach
</div><!--end row--> --}}


<div class="row">
    @foreach ($categorie_menu as $categorie)
        <div class="col-md-6">
            <!-- Carte de catégorie -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <!-- Titre de la catégorie -->
                    <h5 class="card-title text-uppercase fw-bold">{{ $categorie->nom }}</h5>

                    <!-- Liste des produits -->
                    @if ($categorie->plats->isNotEmpty())
                        <ul class="list-group list-group-flush">
                            @foreach ($categorie->plats as $produit)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input me-2 produit" value="1"
                                            name="produits[{{ $produit->id }}][selected]" type="checkbox"
                                            id="formCheck{{ $produit->id }}">
                                        <label class="form-check-label text-capitalize"
                                            for="formCheck{{ $produit->id }}">
                                            {{ $produit->nom }}
                                        </label>
                                    </div>
                                    <span class="text-danger">
                                        {{ number_format($produit->prix, 0, ',', ' ') }} FCFA
                                    </span>
                                    <!-- Bouton pour afficher les compléments -->
                                    <button type="button" class="btn btn-sm btn-primary ms-3"
                                        onclick="toggleComplements({{ $produit->id }})">
                                        Compléments <i><i class="ri ri-add-fill"></i></i>
                                    </button>
                                </li>
                                <!-- Section des compléments masquée par défaut -->
                                <li id="complements-{{ $produit->id }}" class="list-group-item d-none">
                                    @if ($categorie_complements && $categorie_complements->plats->isNotEmpty())
                                        <strong>Compléments disponibles :</strong>
                                        <ul class="mt-2">
                                            @foreach ($categorie_complements->plats as $key => $complement)
                                                <li>
                                                    <input class="form-check-input me-2" value="{{ $complement->id }}"
                                                        name="produits[{{ $produit->id }}][complements][]"
                                                        type="checkbox" id="formCheck{{ $key . $produit->id }}">
                                                    <label class="form-check-label text-capitalize"
                                                        for="formCheck{{ $key . $produit->id }}">
                                                        {{ $complement->nom }}
                                                    </label>
                                                </li>
                                                {{-- <li>
                                                    <input type="checkbox" value="{{ $complement->id }}"
                                                        name="complements[]">
                                                    <label class="ms-2">{{ $complement->nom }}</label>
                                                </li> --}}
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Aucun complément disponible pour ce produit.</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Aucun produit disponible pour cette catégorie.</p>
                    @endif
                </div>
            </div>
        </div><!--end col-->
    @endforeach
</div><!--end row-->

<!-- Script pour afficher/masquer les compléments -->
<script>
    function toggleComplements(produitId) {
        const complementSection = document.getElementById(`complements-${produitId}`);
        if (complementSection.classList.contains('d-none')) {
            complementSection.classList.remove('d-none');
        } else {
            complementSection.classList.add('d-none');
        }
    }
</script>
