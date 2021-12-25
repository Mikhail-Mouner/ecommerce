<div>
    <!-- Nav Item - Alerts -->
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter">{{ $unread_notification_count }}</span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Alerts Center
        </h6>
        @forelse ($unread_notifications as $notification)            
            <a class="dropdown-item d-flex align-items-center" wire:click.prevent="markAsRead('{{ $notification->id }}')" href="{{ $notification->data['order_url'] }}">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                    <span class="font-weight-light">
                        A new order with amount 
                        <span class="text-info font-weight-bolder">{{ $notification->data['amount'] }}</span>
                        from customer
                        <span class="text-info font-weight-bolder">{{ $notification->data['customer_name'] }}</span>
                    </span>
                </div>
            </a>
        @empty
            <div class="py-2">
                <h4 class="text-center text-warning">No Notification Found!</h4>
            </div>
        @endforelse
        @if($unread_notification_count > 3 )
            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
        @endif
    </div>

</div>
