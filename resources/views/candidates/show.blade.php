@extends('layouts.app')
@section('title', $candidate->full_name . ' — DriveHire ATS')

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
                    <a href="{{ route('candidates.index') }}">Candidates</a>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    <span style="color: var(--text-primary);">{{ $candidate->full_name }}</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            <div class="grid-2">
                <!-- Profile Card -->
                <div class="card reveal">
                    <div class="card-body" style="text-align: center; padding: 2rem;">
                        @php $colors = ['avatar-blue','avatar-green','avatar-purple','avatar-orange','avatar-red']; @endphp
                        <div class="avatar avatar-lg {{ $colors[$candidate->id % 5] }}" style="width: 72px; height: 72px; font-size: 1.5rem; margin: 0 auto 1rem; border-radius: 16px;">
                            {{ $candidate->initials }}
                        </div>
                        <h2 class="font-display" style="font-size: 1.5rem; margin-bottom: 0.25rem;">{{ $candidate->full_name }}</h2>
                        @if($candidate->headline)
                        <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1rem;">{{ $candidate->headline }}</p>
                        @endif

                        <div style="display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                            <span class="badge {{ $candidate->availability === 'immediate' ? 'badge-emerald' : 'badge-amber' }}">{{ $candidate->availability_label }}</span>
                            @if($candidate->experience_years)
                            <span class="badge badge-blue">{{ $candidate->experience_years }}+ years exp.</span>
                            @endif
                            <span class="badge badge-slate">{{ ucfirst($candidate->source) }}</span>
                        </div>

                        <div style="text-align: left; border-top: 1px solid var(--border-subtle); padding-top: 1rem;">
                            <div style="display: flex; justify-content: space-between; padding: 0.4rem 0; font-size: 0.85rem;">
                                <span style="color: var(--text-muted);">Email</span>
                                <span>{{ $candidate->email }}</span>
                            </div>
                            @if($candidate->phone)
                            <div style="display: flex; justify-content: space-between; padding: 0.4rem 0; font-size: 0.85rem;">
                                <span style="color: var(--text-muted);">Phone</span>
                                <span>{{ $candidate->phone }}</span>
                            </div>
                            @endif
                            @if($candidate->location)
                            <div style="display: flex; justify-content: space-between; padding: 0.4rem 0; font-size: 0.85rem;">
                                <span style="color: var(--text-muted);">Location</span>
                                <span>{{ $candidate->location }}</span>
                            </div>
                            @endif
                            @if($candidate->desired_salary)
                            <div style="display: flex; justify-content: space-between; padding: 0.4rem 0; font-size: 0.85rem;">
                                <span style="color: var(--text-muted);">Desired Salary</span>
                                <span>{{ $candidate->desired_salary }}</span>
                            </div>
                            @endif
                        </div>

                        @if($candidate->skills && count($candidate->skills))
                        <div style="text-align: left; border-top: 1px solid var(--border-subtle); padding-top: 1rem; margin-top: 0.5rem;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Skills</div>
                            <div>
                                @foreach($candidate->skills as $skill)
                                <span class="tag">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($candidate->certifications && count($candidate->certifications))
                        <div style="text-align: left; border-top: 1px solid var(--border-subtle); padding-top: 1rem; margin-top: 0.5rem;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Certifications</div>
                            <div>
                                @foreach($candidate->certifications as $cert)
                                <span class="tag" style="border-color: var(--accent); color: var(--accent);">{{ $cert }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Applications History -->
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @if($candidate->summary)
                    <div class="card reveal">
                        <div class="card-header"><h3>Summary</h3></div>
                        <div class="card-body">
                            <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.7;">{{ $candidate->summary }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="card reveal">
                        <div class="card-header">
                            <h3>Applications ({{ $candidate->applications->count() }})</h3>
                        </div>
                        <div class="card-body">
                            @foreach($candidate->applications as $app)
                            <div style="padding: 0.75rem 0; {{ !$loop->last ? 'border-bottom: 1px solid var(--border-subtle);' : '' }}">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem;">{{ $app->position->title }}</div>
                                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $app->position->company->name }} · {{ $app->position->location }}</div>
                                    </div>
                                    <span class="badge badge-{{ $app->stage_color }}">{{ $app->stage_label }}</span>
                                </div>
                                <div style="display: flex; gap: 1rem; margin-top: 0.5rem; font-size: 0.75rem; color: var(--text-muted);">
                                    <span>Applied {{ $app->applied_at->format('M d, Y') }}</span>
                                    @if($app->match_score)
                                    <span class="match-score {{ $app->match_score >= 85 ? 'high' : ($app->match_score >= 70 ? 'medium' : 'low') }}">
                                        {{ number_format($app->match_score) }}% match
                                    </span>
                                    @endif
                                </div>
                                @if($app->interviews->count())
                                <div style="margin-top: 0.5rem;">
                                    @foreach($app->interviews as $interview)
                                    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: var(--text-secondary); padding: 0.25rem 0;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
                                        {{ ucfirst($interview->type) }} interview — {{ $interview->scheduled_at->format('M d, g:ia') }}
                                        <span class="badge badge-{{ $interview->status === 'completed' ? 'emerald' : ($interview->status === 'scheduled' ? 'blue' : 'red') }}" style="font-size: 0.6rem;">{{ ucfirst($interview->status) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
