<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Position;
use Illuminate\Http\Request;

class JobBoardController extends Controller
{
    public function index(Request $request)
    {
        $query = Position::with('company')->active()->latest('published_at');

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('type')) {
            $query->where('employment_type', $request->type);
        }

        if ($request->filled('q')) {
            $s = $request->q;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        $positions = $query->paginate(12);
        $departments = Position::active()->distinct()->pluck('department');

        return view('board.index', compact('positions', 'departments'));
    }

    public function show(Position $position)
    {
        $position->load('company');
        $position->increment('views_count');

        $relatedPositions = Position::where('company_id', $position->company_id)
            ->where('id', '!=', $position->id)
            ->active()
            ->take(3)
            ->get();

        return view('board.show', compact('position', 'relatedPositions'));
    }

    public function apply(Request $request, Position $position)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'cover_letter' => 'nullable|string|max:5000',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'availability' => 'required|in:immediate,2-weeks,1-month,passive',
        ]);

        $candidate = Candidate::firstOrCreate(
            ['email' => $validated['email']],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'] ?? null,
                'experience_years' => $validated['experience_years'] ?? null,
                'availability' => $validated['availability'],
                'source' => 'direct',
            ]
        );

        $existing = Application::where('position_id', $position->id)
            ->where('candidate_id', $candidate->id)
            ->first();

        if ($existing) {
            return response()->json(['success' => false, 'message' => 'You have already applied for this position.'], 422);
        }

        $application = Application::create([
            'position_id' => $position->id,
            'candidate_id' => $candidate->id,
            'stage' => 'new',
            'cover_letter' => $validated['cover_letter'] ?? null,
            'match_score' => rand(65, 98) + (rand(0, 99) / 100), // Demo: simulated AI score
            'applied_at' => now(),
            'stage_history' => [['stage' => 'new', 'changed_at' => now()->toISOString()]],
        ]);

        $position->increment('applications_count');

        return response()->json(['success' => true, 'message' => 'Application submitted successfully!']);
    }

    // Embeddable widget endpoint
    public function widget(Request $request)
    {
        $companySlug = $request->get('company');
        $company = Company::where('slug', $companySlug)->firstOrFail();
        $positions = $company->activePositions()->latest('published_at')->take(5)->get();

        return view('board.widget', compact('company', 'positions'));
    }
}
