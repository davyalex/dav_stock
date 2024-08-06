<div class="col-md-4">
    <label class="form-label" for="product-title-input">Fournisseur
    </label>
    <select class="form-control js-example-basic-single" name="categorie">
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
    <select class="form-control js-example-basic-single format" name="format" required>
        <option value="" disabled selected>Choisir</option>
        @foreach ($data_format as $format)
            <option data-value={{ $format->libelle }} value="{{ $format->id }}">{{ $format->libelle }}
                ({{ $format->abreviation }})
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Qté <span class="text-lowercase libFormat"
            id="libFormat"> de format</span></label>
    <input type="number" class="form-control" required>
</div>
<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Qté total <span class="text-lowercase libFormat"
            id="libPiece">/ format</span></label>
    <input type="number" class="form-control">
</div>
<div class="col-md-4">
    <label class="form-label" for="product-title-input">Unité de mesure
    </label>
    <select id="unite" class="form-control js-example-basic-single" name="unite" required>
        <option value="" disabled selected>Choisir</option>
        @foreach ($data_unite as $unite)
            <option data-value="{{ $unite->libelle }}" value="{{ $unite->id }}">{{ $unite->libelle }}
                ({{ $unite->abreviation }})
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-3 mb-3">
    <label class="form-label" for="stocks-input">Unité unitaire <span class="text-lowercase libUnite"
            id="libPiece"></span></label>
    <input type="number" class="form-control" name="unite_unitaire" required>
</div>

<div class="col-md-3 mb-3">
    <label class="form-label" for="stocks-input">Unité globale <span class="text-lowercase libUnite"
            id="libPiece"></span></label>
    <input type="number" class="form-control" name="unite_globale" required>
</div>

<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Prix d'achat </label>
    <input type="number" class="form-control" name="prix_achat" required>
</div>
