<ul>
    @foreach ($categories_child as $categorie)
        <li>
            <a href="{{ $categorie->url }}">{{ $categorie->name }}</a>
            <a href="{{ route('categorie.edit', $categorie['id']) }}" class="fs-5" style="margin-left:30px"> <i
                    class=" ri ri-edit-2-fill ml-4"></i></a>

            <a href="{{ route('categorie.add-subCat', $categorie['id']) }}" class="fs-5"> <i
                    class=" ri ri-add-circle-fill ml-4"></i>
            </a>
            @if (count($categorie->children) == 0)
                <a href="{{ route('categorie.delete', $categorie['id']) }}" class="fs-5"> <i
                        class="ri ri-delete-bin-2-line text-danger"></i>
                </a>
            @endif
            @if ($categorie->children->count() > 0)
                @include('backend.pages.categorie.partials.subcategorie', [
                    'categories_child' => $categorie->children,
                ])
            @endif
        </li>
    @endforeach
</ul>
