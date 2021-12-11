<div>
    <div class="row">
        <div class="col-lg-8">
            <h2 class="h5 text-uppercase mb-4">Shipping Addresses</h2>
            <div class="row">
                @forelse($addresses as $address)
                    <div class="col-6 form-control-plaintext">
                        <div class="custom-control custom-radio">
                            <input type="radio"
                                   wire:model="customer_address_id"
                                   wire:click="updateShippingCompanies()"
                                   name="customer_address"
                                   {{ $customer_address_id == $address->id?'checked':NULL }}
                                   id="{{ "address-{$address->id}" }}"
                                   value="{{ $address->id }}"
                                   class="custom-control-input"
                            />
                            <label for="{{ "address-{$address->id}" }}"
                                   class="custom-control-label text-small">
                                <small>
                                    <span class="h5">{{ $address->address_title }}</span>
                                    <br />
                                    {{ $address->address }} {{ $address->address2?"-{$address->address2}":NULL }}
                                    <br />
                                    {{ $address->country->name }}
                                    - {{ $address->state->name }}
                                    - {{ $address->city->name }}
                                    <br />
                                    ZIP-CODE: {{ $address->zip_code }}
                                </small>
                            </label>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p>No Address Found</p>
                        <a class="btn btn-outline-primary" href="#">Add an address</a>
                    </div>
                @endforelse
            </div>

            @if($customer_address_id != 0)
                <h2 class="h5 text-uppercase mb-4">Shipping Way</h2>
                <div class="row">
                    @forelse($shipping_companies as $shipping_company)
                        <div class="col-6 form-control-plaintext">
                            <div class="custom-control custom-radio">
                                <input type="radio"
                                       wire:model="shipping_company_id"
                                       wire:click="updateShippingCost()"
                                       name="shipping_company"
                                       {{ $shipping_company_id == $shipping_company->id?'checked':NULL }}
                                       id="{{ "shipping-company-{$shipping_company->id}" }}"
                                       value="{{ $shipping_company->id }}"
                                       class="custom-control-input"
                                />
                                <label for="{{ "shipping-company-{$shipping_company->id}" }}"
                                       class="custom-control-label text-small">
                                    <small>
                                        <span class="h5">{{ $shipping_company->name }}</span>
                                        <br />
                                        {{ $shipping_company->description }} - {{ "({$shipping_company->cost} EGP)" }}
                                    </small>
                                </label>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <p>No Address Found</p>
                        </div>
                    @endforelse
                </div>
            @endif

        </div>
        <!-- ORDER SUMMARY-->
        <div class="col-lg-4">
            <div class="card border-0 rounded-0 p-lg-4 bg-light">
                <div class="card-body">
                    <h5 class="text-uppercase mb-4">Your order</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center justify-content-between"><strong
                                    class="small font-weight-bold">Subtotal</strong><span
                                    class="text-muted small">{{ "$subtotal EGP" }}</span></li>
                        <li class="border-bottom my-2"></li>
                        @if(session()->has('coupon'))
                            <li class="d-flex align-items-center justify-content-between">
                                <strong class="small font-weight-bold">Discount
                                    <small>{{ session()->get('coupon')['code'] }}</small></strong>
                                <span class="text-muted small">{{ "- $cart_discount EGP" }}</span></li>
                            <li class="border-bottom my-2"></li>
                        @endif
                        @if(session()->has('shipping'))
                            <li class="d-flex align-items-center justify-content-between">
                                <strong class="small font-weight-bold">Discount
                                    <small>{{ session()->get('shipping')['code'] }}</small></strong>
                                <span class="text-muted small">{{ "+ $cart_shipping EGP" }}</span></li>
                            <li class="border-bottom my-2"></li>
                        @endif
                        <li class="d-flex align-items-center justify-content-between"><strong
                                    class="small font-weight-bold">Tax</strong><span
                                    class="text-muted small">{{ "$cart_tax EGP" }}</span></li>
                        <li class="border-bottom my-2"></li>
                        <li class="d-flex align-items-center justify-content-between"><strong
                                    class="text-uppercase small font-weight-bold">Total</strong><span>{{ "$total EGP" }}</span>
                        </li>
                        <li class="border-bottom my-2"></li>
                        <li>
                            <form wire:submit.prevent="applyDiscount()">
                                <div class="form-group mb-0">
                                    @if(!session()->has('coupon'))
                                        <input class="form-control" type="text" placeholder="Enter your coupon"
                                               wire:model="coupon_code">
                                        <button class="btn btn-dark btn-sm btn-block" type="submit">
                                            <i class="fas fa-gift mr-2"></i> Apply coupon
                                        </button>
                                    @else
                                        <button class="btn btn-outline-danger btn-sm btn-block" type="button"
                                                wire:click.prevent="removeCoupon()">
                                            <i class="fas fa-times mr-2"></i> Remove coupon
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
