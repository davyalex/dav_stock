@extends('site.layouts.app')

@section('title', 'Caisse')


@section('content')
    <!-- checkout-area start -->
    <div class="checkout-area pb-80 pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="checkout-wrapper">
                        <div id="faq" class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title"><span>1.</span> <a data-bs-toggle="collapse"
                                            data-bs-target="#payment-1">Informations</a></h5>
                                </div>
                                <div id="payment-1" class="panel-collapse collapse show" data-bs-parent="#faq">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="checkout-register">
                                                    <div class="title-wrap">
                                                        <h4 class="cart-bottom-title section-bg-white">Mode de livraison</h4>
                                                    </div>
                                                    <div class="register-us">
                                                        <div class="total-shipping">
                                                            <h5>Livraison <small class="text-danger"> * Cocher une option</small> </h5>
                        
                                                            <div class="mt-3 adressYango">
                                                                <label for="" class="form-label">Lieu de livraison</label>
                                                                <input type="text" id="adresseLivraison" name="adresse_livraison"
                                                                    class="form-control" placeholder="cocody saint jeane"
                                                                    aria-describedby="helpId" />
                                                            </div>
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="optionLivraison"
                                                                            value="yango" id="yango">
                                                                        <label class="form-check-label" for="yango">
                                                                            Yango Moto
                                                                        </label>
                                                                    </div>
                        
                        
                                                                </li>
                        
                        
                                                                <li>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="optionLivraison"
                                                                            value="recuperer" id="recuperer">
                                                                        <label class="form-check-label" for="recuperer">
                                                                            Je passe récupérer
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                        
                        
                                                        </div>
                                                    </div>
                                                  
                                                   
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="checkout-login">
                                                    <div class="title-wrap">
                                                        <h4 class="cart-bottom-title section-bg-white">Infos personnelles</h4>
                                                    </div>
                                                   
                                                    <span>Nom: {{Auth::user()->first_name}} </span>
                                                    <span>Nom: {{Auth::user()->last_name}} </span>
                                                    <span>Contact: {{Auth::user()->phone}} </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title"><span>2.</span> <a data-bs-toggle="collapse"
                                            data-bs-target="#payment-6">Facture de la commande</a></h5>
                                </div>
                                <div id="payment-6" class="panel-collapse collapse" data-bs-parent="#faq">
                                    <div class="panel-body">
                                        <div class="order-review-wrapper">
                                            <div class="order-review">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="width-1">Product Name</th>
                                                                <th class="width-2">Price</th>
                                                                <th class="width-3">Qty</th>
                                                                <th class="width-4">Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>Fusce aliquam</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>$236.00</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>2</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>$236.00</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>Primis in faucibus</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>$265.00</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>3</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>$265.00</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>Etiam gravida</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>$363.00</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>2</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>$363.00</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>Quisque in arcu</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>$328.00</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>2</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>$328.00</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">Subtotal </td>
                                                                <td colspan="1">$4,001.00</td>
                                                            </tr>
                                                            <tr class="tr-f">
                                                                <td colspan="3">Shipping & Handling (Flat Rate - Fixed
                                                                </td>
                                                                <td colspan="1">$45.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">Grand Total</td>
                                                                <td colspan="1">$4,722.00</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="billing-back-btn">
                                                  
                                                    <div class="billing-btn">
                                                        <button type="submit">Continue</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="billing-btn">
                                <button id="btnSend">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3">
                    <div class="checkout-progress">
                        <h4>Checkout Progress</h4>
                        <ul>
                            <li>Billing Address</li>
                            <li>Shipping Address</li>
                            <li>Shipping Method</li>
                            <li>Payment Method</li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>


    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css
    " rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
      // afficher le champs adresse de livraison yango si yango est coché
      $('.adressYango').hide();
        $('input[name="optionLivraison"]').change(function(e) {
            e.preventDefault();
            var livraisonValue = $('input[name="optionLivraison"]:checked').val();
            if (livraisonValue == "yango") {
                $('.adressYango').show(300);
            } else {
                $('.adressYango').hide(300);
                $('#adresseLivraison').val('');
            }
        });

        // envoi des informations au controllers  pour enregistrer la commande


        $('#btnSend').click(function(e) {
            e.preventDefault();
            //on verifie si une option de livraison à éte selectionné
            var livraisonValue = $('input[name="optionLivraison"]:checked').val();
            var yangoValue = $('#adresseLivraison').val(); // adresse de livraison yango

            if (livraisonValue == null || livraisonValue == '') {
                Swal.fire({
                    title: 'Ouff',
                    text: 'Veuillez selectionner une option de livraison',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            } else if ($('.adressYango').is(':visible') && yangoValue == '') {
                Swal.fire({
                    title: 'Ouff',
                    text: 'Veuillez entrer le lieu de livraison pour yango',
                    icon: 'error',
                    confirmButtonText: 'OK',
                });
            } else {
                //on envoi les informations au controller pour enregistrer la commande
                $.ajax({
                    url: "{{ route('cart.save-order') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        optionLivraison: livraisonValue, //option livraison
                        adresseLivraison: yangoValue
                    },
                    success: function(response) {
                        console.log(response);

                    },

                });
            }
        });


</script>




@endsection
