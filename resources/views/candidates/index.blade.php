@extends('layouts.app')
@section('title', 'Candidates — DriveHire ATS')

@section('body')
<div class="page-wrapper">
    @include('partials.sidebar')

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" @click="sidebarOpen = !sidebarOpen">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h1 class="font-display">Candidates</h1>
            </div>
        </div>

        <div class="content-area">
            <!-- Search & Filters -->
            <div class="card reveal" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <form method="GET" style="display: flex; gap: 0.75rem; align-items: flex-end; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, or headline..." class="form-input">
                        </div>
                        <div style="min-width: 160px;">
                            <label class="form-label">Availability</label>
                            <select name="availability" class="form-select">
                                <option value="">All</option>
                                <option value="immediate" {{ request('availability') === 'immediate' ? 'selected' : '' }}>Available Now</option>
                                <option value="2-weeks" {{ request('availability') === '2-weeks' ? 'selected' : '' }}>2 Weeks Notice</option>
                                <option value="1-month" {{ request('availability') === '1-month' ? 'selected' : '' }}>1 Month Notice</option>
                                <option value="passive" {{ request('availability') === 'passive' ? 'selected' : '' }}>Passive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                        @if(request()->anyFilled(['search', 'availability']))
                        <a href="{{ route('candidates.index') }}" class="btn btn-ghost btn-sm">Clear</a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Candidates Table -->
            <div class="card reveal">
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Headline</th>
                                <th>Experience</th>
                                <th>Skills</th>
                                <th>Availability</th>
                                <th>Applications</th>
                                <th>Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($candidates as $candidate)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        @php $colors = ['avatar-blue','avatar-green','avatar-purple','avatar-orange','avatar-red']; @endphp
                                        <div class="avatar {{ $colors[$candidate->id % 5] }}">{{ $candidate->initials }}</div>
                                        <div>
                                            <div style="font-weight: 600;">
                                                <a href="{{ route('candidates.show', $candidate) }}" style="color: var(--text-primary); text-decoration: none;">{{ $candidate->full_name }}</a>
                                            </div>
                                            <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $candidate->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size: 0.8rem; color: var(--text-secondary); max-width: 200px;">{{ Str::limit($candidate->headline, 40) ?: '—' }}</td>
                                <td style="font-size: 0.85rem; font-weight: 600;">{{ $candidate->experience_years ? $candidate->experience_years . ' yr' . ($candidate->experience_years > 1 ? 's' : '') : '—' }}</td>
                                <td>
                                    @foreach(array_slice($candidate->skills ?? [], 0, 3) as $skill)
                                    <span class="tag">{{ $skill }}</span>
                                    @endforeach
                                    @if(count($candidate->skills ?? []) > 3)
                                    <span class="tag" style="color: var(--accent);">+{{ count($candidate->skills) - 3 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $candidate->availability === 'immediate' ? 'badge-emerald' : ($candidate->availability === 'passive' ? 'badge-slate' : 'badge-amber') }}">
                                        {{ $candidate->availability_label }}
                                    </span>
                                </td>
                                <td style="text-align: center; font-weight: 600;">{{ $candidate->applications_count }}</td>
                                <td><span class="badge badge-slate">{{ ucfirst($candidate->source) }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="empty-state">No candidates found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($candidates->hasPages())
            <div style="margin-top: 1rem; display: flex; justify-content: center;">
                {{ $candidates->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
