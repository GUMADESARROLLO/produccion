@if ($item["submenu"] == [])
<li class="dd-item dd3-item" data-id="{{$item["id"]}}">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content {{$item["url"] == "javascript:;" ? "font-weight-bold" : ""}}">
        <a href="#!">{{ $item["nombre"] . " | Url -> " . $item["url"]}}</a>
    </div>
</li>
@else
<li class="dd-item dd3-item" data-id="{{$item["id"]}}">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content {{$item["url"] == "javascript:;" ? "font-weight-bold" : ""}}">
        <a href="#!">{{ $item["nombre"] . " | Url -> " . $item["url"]}}</a>
    </div>
    <ol class="dd-list">
        @foreach ($item["submenu"] as $submenu)
        @include("Admin.Menu.menu-item",[ "item" => $submenu ])
        @endforeach
    </ol>
</li>
@endif