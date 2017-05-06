<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\User;

class NotificationController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Mark a notification as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()
            ->where('id', $request->input('id'))
            ->first();
        
        if ($notification) {
            $notification->markAsRead();
        }
        
        return response()->json([
            'error' => false
        ]);
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead(): JsonResponse
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        
        return response()->json([
            'error' => false
        ]);
    }
}
