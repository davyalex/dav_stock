@extends('site.layouts.app')

@section('title', 'Mes commandes')


@section('content')
  
<div class="row">
@forelse ($commandes as $key=>$commande)
        <div class="col-12 col-lg-6 mb-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list-unstyled">
                        <li class=""><h5 class="panel-title"><span> {{++$key}} </span> <a data-bs-toggle="collapse" data-bs-target="#payment-{{$commande->id}}"> #{{$commande->code}}  </a></h5>
                        </li>
                        <li><i class="px-4 text-lowercase">Date : {{$commande->date_commande}}</i></li>

                        <li><i class="px-4 text-lowercase">Statut : {{$commande->statut}}</i></li>
                    </ul>
                </div>
                <div id="payment-{{$commande->id}}" class="panel-collapse collapse" data-bs-parent="#faq">
                    <div class="panel-body">
                        <div class="order-review-wrapper">
                            <div class="order-review">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="width-1">Produit</th>
                                                <th class="width-2">prix</th>
                                                <th class="width-3">Qté</th>
                                                <th class="width-4">total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($commande->produits as $produit)
                                           <tr>
                                            <td>
                                                <div class="o-pro-dec">
                                                    <p> <a href="{{route('produit.detail' , $produit->slug)}}"><img src="{{$produit->getFirstMediaUrl('ProduitImage')}}" width="50"> {{$produit->nom}}</a> </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-price">
                                                    <p>{{$produit->pivot->prix_unitaire}}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-qty">
                                                    <p>{{$produit->pivot->quantite}}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-subtotal">
                                                    <p>{{$produit->pivot->total}}</p>
                                                </div>
                                            </td>
                                        </tr>
                                           @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">Grand Total</td>
                                                <td colspan="1"> {{$commande->montant_total}} </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
@empty
    <h3>Vous n'avez pas encore passé de commande </h3>
@endforelse
</div>
@endsection
