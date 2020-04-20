<nav id="sidebar" class="">
    <ul class="list-unstyled components">

        @auth
            <li class="nav-item">
                
                <a href="{{ route('dashboard') }}">
                    <i class="mr-2 fa fa-sticky-note"></i>
                    notes
                </a>
            </li>

            <li class="nav-item">
                
                <a href="{{ route('archived') }}">
                    <i class="mr-2 fa fa-archive"></i>
                    archive
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('apiDetails') }}">
                    <i class="mr-2 fa fa-cog"></i>
                    api details
                </a>
            </li>
            
            <li class="nav-item">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <i class="mr-2 fa fa-sign-out"></i>
                    {{ __('Logout') }}
                </a>

                <form style="display: none;" id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </li>
        @else
            <li class="nav-item">
                
                <a href="{{ route('login') }}">
                    <i class="mr-2 fa fa-sign-in"></i>
                    {{ __('Login') }}
                </a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    
                    <a href="{{ route('register') }}">
                        <i class="mr-2 fa fa-user"></i>
                        {{ __('Register') }}
                    </a>
                </li>
            @endif
        @endauth

    </ul>
    
</nav>