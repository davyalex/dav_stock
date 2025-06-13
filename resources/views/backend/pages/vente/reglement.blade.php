<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="reglementModal{{ $vente->id }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Créer un nouveau administrateur  </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="needs-validation" novalidate method="POST"
                                action="{{ route('admin-register.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nom</label>
                                    <input type="text" name="last_name" class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Prenoms</label>
                                    <input type="text" name="first_name" class="form-control" id="username"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Telephone</label>
                                    <input type="number" name="phone" class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Role</label>
                                    <select class="form-control" name="role" id="" required>
                                        <option disabled selected value>Selectionner...</option>

                                    </select>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-success w-100" type="submit">Valider</button>
                                </div>


                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end col -->
</div>
