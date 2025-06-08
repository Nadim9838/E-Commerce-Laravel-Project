<x-layout>
  <x-slot:title>
    <i class="fa fa-globe fa-fw"></i> Client Review Settings
  </x-slot:title>
  
  {{-- Banner Image Section --}}
  <button class="btn btn-primary text-right mb-2" id="addReviewBtn" title="Add New Review Banner"><i class="mdi mdi-plus me-1"></i> Add Review Banner</button>
  <div class="card">
    <div class="card-body pt-2">
      
      {{-- Add & Update Modal --}}
      <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="reviewForm" method="post" enctype="multipart/form-data">
              @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-tags fa-fw"></i>&nbsp;
                        <h5 class="modal-title">Review Banner Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="reviewId">

                        <div class="mb-2"><label>Banner Image</label>
                          <input type="file" name="review_banner" class="form-control" id="review_banner_image" accept=".png,.jpg,.jpeg,.ico, .gif">

                          <img id="review_banner__image_preview" class="img-thumbnail mt-2" src="" style="max-width: 100px;">
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-xmark"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
      {{-- End Add & Update Modal --}}
      {{-- Table --}}
      <div class="table-responsive">
        <table class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
          <thead>
            <tr>
              <th class="text-center">Review Banner Image</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @if(isset($banner))
            <tr>
              <td>
                @if (isset($banner->review_banner))
                <img src="{{ $banner->review_banner }}" class="img-thumbnail" style="max-width:200px; width:100%">
                @endif
              </td>
              <td>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="#" class="btn btn-success btn-sm review-btn-edit" title="Edit Banner" data-review='@json($banner)'><i class="mdi mdi-pencil"></i></a>

                    <form class="delete-confirmation" action="{{ route('delete_review_banner', $banner->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" title="Delete Banner"><i class="mdi mdi-delete"></i></button>
                    </form>
                </div>
              </td>
            </tr>
            @endif
          </tbody>
        </table>
        {{-- End Table --}}
      </div>
    </div>
  </div>
</x-layout>