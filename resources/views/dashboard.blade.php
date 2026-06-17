<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard Divisi IT</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: #f3f4f6;
            color: #111827;
            font-family: Arial, Helvetica, sans-serif;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            padding: 28px 20px;
            background: #111827;
            color: #ffffff;
        }

        .sidebar h1 {
            margin-bottom: 8px;
            font-size: 22px;
        }

        .sidebar p {
            margin-bottom: 35px;
            color: #9ca3af;
            font-size: 13px;
        }

        .menu a {
            display: block;
            margin-bottom: 10px;
            padding: 12px 14px;
            border-radius: 8px;
            color: #d1d5db;
            text-decoration: none;
        }

        .menu a.active,
        .menu a:hover {
            background: #2563eb;
            color: #ffffff;
        }

        .main {
            flex: 1;
            padding: 32px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .header h2 {
            margin-bottom: 6px;
            font-size: 28px;
        }

        .header p {
            color: #6b7280;
        }

        .server-status {
            padding: 10px 14px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 13px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .card {
            padding: 22px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .card span {
            display: block;
            margin-bottom: 12px;
            color: #6b7280;
            font-size: 13px;
        }

        .card strong {
            font-size: 30px;
        }

        .blue {
            color: #2563eb;
        }

        .yellow {
            color: #ca8a04;
        }

        .orange {
            color: #ea580c;
        }

        .green {
            color: #16a34a;
        }

        footer {
            margin-top: 28px;
            color: #6b7280;
            font-size: 13px;
            text-align: center;
        }

        @media (max-width: 1000px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 720px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
            }

            .main {
                padding: 20px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="layout">
        <aside class="sidebar">
            <h1>IT SUPPORT</h1>

            <p>Dashboard Divisi IT</p>

            <nav class="menu">
                <a
                    href="/dashboard"
                    class="active"
                >
                    Dashboard
                </a>
            </nav>
        </aside>

        <main class="main">
            <header class="header">
                <div>
                    <h2>Dashboard Divisi IT</h2>

                    <p>
                        Monitoring aktivitas dan layanan Divisi IT
                    </p>
                </div>

                <div class="server-status">
                    Laravel Aktif
                </div>
            </header>

            <section class="cards">
                <article class="card">
                    <span>Total Aktivitas</span>

                    <strong class="blue">
                        {{ $statistics['total'] }}
                    </strong>
                </article>

                <article class="card">
                    <span>Aktivitas Baru</span>

                    <strong class="yellow">
                        {{ $statistics['new'] }}
                    </strong>
                </article>

                <article class="card">
                    <span>Sedang Diproses</span>

                    <strong class="orange">
                        {{ $statistics['process'] }}
                    </strong>
                </article>

                <article class="card">
                    <span>Aktivitas Selesai</span>

                    <strong class="green">
                        {{ $statistics['completed'] }}
                    </strong>
                </article>
            </section>

            <footer>
                IT Support Dashboard · agachi_alvin
            </footer>
        </main>
    </div>
</body>
</html> 