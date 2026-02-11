<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DriveHire — Automotive & Industrial ATS')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-primary: #0a0e17;
            --bg-secondary: #111827;
            --bg-card: #1a2332;
            --bg-card-hover: #1f2b3d;
            --bg-elevated: #243044;
            --border: #2a3a50;
            --border-subtle: #1e2d42;
            --text-primary: #f0f4f8;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --accent-glow: rgba(59, 130, 246, 0.15);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #8b5cf6;
            --orange: #f97316;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .font-display { font-family: 'Space Grotesk', sans-serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

        /* Layout */
        .page-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-subtle);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 40;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .sidebar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--accent), #1d4ed8);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .sidebar-brand .brand-tag {
            font-size: 0.65rem;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
        }

        .sidebar-nav { padding: 1rem 0; flex: 1; overflow-y: auto; }

        .nav-section {
            padding: 0.5rem 1.5rem 0.25rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            font-weight: 600;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            border-left: 2px solid transparent;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: var(--bg-card);
        }

        .nav-link.active {
            color: var(--accent);
            background: var(--accent-glow);
            border-left-color: var(--accent);
        }

        .nav-link svg { width: 18px; height: 18px; opacity: 0.7; flex-shrink: 0; }
        .nav-link.active svg { opacity: 1; }

        .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: white;
            font-size: 0.7rem;
            padding: 0.1rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Main content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
        }

        .topbar {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-subtle);
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 30;
            backdrop-filter: blur(8px);
        }

        .topbar-left { display: flex; align-items: center; gap: 1rem; }

        .topbar h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .topbar-breadcrumb a { color: var(--text-muted); text-decoration: none; }
        .topbar-breadcrumb a:hover { color: var(--accent); }

        .topbar-actions { display: flex; align-items: center; gap: 0.75rem; }

        .content-area { padding: 1.5rem 2rem 3rem; }

        /* Cards */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 {
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Space Grotesk', sans-serif;
        }

        .card-body { padding: 1.25rem; }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
        }

        .stat-card.blue::before { background: var(--accent); }
        .stat-card.green::before { background: var(--success); }
        .stat-card.orange::before { background: var(--orange); }
        .stat-card.purple::before { background: var(--info); }
        .stat-card.amber::before { background: var(--warning); }
        .stat-card.red::before { background: var(--danger); }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        .stat-icon.blue { background: rgba(59, 130, 246, 0.15); color: var(--accent); }
        .stat-icon.green { background: rgba(16, 185, 129, 0.15); color: var(--success); }
        .stat-icon.orange { background: rgba(249, 115, 22, 0.15); color: var(--orange); }
        .stat-icon.purple { background: rgba(139, 92, 246, 0.15); color: var(--info); }
        .stat-icon.amber { background: rgba(245, 158, 11, 0.15); color: var(--warning); }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn svg { width: 16px; height: 16px; }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            box-shadow: 0 0 20px var(--accent-glow);
        }

        .btn-secondary {
            background: var(--bg-elevated);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg-card-hover);
            color: var(--text-primary);
        }

        .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.8rem; border-radius: 6px; }
        .btn-xs { padding: 0.2rem 0.5rem; font-size: 0.7rem; border-radius: 5px; }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
        }
        .btn-ghost:hover { background: var(--bg-elevated); color: var(--text-primary); }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.15rem 0.6rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .badge-blue { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .badge-indigo { background: rgba(99,102,241,0.15); color: #818cf8; }
        .badge-violet { background: rgba(139,92,246,0.15); color: #a78bfa; }
        .badge-amber { background: rgba(245,158,11,0.15); color: #fbbf24; }
        .badge-emerald { background: rgba(16,185,129,0.15); color: #34d399; }
        .badge-green { background: rgba(34,197,94,0.15); color: #4ade80; }
        .badge-red { background: rgba(239,68,68,0.15); color: #f87171; }
        .badge-slate { background: rgba(100,116,139,0.15); color: #94a3b8; }
        .badge-orange { background: rgba(249,115,22,0.15); color: #fb923c; }

        /* Pipeline columns */
        .pipeline-board {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            padding-bottom: 1rem;
        }

        .pipeline-column {
            min-width: 260px;
            flex: 1;
            background: var(--bg-secondary);
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            max-height: 600px;
        }

        .pipeline-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .pipeline-header h4 {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .pipeline-count {
            background: var(--bg-elevated);
            padding: 0.1rem 0.5rem;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .pipeline-cards {
            padding: 0.5rem;
            overflow-y: auto;
            flex: 1;
        }

        .pipeline-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .pipeline-card:hover {
            border-color: var(--accent);
            background: var(--bg-card-hover);
        }

        .pipeline-card .card-name {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .pipeline-card .card-role {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .pipeline-card .card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .match-score {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .match-score.high { color: var(--success); }
        .match-score.medium { color: var(--warning); }
        .match-score.low { color: var(--danger); }

        /* Avatar */
        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .avatar-sm { width: 28px; height: 28px; font-size: 0.65rem; border-radius: 6px; }
        .avatar-lg { width: 48px; height: 48px; font-size: 1rem; border-radius: 10px; }

        .avatar-blue { background: rgba(59,130,246,0.2); color: #60a5fa; }
        .avatar-green { background: rgba(16,185,129,0.2); color: #34d399; }
        .avatar-purple { background: rgba(139,92,246,0.2); color: #a78bfa; }
        .avatar-orange { background: rgba(249,115,22,0.2); color: #fb923c; }
        .avatar-red { background: rgba(239,68,68,0.2); color: #f87171; }

        /* Table */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 1px solid var(--border-subtle);
        }
        .data-table td {
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            border-bottom: 1px solid var(--border-subtle);
            vertical-align: middle;
        }
        .data-table tr:hover td { background: var(--bg-card-hover); }
        .data-table tr:last-child td { border-bottom: none; }

        /* Forms */
        .form-group { margin-bottom: 1rem; }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.35rem;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.6rem 0.85rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 0.85rem;
            font-family: inherit;
            transition: border-color 0.15s ease;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .form-textarea { resize: vertical; min-height: 100px; }
        .form-select { cursor: pointer; }

        /* Grid */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; }

        /* Activity feed */
        .activity-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-subtle);
        }
        .activity-item:last-child { border-bottom: none; }
        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-top: 0.4rem;
            flex-shrink: 0;
        }
        .activity-text { font-size: 0.8rem; color: var(--text-secondary); line-height: 1.5; }
        .activity-time { font-size: 0.7rem; color: var(--text-muted); margin-top: 0.15rem; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--text-muted);
        }
        .empty-state svg { width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.3; }

        /* Reveal animations */
        body.gsap-ready .reveal { visibility: hidden; }

        /* Mobile toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            padding: 0.5rem;
        }

        /* Tag/chip */
        .tag {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.5rem;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 0.7rem;
            color: var(--text-secondary);
            margin: 0.15rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: block; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .pipeline-board { flex-direction: column; }
            .pipeline-column { min-width: auto; max-height: 300px; }
        }

        @media (max-width: 640px) {
            .content-area { padding: 1rem; }
            .topbar { padding: 0.75rem 1rem; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
    @yield('styles')
</head>
<body x-data="{ sidebarOpen: false }">
    @yield('body')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        gsap.registerPlugin(ScrollTrigger);
        document.body.classList.add('gsap-ready');

        document.querySelectorAll('.reveal').forEach(function(el) {
            var rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight) {
                gsap.fromTo(el, { autoAlpha: 0, y: 16 }, { autoAlpha: 1, y: 0, duration: 0.5, ease: 'power2.out' });
            } else {
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top 90%',
                    once: true,
                    onEnter: function() {
                        gsap.fromTo(el, { autoAlpha: 0, y: 16 }, { autoAlpha: 1, y: 0, duration: 0.5, ease: 'power2.out' });
                    }
                });
            }
        });
    });
    </script>
    @yield('scripts')
</body>
</html>
