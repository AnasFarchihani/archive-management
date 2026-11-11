<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = AuditLog::with('user')->latest('created_at');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('model_type')) {
            $query->where('model_type', 'like', "%{$request->model_type}%");
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(30)->withQueryString();

        return view('admin.audit-logs.index', [
            'logs' => $logs,
            'actions' => ['login', 'logout', 'created', 'updated', 'deleted', 'restored', 'downloaded'],
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function show(AuditLog $auditLog): View
    {
        $auditLog->load('user');
        return view('admin.audit-logs.show', compact('auditLog'));
    }
}
