<div class="col-md-5">
    <label class="form-label" for="product-title-input">Fournisseur
    </label>
    <select class="form-control js-example-basic-single" name="fournisseur_id">
        <option value="" disabled selected>Choisir</option>
        @foreach ($data_fournisseur as $fournisseur)
            <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-4 mb-3">
    <label class="form-label" for="product-title-input">Format
    </label>
    <select class="form-control js-example-basic-single format" name="format_id" required>
        <option value="" disabled selected>Choisir</option>
        @foreach ($data_format as $format)
            <option data-value={{ $format->libelle }} value="{{ $format->id }}">{{ $format->libelle }}
                ({{ $format->abreviation }})
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-3 mb-3">
    <label class="form-label" for="stocks-input">Qté <span class="text-lowercase libFormat" id="libFormat"> de
            format</span></label>
    <input type="number" id="qteFormat" name="quantite_format" class="form-control" required>
</div>

<div class="col-md-4">
    <label class="form-label" for="product-title-input">Unité de mesure
    </label>
    <select id="unite" class="form-control js-example-basic-single" name="unite_id" required>
        <option value="" disabled selected>Choisir</option>
        @foreach ($data_unite as $unite)
            <option data-value="{{ $unite->libelle }}" value="{{ $unite->id }}">{{ $unite->libelle }}
                ({{ $unite->abreviation }})
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-4 mb-3">
    <label class="form-label" for="stocks-input">Quantité stockable <span class="text-danger" id="labelUnite"></span></label>
    <input type="number" class="form-control" id="qteUniteUnitaire" name="quantite_stockable" required>
</div>

{{-- <div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Quantité stockable</label>
    <input type="number" class="form-control" id="qteUniteGlobale" name="quantite_unite_total" readonly>
</div> --}}

<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Prix d'achat unitaire </label>
    <input type="number" id="prixAchatUnitaire" class="form-control" name="prix_achat_unitaire" required>
</div>
<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Prix d'achat total </label>
    <input type="number" id="prixAchatTotal" class="form-control" name="prix_achat_total">
</div>

<div class="col-md-3">
    <label class="form-check-label" for="customAff">Activer le stock</label>

    <div class="form-check form-switch form-switch-lg col-md-2" dir="ltr">
        <input type="checkbox" name="statut" class="form-check-input" id="customAff">
    </div>
    <div class="valid-feedback">
        Looks good!
    </div>
</div>
