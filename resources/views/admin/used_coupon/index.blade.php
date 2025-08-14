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
                            <h3 class="mb-0">{{ __('Used Coupons') }}</h3>
                        </div>
                        <div class="col-6 text-right">
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
                    <table id="usedCouponDataTable" class="table table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Coupon No') }}</th>
                                <th>{{ __('Member') }}</th>
                                <th>{{ __('Shop') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Value') }}</th>
                                <th>{{ __('Used At') }}</th>
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
  // Import CSV logic

  $('#usedCouponDataTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ route('used_coupon.search') }}",
      type: 'GET',
      error: function (xhr) {
        console.error('DataTables AJAX error:', xhr.status, xhr.responseText);
        alert('Failed to load coupons: ' + xhr.status + ' — check console for details.');
      }
    },
    columns: [
      { data: 'no', name: 'no' },
      { data: 'coupon_no', name: 'coupon_no' },
      { data: 'member', name: 'member' },
      { data: 'shop', name: 'shop' },
      { data: 'type', name: 'type' },
      { data: 'value', name: 'value' },
      { data: 'used_at', name: 'used_at' },
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