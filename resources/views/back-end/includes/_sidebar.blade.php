<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('backend.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @if(auth()->user()->hasRole('admin')) 1 @endif
    @if(auth()->user()->hasRole('supervisor')) 1 @endif
    @role(['admin'])
    @foreach($admin_side_menu as $menu)
        @if($menu->appearedChildren->count() == 0 )
            <li class="nav-item {{ getParentShowOf() == $menu->id?"active":NULL }}">
                <!-- Nav Item - Page -->
                <a class="nav-link" href="{{ route("backend.{$menu->route}") }}">
                    <i class="{{ $menu->icon }} fa-fw"></i>
                    <span>{{ $menu->display_name }}</span>
                </a>
            </li>
        @else
            <li class="nav-item  {{ in_array($menu->parent_show,[getParentOf(),getParentShowOf()])?"active":NULL }}">
                <!-- Nav Item - Pages Collapse Menu -->
                <a class="nav-link {{ in_array($menu->parent_show,[getParentOf(),getParentShowOf()])?"collapsed":NULL }}"
                   href="#" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}"
                   aria-expanded="{{ $menu->parent_show == getParentOf() && getParentOf() != '' ?"false":"true" }}"
                   aria-controls="collapse{{ $loop->iteration }}">
                    <i class="{{ $menu->icon }} fa-fw"></i>
                    <span>{{ $menu->display_name }}</span>
                </a>
                <div id="collapse{{ $loop->iteration }}"
                     class="collapse {{ in_array($menu->parent_show,[getParentOf(),getParentShowOf()])?"show":NULL }}"
                     aria-labelledby="heading{{ $loop->iteration }}" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @foreach($menu->appearedChildren as $child )
                            <a class="collapse-item {{ getParentOf() != NULL && (int)(getParentIdOf()+1 == $child->id) ? "active":NULL  }}"
                               href="{{ route("backend.{$child->as}") }}">{{ $child->display_name }}</a>
                        @endforeach
                    </div>
                </div>
            </li>
        @endif
        <hr class="sidebar-divider">

    @endforeach
    @endrole
    @role(['supervisor'])
    @foreach($admin_side_menu as $menu)
    @permission($menu->name)
        @if($menu->appearedChildren->count() == 0 )
            <li class="nav-item {{ getParentShowOf() == $menu->id?"active":NULL }}">
                <!-- Nav Item - Page -->
                <a class="nav-link" href="{{ route("backend.{$menu->route}") }}">
                    <i class="{{ $menu->icon }} fa-fw"></i>
                    <span>{{ $menu->display_name }}</span>
                </a>
            </li>
        @else
            <li class="nav-item  {{ in_array($menu->parent_show,[getParentOf(),getParentShowOf()])?"active":NULL }}">
                <!-- Nav Item - Pages Collapse Menu -->
                <a class="nav-link {{ in_array($menu->parent_show,[getParentOf(),getParentShowOf()])?"collapsed":NULL }}"
                   href="#" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}"
                   aria-expanded="{{ $menu->parent_show == getParentOf() && getParentOf() != '' ?"false":"true" }}"
                   aria-controls="collapse{{ $loop->iteration }}">
                    <i class="{{ $menu->icon }} fa-fw"></i>
                    <span>{{ $menu->display_name }}</span>
                </a>
                <div id="collapse{{ $loop->iteration }}"
                     class="collapse {{ in_array($menu->parent_show,[getParentOf(),getParentShowOf()])?"show":NULL }}"
                     aria-labelledby="heading{{ $loop->iteration }}" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @foreach($menu->appearedChildren as $child )
                            @permission($child->name)
                            <a class="collapse-item {{ getParentOf() != NULL && (int)(getParentIdOf()+1 == $child->id) ? "active":NULL  }}"
                               href="{{ route("backend.{$child->as}") }}">{{ $child->display_name }}</a>
                            @endpermission
                        @endforeach
                    </div>
                </div>
            </li>
        @endif
        <hr class="sidebar-divider">
    @endpermission
    @endforeach
    @endrole

    <div class="text-center d-none d-md-inline">
        <!-- Sidebar Toggler (Sidebar) -->
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="{{ asset('back-end/img/undraw_rocket.svg') }}"
             alt="...">
        <p class="text-center mb-2">
            <strong>SB Admin Pro</strong>
            is packed with premium features, components, and more!
        </p>
    </div>

</ul>
<!-- End of Sidebar -->