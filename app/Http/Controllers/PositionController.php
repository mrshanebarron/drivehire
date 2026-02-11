<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Company;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $company = Company::first();
        $positions = Position::where('company_id', $company->id)
            ->withCount('applications')
            ->latest()
            ->get();

        return view('positions.index', compact('company', 'positions'));
    }

    public function show(Position $position)
    {
        $position->load(['company', 'applications.candidate']);

        $pipeline = [];
        foreach (Application::$stages as $stage) {
            $pipeline[$stage] = $position->applications->where('stage', $stage);
        }

        return view('positions.show', compact('position', 'pipeline'));
    }
}
