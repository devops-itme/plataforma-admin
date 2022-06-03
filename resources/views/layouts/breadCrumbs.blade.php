<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color: transparent;">
       <li class="breadcrumb-item Active"><a href="/" style="color: #6f6f6f !important;">Inicio</a></li>
       @foreach (explode(".",request()->route()->getName()) as $item)
          @if ($item!="index")
             @if($item == "internationalOrders")
                <li class="breadcrumb-item active" {aria-current="page"}>  <a href="{{request()->segment(1)==$item?'/'.request()->segment(1):route('internationalOrders.index')}}" style="color: #6f6f6f !important;">{{__("Ordenes Internacionales")}}</a> </li>
                @elseif ($item!="internationalOrders")
                @if ($item == "shipments")
                <li class="breadcrumb-item active" {aria-current="page"}>  <a href="{{request()->segment(1)==$item?'/'.request()->segment(1):route('internationalOrders.index')}}" style="color: #6f6f6f !important;">{{__("Ordenes Internacionales")}}</a> </li>
                <li class="breadcrumb-item active" {aria-current="page"}>  <a href="javascript:history.back()" style="color: #6f6f6f !important;">{{__("Guias")}}</a> </li>
                @elseif ($item!="shipments")
                <li class="breadcrumb-item active" {aria-current="page"}>  <a href="{{request()->segment(1)==$item?'/'.request()->segment(1):'#'}}" style="color: #6f6f6f !important;">{{__("$item")}}</a> </li>
                @endif
             @else
             <li class="breadcrumb-item active" {aria-current="page"}>  <a href="{{request()->segment(1)==$item?'/'.request()->segment(1):'#'}}" style="color: #6f6f6f !important;">{{__("$item")}}</a> </li>
            @endif
          @endif
       @endforeach
    </ol>
 </nav>
