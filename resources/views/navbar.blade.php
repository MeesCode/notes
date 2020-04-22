
<nav class="navbar navbar-expand-md navbar-dark shadow-sm">

    <a class="navbar-brand cursor-pointer mr-auto" id="opensidebar">
        <i class="fa fa-bars mr-2"></i>
        {{ config('app.name') }}
    </a>

    <span class="navbar-nav ml-auto mr-auto w-25">
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
