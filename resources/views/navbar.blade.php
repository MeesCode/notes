
<nav class="navbar navbar-expand-md navbar-dark shadow-sm">

    <a class="navbar-brand cursor-pointer" id="opensidebar">
        <i class="fa fa-bars mr-2"></i>
        {{ config('app.name') }}
    </a>

    <ul class="navbar-nav ml-auto">
        @auth
            <li class="nav-item navbar-brand">
                <create-from-poppup></create-from-poppup>
            </li>
        @endauth
    </ul>

</nav>
