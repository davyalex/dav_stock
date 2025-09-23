

<option value="{{ $category->id }}">{{ str_repeat('--', $level ?? 0) }} {{ $category->name }}</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('backend.pages.produit.partials.subCategorieOption', [
            'category' => $child,
            'level' => ($level ?? 0) + 1,
        ])
    @endforeach
@endif

