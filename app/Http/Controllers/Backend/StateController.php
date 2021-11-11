<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StateRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param StateRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StateRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_states, list_states' )) {
            return redirect()->route( 'admin.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $states = State::query()
            ->withCount( 'cities' )
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.states.index', compact( 'states' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_states' )) {
            return redirect()->route( 'admin.index' );
        }
        $countries = Country::all();

        return view( 'back-end.states.create', compact( 'countries' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StateRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_states' )) {
            return redirect()->route( 'admin.index' );
        }

        try {

            State::create( $request->validated() );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.state.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param State  $state
     *
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        if (!auth()->user()->ability( 'admin', 'display_states' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.states.show', compact( 'state' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param State  $state
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        if (!auth()->user()->ability( 'admin', 'update_states' )) {
            return redirect()->route( 'admin.index' );
        }
        $countries = Country::all();

        return view( 'back-end.states.edit', compact( [ 'state', 'countries' ] ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StateRequest  $request
     * @param State         $state
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, State $state)
    {

        if (!auth()->user()->ability( 'admin', 'update_states' )) {
            return redirect()->route( 'admin.index' );
        }
        try {

            $state->update( $request->validated() );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.state.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param State  $state
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        if (!auth()->user()->ability( 'admin', 'delete_states' )) {
            return redirect()->route( 'admin.index' );
        }
        $state->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.state.index' );
    }


}
