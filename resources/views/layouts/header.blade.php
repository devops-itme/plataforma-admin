{{-- Header --}}
<div id="kt_header" class="header header-fixed ">

    {{-- Container --}}
    <div class="container-fluid d-flex align-items-center justify-content-between">

        {{-- Header Menu --}}
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div class="header-logo">
                <a href="#">
                    <img alt="Logo" style="object-fit: contain; width: 160px;"
                        src="{{ asset('img/logoME-03.png') }}" />
                </a>
            </div>
        </div>


        <div class="btn-group">
            <a href="#" class="btn btn-primary">Admin</a>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                 @csrf
             </form>
            </div>
        </div>
    </div>
</div>
