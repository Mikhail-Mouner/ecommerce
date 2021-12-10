<div>
    <div class="row">
        <div class="col-lg-8">
            <form action="#">
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="firstName">First name</label>
                        <input class="form-control form-control-lg" id="firstName" type="text"
                               placeholder="Enter your first name">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="lastName">Last name</label>
                        <input class="form-control form-control-lg" id="lastName" type="text"
                               placeholder="Enter your last name">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="email">Email address</label>
                        <input class="form-control form-control-lg" id="email" type="email"
                               placeholder="e.g. Jason@example.com">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="phone">Phone number</label>
                        <input class="form-control form-control-lg" id="phone" type="tel"
                               placeholder="e.g. +02 245354745">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="company">Company name (optional)</label>
                        <input class="form-control form-control-lg" id="company" type="text"
                               placeholder="Your company name">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="country">Country</label>
                        <select class="selectpicker country" id="country" data-width="fit"
                                data-style="form-control form-control-lg" data-title="Select your country"></select>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="text-small text-uppercase" for="address">Address line 1</label>
                        <input class="form-control form-control-lg" id="address" type="text"
                               placeholder="House number and street name">
                    </div>
                    <div class="col-lg-12 form-group">
                        <label class="text-small text-uppercase" for="address">Address line 2</label>
                        <input class="form-control form-control-lg" id="addressalt" type="text"
                               placeholder="Apartment, Suite, Unit, etc (optional)">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="city">Town/City</label>
                        <input class="form-control form-control-lg" id="city" type="text">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class="text-small text-uppercase" for="state">State/County</label>
                        <input class="form-control form-control-lg" id="state" type="text">
                    </div>
                    <div class="col-lg-6 form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="alternateAddressCheckbox" type="checkbox">
                            <label class="custom-control-label text-small" for="alternateAddressCheckbox">Alternate
                                                                                                          billing
                                                                                                          address</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row d-none" id="alternateAddress">
                            <div class="col-12 mt-4">
                                <h2 class="h4 text-uppercase mb-4">Alternative billing details</h2>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="firstName2">First name</label>
                                <input class="form-control form-control-lg" id="firstName2" type="text"
                                       placeholder="Enter your first name">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="lastName2">Last name</label>
                                <input class="form-control form-control-lg" id="lastName2" type="text"
                                       placeholder="Enter your last name">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="email2">Email address</label>
                                <input class="form-control form-control-lg" id="email2" type="email"
                                       placeholder="e.g. Jason@example.com">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="phone2">Phone number</label>
                                <input class="form-control form-control-lg" id="phone2" type="tel"
                                       placeholder="e.g. +02 245354745">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="company2">Company name
                                                                                        (optional)</label>
                                <input class="form-control form-control-lg" id="company2" type="text"
                                       placeholder="Your company name">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="country2">Country</label>
                                <select class="selectpicker country" id="country2" data-width="fit"
                                        data-style="form-control form-control-lg"
                                        data-title="Select your country"></select>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="text-small text-uppercase" for="address2">Address line 1</label>
                                <input class="form-control form-control-lg" id="address2" type="text"
                                       placeholder="House number and street name">
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="text-small text-uppercase" for="address2">Address line 2</label>
                                <input class="form-control form-control-lg" id="addressalt2" type="text"
                                       placeholder="Apartment, Suite, Unit, etc (optional)">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="city3">Town/City</label>
                                <input class="form-control form-control-lg" id="city3" type="text">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase" for="state4">State/County</label>
                                <input class="form-control form-control-lg" id="state4" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group">
                        <button class="btn btn-dark" type="submit">Place order</button>
                    </div>
                </div>
            </form>
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
