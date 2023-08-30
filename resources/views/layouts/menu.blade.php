<!--<nav class="pcoded-navbar">
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

               <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><span class="pcoded-micon"><i class="feather icon-log-out"></i></span><span class="pcoded-mtext">Salir</span></a>
                </li>
            </ul>

        </div>
    </div>
</nav>-->
<header>
    <nav id="menu_gral" class="navbar navbar-light m-0 p-0 nav-justified navbar-expand-md">
        <div class="container-fluid">

            <div class="col-2 text-left">
                <a href="#">
                    <img src="{{ asset('images/innova-blanco.png') }}" height="35" alt="image">
                </a>
            </div>

            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse-1" aria-controls="navbarNav6" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse justify-content-center navbar-collapse-1 collapse">
                <ul class="navbar-nav w-100 justify-content-center">
                    @foreach ($menusComposer as $key => $item)
                        @if ($item["menu_id"] != 0)
                            @break
                        @endif
                        @include("layouts.menu-item", ["item" => $item])
                    @endforeach
                </ul>
            </div>

            <div class="navbar-collapse justify-content-end col-md-2 navbar-collapse-1 collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit()">Salir
                            <span class="pcoded-micon ml-2">
                                <i class="feather icon-log-out"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

