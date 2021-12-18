<!--sidebar-->
<div class="card border-0 rounded-0 p-lg-4 bg-light">
    <div class="card-body">
        <h5 class="text-uppercase mb-4">Navigation</h5>
        @php
            $navigation_tabs = [
                [ 'prefix' => 'frontend.dashboard' , 'label' => 'Dashboard' ],
                [ 'prefix' => 'frontend.customer.profile' , 'label' => 'Profile' ],
                [ 'prefix' => 'frontend.customer.addresses' , 'label' => 'Addresses' ],
                [ 'prefix' => 'frontend.customer.orders' , 'label' => 'Orders' ],
            ];
        @endphp
        @foreach($navigation_tabs as $tab)
            <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == $tab['prefix']?'bg-dark-light':'bg-light-light' }}">
                <a href="{{ route($tab['prefix']) }}" class=" text-decoration-none">
                    <strong class="small text-uppercase font-weight-bold">{{ $tab['label'] }}</strong>
                </a>
            </div>
        @endforeach
        <div class="py-2 px-4 mb-3 bg-danger-light">
            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
               class="text-danger text-decoration-none">
                <strong class="small text-uppercase font-weight-bold">Logout</strong>
            </a>
        </div>
    </div>
</div>