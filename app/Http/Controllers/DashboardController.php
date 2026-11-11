<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'department_archives' => Archive::where('department_id', $user->department_id)->count(),
            'my_archives' => Archive::where('created_by', $user->id)->count(),
            'recent_count' => Archive::where('department_id', $user->department_id)
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
        ];

        $archivesByStatus = Archive::where('department_id', $user->department_id)
            ->selectRaw('archive_status, COUNT(*) as count')
            ->groupBy('archive_status')
            ->get();

        $recentArchives = Archive::where('department_id', $user->department_id)
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'archivesByStatus', 'recentArchives'));
    }
}
