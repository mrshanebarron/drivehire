<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: transparent;
            color: #1a1a2e;
        }
        .widget {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            max-width: 400px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .widget-header {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 1rem 1.25rem;
        }
        .widget-header h3 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 0.15rem;
        }
        .widget-header p {
            font-size: 0.75rem;
            opacity: 0.8;
        }
        .widget-job {
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            display: block;
            text-decoration: none;
            color: inherit;
            transition: background 0.15s;
        }
        .widget-job:hover { background: #f8fafc; }
        .widget-job:last-of-type { border-bottom: none; }
        .widget-job h4 {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
            color: #1e293b;
        }
        .widget-job-meta {
            display: flex;
            gap: 0.75rem;
            font-size: 0.7rem;
            color: #64748b;
        }
        .widget-footer {
            padding: 0.75rem 1.25rem;
            text-align: center;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
        .widget-footer a {
            font-size: 0.8rem;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="widget">
        <div class="widget-header">
            <h3>{{ $company->name }} is Hiring</h3>
            <p>{{ $positions->count() }} open position{{ $positions->count() !== 1 ? 's' : '' }}</p>
        </div>

        @foreach($positions as $position)
        <a href="{{ route('board.show', $position) }}" class="widget-job" target="_blank">
            <h4>{{ $position->title }}</h4>
            <div class="widget-job-meta">
                <span>{{ $position->location }}</span>
                <span>{{ ucfirst($position->employment_type) }}</span>
                <span style="color: #16a34a; font-weight: 600;">{{ $position->salary_range }}</span>
            </div>
        </a>
        @endforeach

        <div class="widget-footer">
            <a href="{{ route('board.index') }}" target="_blank">View All Positions →</a>
        </div>
    </div>
</body>
</html>
