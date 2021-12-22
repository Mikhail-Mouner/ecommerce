<?php

namespace App\Http\Livewire\Frontend\Customer;

use App\Models\Order;
use Livewire\Component;

class OrdersComponent extends Component
{
    public $show_order = false;
    public $order_details = null;

    public function requestReturnOrder($id)
    {

    }
    public function dispalyOrder($id)
    {
        $this->show_order= true;
        $this->order_details = Order::with('products')->find($id);
    }
    public function render()
    {
        return view('livewire.frontend.customer.orders-component',[
            'orders' => auth()->user()->orders,
        ]);
    }
}
