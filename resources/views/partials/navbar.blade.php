<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <nav class="navbar-brand fw-bold">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/Logo_Universitas_Teuku_Umar.png') }}" alt="" width="30" height="30"
                    class="d-inline-block align-text-top">
                Universitas Teuku Umar
            </a>
        </div>
    </nav>
    <div class="container">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('panduan.index') }}">Panduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('chatbot.index') }}">ChatBot</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('engine.index') }}">Engine</a>
                    </li>
                @endauth
            </ul>

            @if (Auth::user())
                <form action="{{ route('logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button class="btn btn-primary" type="submit">Logout</button>
                </form>
            @else
                <button class="btn btn-primary" type="submit"
                    onclick="window.location.href='{{ route('login') }}'">Login</button>
            @endif
        </div>
    </div>
</nav>
