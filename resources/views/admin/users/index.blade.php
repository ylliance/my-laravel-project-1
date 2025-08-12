@extends('layouts.app')

@section('content')
@include('layouts.headers.header',
array(
'class'=>'info',
'title'=>"Users",'description'=>'',
'icon'=>'fas fa-home',
'breadcrumb'=>array([
'text'=>'User List'
])))
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Users') }}</h3>
                        </div>
                        @can('user_create')
                        <div class="col-4 text-right">
                            <a href="{{ route('users.create') }}"
                                class="btn btn-sm btn-primary">{{ __('Add User') }}</a>
                        </div>
                        @endcan
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
                                <th>#</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Role')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $user->name}}</td>
                                <td> <a href="mailto:{{ $user->email}}">{{ $user->email}}</a></td>
                                <td>
                                    @forelse ($user->roles as $roles)
                                    <span class="badge   badge-primary  m-1">{{$roles->title}}</span>
                                    @empty
                                    <span class="badge   badge-warning  m-1">{{__('No Data')}}</span>
                                    @endforelse
                                </td>
                                <td class="d-flex">



                                    @can('user_edit')
                                    <a class="btn btn-outline-info btn-icon m-1 btn-sm"
                                        href="{{ route('users.edit', $user->id) }}">
                                        <span class="ul-btn__icon"><i class="fas fa-pencil-alt"></i></span>
                                    </a>
                                    @endcan
                                    @can('user_delete')
                                    @if (Auth::user()->id !== $user->id)
                                    <form action="{{ route('users.destroy', $user) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-outline-danger btn-icon m-1 btn-sm"
                                            onclick="confirm('{{ __("Are you sure you want to delete this?") }}') ? this.parentElement.submit() : ''">
                                            <span class="ul-btn__icon"><i class="far fa-trash-alt"></i></span>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
