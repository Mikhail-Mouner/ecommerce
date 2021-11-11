<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SupervisorRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SupervisorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param SupervisorRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SupervisorRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_supervisors, list_supervisors' )) {
            return redirect()->route( 'admin.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $supervisors = User::query()
            ->withRole( 'supervisor' )
            ->withCount( 'reviews' )
            ->with( 'permissions:display_name' )
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.supervisors.index', compact( 'supervisors' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_supervisors' )) {
            return redirect()->route( 'admin.index' );
        }
        $permissions = Permission::where( 'parent', '!=', 0 )->get( [ 'id', 'display_name as name' ] );

        return view( 'back-end.supervisors.create', compact( 'permissions' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SupervisorRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SupervisorRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_supervisors' )) {
            return redirect()->route( 'admin.index' );
        }

        try {

            if ($request->has( 'user_image' )) {
                $img = $request->file( 'user_image' );
                $file_name = $this->imageStore( $img, $request->username );
            } else {
                $file_name = 'user.png';
            }

            $supervisor = User::create( [
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
            $role = Role::whereName( 'supervisor' )->first();
            $supervisor->attachRole( $role );
            if (isset( $request->permissions ) && count( $request->permissions ) > 0) {
                $supervisor->permissions()->sync( $request->permissions );
            }

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong $exception" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.supervisor.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param User  $supervisor
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $supervisor)
    {
        if (!auth()->user()->ability( 'admin', 'display_supervisors' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.supervisors.show', compact( 'supervisor' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User  $supervisor
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $supervisor)
    {
        if (!auth()->user()->ability( 'admin', 'update_supervisors' )) {
            return redirect()->route( 'admin.index' );
        }
        $permissions = Permission::where( 'parent', '!=', 0 )->get( [ 'id', 'display_name as name' ] );

        return view( 'back-end.supervisors.edit', compact( [ 'supervisor', 'permissions' ] ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SupervisorRequest  $request
     * @param User               $supervisor
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SupervisorRequest $request, User $supervisor)
    {

        if (!auth()->user()->ability( 'admin', 'update_supervisors' )) {
            return redirect()->route( 'admin.index' );
        }
        try {


            if ($request->has( 'user_image' )) {
                $img = $request->file( 'user_image' );
                $this->removeImage( $supervisor->id );
                $file_name = $this->imageStore( $img, $request->username );
            } else {
                $file_name = $supervisor->user_image;
            }

            $supervisor->update( [
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
                $supervisor->password = Hash::make( $request->password );
                $supervisor->save();
            }
            if (isset( $request->permissions ) && count( $request->permissions ) > 0) {
                $supervisor->permissions()->sync( $request->permissions );
            }
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.supervisor.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User  $supervisor
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $supervisor)
    {
        if (!auth()->user()->ability( 'admin', 'delete_supervisors' )) {
            return redirect()->route( 'admin.index' );
        }
        $this->removeImage( $supervisor->id );
        $supervisor->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.supervisor.index' );
    }

    public function removeImage($id)
    {
        if (!auth()->user()->ability( 'admin', 'delete_supervisors' )) {
            return redirect()->route( 'admin.index' );
        }
        $supervisor = User::findOrFail( $id );
        $path = public_path( "/assets/users/{$supervisor->user_image}" );
        if (File::exists( $path ) && $supervisor->user_image != NULL && $supervisor->user_image != 'user.png') {
            unlink( $path );
        }
        $supervisor->user_image = 'user.png';
        $supervisor->save();

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
