<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OrderRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderRequest $request)
    {
        if (!auth()->user()->ability('admin', 'manage_orders, list_orders')) {
            return redirect()->route('backend.index');
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config('general.general_order_by');
        $paginate = $request->limit_by ?? config('general.general_paginate');
        $orders = Order::query()
            ->when($request->keyword, function ($q) use ($request) {
                return $q->search($request->keyword);
            })->when($request->status !== NULL, function ($q) use ($request) {
                return $q->whereOrderStatus($request->status);
            })
            ->orderBy($sort_by, $order_by)
            ->paginate($paginate);


        return view('back-end.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('backend.order.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('backend.order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Order  $order
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if (!auth()->user()->ability('admin', 'display_order')) {
            return redirect()->route('backend.index');
        }
        $order_status_array = [
            '0' => 'NEW ORDER',
            '1' => 'PAYMENT COMPLETED',
            '2' => 'UNDER PROCESS',
            '3' => 'FINISHED',
            '7' => 'REFUNDED',
            '8' => 'RETURNED',
        ];
        $key = array_search($order->order_status, array_keys($order_status_array));
        
        foreach ($order_status_array as $k => $val) {
            if ($k <= $key) {
                unset($order_status_array[$k]);
            }
        }

        return view('back-end.orders.show', compact(['order', 'order_status_array']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order  $order
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return redirect()->route('backend.order.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest  $request
     * @param Order         $order
     *
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        if (!auth()->user()->ability('admin', 'update_order')) {
            return redirect()->route('backend.index');
        }
        $order->update([
            'order_status' => $request->order_status
        ]);
        $order->transactions()->create([
            'transaction'=>$request->order_status,
        ]);
        session()->flash('mssg', ['status' => 'success', 'data' => 'Update Data Successfully']);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order  $order
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if (!auth()->user()->ability('admin', 'delete_order')) {
            return redirect()->route('backend.index');
        }
        $order->delete();
        session()->flash('mssg', ['status' => 'success', 'data' => 'Remove Data Successfully']);

        return redirect()->route('backend.order.index');
    }
}
