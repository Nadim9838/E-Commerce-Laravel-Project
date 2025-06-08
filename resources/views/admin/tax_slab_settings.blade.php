<x-layout>
  <x-slot:title>
    <i class="fa fa-globe fa-fw"></i> Tax Slab Settings
  </x-slot:title>
  
  <button class="btn btn-primary text-right mb-2" id="addTaxBtn" title="Add New Tax"><i class="mdi mdi-plus me-1"></i> Add Tax</button>
  <div class="card">
    <div class="card-body pt-2">
      
      {{-- Add & Update Modal --}}
      <div class="modal fade" id="taxModal" tabindex="-1" aria-labelledby="TaxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="taxForm" method="post">
              @csrf
                <div class="modal-content">
                    <div class="modal-header">
                      <i class="fa fa-tags fa-fw"></i>&nbsp;
                      <h5 class="modal-title">Tax Form</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" id="taxId">

                      <div class="mb-2"><label>Enter Tax Slab</label><span class="text-danger">*</span>
                        <input type="number" min="0" step="0.00" name="tax" class="form-control" id="tax" required>
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
              <th class="text-center">Tax Slabs</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($taxes as $index => $tax)
            <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td class="text-center">{{ $tax->tax }}%</td>
              <td>
                <div class="d-flex gap-3 justify-content-center">
                  <a href="#" class="btn btn-success btn-sm tax-btn-edit" title="Edit Tax" data-tax='@json($tax)'><i class="mdi mdi-pencil"></i></a>

                  <form class="delete-confirmation" action="{{ route('delete_tax', $tax->id) }}%" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Tax"><i class="mdi mdi-delete"></i></button>
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