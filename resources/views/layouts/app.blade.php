<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>YPExam</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sidebar {
            transition: width 0.3s ease;
        }

        .sidebar-label {
            transition: opacity 0.2s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-item {
            transition: background 0.15s, color 0.15s;
        }

        .nav-item:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .nav-item.active {
            background: #eff6ff;
            color: #2563eb;
        }

        .avatar-btn:focus {
            outline: none;
        }

        .dropdown {
            display: none;
            transform-origin: top right;
            animation: dropIn 0.15s ease forwards;
        }

        .dropdown.open {
            display: block;
        }

        @keyframes dropIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-4px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .bar {
            transition: background 0.2s;
        }

        .bar:hover {
            background: #2563eb !important;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 flex h-screen overflow-hidden">

    <!-- ===================== SIDEBAR ===================== -->
    @include('layouts.sidebar')

    <!-- ===================== MAIN ===================== -->
    <div class="flex flex-col flex-1 overflow-hidden">

        <!-- Topbar -->
        @include('layouts.navigation')

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto p-6 bg-slate-50">
            {{ $slot }}
        </main>
    </div>

    <script>
        let collapsed = false;

        function toggleSidebar() {
            collapsed = !collapsed;
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('toggle-icon');
            const labels = document.querySelectorAll('.sidebar-label');

            sidebar.style.width = collapsed ? '72px' : '240px';
            icon.style.transform = collapsed ? 'rotate(180deg)' : 'rotate(0deg)';

            labels.forEach(el => {
                el.style.opacity = collapsed ? '0' : '1';
                el.style.maxWidth = collapsed ? '0' : '200px';
                el.style.pointerEvents = collapsed ? 'none' : '';
            });
        }

        function toggleDropdown() {
            document.getElementById('avatar-dropdown').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('avatar-dropdown');
            const btn = document.querySelector('.avatar-btn');
            if (btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
