  <div class="col-lg-6">
      <div class="card">
          <div class="card-body">
              <h5>Liste de menu</h5>
              <!-- Accordions with Plus Icon -->
              @foreach ($data_menu as $key => $menu)
                  {{-- <div class="accordion custom-accordionwithicon-plus" id="accordionWithplusicon{{ $menu['id'] }}">

                      <div class="accordion-item">
                          <h2 class="accordion-header d-flex justify-content-around"
                              id="accordionwithplusExample{{ $menu['id'] }}">
                              <button class="accordion-button fw-semibold w-8" type="button" data-bs-toggle="collapse"
                                  data-bs-target="#accor_plusExamplecollapse{{ $menu['id'] }}" aria-expanded="true"
                                  aria-controls="accor_plusExamplecollapse{{ $menu['id'] }}">
                                  {{ $menu['name'] }}
                              </button>
                              <div>
                                  <a href="{{ route('menu.add-item', $menu['id']) }}" class="fs-5"> <i
                                          class="ri ri-edit-2-fill"></i> </a>
                                  <a href="" class="fs-5"> <i class=" ri ri-delete-bin-2-line text-danger"></i>
                                  </a>
                              </div>
                          </h2>




                          <div id="accor_plusExamplecollapse{{ $menu['id'] }}"
                              class="accordion-collapse collapse show"
                              aria-labelledby="accordionwithplusExample{{ $menu['id'] }}"
                              data-bs-parent="#accordionWithplusicon{{ $menu['id'] }}">
                              <div class="accordion-body">
                                 
                              </div>
                          </div>
                      </div>

                  </div> --}}
                  <div>
                      <hr>
                      <li>
                          <a class="fs-5 fw-medium" href="{{ $menu->url }}">{{ $menu->name }}</a>
                          <a href="{{ route('menu.edit', $menu['id']) }}" class="fs-5" style="margin-left:30px"> <i
                                  class=" ri ri-edit-2-fill ml-4"></i></a>

                          <a href="{{ route('menu.add-item', $menu['id']) }}" class="fs-5"> <i
                                  class=" ri ri-add-circle-fill ml-4"></i>
                          </a>
                          @if ($menu['children_count'] ==0)
                          <a href="{{ route('menu.delete', $menu['id']) }}" class="fs-5"> <i
                                  class=" ri ri-delete-bin-2-line text-danger"></i>
                          </a>
                          @endif

                          @if ($menu->children->count() > 0)
                              @include('backend.pages.menu.partials.submenu', [
                                  'menus_child' => $menu->children,
                              ])
                          @endif
                      </li>
                  </div>
              @endforeach
          </div>

      </div>
  </div><!-- end row -->
