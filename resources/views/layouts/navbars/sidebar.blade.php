<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <!-- <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span> -->
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
     
        <!-- Navigation -->
        <ul class="navbar-nav">
            <h6 class="navbar-heading text-muted "></h6>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="ni ni-tv-2 text-blue"></i> {{ __('Home') }}
                </a>
            </li>

            @can('role_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('roles.index')}}">
                    <i class="far fa-id-badge text-blue"></i> {{ __('Role') }}
                </a>
            </li>
            @endcan
            @can('user_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('users.index')}}">
                    <i class="far fa-user text-blue"></i> {{ __('User') }}
                </a>
            </li>
            @endcan
            @can('member_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('members.index')}}">
                    <i class="fas fa-users text-blue"></i> {{ __('Member') }}
                </a>
            </li>
            @endcan
            @can('coupon_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('coupon.index')}}">
                    <i class="fas fa-ticket-alt text-blue"></i> {{ __('Coupon') }}
                </a>
            </li>
            @endcan
            @can('redeem_treasure_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('redeem.treasure')}}">
                    <i class="fas fa-gem text-blue"></i> {{ __('Redeem Stamp') }}
                </a>
            </li>
            @endcan
            @can('redeem_coupon_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('redeem.coupon')}}">
                    <i class="fas fa-gift text-blue"></i> {{ __('Redeem Coupon') }}
                </a>
            </li>
            @endcan
            @can('redeem_coupon_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('used_coupon.index')}}">
                    <i class="fas fa-eye-slash text-blue"></i> {{ __('Used Coupon') }}
                </a>
            </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="ni ni-user-run text-blue"></i> {{ __('Sign out') }}
                </a>
            </li>

        </ul>
        <!-- Divider -->
        <hr class="my-3">
   
    </div>
    </div>
</nav>
