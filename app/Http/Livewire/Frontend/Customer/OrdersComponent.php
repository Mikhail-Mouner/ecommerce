<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Http\Livewire\Frontend\traits\SendSweetAlertTrait;
use App\Models\Order;
use Livewire\Component;

class OrdersComponent extends Component
{
    use SendSweetAlertTrait;

    public $show_order = false;
    public $order_details = null;

    public function requestReturnOrder(Order $order)
    {
        $order->update([
            'order_status' => Order::REFUNDED_REQUEST,
        ]);
        $order->transactions()->create([
            'transaction' => Order::REFUNDED_REQUEST,
            'transaction_no' => $order->transactions()->whereTransaction(Order::PAYMENT_COMPLETED)->first()->transaction_no,
        ]);
        
        $this->sendSweetAlert('success', 'Your Request is sent successfully!');
    }

    public function dispalyOrder($id)
    {
        $this->show_order = true;
        $this->order_details = Order::with('products')->find($id);
    }
    public function render()
    {
        return view('livewire.frontend.customer.orders-component', [
            'orders' => auth()->user()->orders,
        ]);
    }
}
