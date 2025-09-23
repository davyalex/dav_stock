 <div class="tab-pane" id="privacy" role="tabpanel">
                            <div class="mb-4 pb-2">

                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                    <input type="text" name="type_clear" value="cache" hidden>
                                    <div class="flex-grow-1">
                                        <h6 class="fs-14 mb-1">Cache systeme</h6>
                                        <p class="text-muted">En cliquant sur vider le cache vous allez supprimer les
                                            fichier temporaires stockés en memoire</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <a href="#" class="btn btn-sm btn-primary btn-clear">Vider
                                            le
                                            cache</a>
                                    </div>
                                </div>



                            </div>
                            <div class="mb-3">
                                {{-- <h5 class="card-title text-decoration-underline mb-3">Application </h5> --}}
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex">
                                        <div class="flex-grow-1">
                                            <label for="directMessage" class="form-check-label fs-14">Maintenance
                                                mode</label>
                                            <p class="text-muted">Mettre l'application en mode maintenance</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            @if ($data_maintenance == null || $data_maintenance['type'] == 'up')
                                                <div class="form-check form-switch">
                                                    <a href="#"
                                                        class="btn btn-sm btn-primary btn-mode-down">Activer</a>
                                                </div>
                                            @else
                                                <div class="form-check form-switch">
                                                    <a href="#"
                                                        class="btn btn-sm btn-primary btn-mode-up">Désactiver</a>
                                                </div>
                                            @endif

                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </div>