<div class="col-2">
    <label for="variante">Categorie</label>
    <div class="d-flex">
        <select name="variantes[${varianteIndex}][quantite]" class="form-control js-example-basic-single categorie"
            required>
            <option value="" selected> Selectionner</option>
            @foreach ($categorie_menu as $categorie)
                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-3">
    <label for="variante">Plats :</label>
    <div class="d-flex">
        <select id="plats-select-${varianteIndex}" name="variantes[${varianteIndex}][nom]" class="form-control js-example-basic-single categorie plats-select" required>
            {{-- <option value="" selected> Selectionner</option>
            @foreach ($plats as $plat)
                <option value="{{ $plat->id }}">{{ $plat->nom }}</option>
            @endforeach --}}
        </select>
        <button type="button" class="btn btn-primary ml-2 btn-sm" data-bs-toggle="modal"
            data-bs-target="#createPlatModal">
            <i class="mdi mdi-plus"></i>
        </button>
    </div>
</div>

<div class="col-3">
    <label for="variante">Complements :</label>
    <div class="d-flex">
        <select id="complements-select-${varianteIndex}" name="variantes[${varianteIndex}][complement]" class="form-control js-example-basic-single categorie complements-select"
            multiple>
            {{-- <option value=""> Selectionner</option>
            @foreach ($plats_complements as $complement)
                <option value="{{ $complement->id }}">{{ $complement->nom }}</option>
            @endforeach --}}
        </select>
        <button type="button" class="btn btn-primary ml-2 btn-sm" data-bs-toggle="modal"
            data-bs-target="#createComplementModal">
            <i class="mdi mdi-plus"></i>
        </button>
    </div>
</div>

<div class="col-3">
    <label for="variante">Garnitures :</label>
    <div class="d-flex">
        <select id="garnitures-select-${varianteIndex}" name="variantes[${varianteIndex}][complement]" class="form-control js-example-basic-single categorie garnitures-select"
            multiple>
            {{-- <option value=""> Selectionner</option>
            @foreach ($plats_complements as $complement)
                <option value="{{ $complement->id }}">{{ $complement->nom }}</option>
            @endforeach --}}
        </select>
        <button type="button" class="btn btn-primary ml-2 btn-sm" data-bs-toggle="modal"
            data-bs-target="#createGarnitureModal">
            <i class="mdi mdi-plus"></i>
        </button>
    </div>
</div>

<div class="col-1 mt-2">
    <button type="button" class="btn btn-danger remove-variante mt-3">
        <i class="mdi mdi-delete remove-variante"></i>
    </button>
</div>
