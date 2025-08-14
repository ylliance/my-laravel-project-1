@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Coupons",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Coupon List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">{{ __('Coupons') }}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('coupons.create') }}" class="btn btn-sm btn-primary">{{ __('Add Coupon') }}</a>
                            <a href="{{ route('coupons.export') }}" class="btn btn-sm btn-default">{{ __('Export to CSV') }}</a>
                            <a href="#" id="importCsvBtn" class="btn btn-sm btn-default">{{ __('Import from CSV') }}</a>
                            <input type="file" id="importCsvInput" accept=".csv" style="display:none;">
                            <div id="importProgress" class="progress" style="height: 20px; display:none; margin-top:10px;">
                              <div class="progress-bar" role="progressbar" style="width:0%">0%</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="couponsDataTable" class="table table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Coupon Id') }}</th>
                                <th>{{ __('Shop') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Value') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Used At') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- Pagination handled by DataTables -->
            </div>
        </div>
    </div>
</div>
@push('page-script')
<!-- Modal for duplicate handling -->
<div class="modal fade" id="duplicateModal" tabindex="-1" role="dialog" aria-labelledby="duplicateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="duplicateModalLabel">Duplicate Coupon Found</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="duplicateModalBody">
        <!-- Content injected by JS -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancelImport">Cancel</button>
        <button type="button" class="btn btn-warning" id="skipImport">Skip</button>
      </div>
    </div>
  </div>
</div>
<!-- DataTables Bootstrap 4 integration -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
$(function () {
  // Import CSV logic
  $('#importCsvBtn').on('click', function(e) {
    e.preventDefault();
    $('#importCsvInput').val('');
    $('#importCsvInput').click();
  });

  $('#importCsvInput').on('change', function() {
    var file = this.files[0];
    if (!file) return;
    var formData = new FormData();
    formData.append('csv', file);
    $('#importProgress').show();
    $('.progress-bar').css('width', '0%').text('0%');

    $.ajax({
      url: "{{ route('coupons.import') }}",
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data: formData,
      processData: false,
      contentType: false,
      xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(evt) {
          if (evt.lengthComputable) {
            var percent = Math.round((evt.loaded / evt.total) * 100);
            $('.progress-bar').css('width', percent + '%').text(percent + '%');
          }
        }, false);
        return xhr;
      },
      success: function(response) {
        $('#importProgress').hide();
        if (response.duplicates && response.duplicates.length > 0) {
          // Show duplicate modal
          var html = '<p>The following coupons are duplicates:</p><ul>';
          response.duplicates.forEach(function(m) {
            html += '<li>' + m.username + ' (' + m.email + ', ' + m.phone_number + ')</li>';
          });
          html += '</ul><p>Do you want to skip these and continue importing others?</p>';
          $('#duplicateModalBody').html(html);
          $('#duplicateModal').modal('show');
        } else {
          $('#couponsDataTable').DataTable().ajax.reload();
          alert('Import completed successfully!');
        }
      },
      error: function(xhr) {
        $('#importProgress').hide();
        alert('Import failed: ' + xhr.responseText);
      }
    });
  });

  $('#cancelImport').on('click', function() {
    $('#duplicateModal').modal('hide');
  });
  $('#skipImport').on('click', function() {
    // Send request to skip duplicates
    $.ajax({
      url: "{{ route('coupons.import') }}?skip=1",
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data: {},
      success: function() {
        $('#duplicateModal').modal('hide');
        $('#couponsDataTable').DataTable().ajax.reload();
        alert('Import completed, duplicates skipped.');
      },
      error: function(xhr) {
        alert('Import failed: ' + xhr.responseText);
      }
    });
  });
  $('#couponsDataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('coupons.search') }}",
      type: 'GET',
      error: function (xhr) {
        console.error('DataTables AJAX error:', xhr.status, xhr.responseText);
        alert('Failed to load coupons: ' + xhr.status + ' — check console for details.');
      }
    },
    columns: [
      { data: 'no', name: 'no' },
      { data: 'coupon_no', name: 'coupon_no' },
      { data: 'shop', name: 'shop' },
      { data: 'type', name: 'type' },
      { data: 'value', name: 'value' },
      { data: 'status', name: 'status' },
      { data: 'created_at', name: 'created_at' },
      { data: 'used_at', name: 'used_at' },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ],
    order: [[5, 'desc']],
    scrollX: true,
    bLengthChange: false,
    pagingType: 'simple_numbers',
    language: {
      paginate: {
        previous: '<i class="fas fa-angle-left"></i>',
        next: '<i class="fas fa-angle-right"></i>'
      }
    },
  });
});
</script>
@endpush
@endsection