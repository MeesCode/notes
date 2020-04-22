<nav id="sidebar" class="">
    <ul class="list-unstyled components">

        @auth

            @if($toggles)
                <li class="nav-item divider mt-3">toggles</li>
            
                <toggles></toggles>
            @endif

            <li class="nav-item divider mt-3">pages</li>

            <li class="nav-item">
                <a href="{{ route('dashboard') }}">
                    <i class="mr-2 fa fa-cog"></i>
                    notes
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('apiDetails') }}">
                    <i class="mr-2 fa fa-cog"></i>
                    api details
                </a>
            </li>

            <li class="nav-item divider mt-3">actions</li>
            
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