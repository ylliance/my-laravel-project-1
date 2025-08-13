@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Members",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'Member List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0">{{ __('Members') }}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('members.create') }}" class="btn btn-sm btn-primary">{{ __('Add Member') }}</a>
                            <a href="#" class="btn btn-sm btn-default">{{ __('Export to CSV') }}</a>
                            <a href="#" class="btn btn-sm btn-default">{{ __('Import to CSV') }}</a>
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
                    <table id="membersDataTable" class="table table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Phone number') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Stamps') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Last Login') }}</th>
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
<!-- DataTables Bootstrap 4 integration -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
$(function () {
  $('#membersDataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('members.search') }}",
      type: 'GET',
      error: function (xhr) {
        console.error('DataTables AJAX error:', xhr.status, xhr.responseText);
        alert('Failed to load members: ' + xhr.status + ' — check console for details.');
      }
    },
    columns: [
      { data: 'no', name: 'no' },
      { data: 'username', name: 'username' },
      { data: 'phone_number', name: 'phone_number' },
      { data: 'email', name: 'email' },
      {
        data: 'stamps',
        name: 'stamps',
        render: function(data, type, row) {
          // data is an array of stamp objects
          if (!Array.isArray(data) || data.length === 0) return '';
          var html = '<div style="display:flex;">';
            data.forEach(function(stamp) {
            // Use moment.js to format datetime
            var formatted = stamp.created_at ? moment(stamp.created_at).format('YYYY-MM-DD HH:mm:ss') : '';
            html += '<img src="/argon/img/stamp.png" alt="stamp" style="height:32px;margin-right:4px;" title="' + formatted + '">';
          });
          html += '</div>';
          return html;
        },
        orderable: false,
        searchable: false
      },
      { data: 'created_at', name: 'created_at' },
      { data: 'last_login', name: 'last_login' },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ],
    order: [[4, 'desc']],
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

  $('#member-search').on('keyup', function () {
    var table = $('#membersDataTable').DataTable();
    table.search($(this).val()).draw();
  });
});
</script>
@endpush
@endsection