<div class="row">
    @foreach ($data_categorie_produit as $categorie)
        @php
            $dNone =
                $categorie->produits->isEmpty() && $categorie->type != 'menu' && $categorie->children->isEmpty()
                    ? 'd-none'
                    : '';
            $textUpper = in_array($categorie->type, ['menu', 'bar'])
                ? 'text-uppercase alert alert-danger alert-border-left fs-4 mt-4'
                : 'text-capitalize fw-bold';
        @endphp

        <div class="col-md-12 {{ $dNone }}">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <!-- Titre de la catégorie -->
                    <h5 class="card-title {{ $textUpper }}">{{ $categorie->name }}</h5>

                    <!-- Liste des produits -->
                    @foreach ($categorie->produits as $produit)
                        <div class="form-check form-check-dark m-2">
                            <input class="form-check-input fs-5 produit" value="{{ $produit['id'] }}" name="produits[]" type="checkbox"
                                id="formCheck{{ $produit->id }}">
                            <label class="form-check-label text-capitalize" for="formCheck{{ $produit->id }}">
                                {{ $produit->nom }}
                                (<span class="text-danger"> {{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>)
                            </label>
                        </div>
                    @endforeach

                    <!-- Sous-catégories -->
                    <div class="m-3">
                        @if ($categorie->children->isNotEmpty())
                            @include('backend.pages.menu.partials.categorieProduct', [
                                'data_categorie_produit' => $categorie->children,
                            ])
                        @endif
                    </div>
                </div>
            </div>
        </div><!--end col-->
    @endforeach
</div><!--end row-->
