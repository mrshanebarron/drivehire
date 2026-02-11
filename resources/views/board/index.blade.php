@extends('layouts.app')
@section('title', 'Careers — DriveHire')

@section('styles')
<style>
    .board-hero {
        background: linear-gradient(135deg, var(--bg-secondary) 0%, #0f1b2e 100%);
        border-bottom: 1px solid var(--border-subtle);
        padding: 3rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .board-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 50%, rgba(59,130,246,0.08) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(139,92,246,0.05) 0%, transparent 50%);
        pointer-events: none;
    }

    .board-hero h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
    }

    .board-hero p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }

    .board-nav {
        background: var(--bg-secondary);
        border-bottom: 1px solid var(--border-subtle);
        padding: 0.75rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 30;
    }

    .board-logo {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: var(--text-primary);
    }

    .board-logo .brand-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--accent), #1d4ed8);
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .board-logo span {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .board-content { max-width: 900px; margin: 0 auto; padding: 2rem; }

    .search-bar {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .search-bar .form-input,
    .search-bar .form-select {
        background: var(--bg-card);
    }

    .job-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .job-card:hover {
        border-color: var(--accent);
        background: var(--bg-card-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .job-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .job-card h3 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1.15rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .job-card .company-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0.75rem;
    }

    .job-card .job-meta {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .job-meta-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .job-meta-item svg { width: 14px; height: 14px; }

    .board-footer {
        text-align: center;
        padding: 3rem 2rem;
        border-top: 1px solid var(--border-subtle);
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    .board-footer a { color: var(--accent); text-decoration: none; }
</style>
@endsection

@section('body')
<div>
    <nav class="board-nav">
        <a href="{{ route('board.index') }}" class="board-logo">
            <div class="brand-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <span>DriveHire</span>
        </a>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">Employer Login</a>
        </div>
    </nav>

    <div class="board-hero reveal">
        <h1>Find Your Next Role in<br><span style="color: var(--accent);">Automotive & Industrial</span></h1>
        <p>From Master Technicians to Service Managers — discover opportunities at top dealerships and industrial companies.</p>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: center; position: relative;">
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted);">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                <span>{{ $positions->total() }} Open Positions</span>
            </div>
        </div>
    </div>

    <div class="board-content">
        <form method="GET" class="search-bar reveal">
            <div style="flex: 2; min-width: 200px;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search positions..." class="form-input">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <select name="department" class="form-select">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('-', ' ', $dept)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 150px;">
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="full-time" {{ request('type') === 'full-time' ? 'selected' : '' }}>Full Time</option>
                    <option value="part-time" {{ request('type') === 'part-time' ? 'selected' : '' }}>Part Time</option>
                    <option value="contract" {{ request('type') === 'contract' ? 'selected' : '' }}>Contract</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        @forelse($positions as $position)
        <a href="{{ route('board.show', $position) }}" class="job-card reveal">
            <div class="job-card-header">
                <div>
                    <h3>{{ $position->title }}</h3>
                    <div class="company-info">
                        @php $colors = ['avatar-blue','avatar-green','avatar-purple','avatar-orange']; @endphp
                        <div class="avatar avatar-sm {{ $colors[$position->company->id % 4] }}">{{ $position->company->initials }}</div>
                        {{ $position->company->name }}
                    </div>
                </div>
                <span style="font-family: 'Space Grotesk', sans-serif; font-weight: 700; color: var(--success); font-size: 0.95rem; white-space: nowrap;">{{ $position->salary_range }}</span>
            </div>
            <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 0.75rem; line-height: 1.6;">{{ Str::limit($position->description, 180) }}</p>
            <div class="job-meta">
                <span class="job-meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $position->location }}
                </span>
                <span class="job-meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    {{ ucfirst($position->employment_type) }}
                </span>
                <span class="job-meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    {{ ucfirst($position->experience_level) }} Level
                </span>
                <span class="badge badge-slate">{{ ucfirst(str_replace('-', ' ', $position->department)) }}</span>
                @if($position->published_at)
                <span class="job-meta-item" style="margin-left: auto;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $position->published_at->diffForHumans() }}
                </span>
                @endif
            </div>
        </a>
        @empty
        <div class="empty-state" style="padding: 4rem 2rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            <p style="font-size: 1rem; margin-bottom: 0.5rem; color: var(--text-secondary);">No positions found</p>
            <p style="font-size: 0.85rem;">Try adjusting your search or filters.</p>
        </div>
        @endforelse

        @if($positions->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $positions->links() }}
        </div>
        @endif
    </div>

    <div class="board-footer">
        <p>Powered by <a href="{{ route('dashboard') }}">DriveHire</a> — The Automotive & Industrial ATS</p>
        <p style="margin-top: 0.25rem;">Embeddable job boards for dealerships and industrial companies.</p>
    </div>
</div>
@endsection
