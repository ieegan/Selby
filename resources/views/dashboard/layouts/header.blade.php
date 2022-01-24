<nav class="navbar is-expanded has-shadow is-spaced is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand" style="justify-content: center">
            <a class="navbar-item logo" href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarExpanded">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbarExpanded" class="navbar-menu">
            <div class="navbar-start">
                @hasanyrole('admin|supervisor')
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Users
                    </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="{{ route('user.create') }}">
                            Create new
                        </a>
                        <a class="navbar-item" href="{{ route('user.index') }}">
                            All Users
                        </a>
                    </div>
                </div>
                @endhasanyrole
                <div class="navbar-item has-dropdown is-hoverable is-hidden-desktop">
                    <a class="navbar-link">
                        {{ auth()->user()->name }}
                    </a>
                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-end is-hidden-touch">
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    {{ auth()->user()->name }}
                </a>
                <div class="navbar-dropdown">
                    <a class="navbar-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
