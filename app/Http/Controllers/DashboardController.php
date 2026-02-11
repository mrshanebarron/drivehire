<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Interview;
use App\Models\Position;
use App\Models\Activity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $company = Company::first();
        $stats = [
            'active_positions' => Position::where('company_id', $company->id)->active()->count(),
            'total_candidates' => Candidate::count(),
            'new_applications' => Application::whereHas('position', fn($q) => $q->where('company_id', $company->id))->where('stage', 'new')->count(),
            'interviews_this_week' => Interview::whereHas('application.position', fn($q) => $q->where('company_id', $company->id))
                ->where('scheduled_at', '>=', now()->startOfWeek())
                ->where('scheduled_at', '<=', now()->endOfWeek())
                ->count(),
            'hired_this_month' => Application::whereHas('position', fn($q) => $q->where('company_id', $company->id))
                ->where('stage', 'hired')
                ->where('updated_at', '>=', now()->startOfMonth())
                ->count(),
            'time_to_hire_avg' => 18, // demo value in days
        ];

        $recentApplications = Application::with(['candidate', 'position'])
            ->whereHas('position', fn($q) => $q->where('company_id', $company->id))
            ->latest('applied_at')
            ->take(8)
            ->get();

        $pipeline = [];
        foreach (Application::$stages as $stage) {
            if ($stage === 'rejected') continue;
            $pipeline[$stage] = Application::with(['candidate', 'position'])
                ->whereHas('position', fn($q) => $q->where('company_id', $company->id))
                ->where('stage', $stage)
                ->latest('applied_at')
                ->get();
        }

        $upcomingInterviews = Interview::with(['application.candidate', 'application.position'])
            ->whereHas('application.position', fn($q) => $q->where('company_id', $company->id))
            ->where('scheduled_at', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        $activities = Activity::where('company_id', $company->id)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('company', 'stats', 'recentApplications', 'pipeline', 'upcomingInterviews', 'activities'));
    }
}
