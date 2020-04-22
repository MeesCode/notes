
<nav class="navbar navbar-expand-md navbar-dark shadow-sm">

    <a class="navbar-brand cursor-pointer mr-auto" id="opensidebar">
        <i class="fa fa-bars mr-2"></i>
        {{ config('app.name') }}
    </a>

    <span class="navbar-nav ml-auto mr-auto w-25">
        @auth
            <search></search>
        @endauth
    </span>

    <span class="navbar-nav ml-auto">
        @auth
            <create-from-poppup></create-from-poppup>
        @endauth
    </span>

</nav>
