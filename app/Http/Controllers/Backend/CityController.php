<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CityRequest;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CityRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CityRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_cities, list_cities' )) {
            return redirect()->route( 'backend.index' );
        }
        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $cities = City::query()
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.cities.index', compact( 'cities' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_cities' )) {
            return redirect()->route( 'backend.index' );
        }
        $states = State::all();

        return view( 'back-end.cities.create', compact( 'states' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CityRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_cities' )) {
            return redirect()->route( 'backend.index' );
        }

        try {

            City::create( $request->validated() );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.city.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param City  $city
     *
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        if (!auth()->user()->ability( 'admin', 'display_cities' )) {
            return redirect()->route( 'backend.index' );
        }

        return view( 'back-end.cities.show', compact( 'city' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param City  $city
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        if (!auth()->user()->ability( 'admin', 'update_cities' )) {
            return redirect()->route( 'backend.index' );
        }
        $states = State::all();

        return view( 'back-end.cities.edit', compact( [ 'city', 'states' ] ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityRequest  $request
     * @param City         $city
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, City $city)
    {

        if (!auth()->user()->ability( 'admin', 'update_cities' )) {
            return redirect()->route( 'backend.index' );
        }
        try {

            $city->update( $request->validated() );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.city.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param City  $city
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        if (!auth()->user()->ability( 'admin', 'delete_cities' )) {
            return redirect()->route( 'backend.index' );
        }
        $city->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.city.index' );
    }

    public function getCities()
    {
        $cities = City::whereStateId( \request()->input( 'state_id' ) )->orderBy( 'name' )->get( [ 'id', 'name' ] )->toArray();

        return response()->json( $cities );
    }

}
