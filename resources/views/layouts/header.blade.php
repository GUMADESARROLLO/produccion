<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
        <a href="index.html" class="b-brand">
            <div class="b-bg">
                <i class="feather icon-trending-up"></i>
            </div>
            <span class="b-title">Producción - INNOVA</span>
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="javascript:">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
        <li>
            <div class="page-header-title">
                <h5 class="m-b-10">Inicio</h5>
            </div>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li>
            <div class="dropdown">
                <a class="dropdown-toggle" href="javascript:" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
                <div class="dropdown-menu dropdown-menu-right notification">
                    <div class="noti-head">
                        <h6 class="d-inline-block m-b-0">Notificaciones</h6>
                    </div>
                    <ul class="noti-body">
                        <li class="notification">
                            <div class="media">
                                <img class="img-radius" src="{{ asset('images/user/avatar-1.jpg') }}">
                                <div class="media-body">
                                    <p><strong>F11</strong></p>
                                    <p>Nuevo pedido de C$ 2,328.57</p>
                                    <span class="n-time text-muted float-left mt-2"><i class="icon feather icon-calendar"></i> 01/11/2020 04:30 pm</span>
                                </div>
                            </div>
                        </li>
                        <li class="notification">
                            <div class="media">
                                <img class="img-radius" src="{{ asset('images/user/avatar-1.jpg') }}">
                                <div class="media-body">
                                    <p><strong>F11</strong></p>
                                    <p>Nuevo pedido de C$ 2,328.57</p>
                                    <span class="n-time text-muted float-left mt-2"><i class="icon feather icon-calendar"></i> 01/11/2020 04:30 pm</span>
                                </div>
                            </div>
                        </li>
                        <li class="notification">
                            <div class="media">
                                <img class="img-radius" src="{{ asset('images/user/avatar-1.jpg') }}">
                                <div class="media-body">
                                    <p><strong>F11</strong></p>
                                    <p>Nuevo pedido de C$ 2,328.57</p>
                                    <span class="n-time text-muted float-left mt-2"><i class="icon feather icon-calendar"></i> 01/11/2020 04:30 pm</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="noti-footer">
                        <a href="javascript:">Ver todas</a>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="dropdown drp-user">
                <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon feather icon-settings"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-notification">
                    <div class="pro-head">
                        <img src="{{ asset('images/user/avatar-1.jpg') }}" class="img-radius" alt="User-Profile-Image">
                        <span>John Doe</span>
                        <a href="auth-signin.html" class="dud-logout" title="Logout">
                            <i class="feather icon-log-out"></i>
                        </a>
                    </div>
                    <ul class="pro-body">
                        <li><a href="javascript:" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li>
                        <li><a href="javascript:" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                        <li><a href="message.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>
                        <li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</div>
</header>
