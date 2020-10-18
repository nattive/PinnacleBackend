<?php

namespace App\Http\Controllers;

use App\userNotification;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function index()
    {
        return auth()->user()->userNotifications;
    }

    /**
     * Mark the notification as read
     * @param int $id
     * @return Response
     */
    public function read($id)
    {
     $notification = userNotification::findOrFail($id);
      $notification -> update([
          'isRead' => true
      ]);
      return response()->json(200);
    }

}
