<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CustomerRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param CustomerRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CustomerRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_customers, list_customers' )) {
            return redirect()->route( 'admin.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $customers = User::query()
            ->withRole( 'customer' )
            ->withCount( 'reviews' )
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.customers.index', compact( 'customers' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_customers' )) {
            return redirect()->route( 'admin.index' );
        }


        return view( 'back-end.customers.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_customers' )) {
            return redirect()->route( 'admin.index' );
        }

        try {

            if ($request->has( 'user_image' )) {
                $img = $request->file( 'user_image' );
                $file_name = $this->imageStore( $img, $request->username );
            } else {
                $file_name = 'user.png';
            }

            $customer = User::create( [
                'username' => $request->username,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make( $request->password ),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'user_image' => $file_name,
                'status' => $request->status,
            ] );

            $role = Role::whereName( 'customer' )->first();
            $customer->attachRole( $role );

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.customer.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param User  $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer)
    {
        if (!auth()->user()->ability( 'admin', 'display_customers' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.customers.show', compact( 'customer' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User  $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $customer)
    {
        if (!auth()->user()->ability( 'admin', 'update_customers' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.customers.edit', compact( 'customer' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest  $request
     * @param User             $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, User $customer)
    {

        if (!auth()->user()->ability( 'admin', 'update_customers' )) {
            return redirect()->route( 'admin.index' );
        }
        try {


            if ($request->has( 'user_image' )) {
                $img = $request->file( 'user_image' );
                $this->removeImage( $customer->id );
                $file_name = $this->imageStore( $img, $request->username );
            } else {
                $file_name = $customer->user_image;
            }

            $customer->update( [
                'username' => $request->username,
                'email' => $request->email,
                'email_verified_at' => now(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'user_image' => $file_name,
                'status' => $request->status,
            ] );
            if ($request->password != NULL) {
                $customer->password = Hash::make( $request->password );
                $customer->save();

            }
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.customer.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User  $customer
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        if (!auth()->user()->ability( 'admin', 'delete_customers' )) {
            return redirect()->route( 'admin.index' );
        }
        $this->removeImage( $customer->id );
        $customer->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.customer.index' );
    }

    public function removeImage($id)
    {
        if (!auth()->user()->ability( 'admin', 'delete_customers' )) {
            return redirect()->route( 'admin.index' );
        }
        $customer = User::findOrFail( $id );
        $path = public_path( "/assets/users/{$customer->user_image}" );
        if (File::exists( $path ) && $customer->user_image != NULL && $customer->user_image != 'user.png') {
            unlink( $path );
        }
        $customer->user_image = 'user.png';
        $customer->save();

        return TRUE;
    }


    public function imageStore($img_data, $username)
    {
        $file_name = Str::slug( $username ) . '.' . $img_data->getClientOriginalExtension();
        $path = public_path( "/assets/users/{$file_name}" );
        Image::make( $img_data->getRealPath() )->resize( 300, NULL, function ($constraint) {
            $constraint->aspectRatio();
        } )->save( $path, 100 );

        return $file_name;
    }

}
