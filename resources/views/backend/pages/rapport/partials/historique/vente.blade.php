<table id="buttons-datatables" class="display table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Produit</th>
            <th>Date de vente</th>
            <th>Quantite</th>
            <th>Prix unitaire</th>
            <th>total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vente as $key => $item)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $item['produit']['nom'] }}</td>
                <td>{{ $item['vente']['date_vente'] }}</td>
                <td><b> {{ $item['quantite'] ?? 0 }} {{ $item['variante']['libelle'] ?? 'bouteille' }} </b> </td>
                <td>{{ number_format($item['prix_unitaire'], 0, ',', ' ') }} FCFA</td>
                <td>{{ number_format($item['total'], 0, ',', ' ') }}
                    FCFA</td>
            </tr>
        @endforeach
    </tbody>
</table>
