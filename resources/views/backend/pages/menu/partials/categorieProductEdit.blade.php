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
                                @php
                                    // Vérifier si le produit est associé au menu
                                    $isProduitSelected = $data_menu->produits->contains($produit->id);

                                    // Récupérer les compléments associés pour ce produit
                                    $selectedComplements = $data_menu->produits
                                        ->where('id', $produit->id)
                                        ->first()
                                        ->complements
                                        ->pluck('id')
                                        ->toArray() ?? [];
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <input class="form-check-input me-2 produit"
                                            value="1"
                                            name="produits[{{ $produit->id }}][selected]"
                                            type="checkbox"
                                            id="formCheck{{ $produit->id }}"
                                            {{ $isProduitSelected ? 'checked' : '' }}>
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
                                        Compléments <i class="ri ri-add-fill"></i>
                                    </button>
                                </li>
                                <!-- Section des compléments masquée par défaut -->
                                <li id="complements-{{ $produit->id }}" class="list-group-item {{ $isProduitSelected ? '' : 'd-none' }}">
                                    @if ($categorie_complements && $categorie_complements->produits->isNotEmpty())
                                        <strong>Compléments disponibles :</strong>
                                        <ul class="mt-2">
                                            @foreach ($categorie_complements->produits as $key => $complement)
                                                <li>
                                                    <input class="form-check-input me-2"
                                                        value="{{ $complement->id }}"
                                                        name="produits[{{ $produit->id }}][complements][]"
                                                        type="checkbox"
                                                        id="formCheck{{ $key . $produit->id }}"
                                                        {{ in_array($complement->id, $selectedComplements) ? 'checked' : '' }}>
                                                    <label class="form-check-label text-capitalize"
                                                        for="formCheck{{ $key . $produit->id }}">
                                                        {{ $complement->nom }}
                                                    </label>
                                                </li>
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
</script> --}}


<div class="row">
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
                                @php
                                    // Vérifiez si le produit est déjà dans le menu
                                    $isProduitSelected = $data_menu->produits->contains('id', $produit->id);

                                    // Récupérez les compléments déjà associés au produit
                                    $selectedComplements = $isProduitSelected
                                        ? $data_menu->produits->where('id', $produit->id)->first()->complements->pluck('id')->toArray()
                                        : [];
                                @endphp

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <!-- Checkbox pour sélectionner le produit -->
                                        <input class="form-check-input me-2 produit"
                                            value="1"
                                            name="produits[{{ $produit->id }}][selected]"
                                            type="checkbox"
                                            id="formCheck{{ $produit->id }}"
                                            {{ $isProduitSelected ? 'checked' : '' }}>
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
                                        Compléments <i class="ri ri-add-fill"></i>
                                    </button>
                                </li>

                                <!-- Section des compléments masquée par défaut -->
                                <li id="complements-{{ $produit->id }}" class="list-group-item {{ $isProduitSelected ? '' : 'd-none' }}">
                                    @if ($categorie_complements && $categorie_complements->produits->isNotEmpty())
                                        <strong>Compléments disponibles :</strong>
                                        <ul class="mt-2">
                                            @foreach ($categorie_complements->produits as $key => $complement)
                                                <li>
                                                    <!-- Checkbox pour les compléments -->
                                                    <input class="form-check-input me-2"
                                                        value="{{ $complement->id }}"
                                                        name="produits[{{ $produit->id }}][complements][]"
                                                        type="checkbox"
                                                        id="formCheck{{ $key . $produit->id }}"
                                                        {{ in_array($complement->id, $selectedComplements) ? 'checked' : '' }}>
                                                    <label class="form-check-label text-capitalize"
                                                        for="formCheck{{ $key . $produit->id }}">
                                                        {{ $complement->nom }}
                                                    </label>
                                                </li>
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

