@extends('backend.layouts.master')
@section('title')
    Intrant
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">
        @slot('li_1')
            Intrant
        @endslot
        @slot('title')
            Modifier un intrant
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="formSend" method="POST" action="{{ route('intrant.update', $data_intrant->id) }}" autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Colonne principale -->
                            <div class="col-lg-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Libellé <span class="text-danger">*</span></label>
                                                <input type="text" name="nom" class="form-control" id="nomIntrant" value="{{ $data_intrant->nom }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Prix <span class="text-danger">*</span></label>
                                                <input type="number" name="prix" class="form-control" id="prixIntrant" value="{{ $data_intrant->prix }}" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Stock alerte <span class="text-danger">*</span></label>
                                                <input type="number" name="stock_alerte" class="form-control" id="stockAlerte" value="{{ $data_intrant->stock_alerte }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control">{{ $data_intrant->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Colonne image -->
                            <div class="col-lg-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label class="form-label">Image de l'intrant</label>
                                        <input type="file" id="imageInput" name="image" accept="image/*" class="form-control mb-2">
                                        <div id="imagePreviewContainer" class="text-center">
                                            <img id="imagePreview" src="{{ $data_intrant->getFirstMediaUrl('IntrantImage') ?: '#' }}" alt="Aperçu" class="img-fluid rounded {{ $data_intrant->getFirstMediaUrl('IntrantImage') ? '' : 'd-none' }}" style="max-height:200px;">
                                        </div>
                                        <label class="form-label mt-3">Statut</label>
                                        <select name="statut" class="form-control">
                                            <option value="active" {{ $data_intrant->statut == 'active' ? 'selected' : '' }}>Actif</option>
                                            <option value="desactive" {{ $data_intrant->statut == 'desactive' ? 'selected' : '' }}>Désactivé</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-lg" id="submitBtn">
                                <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
        <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
        <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
        <script>
            document.getElementById('imageInput').addEventListener('change', function(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.src = '#';
                    preview.classList.add('d-none');
                }
            });

            document.getElementById('formSend').addEventListener('submit', function() {
                const btn = document.getElementById('submitBtn');
                const spinner = document.getElementById('spinner');
                btn.disabled = true;
                spinner.classList.remove('d-none');
            });
        </script>
    @endsection
@endsection
