<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Dashboard - IT Support</title>

    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --primary: #2563eb;
            --primary-soft: #dbeafe;
            --success: #16a34a;
            --warning: #ca8a04;
            --danger: #dc2626;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        body.dark {
            --bg: #020617;
            --card: #0f172a;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --border: #1e293b;
            --primary: #60a5fa;
            --primary-soft: rgba(37, 99, 235, 0.18);
            --success: #4ade80;
            --warning: #facc15;
            --danger: #f87171;
            --shadow: 0 18px 45px rgba(0, 0, 0, 0.35);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            transition: background 0.25s ease, color 0.25s ease;
        }

        .layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            padding: 24px;
            background: var(--card);
            border-right: 1px solid var(--border);
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: var(--primary);
            color: #ffffff;
            font-weight: 800;
        }

        .brand-text strong {
            display: block;
            font-size: 17px;
        }

        .brand-text span {
            color: var(--muted);
            font-size: 13px;
        }

        .nav {
            display: grid;
            gap: 10px;
        }

        .nav a,
        .logout-button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            min-height: 44px;
            padding: 0 14px;
            border: 0;
            border-radius: 12px;
            background: transparent;
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .nav a.active {
            background: var(--primary-soft);
            color: var(--primary);
            font-weight: 700;
        }

        .logout-button {
            margin-top: 20px;
            color: var(--danger);
            font-weight: 700;
        }

        .main {
            padding: 28px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
        }

        .page-title h1 {
            margin: 0 0 6px;
            font-size: 30px;
        }

        .page-title p {
            margin: 0;
            color: var(--muted);
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toggle-dark,
        .refresh-button {
            min-height: 42px;
            padding: 0 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--card);
            color: var(--text);
            cursor: pointer;
            font-weight: 700;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--card);
            box-shadow: var(--shadow);
        }

        .stat-label {
            margin-bottom: 10px;
            color: var(--muted);
            font-size: 13px;
        }

        .stat-value {
            font-size: 30px;
            font-weight: 800;
        }

        .content-card {
            border: 1px solid var(--border);
            border-radius: 20px;
            background: var(--card);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 22px 24px;
            border-bottom: 1px solid var(--border);
        }

        .card-header h2 {
            margin: 0;
            font-size: 20px;
        }

        .card-header span {
            color: var(--muted);
            font-size: 13px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th,
        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-size: 14px;
        }

        th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td strong {
            display: block;
            margin-bottom: 4px;
        }

        td small {
            color: var(--muted);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge.open {
            background: rgba(37, 99, 235, 0.14);
            color: var(--primary);
        }

        .badge.in_progress {
            background: rgba(202, 138, 4, 0.14);
            color: var(--warning);
        }

        .badge.resolved,
        .badge.closed {
            background: rgba(22, 163, 74, 0.14);
            color: var(--success);
        }

        .badge.urgent,
        .badge.high {
            background: rgba(220, 38, 38, 0.14);
            color: var(--danger);
        }

        .badge.medium {
            background: rgba(202, 138, 4, 0.14);
            color: var(--warning);
        }

        .badge.low {
            background: rgba(22, 163, 74, 0.14);
            color: var(--success);
        }

        .state {
            display: none;
            padding: 50px 24px;
            text-align: center;
        }

        .state.active {
            display: block;
        }

        .state-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 18px;
            border-radius: 22px;
            display: grid;
            place-items: center;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 28px;
        }

        .state h3 {
            margin: 0 0 8px;
            font-size: 22px;
        }

        .state p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .spinner {
            width: 44px;
            height: 44px;
            margin: 0 auto 18px;
            border: 4px solid var(--border);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .mobile-menu {
            display: none;
            min-height: 42px;
            padding: 0 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--card);
            color: var(--text);
            cursor: pointer;
            font-weight: 700;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 820px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
                position: fixed;
                z-index: 20;
                left: 0;
                top: 0;
                width: 270px;
                height: 100vh;
                box-shadow: var(--shadow);
            }

            .sidebar.show {
                display: block;
            }

            .main {
                padding: 18px;
            }

            .mobile-menu {
                display: inline-flex;
                align-items: center;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .top-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            .toggle-dark,
            .refresh-button,
            .mobile-menu {
                flex: 1;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .page-title h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="layout">
        <aside
            class="sidebar"
            id="sidebar"
        >
            <div class="brand">
                <div class="brand-icon">
                    IT
                </div>

                <div class="brand-text">
                    <strong>IT Support</strong>
                    <span>Admin Panel</span>
                </div>
            </div>

            <nav class="nav">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="active"
                >
                    Dashboard
                </a>
            </nav>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    class="logout-button"
                    type="submit"
                >
                    Logout
                </button>
            </form>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="page-title">
                    <h1>Dashboard Admin</h1>

                    <p>
                        Monitoring ticket IT Support secara ringkas dan responsif.
                    </p>
                </div>

                <div class="top-actions">
                    <button
                        class="mobile-menu"
                        type="button"
                        onclick="toggleSidebar()"
                    >
                        Menu
                    </button>

                    <button
                        class="refresh-button"
                        type="button"
                        onclick="simulateReload()"
                    >
                        Refresh
                    </button>

                    <button
                        class="toggle-dark"
                        type="button"
                        onclick="toggleDarkMode()"
                    >
                        Dark Mode
                    </button>
                </div>
            </header>

            <section class="stats">
                <article class="stat-card">
                    <div class="stat-label">Total Ticket</div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                </article>

                <article class="stat-card">
                    <div class="stat-label">Open</div>
                    <div class="stat-value">{{ $stats['open'] ?? 0 }}</div>
                </article>

                <article class="stat-card">
                    <div class="stat-label">In Progress</div>
                    <div class="stat-value">{{ $stats['in_progress'] ?? 0 }}</div>
                </article>

                <article class="stat-card">
                    <div class="stat-label">Resolved</div>
                    <div class="stat-value">{{ $stats['resolved'] ?? 0 }}</div>
                </article>

                <article class="stat-card">
                    <div class="stat-label">Urgent</div>
                    <div class="stat-value">{{ $stats['urgent'] ?? 0 }}</div>
                </article>
            </section>

            <section class="content-card">
                <div class="card-header">
                    <div>
                        <h2>Ticket Terbaru</h2>
                        <span>Data terbaru dari sistem ticket IT Support</span>
                    </div>
                </div>

                <div
                    class="state"
                    id="loadingState"
                >
                    <div class="spinner"></div>

                    <h3>Memuat data</h3>

                    <p>
                        Sistem sedang mengambil data ticket terbaru.
                    </p>
                </div>

                @if ($hasError)
                    <div class="state active">
                        <div class="state-icon">!</div>

                        <h3>Error State</h3>

                        <p>
                            {{ $errorMessage }}
                        </p>
                    </div>
                @elseif ($tickets->isEmpty())
                    <div class="state active">
                        <div class="state-icon">0</div>

                        <h3>Empty State</h3>

                        <p>
                            Belum ada ticket yang masuk. Data akan tampil otomatis setelah ticket dibuat.
                        </p>
                    </div>
                @else
                    <div
                        class="table-wrapper"
                        id="ticketTable"
                    >
                        <table>
                            <thead>
                                <tr>
                                    <th>Ticket</th>
                                    <th>Kategori</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Pelapor</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>
                                            <strong>{{ $ticket->title }}</strong>
                                            <small>{{ $ticket->description ?: 'Tidak ada deskripsi' }}</small>
                                        </td>

                                        <td>
                                            {{ ucfirst($ticket->category) }}
                                        </td>

                                        <td>
                                            <span class="badge {{ $ticket->priority }}">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge {{ $ticket->status }}">
                                                {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <strong>{{ $ticket->requester_name }}</strong>
                                            <small>{{ $ticket->requester_email }}</small>
                                        </td>

                                        <td>
                                            {{ $ticket->created_at?->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </main>
    </div>

    <script>
        const body = document.body;
        const sidebar = document.getElementById('sidebar');
        const loadingState = document.getElementById('loadingState');
        const ticketTable = document.getElementById('ticketTable');

        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark');
        }

        function toggleDarkMode() {
            body.classList.toggle('dark');

            localStorage.setItem(
                'theme',
                body.classList.contains('dark') ? 'dark' : 'light'
            );
        }

        function toggleSidebar() {
            sidebar.classList.toggle('show');
        }

        function simulateReload() {
            if (!loadingState) {
                return;
            }

            if (ticketTable) {
                ticketTable.style.display = 'none';
            }

            loadingState.classList.add('active');

            setTimeout(() => {
                loadingState.classList.remove('active');

                if (ticketTable) {
                    ticketTable.style.display = 'block';
                }
            }, 900);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth > 820) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>