<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color: transparent;">
        <li class="breadcrumb-item Active"><a href="/" style="color: #6f6f6f !important;">Inicio</a></li>
        @foreach (explode(".",request()->route()->getName()) as $item)
            @if ($item!="index")
                <li class="breadcrumb-item active" {aria-current="page" }> <a href="{{ucfirst(request()->segment(1))==__("$item")?'/'.request()->segment(1):'#'}}" style="color: #6f6f6f !important;">{{__("$item")}}</a> </li>
            @endif
        @endforeach
    </ol>
</nav>
