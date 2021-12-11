<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PaymentRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PaymentRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaymentRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_payment_methods, list_payment_methods' )) {
            return redirect()->route( 'backend.index' );
        }
        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $payment_methods = PaymentMethod::query()
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.payment_methods.index', compact( 'payment_methods' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_payment_method' )) {
            return redirect()->route( 'backend.index' );
        }

        return view( 'back-end.payment_methods.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_payment_method' )) {
            return redirect()->route( 'backend.index' );
        }

        try {

            PaymentMethod::create( $request->validated() );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.payment_method.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param PaymentMethod  $payment_method
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $payment_method)
    {
        if (!auth()->user()->ability( 'admin', 'display_payment_method' )) {
            return redirect()->route( 'backend.index' );
        }

        return view( 'back-end.payment_methods.show', compact( 'payment_method' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PaymentMethod  $payment_method
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $payment_method)
    {
        if (!auth()->user()->ability( 'admin', 'update_payment_method' )) {
            return redirect()->route( 'backend.index' );
        }

        return view( 'back-end.payment_methods.edit' );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentRequest  $request
     * @param PaymentMethod   $payment_method
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRequest $request, PaymentMethod $payment_method)
    {

        if (!auth()->user()->ability( 'admin', 'update_payment_method' )) {
            return redirect()->route( 'backend.index' );
        }
        try {

            $payment_method->update( $request->validated() );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.payment_method.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PaymentMethod  $payment_method
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $payment_method)
    {
        if (!auth()->user()->ability( 'admin', 'delete_payment_method' )) {
            return redirect()->route( 'backend.index' );
        }
        $payment_method->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.payment_method.index' );
    }

}
