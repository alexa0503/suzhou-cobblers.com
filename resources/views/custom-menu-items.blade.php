@foreach($items as $item)
  <li @if($item->hasChildren()) class="dropdown" @endif>
      <a href="{!! $item->url() !!}"@if($item->hasChildren()) class="dropdown-toggle" data-toggle="dropdown" @endif>{!! $item->title !!} @if($item->hasChildren())<b class="caret"></b>@endif</a>
      @if($item->hasChildren())
        <ul class="menu_level_1 dropdown-menu">
              @include('custom-menu-items', array('items' => $item->children()))
        </ul>
      @endif
  </li>
@endforeach
