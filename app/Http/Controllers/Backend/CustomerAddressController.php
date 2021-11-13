<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CustomerAddressRequest;
use App\Models\Country;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CustomerAddressRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomerAddressRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_customer_addresses, list_customer_addresses' )) {
            return redirect()->route( 'backend.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $customer_addresses = UserAddress::query()
            ->with( 'user:id,first_name,last_name' )
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereDefaultAddress( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.customer_addresses.index', compact( 'customer_addresses' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_customer_address' )) {
            return redirect()->route( 'backend.index' );
        }
        $countries = Country::whereStatus( TRUE )->get();

        return view( 'back-end.customer_addresses.create', compact( 'countries' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerAddressRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerAddressRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_customer_address' )) {
            return redirect()->route( 'backend.index' );
        }

        try {

            UserAddress::create( $request->validated() );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.customer_address.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param UserAddress  $customer_address
     *
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $customer_address)
    {
        if (!auth()->user()->ability( 'admin', 'display_customer_address' )) {
            return redirect()->route( 'backend.index' );
        }

        return view( 'back-end.customer_addresses.show', compact( 'customer_address' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UserAddress  $customer_address
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $customer_address)
    {
        if (!auth()->user()->ability( 'admin', 'update_customer_address' )) {
            return redirect()->route( 'backend.index' );
        }
        $countries = Country::whereStatus( TRUE )->get();

        return view( 'back-end.customer_addresses.edit', compact( [ 'customer_address', 'countries' ] ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerAddressRequest  $request
     * @param UserAddress             $customer_address
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerAddressRequest $request, UserAddress $customer_address)
    {

        if (!auth()->user()->ability( 'admin', 'update_customer_address' )) {
            return redirect()->route( 'backend.index' );
        }
        try {

            $customer_address->update( $request->validated() );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.customer_address.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserAddress  $customer_address
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $customer_address)
    {
        if (!auth()->user()->ability( 'admin', 'delete_customer_address' )) {
            return redirect()->route( 'backend.index' );
        }
        $customer_address->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.customer_address.index' );
    }


}
