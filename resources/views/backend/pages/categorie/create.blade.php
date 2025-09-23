@extends('backend.layouts.master')
@section('title')
    Gestion des Catégories
@endsection

@push('css')
<style>
    .category-form-card {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    
    .category-form-card:hover {
        transform: translateY(-2px);
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    
    .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
    }
    
    .btn-primary-custom {
        background: linear-gradient(45deg, #4f46e5, #7c3aed);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-primary-custom:hover {
        background: linear-gradient(45deg, #4338ca, #6d28d9);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.3);
    }
    
    .parent-category-info {
        background: #f8f9fa;
        border-left: 4px solid #4f46e5;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
    
    .category-type-toggle {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .type-option {
        padding: 15px 12px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 80px;
    }
    
    .type-option.active {
        border-color: #4f46e5;
        background: #f0f4ff;
        color: #4f46e5;
        font-weight: 600;
        transform: scale(1.02);
    }
    
    .type-option:hover {
        border-color: #4f46e5;
        background: #f8f9ff;
    }
    
    .type-option i {
        font-size: 1.5rem;
        margin-bottom: 8px;
    }
    
    .card-header {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .card-title {
        color: #495057;
        font-weight: 700;
    }
    
    /* Responsive Design */
    @media (max-width: 1024px) {
        .row {
            flex-direction: column;
        }
        
        .col-lg-6 {
            width: 100%;
            margin-bottom: 2rem;
        }
        
        .col-lg-10 {
            width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .category-type-toggle {
            grid-template-columns: 1fr;
            gap: 8px;
        }
        
        .type-option {
            padding: 12px 10px;
            min-height: 60px;
        }
        
        .type-option i {
            font-size: 1.2rem;
            margin-bottom: 4px;
        }
        
        .btn-primary-custom {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 10px 12px;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .category-form-card {
            margin: 0 10px;
        }
        
        .form-label {
            font-size: 0.9rem;
        }
        
        .category-type-toggle {
            margin-bottom: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .type-option {
            padding: 10px 8px;
            min-height: 50px;
            font-size: 0.8rem;
        }
        
        .type-option i {
            font-size: 1rem;
        }
        
        .btn-primary-custom {
            padding: 8px 16px;
            font-size: 0.8rem;
        }
        
        .form-control {
            font-size: 0.9rem;
        }
        
        .parent-category-info {
            padding: 8px;
            font-size: 0.8rem;
        }
    }
    
    /* Animations et transitions */
    .category-form-card {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-control:focus {
        animation: focusPulse 0.3s ease-out;
    }
    
    @keyframes focusPulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.02);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* Accessibilité */
    .type-option:focus {
        outline: 2px solid #4f46e5;
        outline-offset: 2px;
    }
    
    .btn-primary-custom:focus {
        outline: 2px solid #4f46e5;
        outline-offset: 2px;
    }
    
    /* États de validation */
    .was-validated .form-control:valid {
        border-color: #28a745;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.5.04.53-.43.77-.81.45-.53.5-.36-.5-.86-.5.36-.45.53-.77.81-.53.43-.5-.04-.5.86z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .was-validated .form-control:invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 5.9 2.4 2.4m-2.4 0 2.4-2.4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    /* Mode sombre (optionnel) */
    @media (prefers-color-scheme: dark) {
        .category-form-card {
            background: linear-gradient(145deg, #2d3748, #4a5568);
            color: #e2e8f0;
        }
        
        .form-control {
            background-color: #4a5568;
            border-color: #718096;
            color: #e2e8f0;
        }
        
        .form-control:focus {
            border-color: #63b3ed;
            background-color: #4a5568;
        }
        
        .type-option {
            background-color: #4a5568;
            border-color: #718096;
            color: #e2e8f0;
        }
        
        .type-option.active {
            background-color: #2b6cb0;
            border-color: #3182ce;
            color: #e2e8f0;
        }
    }
</style>
@endpush

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Catégories
        @endslot
        @slot('title')
            Gestion des Catégories
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card category-form-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-3">
                        <i class="ri-folder-add-line me-2"></i>
                        Créer une Nouvelle Catégorie
                    </h5>
                </div>
                
                <div class="card-body pt-0">
                    <!-- Toggle pour type de catégorie -->
                    <div class="category-type-toggle">
                        <div class="type-option active" data-type="principal">
                            <i class="ri-folder-line d-block mb-2"></i>
                            Catégorie Principale
                        </div>
                        {{-- <div class="type-option" data-type="sous-categorie">
                            <i class="ri-folder-2-line d-block mb-2"></i>
                            Sous-Catégorie
                        </div> --}}
                    </div>

                    <form class="row g-3 needs-validation" method="post" action="{{ route('categorie.store') }}" novalidate id="categoryForm">
                        @csrf
                        
                        <!-- Sélecteur de catégorie parent (caché par défaut) -->
                        <div class="col-12" id="parentCategoryDiv" style="display: none;">
                            <label for="parent_category" class="form-label">
                                <i class="ri-folder-line me-1"></i>
                                Catégorie Parent
                            </label>
                            <select name="parent_id" class="form-control" id="parent_category">
                                <option value="">Sélectionner une catégorie parent</option>
                                @foreach ($data_categorie as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @if($category->children->count() > 0)
                                        @include('backend.pages.categorie.partials.category-options', ['categories' => $category->children, 'prefix' => '-- '])
                                    @endif
                                @endforeach
                            </select>
                            <div class="parent-category-info" id="parentInfo" style="display: none;">
                                <small class="text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    La nouvelle catégorie sera créée sous : <span id="parentName"></span>
                                </small>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="category_name" class="form-label">
                                <i class="ri-text me-1"></i>
                                Nom de la Catégorie *
                            </label>
                            <input type="text" name="name" class="form-control" id="category_name"
                                placeholder="Ex: Viennoiseries, Gâteaux..." required>
                            <div class="valid-feedback">
                                Parfait !
                            </div>
                            <div class="invalid-feedback">
                                Veuillez saisir un nom de catégorie.
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label for="category_url" class="form-label">
                                <i class="ri-link me-1"></i>
                                URL (Optionnel)
                            </label>
                            <input type="text" name="url" class="form-control" id="category_url"
                                placeholder="Ex: /viennoiseries">
                            <div class="valid-feedback">
                                Parfait !
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="category_status" class="form-label">
                                <i class="ri-toggle-line me-1"></i>
                                Statut
                            </label>
                            <select name="status" class="form-control" id="category_status">
                                <option value="active">✅ Activé</option>
                                <option value="desactive">❌ Désactivé</option>
                            </select>
                            <div class="valid-feedback">
                                Parfait !
                            </div>
                        </div>

                        <div class="col-12 pt-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ri-save-line me-2"></i>
                                Créer la Catégorie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <!-- ========== Start categorie list ========== -->
            @include('backend.pages.categorie.categorie-list', ['data_categorie' => $data_categorie])
            <!-- ========== End categorie list ========== -->
        
    </div><!-- end row -->

@endsection

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="{{ URL::asset('js/category-manager.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du toggle entre catégorie principale et sous-catégorie
            const typeOptions = document.querySelectorAll('.type-option');
            const parentCategoryDiv = document.getElementById('parentCategoryDiv');
            const parentCategorySelect = document.getElementById('parent_category');
            const parentInfo = document.getElementById('parentInfo');
            const parentName = document.getElementById('parentName');
            const categoryForm = document.getElementById('categoryForm');

            typeOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Retirer la classe active de tous les options
                    typeOptions.forEach(opt => opt.classList.remove('active'));
                    // Ajouter la classe active à l'option cliquée
                    this.classList.add('active');
                    
                    const type = this.getAttribute('data-type');
                    
                    if (type === 'sous-categorie') {
                        parentCategoryDiv.style.display = 'block';
                        parentCategorySelect.required = true;
                    } else {
                        parentCategoryDiv.style.display = 'none';
                        parentCategorySelect.required = false;
                        parentCategorySelect.value = '';
                        parentInfo.style.display = 'none';
                    }
                });
            });

            // Affichage des informations de la catégorie parent sélectionnée
            parentCategorySelect.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    parentName.textContent = selectedOption.text.replace(/--/g, '').trim();
                    parentInfo.style.display = 'block';
                } else {
                    parentInfo.style.display = 'none';
                }
            });

            // Validation du formulaire
            categoryForm.addEventListener('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                this.classList.add('was-validated');
            });

            // Auto-génération de l'URL basée sur le nom
            const categoryNameInput = document.getElementById('category_name');
            const categoryUrlInput = document.getElementById('category_url');
            
            categoryNameInput.addEventListener('input', function() {
                if (!categoryUrlInput.value || categoryUrlInput.getAttribute('data-manual') !== 'true') {
                    let slug = this.value
                        .toLowerCase()
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '') // Retirer les accents
                        .replace(/[^a-z0-9]/g, '-')
                        .replace(/-+/g, '-')
                        .replace(/^-|-$/g, '');
                    
                    categoryUrlInput.value = slug ? '/' + slug : '';
                }
            });

            // Marquer l'URL comme modifiée manuellement
            categoryUrlInput.addEventListener('input', function() {
                this.setAttribute('data-manual', 'true');
            });

            // Raccourcis clavier pour l'accessibilité
            document.addEventListener('keydown', function(e) {
                // Alt + N : Focus sur le champ nom
                if (e.altKey && e.key === 'n') {
                    e.preventDefault();
                    categoryNameInput.focus();
                }
                
                // Alt + P : Focus sur le sélecteur parent
                if (e.altKey && e.key === 'p') {
                    e.preventDefault();
                    if (parentCategoryDiv.style.display !== 'none') {
                        parentCategorySelect.focus();
                    }
                }
                
                // Alt + S : Soumettre le formulaire
                if (e.altKey && e.key === 's') {
                    e.preventDefault();
                    categoryForm.requestSubmit();
                }
            });

            // Prévisualisation en temps réel
            categoryNameInput.addEventListener('input', function() {
                const preview = document.getElementById('categoryPreview');
                if (preview) {
                    preview.textContent = this.value || 'Nouvelle catégorie';
                }
            });
        });
    </script>
@endsection
