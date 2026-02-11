@extends('layouts.app')
@section('title', $position->title . ' — Careers at ' . $position->company->name)

@section('styles')
<style>
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

    .job-detail { max-width: 900px; margin: 0 auto; padding: 2rem; }

    .job-detail-header {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    .job-detail-content {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.5rem;
    }

    .job-description {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: 12px;
        padding: 2rem;
    }

    .job-description h2 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-subtle);
    }

    .job-description p,
    .job-description li {
        font-size: 0.9rem;
        color: var(--text-secondary);
        line-height: 1.8;
        margin-bottom: 0.5rem;
    }

    .job-description ul {
        list-style: none;
        padding: 0;
    }

    .job-description ul li::before {
        content: '→';
        color: var(--accent);
        margin-right: 0.5rem;
        font-weight: 600;
    }

    .apply-panel {
        position: sticky;
        top: 80px;
    }

    .apply-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .apply-card h3 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .related-card {
        background: var(--bg-card);
        border: 1px solid var(--border-subtle);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: border-color 0.15s ease;
    }

    .related-card:hover { border-color: var(--accent); }

    @media (max-width: 768px) {
        .job-detail-content { grid-template-columns: 1fr; }
        .apply-panel { position: static; }
    }
</style>
@endsection

@section('body')
<div>
    <nav class="board-nav">
        <a href="{{ route('board.index') }}" class="board-logo">
            <div class="brand-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <span>DriveHire</span>
        </a>
        <a href="{{ route('board.index') }}" class="btn btn-ghost btn-sm">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            All Jobs
        </a>
    </nav>

    <div class="job-detail">
        <div class="job-detail-header reveal">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        @php $colors = ['avatar-blue','avatar-green','avatar-purple','avatar-orange']; @endphp
                        <div class="avatar {{ $colors[$position->company->id % 4] }}">{{ $position->company->initials }}</div>
                        <span style="font-size: 0.9rem; color: var(--text-secondary);">{{ $position->company->name }}</span>
                    </div>
                    <h1 class="font-display" style="font-size: 1.75rem; margin-bottom: 0.5rem;">{{ $position->title }}</h1>
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap; color: var(--text-muted); font-size: 0.85rem;">
                        <span style="display: flex; align-items: center; gap: 0.35rem;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $position->location }}
                        </span>
                        <span>{{ ucfirst($position->employment_type) }}</span>
                        <span>{{ ucfirst($position->experience_level) }} Level</span>
                        <span>{{ ucfirst(str_replace('-', ' ', $position->department)) }}</span>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--success);">{{ $position->salary_range }}</div>
                    @if($position->published_at)
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem;">Posted {{ $position->published_at->diffForHumans() }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="job-detail-content">
            <div>
                <div class="job-description reveal">
                    <h2>About the Role</h2>
                    <p>{{ $position->description }}</p>

                    @if($position->requirements)
                    <h2 style="margin-top: 1.5rem;">Requirements</h2>
                    <ul>
                        @foreach(explode("\n", $position->requirements) as $req)
                            @if(trim($req))
                            <li>{{ trim($req, '- ') }}</li>
                            @endif
                        @endforeach
                    </ul>
                    @endif

                    @if($position->benefits)
                    <h2 style="margin-top: 1.5rem;">Benefits & Perks</h2>
                    <ul>
                        @foreach(explode("\n", $position->benefits) as $benefit)
                            @if(trim($benefit))
                            <li>{{ trim($benefit, '- ') }}</li>
                            @endif
                        @endforeach
                    </ul>
                    @endif
                </div>

                @if($position->company->description)
                <div class="job-description reveal" style="margin-top: 1rem;">
                    <h2>About {{ $position->company->name }}</h2>
                    <p>{{ $position->company->description }}</p>
                    <div style="display: flex; gap: 1rem; margin-top: 1rem; flex-wrap: wrap;">
                        <span class="tag">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $position->company->location }}
                        </span>
                        @if($position->company->size)
                        <span class="tag">{{ $position->company->size }} employees</span>
                        @endif
                        <span class="tag">{{ ucfirst($position->company->industry) }}</span>
                    </div>
                </div>
                @endif
            </div>

            <div class="apply-panel">
                <div class="apply-card reveal" x-data="applicationForm()">
                    <h3>Apply for this Position</h3>

                    <template x-if="submitted">
                        <div style="text-align: center; padding: 1.5rem 0;">
                            <div style="width: 48px; height: 48px; background: rgba(16,185,129,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <p style="font-weight: 600; margin-bottom: 0.25rem;">Application Submitted!</p>
                            <p style="font-size: 0.8rem; color: var(--text-muted);">We'll be in touch soon.</p>
                        </div>
                    </template>

                    <template x-if="!submitted">
                        <form @submit.prevent="submitForm" method="POST">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                                <div class="form-group">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" x-model="form.first_name" class="form-input" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" x-model="form.last_name" class="form-input" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email *</label>
                                <input type="email" x-model="form.email" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" x-model="form.phone" class="form-input">
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                                <div class="form-group">
                                    <label class="form-label">Experience (years)</label>
                                    <input type="number" x-model="form.experience_years" min="0" max="50" class="form-input">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Availability *</label>
                                    <select x-model="form.availability" class="form-select" required>
                                        <option value="immediate">Available Now</option>
                                        <option value="2-weeks">2 Weeks Notice</option>
                                        <option value="1-month">1 Month Notice</option>
                                        <option value="passive">Passively Looking</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cover Letter</label>
                                <textarea x-model="form.cover_letter" class="form-textarea" rows="4" placeholder="Tell us why you'd be a great fit..."></textarea>
                            </div>
                            <p x-show="error" style="color: var(--danger); font-size: 0.8rem; margin-bottom: 0.75rem;" x-text="error"></p>
                            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;" :disabled="loading">
                                <span x-show="!loading">Apply Now</span>
                                <span x-show="loading">Submitting...</span>
                            </button>
                        </form>
                    </template>
                </div>

                @if($relatedPositions->count())
                <div class="apply-card reveal">
                    <h3 style="font-size: 0.9rem;">More at {{ $position->company->name }}</h3>
                    @foreach($relatedPositions as $related)
                    <a href="{{ route('board.show', $related) }}" class="related-card">
                        <div style="font-weight: 600; font-size: 0.85rem; margin-bottom: 0.2rem;">{{ $related->title }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $related->location }} · {{ $related->salary_range }}</div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function applicationForm() {
    return {
        form: {
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            experience_years: '',
            availability: 'immediate',
            cover_letter: ''
        },
        loading: false,
        submitted: false,
        error: '',
        submitForm() {
            this.loading = true;
            this.error = '';
            fetch('{{ route("board.apply", $position) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(this.form)
            })
            .then(r => r.json())
            .then(data => {
                this.loading = false;
                if (data.success) {
                    this.submitted = true;
                } else {
                    this.error = data.message || 'Something went wrong.';
                }
            })
            .catch(() => {
                this.loading = false;
                this.error = 'Network error. Please try again.';
            });
        }
    };
}
</script>
@endsection
