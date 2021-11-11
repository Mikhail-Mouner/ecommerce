<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductCouponRequest;
use App\Models\ProductCoupon;
use Illuminate\Http\Request;

class ProductCouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductCouponRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductCouponRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_product_coupons, list_product_coupons' )) {
            return redirect()->route( 'admin.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );

        $coupons = ProductCoupon::query()
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );


        return view( 'back-end.product_coupons.index', compact( 'coupons' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_product_coupons' )) {
            return redirect()->route( 'admin.index' );
        }


        return view( 'back-end.product_coupons.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCouponRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCouponRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'create_product_coupons' )) {
            return redirect()->route( 'admin.index' );
        }

        try {

            ProductCoupon::create( [
                'code' => $request->code,
                'status' => $request->status,
                'type' => $request->type,
                'value' => $request->value,
                'description' => $request->description,
                'use_times' => $request->use_times,
                'start_date' => $request->start_date,
                'expire_date' => $request->expire_date,
                'greater_than' => $request->greater_than,
            ] );
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.product_coupons.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param ProductCoupon  $productCoupon
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCoupon $productCoupon)
    {
        if (!auth()->user()->ability( 'admin', 'display_product_coupons' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.product_coupons.show', compact( 'productCoupon' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductCoupon  $productCoupon
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCoupon $productCoupon)
    {
        if (!auth()->user()->ability( 'admin', 'update_product_coupons' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.product_coupons.edit', compact( 'productCoupon' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductCouponRequest  $request
     * @param ProductCoupon         $productCoupon
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCouponRequest $request, ProductCoupon $productCoupon)
    {

        if (!auth()->user()->ability( 'admin', 'update_product_coupons' )) {
            return redirect()->route( 'admin.index' );
        }

        try {
            $productCoupon->update( [
                'code' => $request->code,
                'status' => $request->status,
                'type' => $request->type,
                'value' => $request->value,
                'description' => $request->desc,
                'use_times' => $request->use_times,
                'start_date' => $request->start_date,
                'expire_date' => $request->expire_date,
                'greater_than' => $request->greater_than,
            ] );
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.product_coupons.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductCoupon  $productCoupon
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCoupon $productCoupon)
    {

        if (!auth()->user()->ability( 'admin', 'delete_product_coupons' )) {
            return redirect()->route( 'admin.index' );
        }
        $productCoupon->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.product_coupons.index' );
    }

}
