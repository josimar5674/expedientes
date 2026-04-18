<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema de Expedientes') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-black dark:text-white">

    <!-- HEADER -->
<header style="
    height:60px;
    background:#1e293b;
    color:white;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 20px;
    font-weight:bold;
">



    <!-- IZQUIERDA -->
    <div>
       <a href="{{ route('expedientes.index') }}" style="color:white; text-decoration:none;">
            Expedientes
        </a>
    </div>

    <!-- DERECHA (USUARIO) -->
<!-- DERECHA (USUARIO + MENÚ) -->
<div style="display:flex; align-items:center; gap:15px; position:relative;">

    <!-- 🌙 DARK MODE -->
    <button onclick="toggleDarkMode()" 
        style="background:#444; color:white; padding:5px 10px; border-radius:5px;">
        🌙
    </button>

    <!-- 🔐 SOLO ADMIN -->
    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('usuarios.index') }}" style="
                color:white;
                text-decoration:none;
                font-weight:normal;
            ">
                Gestión de usuarios
            </a>
        @endif
    @endauth

    <!-- 👤 USUARIO -->
    <span onclick="toggleMenu()" style="cursor:pointer;">
        {{ Auth::user()->name }} ▼
    </span>

    <!-- MENU -->
    <div id="menu-user" style="
        display:none;
        position:absolute;
        right:0;
        top:35px;
        background:white;
        color:black;
        border-radius:5px;
        min-width:150px;
        box-shadow:0 2px 8px rgba(0,0,0,0.2);
    ">
</div>
    </div>

</header>

    <!-- CONTENIDO -->
    <main style="
        min-height: calc(100vh - 60px);
    ">
        @yield('content')
    </main>

</body>
</html>


<script>
function toggleMenu() {
    let menu = document.getElementById('menu-user');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}
</script>

<script>
function toggleDarkMode() {
    const html = document.documentElement;

    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
}

// 🔄 Cargar preferencia al iniciar
(function () {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    }
})();
</script>