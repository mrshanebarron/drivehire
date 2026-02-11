@extends('layouts.app')
@section('title', 'Positions — DriveHire ATS')

@section('body')
<div class="page-wrapper">
    @include('partials.sidebar')

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" @click="sidebarOpen = !sidebarOpen">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h1 class="font-display">Positions</h1>
                <span style="color: var(--text-muted); font-size: 0.8rem;">{{ $positions->count() }} total</span>
            </div>
            <div class="topbar-actions">
                <button class="btn btn-primary btn-sm" onclick="alert('Demo: Position creation form would open here')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    New Position
                </button>
            </div>
        </div>

        <div class="content-area">
            <div class="card reveal">
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Department</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Applications</th>
                                <th>Views</th>
                                <th>Status</th>
                                <th>Posted</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($positions as $position)
                            <tr>
                                <td>
                                    <a href="{{ route('positions.show', $position) }}" style="color: var(--text-primary); text-decoration: none; font-weight: 600;">
                                        {{ $position->title }}
                                    </a>
                                    <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $position->company->name }} · {{ ucfirst($position->employment_type) }}</div>
                                </td>
                                <td><span class="badge badge-slate">{{ $position->department_label }}</span></td>
                                <td style="font-size: 0.8rem; color: var(--text-secondary);">{{ $position->location }}</td>
                                <td style="font-size: 0.8rem; font-weight: 600;">{{ $position->salary_range }}</td>
                                <td>
                                    <span style="font-weight: 600; color: {{ $position->applications_count > 0 ? 'var(--accent)' : 'var(--text-muted)' }};">{{ $position->applications_count }}</span>
                                </td>
                                <td style="font-size: 0.8rem; color: var(--text-muted);">{{ number_format($position->views_count) }}</td>
                                <td><span class="badge badge-{{ $position->status_color }}">{{ ucfirst($position->status) }}</span></td>
                                <td style="font-size: 0.75rem; color: var(--text-muted);">{{ $position->published_at?->diffForHumans() ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('positions.show', $position) }}" class="btn btn-ghost btn-xs">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
