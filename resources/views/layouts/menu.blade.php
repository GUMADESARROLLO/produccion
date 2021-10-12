<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="index.html" class="b-brand mt-3">
                <img src="{{ asset('images/innova-blanco.png') }}" width="55%"><hr>
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>Menu</label>
                </li>
                @foreach ($menusComposer as $key => $item)
                    @if ($item["menu_id"] != 0)
                        @break
                    @endif
                    @include("layouts.menu-item", ["item" => $item])
                @endforeach
               <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><span class="pcoded-micon"><i class="feather icon-log-out"></i></span><span class="pcoded-mtext">Salir</span></a>
                </li>
            </ul>

        </div>
    </div>
</nav>

    