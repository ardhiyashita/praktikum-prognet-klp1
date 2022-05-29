<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function adminReadNotification($id) 
    {
        $adminUnreadNotification = Auth::guard('admin')->user()
                                ->unreadNotifications
                                ->where('id', $id)
                                ->first();
    
        if($adminUnreadNotification) {
            $adminUnreadNotification->markAsRead();
        }
        return back();
    }

    public function userReadNotification($id) 
    {
        $userUnreadNotification = Auth::guard('web')->user()
                                ->unreadNotifications
                                ->where('id', $id)
                                ->first();
    
        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
        }
        return back();
    }
}
