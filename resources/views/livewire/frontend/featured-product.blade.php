<div wire:ignore>

    <!-- TRENDING PRODUCTS-->
    <section class="py-5">
        <header>
            <p class="small text-muted small text-uppercase mb-1">Made the hard way</p>
            <h2 class="h5 text-uppercase mb-4">Top trending products</h2>
        </header>
        <div class="row">
        @foreach($featured_products as $product)
            <!-- PRODUCT ({{ $product->name }})-->
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="product text-center">
                        <div class="position-relative mb-3">
                            <div class="badge text-white badge-"></div>
                            <a class="d-block" href="{{ route('frontend.product',$product->slug) }}">
                                <img class="img-fluid w-100"
                                     src="{{ asset("/assets/products/{$product->firstMedia->file_name}") }}"
                                     alt="{{ $product->name }}">
                            </a>
                            <div class="product-overlay">
                                <ul class="mb-0 list-inline">
                                    <li class="list-inline-item m-0 p-0">
                                        <a wire:click.prevent="addToWishList('{{ $product->id }}')"
                                           class="btn btn-sm btn-outline-dark">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item m-0 p-0">
                                        <a wire:click.prevent="addToCart('{{ $product->id }}')"
                                           class="btn btn-sm btn-dark">
                                            Add to cart
                                        </a>
                                    </li>
                                    <li class="list-inline-item mr-0">
                                        <a class="btn btn-sm btn-outline-dark"
                                           wire:click.prevent="$emit('showProductModalAction','{{ $product->slug }}')"
                                           data-target="#productView"
                                           data-toggle="modal">
                                            <i class="fas fa-expand"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <h6><a class="reset-anchor"
                               href="{{ route('frontend.product',$product->slug) }}">{{ $product->name }}</a>
                        </h6>
                        <p class="small text-muted">{{ "{$product->price} EGP" }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <livewire:frontend.product-modal-shared />
    </section>

</div>
