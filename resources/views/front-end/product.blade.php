@extends('front-end.layouts.app')
@section('content')

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <!-- PRODUCT SLIDER-->
                    <div class="row m-sm-0">
                        <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0">
                            <div class="owl-thumbs d-flex flex-row flex-sm-column" data-slider-id="1">

                                @foreach($product->media as $media)
                                    <div class="owl-thumb-item flex-fill mb-2 mr-2 mr-sm-0">
                                        <img class="w-100"
                                             src="{{ asset("/assets/products/{$media->file_name}") }}"
                                             alt="{{ $product->name }}">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="col-sm-10 order-1 order-sm-2">
                            <div class="owl-carousel product-slider" data-slider-id="1">
                                @foreach($product->media as $media)
                                    <a class="d-block"
                                       href="{{ asset("/assets/products/{$media->file_name}") }}"
                                       data-lightbox="product"
                                       title="{{ $product->name }}">
                                        <img class="img-fluid" src="{{ asset("/assets/products/{$media->file_name}") }}"
                                             alt="{{ $product->name }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT DETAILS-->
                <div class="col-lg-6">
                    <ul class="list-inline mb-2">

                        @if($product->reviews_avg_rating != '')
                            ({{ round($product->reviews_avg_rating) }})
                            @for($i=1;$i<=$product->reviews_avg_rating;$i++)
                                <li class="list-inline-item m-0"><i
                                            class="fas fa-star fa-sm text-warning"></i>
                                </li>
                            @endfor
                            @for($i=$product->reviews_avg_rating;$i<5;$i++)
                                <li class="list-inline-item m-0">
                                    <i class="far fa-star fa-sm text-warning"></i>
                                </li>
                            @endfor
                        @else
                            @for($i=0;$i<5;$i++)
                                <li class="list-inline-item m-0">
                                    <i class="far fa-star fa-sm text-warning"></i>
                                </li>
                            @endfor
                        @endif

                    </ul>
                    <h1>{{ $product->name }}</h1>
                    <p class="text-muted lead">{{ "{$product->price} EGP" }}</p>
                    <p class="text-small mb-4">
                        {!! $product->description !!}
                    </p>

                    <!-- SHOW PRODUCT COMPONENT-->
                    <livewire:frontend.show-product-component :product="$product" />

                    <br>
                    <ul class="list-unstyled small d-inline-block">
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">Category:</strong>
                            <a class="reset-anchor ml-2"
                               href="{{ route('frontend.shop',$product->category->slug) }}">
                                <span class="badge badge-primary-light">{{ $product->category->name }}</span></a>
                        </li>
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">Tags:</strong>
                            @foreach($product->tags as $tag)
                                <a class="reset-anchor ml-2" href="#{{ $tag->slug }}">
                                    <span class="badge badge-primary">{{ $tag->name }}</span>
                                </a>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
            <!-- DETAILS TABS-->
            <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="description-tab" data-toggle="tab"
                       href="#description" role="tab" aria-controls="description" aria-selected="true">
                        Description
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab"
                       aria-controls="reviews" aria-selected="false">
                        Reviews
                    </a>
                </li>
            </ul>
            <div class="tab-content mb-5" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel"
                     aria-labelledby="description-tab">
                    <div class="p-4 p-lg-5 bg-white">
                        <h6 class="text-uppercase">Product description </h6>
                        <p class="text-muted text-small mb-0">
                            {!! $product->description !!}
                        </p>
                    </div>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="p-4 p-lg-5 bg-white">
                        <div class="row">
                            <div class="col-lg-8">
                                @forelse($product->reviews as $review)
                                    <div class="media mb-3">
                                        <img class="rounded-circle"
                                             src="{{ asset("/assets/users/{$review->user->user_image}") }}"
                                             alt="{{ $review->user->name }}" width="50">
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 text-uppercase">{{ $review->user->name }}</h6>
                                            <p class="small text-muted mb-0 text-uppercase">{{ $review->created_at->format('j M y') }}</p>
                                            <ul class="list-inline mb-1 text-xs">
                                                ({{ round($review->rating) }})
                                                @for($i=1;$i<=$review->rating;$i++)
                                                    <li class="list-inline-item m-0"><i
                                                                class="fas fa-star fa-sm text-warning"></i>
                                                    </li>
                                                @endfor
                                                @for($i=$review->rating;$i<5;$i++)
                                                    <li class="list-inline-item m-0">
                                                        <i class="far fa-star fa-sm text-warning"></i>
                                                    </li>
                                                @endfor
                                            </ul>
                                            <p class="mb-0">
                                                {!! $review->title !!}
                                            </p>
                                            <p class="text-small mb-0 text-muted">
                                                {!! $review->message !!}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RELATED PRODUCTS-->
            <livewire:frontend.related-product :related_products="$related_products" />
        </div>
    </section>
@endsection