@foreach ($data_categorie_produit as $categorie)
    <div class="col-md-6">
        @php
            //style manipulation
            $dNone =
                $categorie->produits->isEmpty() && $categorie->type != 'menu' && $categorie->children->isEmpty()
                    ? 'd-none'
                    : '';
            $textUpper = in_array($categorie->type, ['menu', 'bar'])
                ? 'text-uppercase alert alert-success alert-border-left fs-4 mt-4'
                : 'text-capitalize fw-bold';

            //get produit_menu for checked default store
            $menu_produit = [];
            foreach ($data_menu['produits'] as $value) {
                array_push($menu_produit, $value['id']);
            }
        @endphp

        <h5 class="{{ $dNone }} {{ $textUpper }}">{{ $categorie->name }}</h5>

        @foreach ($categorie->produits as $produit)
            <div class="form-check form-check-dark m-2 ">
                <input class="form-check-input fs-5 produit" value="{{ $produit['id'] }}" name="produits[]" type="checkbox"
                    id="formCheck{{ $produit->id }}" {{ in_array($produit->id, $menu_produit) ? 'checked' : '' }}>
                <label class="form-check-label" for="formCheck{{ $produit->id }}">
                    {{ $produit->nom }} - <i class="text-danger">
                        {{ $produit->prix }} FCFA</i>
                </label>
            </div>
        @endforeach
        <div class="m-3 ">
            @if ($categorie->children->isNotEmpty())
                @include('backend.pages.menu.partials.categorieProductEdit', [
                    'data_categorie_produit' => $categorie->children,
                ])
            @endif
        </div>
    </div><!--end col-->
@endforeach
