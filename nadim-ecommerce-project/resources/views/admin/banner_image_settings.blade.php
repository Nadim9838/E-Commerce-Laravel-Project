<x-layout>
  <x-slot:title>
    <i class="fa fa-globe fa-fw"></i> Banner Image Settings
  </x-slot:title>
  
  {{-- Banner Image Section --}}
  <button class="btn btn-primary text-right mb-2" id="addBannerBtn" title="Add New Banner"><i class="mdi mdi-plus me-1"></i> Add Banner</button>
  <div class="card">
    <div class="card-body pt-2">
      
      {{-- Add & Update Modal --}}
      <div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="BannerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="bannerForm" method="post" enctype="multipart/form-data">
              @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-tags fa-fw"></i>&nbsp;
                        <h5 class="modal-title">Banner Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="bannerId">

                        <div class="mb-2"><label>Banner Title</label><span class="text-danger">*</span>
                          <input type="text" name="title" class="form-control" id="title" required>
                        </div>

                        <div class="mb-2"><label>Banner Description</label><span class="text-danger">*</span>
                          <input type="text" name="desc" class="form-control" id="desc" required>
                        </div>

                        <div class="mb-2"><label>Banner Image</label>
                          <input type="file" name="banner_image" class="form-control" id="banner_image" accept=".png,.jpg,.jpeg,.ico, .gif">

                          <img id="banner_image_preview" class="img-thumbnail mt-2" src="" style="max-width: 100px;">
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
        <table id="dataTable" class="table table-stripped text-center table-bordered align-middle table-nowrap mb-0">
          <thead>
            <tr>
              <th class="text-center">Sr. No.</th>
              <th class="text-center">Banner Image</th>
              <th class="text-center">Banner Title</th>
              <th class="text-center">Banner Description</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($banners as $index => $banner)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td title='{{ $banner->title }}'>
                @if ($banner->banner_image)
                <img src="{{ $banner->banner_image }}" class="img-thumbnail" style="max-width: 100px; max-height: 70px;">
                @endif
              </td>
              <td title="{{ $banner->title }}">{{ $banner->title }}</td>
              <td title="{{ $banner->desc }}">{{ $banner->desc }}</td>
              <td>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="#" class="btn btn-success btn-sm banner-btn-edit" title="Edit Banner" data-banner='@json($banner)'><i class="mdi mdi-pencil"></i></a>

                    <form class="delete-confirmation" action="{{ route('delete_banner', $banner->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" title="Delete Banner"><i class="mdi mdi-delete"></i></button>
                    </form>
                </div>
              </td>
            </tr>
            @empty
            @endforelse
          </tbody>
        </table>
        {{-- End Table --}}
      </div>
    </div>
  </div>
</x-layout>