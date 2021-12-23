<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom sticky">
    <div class="container">
        <a class="navbar-brand logo" href="#">
            <i class="mdi mdi-chart-donut-variant"></i>
                Han Demo
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto" >
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Select2">Select2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Slider">Slider</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Editor">Editor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Popup">Popup</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Form">Form Validation</a>
                </li>
            </ul>
        </div>
        <div class="ml-5" id="userNav">
            @if(\Illuminate\Support\Facades\Auth::check())
                    <form action="{{ route('logout') }}" method="post" class="form-inline">
                        @csrf
                        <span class="mr-3"> Hi! {{ \Illuminate\Support\Facades\Auth::user()->name  }}</span>
                        <a class="btn btn-sm btn-outline-danger" href="{{route('admin.index')}}">後台</a>
                        <button class="nav-link btn btn-sm text-danger">登出</button>
                    </form>
            @else
                    <a class="nav-link" href="{{route('login')}}">登入</a>
            @endif
        </div>
        </div>
    </div>
</nav>
<!-- NAVBAR END-->
