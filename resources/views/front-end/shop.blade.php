@extends('front-end.layouts.app')
@section('style')
    <style>
        a.reset-anchor.active {
            color: #ffffff;
            background: #b68b23;
            border: solid 1px #b68b23;
            border-radius: 25px;
            padding: 0 5px;
        }
    </style>
@endsection
@section('content')

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Shop</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shop</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <livewire:frontend.list-products-component :slug="$slug" />
@endsection
@push('script')
    <script>

        function changeBoxSize(removeClass, addClass) {
            let product_blocks = document.querySelectorAll('.product-container-area');
            Array.prototype.forEach.call(product_blocks, function (product_block) {
                if (product_block.classList.contains(removeClass)) {
                    product_block.classList.remove(removeClass);
                    product_block.classList.add(addClass);
                }
            })
        }

        document.getElementById('two-items').addEventListener('click', () => {
            changeBoxSize('col-4', 'col-6')
        });
        document.getElementById('three-items').addEventListener('click', () => {
            changeBoxSize('col-6', 'col-4')
        });
    </script>
@endpush