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
                            <a href="#" class="btn btn-sm btn-primary">{{ __('Add Member') }}</a>
                            <a href="#" class="btn btn-sm btn-default">{{ __('Export to CSV') }}</a>
                            <a href="#" class="btn btn-sm btn-default">{{ __('Import to CSV') }}</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Last Login') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>{{ ($members->currentPage() - 1) * $members->perPage() + $loop->iteration }}</td>
                                <td>{{ $member->username }}</td>
                                <td>{{ $member->created_at }}</td>
                                <td>{{ $member->last_login }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
