<!--Afficher les sous categories en option dans produit -->
{{-- {{count($category->children) > 0 ? 'disabled' : '' }} --}}
<option {{$category->type =='menu' ? 'disabled' : ''}}  value="{{ $category->id }}" {{$data_produit_menu['categorie_id'] == $category->id ? 'selected' :''}}>{{ str_repeat('--', $level ?? 0) }} {{ $category->name }}</option>
@if($category->children)
    @foreach($category->children as $child)
        @include('backend.pages.menu.produit.partials.subCategorieOptionEdit', ['category' => $child, 'level' => ($level ?? 0) + 1])
    @endforeach
@endif
