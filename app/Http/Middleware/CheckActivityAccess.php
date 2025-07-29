<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActivityAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Allow admins to access all activities
        if ($user->isAdmin()) {
            return $next($request);
        }
        
        // For non-admins, check if they're trying to access their own activity
        if ($request->route('activity')) {
            $activityId = $request->route('activity');
            $activity = \App\Models\ActivityLog::find($activityId);
            
            if (!$activity || $activity->user_id !== $user->id) {
                return response()->view('errors.404', [
                    'message' => 'Access Denied',
                    'error' => 'You can only view your own activities.'
                ], 403);
            }
        }
        
        return $next($request);
    }
}
