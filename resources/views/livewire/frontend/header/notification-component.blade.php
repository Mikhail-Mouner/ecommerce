<div>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="pagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <span class="position-relative">
                <i class="fas fa-bell mr-1 text-gray"></i>
                <span
                    class="badge badge-danger badge-counter rounded-pill shadow">{{ $unread_notification_count }}</span>
            </span>
        </a>
        <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown">
            @forelse ($unread_notifications as $notification)
                @if ($notification->type === 'App\Notifications\Frontend\Customer\OrderThanksNotification')
                    <a class="dropdown-item d-flex align-items-center border-0 transition-link" wire:click.prevent="markAsRead('{{ $notification->id }}')" href="{{ $notification->data['order_url'] }}">                    
                        <div class="mr-3">
                            <i class="fas fa-file-alt text-primary"></i>
                        </div>
                        <div>
                            <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                            <span class="font-weight-light">
                                Order ({{ $notification->data['order_ref'] }}) 
                                <br />
                                Completed Successfully
                            </span>
                        </div>
                    </a>
                
                @else
                <a class="dropdown-item d-flex align-items-center border-0 transition-link" wire:click.prevent="markAsRead('{{ $notification->id }}')" href="{{ $notification->data['order_url'] }}">                    
                    <div class="mr-3">
                        <i class="fas fa-file-alt text-primary"></i>
                    </div>
                    <div>
                        <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                        <span class="font-weight-light">
                            Order ({{ $notification->data['order_ref'] }}) 
                            <br />
                            status is
                            <span class="text-info font-weight-bolder">{{ $notification->data['last_transaction'] }}</span>
                        </span>
                    </div>
                </a>
                @endif
            @empty
                    <h6 class="text-center text-warning">No Notification Found!</h4>
            @endforelse
        </div>
    </li>
</div>
