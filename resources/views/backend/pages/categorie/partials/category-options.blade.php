@foreach ($categories as $category)
    <option value="{{ $category->id }}">{{ $prefix }}{{ $category->name }}</option>
    @if($category->children->count() > 0)
        @include('backend.pages.categorie.partials.category-options', ['categories' => $category->children, 'prefix' => $prefix . '-- '])
    @endif
@endforeach