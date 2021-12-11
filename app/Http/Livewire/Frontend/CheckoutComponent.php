<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Livewire\Frontend\traits\InstanceCart;
use App\Models\ProductCoupon;
use App\Models\ShippingCompany;
use App\Models\UserAddress;
use Livewire\Component;

class CheckoutComponent extends Component
{
    use InstanceCart;

    public $total = 0;
    public $subtotal = 0;
    public $cart_tax = 0;
    public $customer_address_id;
    public $shipping_company_id;
    public $coupon_code = NULL;
    public $cart_discount = NULL;
    public $cart_shipping = NULL;
    public $addresses = NULL;
    public $shipping_companies = NULL;

    public $listeners = [
        'updateCart' => 'mount',
    ];

    public function mount()
    {
        $this->addresses = auth()->user()->addresses;
        $this->subtotal = getNumbers()->get( 'subtotal' );
        $this->cart_tax = getNumbers()->get( 'product_taxes' );
        $this->total = getNumbers()->get( 'total' );
        $this->cart_discount = getNumbers()->get( 'discount' );
        $this->cart_shipping = getNumbers()->get( 'shipping' );
        if ($this->customer_address_id == '') {
            $this->shipping_companies = collect( [] );
        }else{
            $this->updateShippingCompanies();
        }
    }

    public function render()
    {
        return view( 'livewire.frontend.checkout-component' );
    }

    public function applyDiscount()
    {
        if (getNumbers()->get( 'subtotal' ) > 0) {
            $coupon = ProductCoupon::whereRaw( "BINARY code = ? ", $this->coupon_code )->Active()->first();
            if (!$coupon) {
                $this->resetCoupon( 'Coupon is invalid!' );
            } else {
                $coupon_value = $coupon->discount( $this->subtotal );

                if ($coupon_value > 0) {
                    session()->put( 'coupon', [
                        'code' => $coupon->code,
                        'value' => $coupon->value,
                        'discount' => $coupon_value,
                    ] );
                    $this->emitUpdateCart( 'Coupon is applied successfully!' );
                } else {
                    $this->resetCoupon( 'Coupon is invalid!' );
                }

            }
        } else {
            $this->resetCoupon( 'No product available in your cart' );
        }
    }

    protected function resetCoupon($mssg = NULL, $type = 'error')
    {
        $this->coupon_code = '';
        if (!is_null( $mssg )) {
            $this->sendSweetAlert( $type, $mssg );
        }
    }

    public function removeCoupon()
    {
        session()->remove( 'coupon' );
        $this->resetCoupon();
        $this->emitUpdateCart( 'Coupon is removed successfully!' );
    }

    public function updateShippingCompanies()
    {
        $address_country = UserAddress::whereId( $this->customer_address_id )->first();
        $this->shipping_companies = ShippingCompany::whereHas( 'countries', function ($q) use ($address_country) {
            return $q->whereCountryId( $address_country->country_id );
        } )->get();
    }

    public function updatingCustomerAddressId()
    {
        $this->changeValueCustomerAddressId();
    }

    public function updatedCustomerAddressId()
    {
        $this->changeValueCustomerAddressId();
    }

    public function changeValueCustomerAddressId()
    {

        session()->forget( 'saved_customer_address_id' );
        session()->forget( 'saved_shipping_company_id' );
        session()->put( 'saved_customer_address_id', $this->customer_address_id );
        $this->customer_address_id = session()->has( 'saved_customer_address_id' ) ? session()->get( 'saved_customer_address_id' ) : '';
        $this->shipping_company_id = session()->has( 'saved_shipping_company_id' ) ? session()->get( 'saved_shipping_company_id' ) : '';
        $this->emitUpdateCart();
    }

    public function updateShippingCost()
    {
        $selected_shipping_company = ShippingCompany::whereId( $this->shipping_company_id )->first();
        session()->put( 'shipping', [
            'code' => $selected_shipping_company->code,
            'cost' => $selected_shipping_company->cost,
        ] );
        $this->emitUpdateCart( 'Shipping Cost Is Applied Successfully' );

    }

    public function updatingShippingCompanyId()
    {
        $this->changeValueShippingCompanyId();
    }

    public function updatedShippingCompanyId()
    {
        $this->changeValueShippingCompanyId();
    }

    public function changeValueShippingCompanyId()
    {
        session()->forget( 'saved_shipping_company_id' );
        session()->put( 'saved_shipping_company_id', $this->shipping_company_id );
        $this->customer_address_id = session()->has( 'saved_customer_address_id' ) ? session()->get( 'saved_customer_address_id' ) : '';
        $this->shipping_company_id = session()->has( 'saved_shipping_company_id' ) ? session()->get( 'saved_shipping_company_id' ) : '';
        $this->emitUpdateCart();
    }

}
