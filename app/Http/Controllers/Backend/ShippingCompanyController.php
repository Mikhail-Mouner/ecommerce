<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ShippingCompanyRequest;
use App\Models\Country;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ShippingCompanyRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ShippingCompanyRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_shipping_companies, list_shipping_companies' )) {
            return redirect()->route( 'backend.index' );
        }
        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $shipping_companies = ShippingCompany::query()
            ->withCount( 'countries' )
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereDefaultAddress( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.shipping_companies.index', compact( 'shipping_companies' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_shipping_company' )) {
            return redirect()->route( 'backend.index' );
        }
        $countries = Country::whereStatus( TRUE )->get();

        return view( 'back-end.shipping_companies.create', compact( 'countries' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ShippingCompanyRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingCompanyRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_shipping_company' )) {
            return redirect()->route( 'backend.index' );
        }

        try {

            $shipping_company = ShippingCompany::create( $request->validated() );
            $shipping_company->countries()->attach( $request->country_id );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.shipping_company.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param ShippingCompany  $shipping_company
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingCompany $shipping_company)
    {
        if (!auth()->user()->ability( 'admin', 'display_shipping_company' )) {
            return redirect()->route( 'backend.index' );
        }

        return view( 'back-end.shipping_companies.show', compact( 'shipping_company' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ShippingCompany  $shipping_company
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingCompany $shipping_company)
    {
        if (!auth()->user()->ability( 'admin', 'update_shipping_company' )) {
            return redirect()->route( 'backend.index' );
        }
        $countries = Country::whereStatus( TRUE )->get();

        return view( 'back-end.shipping_companies.edit', compact( [ 'shipping_company', 'countries' ] ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShippingCompanyRequest  $request
     * @param ShippingCompany         $shipping_company
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ShippingCompanyRequest $request, ShippingCompany $shipping_company)
    {

        if (!auth()->user()->ability( 'admin', 'update_shipping_company' )) {
            return redirect()->route( 'backend.index' );
        }
        try {

            $shipping_company->update( $request->validated() );
            $shipping_company->countries()->sync( $request->country_id );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();
        }

        return redirect()->route( 'backend.shipping_company.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ShippingCompany  $shipping_company
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingCompany $shipping_company)
    {
        if (!auth()->user()->ability( 'admin', 'delete_shipping_company' )) {
            return redirect()->route( 'backend.index' );
        }
        $shipping_company->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.shipping_company.index' );
    }


}
