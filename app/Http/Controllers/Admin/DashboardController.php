<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\StorageLocation;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'total_archives' => Archive::count(),
            'trashed_archives' => Archive::onlyTrashed()->count(),
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_departments' => Department::count(),
            'active_departments' => Department::where('is_active', true)->count(),
            'total_locations' => StorageLocation::count(),
            'active_locations' => StorageLocation::where('is_active', true)->count(),
        ];

        $archivesByDepartment = Department::withCount('archives')
            ->orderByDesc('archives_count')
            ->get();

        $archivesByStatus = Archive::selectRaw('archive_status, COUNT(*) as count')
            ->groupBy('archive_status')
            ->get();

        $recentActivities = AuditLog::with('user')
            // ->paginate(3)
            ->latest('created_at')
            ->limit(5)
            ->get();

        $recentArchives = Archive::latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'archivesByDepartment',
            'archivesByStatus',
            'recentActivities',
            'recentArchives'
        ));
    }
}
