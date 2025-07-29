<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = auth()->user();
            
            // Admin can see all activities, users can only see their own
            if ($user->isAdmin()) {
                $activities = ActivityLog::with('user')->latest()->paginate(10);
            } else {
                $activities = ActivityLog::where('user_id', $user->id)
                    ->with('user')
                    ->latest()
                    ->paginate(10);
            }
            
            return view('activity.index', compact('activities'));
        } catch (\Exception $e) {
            return response()->view('errors.404', [
                'message' => 'Activity Log Error',
                'error' => 'Unable to load activity logs at this time.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = auth()->user();
            $activity = ActivityLog::with('user')->findOrFail($id);
            
            // Admin can see all activities, users can only see their own
            if (!$user->isAdmin() && $activity->user_id !== $user->id) {
                return response()->view('errors.404', [
                    'message' => 'Access Denied',
                    'error' => 'You can only view your own activities.'
                ], 403);
            }
            
            return view('activity.show', compact('activity'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->view('errors.404', [
                'message' => 'Activity Not Found',
                'error' => 'The activity you are looking for does not exist.'
            ], 404);
        } catch (\Exception $e) {
            return response()->view('errors.404', [
                'message' => 'Activity Error',
                'error' => 'Something went wrong while loading the activity.'
            ], 500);
        }
    }
}
