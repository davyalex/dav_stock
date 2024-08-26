@foreach ($data_categorie_produit as $categorie)
    <div class="col-md-12">
        @php
            $dNone = $categorie->produit_menus->isEmpty() && $categorie->type != 'menu' && $categorie->children->isEmpty() ? 'd-none' : '';
            $textUpper = $categorie->type == 'menu' ? 'text-uppercase alert alert-primary alert-border-left fs-4 mt-4' : 'text-capitalize fw-bold';
        @endphp

        <h5 class="{{ $dNone }} {{ $textUpper }}">{{ $categorie->name }}</h5>

        @foreach ($categorie->produit_menus as $produit)
            <div class="form-check form-check-dark m-2 ">
                <input  class="form-check-input fs-3 produit" value="{{ $produit['id'] }}" name="produits[]" type="checkbox"
                    id="formCheck{{ $produit->id }}">
                <label class="form-check-label" for="formCheck{{ $produit->id }}">
                    {{ $produit->nom }} - <i class="text-danger">
                        {{ $produit->prix }} FCFA</i>
                </label>
            </div>
        @endforeach
        <div class="m-3 ">
            @if ($categorie->children->isNotEmpty())
                @include('backend.pages.menu.produit.partials.categorieProduct', [
                    'data_categorie_produit' => $categorie->children,
                ])
            @endif
        </div>
    </div><!--end col-->
@endforeach
