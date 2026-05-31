<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>🧴 Kasir Parfum</title>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef2ff;
            overflow: hidden;
        }

        .main-layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* CONTENT AREA */
        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 25px;
            background: #eef2ff;
        }

        .page-wrapper {
            width: 100%;
        }

        .content-card {
            background: white;
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(79,70,229,.08);
            border: 1px solid #e5e7eb;
            min-height: calc(100vh - 50px);
        }

        /* TABLE */
        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 20px;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .content-area {
                padding: 15px;
            }

            .content-card {
                padding: 20px;
                border-radius: 20px;
            }
        }
    </style>

</head>

<body>

<div class="main-layout">

    {{-- SIDEBAR --}}
    @include('layouts.navigation')

    {{-- CONTENT --}}
    <main class="content-area">

        <div class="page-wrapper">

            <div class="content-card">

                @yield('content')

            </div>

        </div>

    </main>

</div>

</body>
</html>