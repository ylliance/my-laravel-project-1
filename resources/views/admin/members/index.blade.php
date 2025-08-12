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
                    <table id="dataTable" class="table table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Username') }}</th>
                                <th>{{ __('Phone number') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Last Login') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>{{ ($members->currentPage() - 1) * $members->perPage() + $loop->iteration }}</td>
                                <td>{{ $member->username }}</td>
                                <td>{{ $member->phone_number }}</td>
                                <td><a href="mailto:{{ $member->email}}">{{ $member->email }}</a></td>
                                <td>{{ $member->created_at }}</td>
                                <td>{{ $member->last_login }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="memberActions{{ $member->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ __('Actions') }}
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="memberActions{{ $member->id }}">
                                            <a class="dropdown-item" href="#">{{ __('Edit member') }}</a>
                                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">{{ __('Delete member') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
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