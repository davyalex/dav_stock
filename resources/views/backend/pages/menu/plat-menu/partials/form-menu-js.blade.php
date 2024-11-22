<div class="col-4">
    <label for="variante">Categorie</label>
    <div class="d-flex">
        <select name="variantes[${varianteIndex}][quantite]"
            class="form-control js-example-basic-single-varianteIndex categorie"required>
            <option value="" selected> Selectionner</option>
            @foreach ($categorie_menu as $categorie)
                <option value="{{ $categorie->id }}">
                    {{ $categorie->nom }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-4">
    <label for="variante">Plats :</label>
    <div class="d-flex">
        <select name="variantes[0][nom]" class="form-control js-example-basic-single categorie"required>
            <option value="" selected> Selectionner</option>
            @foreach ($plats as $plat)
                <option value="{{ $plat->id }}">
                    {{ $plat->nom }}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#createPlatModal"> <i
                class="mdi mdi-plus"></i> </button>
    </div>

</div>

<div class="col-4">
    <label for="variante">Complements :</label>
    <div class="d-flex">
        <select name="variantes[0][complement]" class="form-control js-example-basic-single categorie" multiple>
            <option value="" selected> Selectionner</option>
            @foreach ($plats_complements as $complement)
                <option value="{{ $complement->id }}">
                    {{ $complement->nom }}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#createPlatModal"> <i
                class="mdi mdi-plus"></i> </button>
    </div>
</div>
<div class="col-2 mt-2">
    <button type="button" class="btn btn-danger remove-variante mt-3"> <i
            class="mdi mdi-delete remove-variante"></i></button>
</div>




