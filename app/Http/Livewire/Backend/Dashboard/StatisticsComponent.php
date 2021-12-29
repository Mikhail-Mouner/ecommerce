<?php

namespace App\Http\Livewire\Backend\Dashboard;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;

class StatisticsComponent extends Component
{
    public $earning = [
        'current_month' => ['label' => 'Earning (Monthly)', 'color' => 'primary', 'total' => 0, 'icon' => 'fas fa-dollar-sign','is_price'=>true],
        'current_year' => ['label' => 'Earning (Annual)', 'color' => 'success', 'total' => 0, 'icon' => 'fas fa-calendar','is_price'=>true],
        'order_new' => ['label' => 'New Order (Monthly)', 'color' => 'warning', 'total' => 0, 'icon' => 'fas fa-shopping-cart','is_price'=>false],
        'order_finished' => ['label' => 'Finished Order (Monthly)', 'color' => 'info', 'total' => 0, 'icon' => 'fas fa-shopping-basket','is_price'=>false],
        'total_customer' => ['label' => 'Total Customer', 'color' => 'primary', 'total' => 0, 'icon' => 'fa fa-user','is_price'=>false],
        'total_customer_has_order' => ['label' => 'Total Customer Has Order', 'color' => 'success', 'total' => 0, 'icon' => 'fa fa-shopping-basket','is_price'=>false],
        'total_supervisor' => ['label' => 'Supervisor', 'color' => 'warning', 'total' => 0, 'icon' => 'fa fa-user','is_price'=>false],
        'total_product' => ['label' => 'Total Product', 'color' => 'info', 'total' => 0, 'icon' => 'fa fa-file-archive','is_price'=>false],
    ];

    public function mount()
    {
        $this->earning['current_month']['total'] = number_format( Order::whereOrderStatus(Order::FINISHED)->whereMonth('created_at',date('m'))->sum('total') , 2 ,'.','\'');
        $this->earning['current_year']['total'] = number_format( Order::whereOrderStatus(Order::FINISHED)->whereYear('created_at',date('Y'))->sum('total') , 2 ,'.','\'');
        $this->earning['order_new']['total'] = Order::whereOrderStatus(Order::NEW_ORDER)->whereMonth('created_at',date('m'))->count();
        $this->earning['order_finished']['total'] = Order::whereOrderStatus(Order::FINISHED)->whereMonth('created_at',date('m'))->count();
        $this->earning['total_customer']['total'] = User::withRole('customer')->count();
        $this->earning['total_customer_has_order']['total'] = User::withRole('customer')->whereHas('orders')->count();
        $this->earning['total_supervisor']['total'] = User::withRole('supervisor')->count();
        $this->earning['total_product']['total'] = Product::Active()->ActiveCategory()->HasQty()->count();
    }

    public function render()
    {
        return view('livewire.backend.dashboard.statistics-component');
    }
}
