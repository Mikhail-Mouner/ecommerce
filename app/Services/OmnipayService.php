<?php


namespace App\Services;


use Omnipay\Omnipay;

class OmnipayService
{
    protected $gateway = NULL;

    public function __construct($payment_method = 'PayPal_Express')
    {
        if (is_null( $payment_method ) || $payment_method == 'PayPal_Express') {
            $this->gateway = Omnipay::create( $payment_method );
            $this->gateway->setUsername( config( 'services.paypal.username' ) );
            $this->gateway->setPassword( config( 'services.paypal.password' ) );
            $this->gateway->setSignature( config( 'services.paypal.signature' ) );
            $this->gateway->setTestMode( config( 'services.paypal.sandbox' ) );
        }

        return $this->gateway;
    }

    public function purchase(array $parameter)
    {
        return $this->gateway->purchase( $parameter )->send();
    }

    public function complete(array $parameter)
    {
        return $this->gateway->completePurchase( $parameter )->send();
    }

    public function refund(array $parameter)
    {
        return $this->gateway->refund( $parameter )->send();
    }

    public function getCancelUrl($order_id)
    {
        return route( 'frontend.checkout.cancel', $order_id );
    }

    public function getReturnUrl($order_id)
    {
        return route( 'frontend.checkout.complete', $order_id );
    }

    public function getNotifyUrl($order_id)
    {
        $env = config( 'services.paypal.sandbox' ) ? 'sandbox' : 'live';

        return route( 'frontend.checkout.webhook.ipn', [ $order_id, $env ] );
    }

}