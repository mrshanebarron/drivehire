<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Application;
use App\Models\Company;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function updateStage(Request $request, Application $application)
    {
        $validated = $request->validate([
            'stage' => 'required|in:' . implode(',', Application::$stages),
        ]);

        $oldStage = $application->stage;
        $history = $application->stage_history ?? [];
        $history[] = [
            'stage' => $validated['stage'],
            'from' => $oldStage,
            'changed_at' => now()->toISOString(),
        ];

        $application->update([
            'stage' => $validated['stage'],
            'stage_history' => $history,
        ]);

        Activity::create([
            'type' => 'stage_change',
            'description' => "Moved {$application->candidate->full_name} from " . ucfirst($oldStage) . " to " . ucfirst($validated['stage']) . " for {$application->position->title}",
            'subject_type' => Application::class,
            'subject_id' => $application->id,
            'company_id' => $application->position->company_id,
        ]);

        return response()->json(['success' => true, 'stage' => $validated['stage']]);
    }
}
