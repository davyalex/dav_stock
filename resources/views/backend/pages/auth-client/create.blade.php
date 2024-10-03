<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Modal par défaut -->
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Créer un nouveau client</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate method="POST"
                                action="{{ route('client.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Nom</label>
                                    <input type="text" name="last_name" class="form-control" id="last_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="first_name" class="form-label">Prénoms</label>
                                    <input type="text" name="first_name" class="form-control" id="first_name" required>
                                </div>

                            
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="number" name="phone" class="form-control" id="phone" required>
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" class="form-control" id="password" required>
                                </div> --}}

                                <div class="mt-3">
                                    <button class="btn btn-success w-100" type="submit">Valider</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

