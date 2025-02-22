<div class="card-body divPrint">
    <div class="table-responsive">
        <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date de sortie</th>
                    <th>Nom</th>
                    <th>Stock existant</th>
                    <th>Quantité utilisé</th>
                    <th class="d-none">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sortie as $key => $item)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td>{{ \Carbon\Carbon::parse($item['date_sortie'])->format('d-m-Y à H:i') }}</td>
                        <td>{{ $item['produit']['nom'] }} {{ $item['valeur_unite'] ?? '' }}
                            {{ $item['produit']['unite']['abreviation'] ?? '' }}
                        </td>
                        <td>{{ $item['quantite_existant'] }} {{ $item['produit']['uniteSortie']['abreviation'] ?? '' }}</td>
                        <td>{{ $item['quantite_utilise'] }} {{ $item['produit']['uniteSortie']['abreviation'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
