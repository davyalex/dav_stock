@extends('backend.layouts.master')
@section('title')
    Sortie
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Stock
        @endslot
        @slot('title')
            Créer une sortie
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold text-primary">Sélectionner des produits</h4>
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3">
                            <label for="product-select" class="form-label fw-semibold">Produit</label>
                            <select id="product-select" name="produit_id" class="form-select js-example-basic-single">
                                <option value="">Sélectionnez un produit</option>
                                @foreach ($data_produit as $produit)
                                    <option value="{{ $produit->id }}" data-stock="{{ $produit->stock }}">
                                        {{ $produit->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold" for="currentDate">Date de sortie <span
                                    class="text-danger">*</span></label>
                            <input type="datetime-local" id="currentDate" value="{{ date('Y-m-d\TH:i') }}"
                                name="date_sortie" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold text-primary">Liste des produits à sortir</h4>
                    <div class="table-responsive">
                        <div class="alert alert-danger d-none" role="alert">
                            <span id="errorMessage"></span>
                        </div>
                        <table class="table table-bordered align-middle" id="cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Stock disponible</th>
                                    <th>Quantité à sortir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamique JS -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <button type="button" id="validate" class="btn btn-success w-100 fw-bold">
                            <span id="spinner" class="spinner-border spinner-border-sm d-none me-2"></span>
                            Enregistrer la sortie
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        $(function() {
            let cart = [];
            const dataProduit = @json($data_produit);

            $('#product-select').change(function() {
                const id = $(this).val();
                if (!id) return;
                const prod = dataProduit.find(p => p.id == id);
                if (!cart.find(item => item.id == id)) {
                    cart.push({
                        id,
                        name: prod.nom,
                        stock: prod.stock,
                        quantity: 1
                    });
                    renderCart();
                    hideError();
                }
            });

            function renderCart() {
                const tbody = $('#cart-table tbody');
                tbody.empty();
                cart.forEach((item, i) => {
                    tbody.append(`
                        <tr>
                            <td class="fw-semibold">${item.name}</td>
                            <td>${item.stock}</td>
                            <td>
                                <div class="input-group input-group-sm" style="max-width:140px;">
                                    <button class="btn btn-outline-secondary minus" data-i="${i}">-</button>
                                    <input type="number" class="form-control qty text-center" value="${item.quantity}" min="1" max="${item.stock}" data-i="${i}" style="width:70px;">
                                    <button class="btn btn-outline-secondary plus" data-i="${i}">+</button>
                                </div>
                            </td>
                            <td><button class="btn btn-danger btn-sm remove" data-i="${i}"><i class="ri-delete-bin-6-line"></i></button></td>
                        </tr>
                    `);
                });
            }

            $(document).on('click', '.plus', function() {
                let i = $(this).data('i');
                if (cart[i].quantity < cart[i].stock) cart[i].quantity++;
                renderCart();
                hideError();
            });
            $(document).on('click', '.minus', function() {
                let i = $(this).data('i');
                if (cart[i].quantity > 1) cart[i].quantity--;
                renderCart();
                hideError();
            });
            $(document).on('input', '.qty', function() {
                let i = $(this).data('i');
                let val = parseInt($(this).val());
                if (val > 0 && val <= cart[i].stock) cart[i].quantity = val;
                else $(this).val(cart[i].quantity);
                hideError();
            });
            $(document).on('click', '.remove', function() {
                let i = $(this).data('i');
                cart.splice(i, 1);
                renderCart();
                hideError();
            });

            function hideError() {
                $('.alert').addClass('d-none');
                $('#validate').prop('disabled', false);
            }

            $('#validate').click(function() {
                if (!cart.length) {
                    $('#errorMessage').text('Aucun produit ajouté').parent().removeClass('d-none');
                    return;
                }
                let currentDate = $('#currentDate').val();
                let data = {
                    date_sortie: currentDate,
                    cart,
                    _token: '{{ csrf_token() }}'
                };
                $('#spinner').removeClass('d-none');
                $('#validate').prop('disabled', true);
                $.ajax({
                    url: '{{ route('sortie.store') }}',
                    method: 'POST',
                    data,
                    success: function(response) {
                        $('#spinner').addClass('d-none');
                        $('#validate').prop('disabled', false);
                        if (response.status == 'success') {
                            window.location.href = '{{ route('sortie.index') }}';
                        } else {
                            $('#errorMessage').text(response.message ||
                                'Erreur lors de la validation.').parent().removeClass(
                                'd-none');
                        }
                    },
                    error: function(xhr) {
                        $('#spinner').addClass('d-none');
                        $('#validate').prop('disabled', false);
                        let msg = xhr.responseJSON?.message || 'Erreur lors de la validation.';
                        $('#errorMessage').text(msg).parent().removeClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection
