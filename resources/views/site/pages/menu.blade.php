@extends('site.layouts.app')

@section('title', 'Liste du menu')

@section('content')

    <style>
        .product-img img {
            width: 100%;
            /* Adapter à la largeur du conteneur */
            height: 250px;
            /* Fixer une hauteur spécifique */
            object-fit: contain;
            /* Maintenir les proportions tout en remplissant la zone */
        }

        .category-sticker {
            position: absolute;
            top: 10px;
            /* Ajuster la position verticale */
            left: 10px;
            /* Ajuster la position horizontale */
            background-color: rgba(0, 0, 0, 0.7);
            /* Fond semi-transparent */
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
            z-index: 10;
        }

        /* Couleur par défaut */
        .form-check-input {
            accent-color: black;
            /* Mettre la couleur par défaut en noir */
        }

        /* Couleur rouge lorsqu'un bouton radio est sélectionné */
        .form-check-input:checked {
            accent-color: red;
            /* Couleur rouge lorsqu'il est coché */
        }
    </style>
    <div class="shop-page-area pt-10 pb-100">

    @section('content')
        <div class="container">

            @if (!$menu)
                <p class="text-center">Aucun menu disponible pour aujourd'hui.</p>
            @else
                <h1 class="text-center my-4">Menu du <span>{{ \Carbon\carbon::parse($menu->date)->format('d/m/Y') }}</span>
                </h1>

                <div class="row mt-4">
                    @foreach ($categories as $categorie => $produits)
                        <div class="col-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-danger text-white">
                                    <h3 class="m-0 text-white">{{ $categorie }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($produits as $produit)
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-capitalize">{{ $produit->nom }}</h5>

                                                        <!-- Compléments -->
                                                        @if ($produit->complements->isNotEmpty())
                                                            <p class="card-text fw-bold">Choisissez un complément :</p>
                                                            <form class="complement-form">
                                                                @foreach ($produit->complements as $complement)
                                                                    <div class="form-check">
                                                                        <input type="radio"
                                                                            name="complement_{{ $produit->id }}"
                                                                            value="{{ $complement->id }}"
                                                                            id="complement_{{ $produit->id }}_{{ $complement->id }}"
                                                                            class="form-check-input complement-radio">
                                                                        <label class="form-check-label"
                                                                            for="complement_{{ $produit->id }}_{{ $complement->id }}">
                                                                            {{ $complement->nom }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </form>
                                                        @endif
                                                    </div>
                                                    <div class="card-footer text-end">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <strong
                                                                class="text-danger">{{ number_format($produit->prix, 0, ',', ' ') }}
                                                                FCFA</strong>
                                                            {{-- <button class="btn btn-primary commander-btn"
                                                                data-produit-id="{{ $produit->id }}"
                                                                data-has-complement="{{ $produit->complements->isNotEmpty() ? '1' : '0' }}">
                                                                Commander
                                                            </button> --}}

                                                            <button type="button" class="btn btn-danger addCart text-white"
                                                            data-id="{{ $produit->id }}" style="border-radius: 10px">
                                                            <i class="fa fa-shopping-cart"></i> Commander
                                                        </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endsection

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Gérer le clic sur les boutons "Commander"
                document.querySelectorAll('.commander-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const produitId = this.dataset.produitId;
                        const hasComplement = this.dataset.hasComplement === '1';

                        // Vérifier si un complément est sélectionné si nécessaire
                        if (hasComplement) {
                            const selectedComplement = document.querySelector(
                                `input[name="complement_${produitId}"]:checked`);
                            if (!selectedComplement) {
                                alert("Veuillez choisir un complément avant de commander ce plat.");
                                return;
                            }
                            const complementId = selectedComplement.value;

                            // Ajouter au panier avec le complément
                            addToCart(produitId, complementId);
                        } else {
                            // Ajouter au panier sans complément
                            addToCart(produitId, null);
                        }
                    });
                });

                // Fonction pour ajouter au panier
                function addToCart(produitId, complementId) {
                    console.log(`Produit ajouté : ${produitId}, Complément : ${complementId || 'Aucun'}`);
                    alert('Produit ajouté au panier avec succès !');
                    // TODO: Envoyer la requête au serveur via AJAX
                }
            });
        </script>
    @endsection


</div>
@endsection
