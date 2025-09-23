@foreach ($categories_child as $categorie)
    <div class="category-item level-{{ $level }}" data-category-id="{{ $categorie->id }}">
        <div class="category-content">
            <div class="category-info">
                <div class="category-toggle">
                    @if($categorie->children->count() > 0)
                        <i class="ri-arrow-right-s-line toggle-icon"></i>
                    @else
                        <i class="ri-circle-fill empty-icon"></i>
                    @endif
                </div>
                
                <div class="category-icon">
                    <i class="ri-folder-line text-{{ $level == 1 ? 'primary' : ($level == 2 ? 'info' : 'secondary') }}"></i>
                </div>
                
                <div class="category-details">
                    <h6 class="category-name mb-1">{{ $categorie->name }}</h6>
                    <div class="category-meta">
                        <span class="badge badge-{{ $categorie->status === 'active' ? 'success' : 'secondary' }} me-2">
                            {{ $categorie->status === 'active' ? 'Actif' : 'Inactif' }}
                        </span>
                        @if($categorie->children->count() > 0)
                            <small class="text-muted">
                                {{ $categorie->children->count() }} sous-catégorie(s)
                            </small>
                        @endif
                        <small class="text-muted ms-2">
                            Niveau {{ $level + 1 }}
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="category-actions">
                <div class="btn-group" role="group">
                    <a href="{{ route('categorie.edit', $categorie->id) }}" 
                       class="btn btn-outline-success btn-sm" 
                       title="Modifier">
                        <i class="ri-edit-2-line"></i>
                    </a>
                    
                    @if($level < 3)
                        <a href="{{ route('categorie.add-subCat', $categorie->id) }}" 
                           class="btn btn-outline-primary btn-sm" 
                           title="Ajouter une sous-catégorie">
                            <i class="ri-add-circle-line"></i>
                        </a>
                    @endif
                    
                    @if ($categorie->children->count() == 0)
                        <button class="btn btn-outline-danger btn-sm delete" 
                                data-id="{{ $categorie->id }}" 
                                title="Supprimer">
                            <i class="ri-delete-bin-2-line"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        
        @if ($categorie->children->count() > 0 && $level < 3)
            <div class="category-children" style="display: none;">
                @include('backend.pages.categorie.partials.subcategorie-modern', [
                    'categories_child' => $categorie->children,
                    'level' => $level + 1
                ])
            </div>
        @endif
    </div>
@endforeach