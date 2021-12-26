<?php

namespace App\Http\Livewire\Backend\Navbar;

use Livewire\Component;

class NotificationComponent extends Component
{
    public $unread_notification_count = 0;
    public $unread_notifications = null;

    public function getListeners()
    {
        $user_id = auth()->id();
        return [
            "echo-notification:App.Models.User.{$user_id},notification" => 'mount'
        ];
    }

    public function mount()
    {
        $this->unread_notification_count = auth()->user()->unreadNotifications()->count();        
        $this->unread_notifications = auth()->user()->unreadNotifications()->get();        
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications()->whereId($id)->first();
        $notification->markAsRead();
        return redirect()->to($notification->data['order_url']);
    }

    public function render()
    {
        return view('livewire.backend.navbar.notification-component');
    }
}
