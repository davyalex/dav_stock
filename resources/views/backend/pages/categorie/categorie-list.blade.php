<div class="col-lg-10 m-auto">
    <div class="card category-list-card">
        <div class="card-header bg-transparent border-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="ri-folder-line me-2"></i>
                    Arborescence des Catégories
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" id="expandAll">
                        <i class="ri-add-box-line me-1"></i>
                        Tout Développer
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" id="collapseAll">
                        <i class="ri-subtract-line me-1"></i>
                        Tout Réduire
                    </button>
                    <a href="{{ route('categorie.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-fill me-1"></i>
                        Ajouter
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @if($data_categorie->count() > 0)
                <div class="category-tree">
                    @foreach ($data_categorie as $key => $categorie)
                        <div class="category-item level-0" data-category-id="{{ $categorie->id }}">
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
                                        <i class="ri-folder-2-fill text-warning"></i>
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
                                        
                                        <a href="{{ route('categorie.add-subCat', $categorie->id) }}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           title="Ajouter une sous-catégorie">
                                            <i class="ri-add-circle-line"></i>
                                        </a>
                                        
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
                            
                            @if ($categorie->children->count() > 0)
                                <div class="category-children" style="display: none;">
                                    @include('backend.pages.categorie.partials.subcategorie-modern', [
                                        'categories_child' => $categorie->children,
                                        'level' => 1
                                    ])
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="ri-folder-open-line text-muted" style="font-size: 4rem;"></i>
                    <h5 class="text-muted mt-3">Aucune catégorie trouvée</h5>
                    <p class="text-muted">Commencez par créer votre première catégorie</p>
                    <a href="{{ route('categorie.create') }}" class="btn btn-primary">
                        <i class="ri-add-fill me-1"></i>
                        Créer une catégorie
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .category-list-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    
    .category-tree {
        position: relative;
    }
    
    .category-item {
        position: relative;
        margin-bottom: 8px;
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }
    
    .category-item:hover {
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }
    
    .category-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        cursor: pointer;
    }
    
    .category-info {
        display: flex;
        align-items: center;
        flex-grow: 1;
    }
    
    .category-toggle {
        width: 20px;
        margin-right: 10px;
        cursor: pointer;
    }
    
    .toggle-icon {
        transition: transform 0.3s ease;
        font-size: 1.2rem;
        color: #6c757d;
    }
    
    .toggle-icon.expanded {
        transform: rotate(90deg);
    }
    
    .empty-icon {
        font-size: 6px;
        color: #dee2e6;
    }
    
    .category-icon {
        margin-right: 12px;
    }
    
    .category-icon i {
        font-size: 1.5rem;
    }
    
    .category-details {
        flex-grow: 1;
    }
    
    .category-name {
        font-weight: 600;
        color: #495057;
        text-transform: capitalize;
    }
    
    .category-meta {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }
    
    .badge-secondary {
        background-color: #e2e3e5;
        color: #6c757d;
    }
    
    .category-actions {
        flex-shrink: 0;
    }
    
    .category-children {
        padding-left: 40px;
        padding-bottom: 10px;
        border-left: 2px solid #f0f0f0;
        margin-left: 30px;
        position: relative;
    }
    
    .category-children::before {
        content: '';
        position: absolute;
        left: -2px;
        top: 0;
        height: 100%;
        width: 2px;
        background: linear-gradient(to bottom, #4f46e5, transparent);
    }
    
    .level-1 .category-item {
        background-color: #fafafa;
        border-left: 3px solid #4f46e5;
    }
    
    .level-2 .category-item {
        background-color: #f5f5f5;
        border-left: 3px solid #7c3aed;
    }
    
    .level-3 .category-item {
        background-color: #f0f0f0;
        border-left: 3px solid #ec4899;
    }
    
    .btn-group .btn {
        border-radius: 6px;
        margin-left: 2px;
    }
    
    .btn-group .btn:first-child {
        margin-left: 0;
    }
    
    .empty-state {
        padding: 60px 20px;
    }
    
    @media (max-width: 768px) {
        .category-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .category-actions {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }
        
        .category-children {
            padding-left: 20px;
            margin-left: 15px;
        }
    }
</style>



@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // Gestion de l'expansion/collapse des catégories
            $('.category-toggle').on('click', function(e) {
                e.stopPropagation();
                const categoryItem = $(this).closest('.category-item');
                const children = categoryItem.find('> .category-children');
                const toggleIcon = $(this).find('.toggle-icon');
                
                if (children.length > 0) {
                    children.slideToggle(300);
                    toggleIcon.toggleClass('expanded');
                }
            });

            // Bouton pour développer tout
            $('#expandAll').on('click', function() {
                $('.category-children').slideDown(300);
                $('.toggle-icon').addClass('expanded');
            });

            // Bouton pour réduire tout
            $('#collapseAll').on('click', function() {
                $('.category-children').slideUp(300);
                $('.toggle-icon').removeClass('expanded');
            });

            // Gestion de la suppression
            $('.delete').on("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                var Id = $(this).attr('data-id');
                
                Swal.fire({
                    title: 'Êtes-vous sûr(e) ?',
                    text: "Cette action supprimera définitivement cette catégorie !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler',
                    customClass: {
                        confirmButton: 'btn btn-danger w-xs me-2 mt-2',
                        cancelButton: 'btn btn-secondary w-xs mt-2',
                    },
                    buttonsStyling: false,
                    showCloseButton: true,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Afficher un loader
                        Swal.fire({
                            title: 'Suppression en cours...',
                            html: 'Veuillez patienter',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            type: "GET",
                            url: "/admin/categorie/delete/" + Id,
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 200) {
                                    Swal.fire({
                                        title: 'Supprimé !',
                                        text: 'La catégorie a été supprimée avec succès.',
                                        icon: 'success',
                                        customClass: {
                                            confirmButton: 'btn btn-primary w-xs mt-2',
                                        },
                                        buttonsStyling: false,
                                        timer: 2000,
                                        timerProgressBar: true
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Erreur !',
                                        text: 'Une erreur est survenue lors de la suppression.',
                                        icon: 'error',
                                        customClass: {
                                            confirmButton: 'btn btn-primary w-xs mt-2',
                                        },
                                        buttonsStyling: false
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Erreur !',
                                    text: 'Une erreur de connexion est survenue.',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-primary w-xs mt-2',
                                    },
                                    buttonsStyling: false
                                });
                            }
                        });
                    }
                });
            });

            // Animation au survol des éléments
            $('.category-item').hover(
                function() {
                    $(this).addClass('shadow-sm');
                },
                function() {
                    $(this).removeClass('shadow-sm');
                }
            );

            // Recherche en temps réel (optionnel)
            function filterCategories(searchTerm) {
                const items = $('.category-item');
                
                if (!searchTerm) {
                    items.show();
                    return;
                }
                
                items.each(function() {
                    const categoryName = $(this).find('.category-name').text().toLowerCase();
                    if (categoryName.includes(searchTerm.toLowerCase())) {
                        $(this).show();
                        // Afficher aussi les parents
                        $(this).parents('.category-children').prev().show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            // Ajout d'un champ de recherche (optionnel)
            if ($('.category-tree').length > 0) {
                const searchInput = $('<div class="mb-3"><input type="text" class="form-control" placeholder="Rechercher une catégorie..." id="categorySearch"></div>');
                $('.category-tree').before(searchInput);
                
                $('#categorySearch').on('input', function() {
                    filterCategories($(this).val());
                });
            }
        });
    </script>
@endsection