<x-layout>
  <x-slot:title>
    <i class="fa fa-globe fa-fw"></i> Special Offer Settings
  </x-slot:title>
  
  {{-- Special Offer Section --}}
  <button class="btn btn-primary text-right mb-2" id="addSettingBtn" title="Add New Banner"><i class="mdi mdi-plus me-1"></i> Add Special Offer</button>
  <div class="card">
    <div class="card-body pt-2">
      
      {{-- Add & Update Modal --}}
      <div class="modal fade" id="settingModal" tabindex="-1" aria-labelledby="settingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="settingForm" method="post" enctype="multipart/form-data">
              @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="fa fa-tags fa-fw"></i>&nbsp;
                        <h5 class="modal-title">Special Offer Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="settingId">

                        <div class="mb-2"><label>Title</label><span class="text-danger">*</span>
                          <input type="text" name="title" class="form-control" id="title" required>
                        </div>

                        <div class="mb-2"><label>Sub Title</label><span class="text-danger">*</span>
                          <input type="text" name="sub_title" class="form-control" id="sub_title" required>
                        </div>

                        <div class="mb-2"><label>Description</label><span class="text-danger">*</span>
                          <input type="text" name="description" class="form-control" id="description" required>
                        </div>

                        <div class="mb-2"><label>Image</label><span class="text-danger">*</span>
                          <input type="file" name="offer_image" class="form-control" id="offer_image" accept=".png,.jpg,.jpeg,.ico,.gif,.webp">

                          <img id="special_offer_image_preview" class="img-thumbnail mt-2" src="" style="max-width: 100px;">
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
              <th class="text-center">Image</th>
              <th class="text-center">Title</th>
              <th class="text-center">Sub Title</th>
              <th class="text-center">Description</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($settings as $index => $row)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td>
                @if ($row->offer_image)
                <img src="{{ $row->offer_image }}" class="img-thumbnail" style="max-width: 100px; max-height: 70px;">
                @endif
              </td>
              <td title="{{ $row->title }}">{{ $row->title }}</td>
              <td title="{{ $row->sub_title }}">{{ $row->sub_title }}</td>
              <td title="{{ $row->description }}">{{ $row->description }}</td>
              <td>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="#" class="btn btn-success btn-sm setting-btn-edit" title="Edit Special Offer" data-setting='@json($row)'><i class="mdi mdi-pencil"></i></a>

                    <form class="delete-confirmation" action="{{ route('delete_setting', $row->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" title="Delete Special Offer"><i class="mdi mdi-delete"></i></button>
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