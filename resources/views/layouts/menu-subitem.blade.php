@if ($item["submenu"] == [])
    <li class="">
        <a href="{{url($item['url'])}}" class="nav-link active">{{$item['nombre']}}</a>
    </li>
@else
    <li class="nav-item pcoded-hasmenu">
        <a href="javascript:" class="nav-link active">
            <span class="pcoded-mtext">{{$item['nombre']}}</span></a>
        </a>
        <ul class="pcoded-submenu">
            @foreach ($item["submenu"] as $submenu)
                @include("layouts.menu-subitem", ["item" => $submenu])
            @endforeach
        </ul>
    </li>
@endif