@if ($item["submenu"] == [])
    <li class="nav-item">
        <a href="{{url($item['url'])}}" class="nav-link">
            <span class="pcoded-micon"><i class="feather {{$item['icono']}}"></i></span>
            <span class="pcoded-mtext">{{$item['nombre']}}</span>
        </a>
    </li>
@else
    <li class="nav-item pcoded-hasmenu">
        <a href="javascript:" class="nav-link">
            <span class="pcoded-micon"><i class="feather {{$item['icono']}}"></i></span>
            <span class="pcoded-mtext">{{$item['nombre']}}</span>
        </a>
        <ul class="pcoded-submenu">
            @foreach ($item["submenu"] as $submenu)
                @include("layouts.menu-subitem", ["item" => $submenu])
            @endforeach
        </ul>
    </li>
@endif