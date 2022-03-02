<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color: transparent;">
        <li class="breadcrumb-item Active"><a href="/" style="color: #6f6f6f !important;">Inicio</a></li>
        @foreach (explode(".",request()->route()->getName()) as $item)
            @if ($item!="index")
                @if(request()->route()->parameters && count(request()->route()->parameters) > 1)
                    @foreach(request()->route()->parameters as $key)
                        <li class="breadcrumb-item active" aria-current="page" > <a href="{{ucfirst(request()->segment(1))==__("$item")?'/'.request()->segment(1).'/'.$key:'#'}}" style="color: #6f6f6f !important;">{{__("$item")}}</a> </li>
                        @break
                    @endforeach
                @else
                    <li class="breadcrumb-item active" aria-current="page"> <a href="{{ucfirst(request()->segment(1))==__("$item")?'/'.request()->segment(1):'#'}}" style="color: #6f6f6f !important;">{{__("$item")}}</a> </li>
                @endif
                {{request()->segment(1)}}
                {{-- {{__("$item")}} --}}
            @endif
        @endforeach
    </ol>
</nav>
