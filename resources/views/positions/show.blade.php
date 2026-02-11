@extends('layouts.app')
@section('title', $position->title . ' — DriveHire ATS')

@section('body')
<div class="page-wrapper">
    @include('partials.sidebar')

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" @click="sidebarOpen = !sidebarOpen">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div class="topbar-breadcrumb">
                    <a href="{{ route('positions.index') }}">Positions</a>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    <span style="color: var(--text-primary);">{{ $position->title }}</span>
                </div>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('board.show', $position) }}" class="btn btn-secondary btn-sm" target="_blank">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    View Public Listing
                </a>
            </div>
        </div>

        <div class="content-area">
            <!-- Position Header -->
            <div class="card reveal" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <h2 class="font-display" style="font-size: 1.5rem; margin-bottom: 0.25rem;">{{ $position->title }}</h2>
                            <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--text-secondary); font-size: 0.85rem; flex-wrap: wrap;">
                                <span>{{ $position->company->name }}</span>
                                <span style="color: var(--border);">·</span>
                                <span>{{ $position->location }}</span>
                                <span style="color: var(--border);">·</span>
                                <span>{{ ucfirst($position->employment_type) }}</span>
                                <span style="color: var(--border);">·</span>
                                <span>{{ $position->salary_range }}</span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <span class="badge badge-{{ $position->status_color }}" style="font-size: 0.75rem;">{{ ucfirst($position->status) }}</span>
                        </div>
                    </div>
                    <div style="display: flex; gap: 2rem; margin-top: 1.25rem; flex-wrap: wrap;">
                        <div>
                            <div style="font-size: 1.5rem; font-weight: 700; font-family: 'Space Grotesk', sans-serif;">{{ $position->applications->count() }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Applications</div>
                        </div>
                        <div>
                            <div style="font-size: 1.5rem; font-weight: 700; font-family: 'Space Grotesk', sans-serif;">{{ number_format($position->views_count) }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Views</div>
                        </div>
                        <div>
                            @php $convRate = $position->views_count > 0 ? round(($position->applications->count() / $position->views_count) * 100, 1) : 0; @endphp
                            <div style="font-size: 1.5rem; font-weight: 700; font-family: 'Space Grotesk', sans-serif;">{{ $convRate }}%</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Conversion Rate</div>
                        </div>
                        <div>
                            <div style="font-size: 1.5rem; font-weight: 700; font-family: 'Space Grotesk', sans-serif;">{{ $position->published_at?->diffInDays(now()) ?? 0 }}d</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Days Open</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pipeline for this position -->
            <div class="card reveal">
                <div class="card-header">
                    <h3>Applicant Pipeline</h3>
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
                                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                        @php $colors = ['avatar-blue','avatar-green','avatar-purple','avatar-orange','avatar-red']; @endphp
                                        <div class="avatar avatar-sm {{ $colors[$app->candidate->id % 5] }}">{{ $app->candidate->initials }}</div>
                                        <div>
                                            <div class="card-name" style="margin-bottom: 0;">
                                                <a href="{{ route('candidates.show', $app->candidate) }}" style="color: var(--text-primary); text-decoration: none;">{{ $app->candidate->full_name }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if($app->candidate->headline)
                                    <div style="font-size: 0.7rem; color: var(--text-muted); margin-bottom: 0.35rem;">{{ Str::limit($app->candidate->headline, 40) }}</div>
                                    @endif
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
                                        <button class="btn btn-xs btn-secondary" onclick="moveStage({{ $app->id }}, '{{ $next }}', this)">→ {{ ucfirst($next) }}</button>
                                        @endforeach
                                        @if($stage !== 'rejected')
                                        <button class="btn btn-xs" style="background: rgba(239,68,68,0.1); color: var(--danger);" onclick="moveStage({{ $app->id }}, 'rejected', this)">✕</button>
                                        @endif
                                    </div>
                                </div>
                                @empty
                                <div class="empty-state" style="padding: 1.5rem 0.5rem;">
                                    <p style="font-size: 0.7rem;">Empty</p>
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
    .then(data => { if (data.success) window.location.reload(); })
    .catch(() => { btn.disabled = false; });
}
</script>
@endsection
