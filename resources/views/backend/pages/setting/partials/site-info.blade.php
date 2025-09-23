  <div class="tab-pane active" id="personalDetails" role="tabpanel">
      <form action="{{ route('setting.store') }}" method="post" enctype="multipart/form-data">
          @csrf

          <div class="row">

              <!-- ========== Start Section ========== -->
        @php
    $uploads = [
        [
            'id' => 'background',
            'name' => 'cover',
            'label' => "Image d'arrière-plan",
            'media' => 'cover',
            'default' => asset('build/images/profile-bg.jpg'),
        ],
        [
            'id' => 'logo-header',
            'name' => 'logo_header',
            'label' => "Logo d'en-tête",
            'media' => 'logo_header',
            'default' => asset('assets/img/logo/logo.jpg'),
        ],
        [
            'id' => 'logo-footer',
            'name' => 'logo_footer',
            'label' => 'Logo de pied de page',
            'media' => 'logo_footer',
            'default' => asset('images/avatar-1.jpg'),
        ],
    ];
@endphp

<div class="row mb-3">
    @foreach ($uploads as $upload)
        <div class="col-lg-4">
            <label for="{{ $upload['id'] }}">{{ $upload['label'] }}</label>
            <input type="file" id="{{ $upload['id'] }}" name="{{ $upload['name'] }}"
                   class="form-control upload-input" accept="image/*" 
                   data-preview="{{ $upload['id'] }}-preview">
            <div class="mt-2 text-center">
                <img id="{{ $upload['id'] }}-preview"
                     src="{{ $data_setting && $data_setting->hasMedia($upload['media'])
                                ? $data_setting->getFirstMediaUrl($upload['media'])
                                : $upload['default'] }}"
                     class="rounded-circle avatar-xl img-thumbnail"
                     alt="Aperçu de {{ strtolower($upload['label']) }}">
            </div>
        </div>
    @endforeach
</div>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById(previewId).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Appliquer à tous les inputs avec .upload-input
    document.querySelectorAll('.upload-input').forEach(input => {
        input.addEventListener('change', function () {
            previewImage(this, this.dataset.preview);
        });
    });
</script>

              <!-- ========== End Section ========== -->
          </div>
          <hr>
          <div class="row">
              <div class="col-lg-5">
                  <div class="mb-3">
                      <label for="emailInput" class="form-label">Titre du projet</label>
                      <input type="text" name="projet_title" class="form-control" id="emailInput"
                          value="{{ $data_setting['projet_title'] ?? '' }}">
                  </div>
              </div>

              <div class="col-lg-7">
                  <div class="mb-3">
                      <label for="emailInput" class="form-label">Description du projet</label>
                      <input type="text" name="projet_description" class="form-control" id="emailInput"
                          value="{{ $data_setting['projet_description'] ?? '' }}">
                  </div>
              </div>
              <!--end col-->

              <div class="col-lg-4">
                  <div class="mb-3">
                      <label for="phonenumberInput" class="form-label">Telephone1</label>
                      <input type="text" name="phone1" class="form-control" id="phonenumberInput"
                          value="{{ $data_setting['phone1'] ?? '' }}">
                  </div>
              </div>

              <div class="col-lg-4">
                  <div class="mb-3">
                      <label for="phonenumberInput" class="form-label">Telephone2</label>
                      <input type="text" name="phone2" class="form-control" id="phonenumberInput"
                          value="{{ $data_setting['phone2'] ?? '' }}">
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="mb-3">
                      <label for="phonenumberInput" class="form-label">Telephone3</label>
                      <input type="text" name="phone3" class="form-control" id="phonenumberInput"
                          value="{{ $data_setting['phone3'] ?? '' }}">
                  </div>
              </div>
              <!--end col-->
              <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="emailInput" class="form-label">Email 1</label>
                      <input type="email" name="email1" class="form-control" id="emailInput"
                          value="{{ $data_setting['email1'] ?? '' }}">
                  </div>
              </div>

              <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="emailInput" class="form-label">Email 2</label>
                      <input type="email" name="email2" class="form-control" id="emailInput"
                          value="{{ $data_setting['email2'] ?? '' }}">
                  </div>
              </div>
              <!--end col-->


              <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="countryInput" class="form-label">Siège social</label>
                      <input type="text" name="siege_social" class="form-control" id="countryInput"
                          value="{{ $data_setting['siege_social'] ?? '' }}" />
                  </div>
              </div>
              <!--end col-->

              <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="countryInput" class="form-label">Localisation</label>
                      <input type="text" name="localisation" class="form-control" id="countryInput"
                          value="{{ $data_setting['localisation'] ?? '' }}" />
                  </div>
              </div>

              <div class="col-lg-12">
                  <div class="mb-3">
                      <label for="countryInput" class="form-label">Google maps</label>
                      <input type="text" name="google_maps" class="form-control" id="countryInput"
                          value="{{ $data_setting['google_maps'] ?? '' }}" />
                  </div>
              </div>

              <!--end col-->




              <!-- ========== Start social network ========== -->
              <div class="row mt-4">
                  <div class="mb-3 d-flex">
                      <div class="avatar-xs d-block flex-shrink-0 me-3">
                          <span class="avatar-title rounded-circle fs-16 bg-primary material-shadow">
                              <i class=" ri-facebook-fill"></i>
                          </span>
                      </div>
                      <input type="text" name="facebook_link" class="form-control" id="websiteInput"
                          value="{{ $data_setting['facebook_link'] ?? '' }}">
                  </div>
                  <div class="mb-3 d-flex">
                      <div class="avatar-xs d-block flex-shrink-0 me-3">
                          <span class="avatar-title rounded-circle fs-16 bg-primary material-shadow">
                              <i class=" ri-instagram-fill"></i>
                          </span>
                      </div>
                      <input type="text" name="instagram_link" class="form-control" id="websiteInput"
                          value="{{ $data_setting['instagram_link'] ?? '' }}">
                  </div>

                  <div class=" mb-3 d-flex">
                      <div class="avatar-xs d-block flex-shrink-0 me-3">
                          <span class="avatar-title rounded-circle fs-16 bg-danger material-shadow">
                              <i class=" ri-tiktok-fill"></i>
                          </span>
                      </div>
                      <input type="text" name="tiktok_link" class="form-control" id="pinterestName"
                          value="{{ $data_setting['tiktok_link'] ?? '' }}">
                  </div>
                  <div class="mb-3 d-flex">
                      <div class="avatar-xs d-block flex-shrink-0 me-3">
                          <span class="avatar-title rounded-circle fs-16 bg-danger material-shadow">
                              <i class=" ri-linkedin-line"></i>
                          </span>
                      </div>
                      <input type="text" name="linkedin_link" class="form-control" id="pinterestName"
                          value="{{ $data_setting['linkedin_link'] ?? '' }}">
                  </div>

                  <div class="mb-3 d-flex">
                      <div class="avatar-xs d-block flex-shrink-0 me-3">
                          <span class="avatar-title rounded-circle fs-16 bg-danger material-shadow">
                              <i class=" ri-twitter-x-fill"></i>
                          </span>
                      </div>
                      <input type="text" name="twitter_link" class="form-control" id="pinterestName"
                          value="{{ $data_setting['twitter_link'] ?? '' }}">
                  </div>
              </div>
              <!-- ========== End social network ========== -->


              <div class="col-lg-12">
                  <div class="hstack gap-2 justify-content-end">
                      <button type="submit" class="btn btn-primary">Valider</button>
                      {{-- <button type="button" class="btn btn-soft-success">A</button> --}}
                  </div>
              </div>
              <!--end col-->
          </div>

      </form>
  </div>
