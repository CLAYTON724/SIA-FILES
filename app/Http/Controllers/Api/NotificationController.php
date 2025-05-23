<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json([
            'notifications' => $notifications,
        ]);
    }
    
    /**
     * Create a new notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'data' => 'nullable|array',
        ]);
        
        // Only allow creating notifications for other users if you're an admin
        // This is a simple check, you might want to implement proper authorization
        if ($validated['user_id'] !== Auth::id()) {
            // Check if user is admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }
        }
        
        $notification = Notification::create([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'data' => $validated['data'] ?? [],
            'is_read' => false,
        ]);
        
        return response()->json([
            'message' => 'Notification created successfully',
            'notification' => $notification,
        ], 201);
    }
    
    /**
     * Update a notification (mark as read/unread).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        
        // Check if the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $validated = $request->validate([
            'is_read' => 'required|boolean',
        ]);
        
        $notification->update([
            'is_read' => $validated['is_read'],
        ]);
        
        return response()->json([
            'message' => 'Notification updated successfully',
            'notification' => $notification,
        ]);
    }
    
    /**
     * Delete a notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        
        // Check if the notification belongs to the authenticated user
        if ($notification->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
        
        $notification->delete();
        
        return response()->json([
            'message' => 'Notification deleted successfully',
        ]);
    }
}
