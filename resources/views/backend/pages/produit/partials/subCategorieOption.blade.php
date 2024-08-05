<!--Afficher les sous categories en option dans produit -->

<option value="{{ $category->id }}" {{count($category->children) > 0 ? 'disabled' : '' }}>{{ str_repeat('--', $level ?? 0) }} {{ $category->name }}</option>
@if($category->children)
    @foreach($category->children as $child)
        @include('backend.pages.produit.partials.subCategorieOption', ['category' => $child, 'level' => ($level ?? 0) + 1])
    @endforeach
@endif
