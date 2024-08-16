  <div class="col-lg-6">
      <div class="card">
          <div class="card-body">
              <div class="d-flex justify-content-between">
                  <h5>Liste des categories</h5>
                  <a href="{{ route('categorie.create') }}" class="btn btn-primary">
                      <i class="ri ri-add-fill"></i>
                      Ajouter</a>
              </div>
              <!-- Accordions with Plus Icon -->
              @foreach ($data_categorie as $key => $categorie)
                 
                  <div>
                      <hr>
                      <li class="" style="list-style: none">
                        <i class="ri-drag-move-fill align-bottom handle"></i> <a class="fs-5 fw-medium" href="{{ $categorie->url }}">{{ $categorie->name }}</a>
                          <a href="{{ route('categorie.edit', $categorie['id']) }}" class="fs-5"
                              style="margin-left:30px"> <i class=" ri ri-edit-2-fill ml-4 text-success"></i></a>

                          <a href="{{ route('categorie.add-subCat', $categorie['id']) }}" class="fs-5"> <i
                                  class=" ri ri-add-circle-fill ml-4"></i>
                          </a>
                          @if ($categorie['children_count'] == 0)
                              <a href="#" data-id="{{ $categorie['id'] }}" class="fs-5 delete"> <i
                                      class="ri ri-delete-bin-2-line text-danger "></i>
                              </a>
                          @endif

                          @if ($categorie->children->count() > 0)
                              @include('backend.pages.categorie.partials.subcategorie', [
                                  'categories_child' => $categorie->children,
                              ])
                          @endif
                      </li>
                  </div>
              @endforeach
          </div>

      </div>
  </div><!-- end row -->



  @section('script')
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

      <script>
          $(document).ready(function() {
              $('.delete').on("click", function(e) {
                  e.preventDefault();
                  var Id = $(this).attr('data-id');
                  Swal.fire({
                      title: 'Etes-vous sûr(e) de vouloir supprimer ?',
                      text: "Cette action est irréversible!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Supprimer!',
                      cancelButtonText: 'Annuler',
                      customClass: {
                          confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                          cancelButton: 'btn btn-danger w-xs mt-2',
                      },
                      buttonsStyling: false,
                      showCloseButton: true
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                              type: "GET",
                              url: "/categorie/delete/" + Id,
                              dataType: "json",

                              success: function(response) {
                                  if (response.status == 200) {
                                      Swal.fire({
                                          title: 'Deleted!',
                                          text: 'Your file has been deleted.',
                                          icon: 'success',
                                          customClass: {
                                              confirmButton: 'btn btn-primary w-xs mt-2',
                                          },
                                          buttonsStyling: false
                                      })

                                      //   $('#row_' + Id).remove();
                                      location.reload();
                                  }
                              }
                          });
                      }
                  });
              });
          });
      </script>
  @endsection
