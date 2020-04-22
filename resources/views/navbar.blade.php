
<nav class="navbar navbar-expand-md navbar-dark shadow-sm">

    <sidebar-toggle appname="{{ config('app.name') }}"></sidebar-toggle>

    <span class="search-nav navbar-nav ml-auto mr-auto w-25">
        @auth
            @if($toggles)
                <search></search>
            @endif
        @endauth
    </span>

    <span class="navbar-nav ml-auto">
        @auth
            @if($toggles)
                <create-from-poppup></create-from-poppup>
            @endif
        @endauth
    </span>

</nav>
