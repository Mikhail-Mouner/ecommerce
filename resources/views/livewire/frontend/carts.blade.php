<div class="d-flex">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('frontend.cart') }}">
            <i class="fas fa-dolly-flatbed mr-1 text-gray"></i>
            <small class="text-gray">({{ $cart_count }})</small>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('frontend.wishlist') }}">
            <i class="far fa-heart mr-1"></i>
            <small class="text-gray"> ({{ $wishlist_count }})</small>
        </a>
    </li>
</div>