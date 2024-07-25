@extends('backend.layouts.master')

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Media
        @endslot
        @slot('title')
            Créer un media
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="formSend" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Titre du media</label>
                            <input type="text" name="title" class="form-control" id="validationCustom01" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="validationCustom01" class="form-label">Categorie du media</label>
                            <select class="form-control" name="categorie">
                                <option disabled selected value>Selectionner...</option>
                                @foreach ($data_media_category as $item)
                                    <option value="{{ $item['id'] }}"> {{ $item['name'] }} </option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="validationCustom01" class="form-label">Statut</label>
                            <select name="status" class="form-control">
                                <option value="active">Activé</option>
                                <option value="desactive">Desactivé</option>

                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">Image du media (un ou plusieurs
                                images)</label>
                            <input type="file" id="imageInput" accept="image/*" class="form-control" multiple required>

                            <div class="row" id="imageTableBody"></div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">Url de video</label>
                            <input type="text" name="url" class="form-control" id="validationCustom01">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>


                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary w-100 ">Valider</button>
                </div>
                </form>
            </div>
        </div><!-- end row -->
    </div><!-- end col -->

    <!--end row-->

@section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
    {{-- <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script> --}}
    <script src="{{ URL::asset('build/tinymce/tinymce.min.js') }}"></script>

    <script>
        //script for to send data 

        $('#imageInput').on('change', function(e) {
            var files = e.target.files;
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {

                    var image = ` <div class="col-3"><img src="${e.target.result}" width="100" height="100">
                                    <br><button type="button" class="btn btn-danger my-2 remove-image">Delete</button>
                                    </div>`;

                    $('#imageTableBody').append(image);
                }
                reader.readAsDataURL(files[i]);
            }
        });

        $(document).on('click', '.remove-image', function() {
            $(this).closest('div').remove();
        });

        $('#formSend').on('submit', function(e) {

            e.preventDefault();
            var formData = new FormData(this);

            $('#imageTableBody div').each(function() {
                var imageFile = $(this).find('img').attr('src');
                formData.append('images[]', imageFile);

            });


            $.ajax({
                url: "{{ route('media-content.store') }}", // Adjust the route as needed
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#imageTableBody').empty();

                    if (response.message == 'operation reussi') {
                        Swal.fire({
                            title: 'Good job!',
                            text: 'You clicked the button!',
                            icon: 'success',
                            showCancelButton: true,
                            customClass: {
                                confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                                cancelButton: 'btn btn-danger w-xs mt-2',
                            },
                            buttonsStyling: false,
                            showCloseButton: true
                        })

                        location.reload()
                    }
                },

            });
        });
    </script>
@endsection
@endsection
