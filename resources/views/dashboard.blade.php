@extends('layouts.app')
@section('title', 'Dashboard — DriveHire ATS')

@section('body')
<div class="page-wrapper">
    @include('partials.sidebar')

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" @click="sidebarOpen = !sidebarOpen">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h1 class="font-display">Dashboard</h1>
                <span style="color: var(--text-muted); font-size: 0.8rem;">{{ $company->name }}</span>
            </div>
            <div class="topbar-actions">
                <button class="btn btn-secondary btn-sm">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Export
                </button>
                <a href="{{ route('positions.index') }}" class="btn btn-primary btn-sm">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    New Position
                </a>
            </div>
        </div>

        <div class="content-area">
            <!-- Stats -->
            <div class="stats-grid reveal">
                <div class="stat-card blue">
                    <div class="stat-icon blue">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </div>
                    <div class="stat-value">{{ $stats['active_positions'] }}</div>
                    <div class="stat-label">Active Positions</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-icon green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="stat-value">{{ $stats['total_candidates'] }}</div>
                    <div class="stat-label">Total Candidates</div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-icon orange">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="stat-value">{{ $stats['new_applications'] }}</div>
                    <div class="stat-label">New Applications</div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-icon purple">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div class="stat-value">{{ $stats['interviews_this_week'] }}</div>
                    <div class="stat-label">Interviews This Week</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-icon green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <div class="stat-value">{{ $stats['hired_this_month'] }}</div>
                    <div class="stat-label">Hired This Month</div>
                </div>
                <div class="stat-card amber">
                    <div class="stat-icon amber">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="stat-value">{{ $stats['time_to_hire_avg'] }}<span style="font-size: 0.9rem; color: var(--text-muted);">d</span></div>
                    <div class="stat-label">Avg. Time to Hire</div>
                </div>
            </div>

            <div class="grid-2" style="margin-bottom: 1.5rem;">
                <!-- Recent Applications -->
                <div class="card reveal">
                    <div class="card-header">
                        <h3>Recent Applications</h3>
                        <a href="{{ route('candidates.index') }}" class="btn btn-ghost btn-xs">View All</a>
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Candidate</th>
                                    <th>Position</th>
                                    <th>Match</th>
                                    <th>Stage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentApplications as $app)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            @php $colors = ['avatar-blue','avatar-green','avatar-purple','avatar-orange','avatar-red']; @endphp
                                            <div class="avatar avatar-sm {{ $colors[$app->candidate->id % 5] }}">{{ $app->candidate->initials }}</div>
                                            <div>
                                                <div style="font-weight: 600; font-size: 0.8rem;">
                                                    <a href="{{ route('candidates.show', $app->candidate) }}" style="color: var(--text-primary); text-decoration: none;">{{ $app->candidate->full_name }}</a>
                                                </div>
                                                <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $app->applied_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="font-size: 0.8rem;">{{ Str::limit($app->position->title, 25) }}</td>
                                    <td>
                                        @if($app->match_score)
                                        <span class="match-score {{ $app->match_score >= 85 ? 'high' : ($app->match_score >= 70 ? 'medium' : 'low') }}">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            {{ number_format($app->match_score) }}%
                                        </span>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-{{ $app->stage_color }}">{{ $app->stage_label }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right column: Upcoming Interviews + Activity -->
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <!-- Upcoming Interviews -->
                    <div class="card reveal">
                        <div class="card-header">
                            <h3>Upcoming Interviews</h3>
                        </div>
                        <div class="card-body">
                            @forelse($upcomingInterviews as $interview)
                            <div style="display: flex; gap: 0.75rem; padding: 0.5rem 0; {{ !$loop->last ? 'border-bottom: 1px solid var(--border-subtle);' : '' }}">
                                <div style="text-align: center; min-width: 44px;">
                                    <div style="font-size: 0.65rem; color: var(--accent); text-transform: uppercase; font-weight: 600;">{{ $interview->scheduled_at->format('M') }}</div>
                                    <div style="font-size: 1.25rem; font-weight: 700; font-family: 'Space Grotesk', sans-serif; line-height: 1;">{{ $interview->scheduled_at->format('d') }}</div>
                                    <div style="font-size: 0.65rem; color: var(--text-muted);">{{ $interview->scheduled_at->format('g:ia') }}</div>
                                </div>
                                <div>
                                    <div style="font-size: 0.85rem; font-weight: 600;">{{ $interview->application->candidate->full_name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $interview->application->position->title }}</div>
                                    <div style="margin-top: 0.25rem;">
                                        <span class="badge badge-{{ $interview->type === 'in-person' ? 'emerald' : ($interview->type === 'video' ? 'blue' : 'slate') }}">{{ ucfirst($interview->type) }}</span>
                                        <span style="font-size: 0.7rem; color: var(--text-muted); margin-left: 0.35rem;">{{ $interview->duration_minutes }}min</span>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="empty-state">
                                <p style="font-size: 0.8rem;">No upcoming interviews</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Activity Feed -->
                    <div class="card reveal">
                        <div class="card-header">
                            <h3>Recent Activity</h3>
                        </div>
                        <div class="card-body">
                            @forelse($activities as $activity)
                            <div class="activity-item">
                                <div class="activity-dot" style="background: {{ $activity->type === 'stage_change' ? 'var(--accent)' : ($activity->type === 'interview_scheduled' ? 'var(--info)' : 'var(--success)') }};"></div>
                                <div>
                                    <div class="activity-text">{{ $activity->description }}</div>
                                    <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @empty
                            <div class="empty-state">
                                <p style="font-size: 0.8rem;">No recent activity</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pipeline Board -->
            <div class="card reveal">
                <div class="card-header">
                    <h3>Hiring Pipeline</h3>
                    <div style="display: flex; gap: 0.5rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">
                            {{ collect($pipeline)->flatten()->count() }} total applicants
                        </span>
                    </div>
                </div>
                <div style="padding: 1rem; overflow-x: auto;">
                    <div class="pipeline-board">
                        @foreach($pipeline as $stage => $applications)
                        <div class="pipeline-column">
                            <div class="pipeline-header">
                                <h4 style="color: var(--text-secondary);">{{ ucfirst($stage) }}</h4>
                                <span class="pipeline-count">{{ $applications->count() }}</span>
                            </div>
                            <div class="pipeline-cards">
                                @forelse($applications as $app)
                                <div class="pipeline-card" x-data="{ showActions: false }" @mouseenter="showActions = true" @mouseleave="showActions = false">
                                    <div class="card-name">
                                        <a href="{{ route('candidates.show', $app->candidate) }}" style="color: var(--text-primary); text-decoration: none;">{{ $app->candidate->full_name }}</a>
                                    </div>
                                    <div class="card-role">{{ Str::limit($app->position->title, 30) }}</div>
                                    <div class="card-meta">
                                        @if($app->match_score)
                                        <span class="match-score {{ $app->match_score >= 85 ? 'high' : ($app->match_score >= 70 ? 'medium' : 'low') }}">
                                            {{ number_format($app->match_score) }}% match
                                        </span>
                                        @endif
                                        <span style="font-size: 0.65rem; color: var(--text-muted);">{{ $app->applied_at->diffForHumans(null, true) }}</span>
                                    </div>
                                    <div x-show="showActions" x-transition style="margin-top: 0.5rem; display: flex; gap: 0.25rem; flex-wrap: wrap;">
                                        @php
                                            $stageIdx = array_search($stage, \App\Models\Application::$stages);
                                            $nextStages = array_slice(\App\Models\Application::$stages, $stageIdx + 1, 2);
                                        @endphp
                                        @foreach($nextStages as $next)
                                        <button class="btn btn-xs btn-secondary" onclick="moveStage({{ $app->id }}, '{{ $next }}', this)">
                                            → {{ ucfirst($next) }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                                @empty
                                <div class="empty-state" style="padding: 1.5rem 0.5rem;">
                                    <p style="font-size: 0.7rem;">No applicants</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function moveStage(appId, stage, btn) {
    btn.disabled = true;
    btn.textContent = '...';
    fetch('/dashboard/applications/' + appId + '/stage', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ stage: stage })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) window.location.reload();
    })
    .catch(() => {
        btn.disabled = false;
        btn.textContent = '→ ' + stage.charAt(0).toUpperCase() + stage.slice(1);
    });
}
</script>
@endsection
