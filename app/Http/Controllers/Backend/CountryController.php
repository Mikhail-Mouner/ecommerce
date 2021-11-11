<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CountryRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountryRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_countries, list_countries' )) {
            return redirect()->route( 'admin.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $countries = Country::query()
            ->withCount('states')
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.countries.index', compact( 'countries' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_countries' )) {
            return redirect()->route( 'admin.index' );
        }


        return view( 'back-end.countries.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CountryRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_countries' )) {
            return redirect()->route( 'admin.index' );
        }

        try {

            Country::create( [
                'name' => $request->name,
                'status' => $request->status,
            ] );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.country.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param Country  $country
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        if (!auth()->user()->ability( 'admin', 'display_countries' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.countries.show', compact( 'country' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Country  $country
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        if (!auth()->user()->ability( 'admin', 'update_countries' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.countries.edit', compact( 'country' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CountryRequest  $request
     * @param Country         $country
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, Country $country)
    {

        if (!auth()->user()->ability( 'admin', 'update_countries' )) {
            return redirect()->route( 'admin.index' );
        }
        try {

            $country->update( [
                'name' => $request->name,
                'status' => $request->status,
            ] );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.country.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Country  $country
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        if (!auth()->user()->ability( 'admin', 'delete_countries' )) {
            return redirect()->route( 'admin.index' );
        }
        $country->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.country.index' );
    }


}
