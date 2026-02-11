<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidate::withCount('applications');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', "%{$s}%")
                  ->orWhere('last_name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('headline', 'like', "%{$s}%");
            });
        }

        if ($request->filled('availability')) {
            $query->where('availability', $request->availability);
        }

        $candidates = $query->latest()->paginate(20);

        return view('candidates.index', compact('candidates'));
    }

    public function show(Candidate $candidate)
    {
        $candidate->load(['applications.position.company', 'applications.interviews']);

        return view('candidates.show', compact('candidate'));
    }
}
