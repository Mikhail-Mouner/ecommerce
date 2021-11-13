<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProfileRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BackendController extends Controller
{
    public function index()
    {
        return view( 'back-end.index' );
    }

    public function login()
    {
        return view( 'back-end.auth.login' );
    }

    public function forget()
    {
        return view( 'back-end.auth.forget' );
    }

    public function accountSettings()
    {
        return view( 'back-end.account.index' );
    }

    public function updateProfile(ProfileRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'supervisor' )) {
            return redirect()->route( 'backend.index' );
        }
        $user = auth()->user();
        try {


            if ($request->has( 'user_image' )) {
                $img = $request->file( 'user_image' );
                $this->removeImage( $user->id );
                $file_name = $this->imageStore( $img, $request->username );
            } else {
                $file_name = $user->user_image;
            }

            $user->update( [
                'username' => $request->username,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'user_image' => $file_name,
            ] );

            if ($request->password != NULL) {
                $user->password = Hash::make( $request->password );
                $user->save();
            }
            if (isset( $request->permissions ) && count( $request->permissions ) > 0) {
                $user->permissions()->sync( $request->permissions );
            }
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.account_settings' );
    }

    public function removeImage()
    {
        if (!auth()->user()->ability( 'admin', 'supervisor' )) {
            return redirect()->route( 'backend.index' );
        }
        $user = auth()->user();
        $path = public_path( "/assets/users/{$user->user_image}" );
        if (File::exists( $path ) && $user->user_image != NULL && $user->user_image != 'user.png') {
            unlink( $path );
        }
        $user->user_image = 'user.png';
        $user->save();

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
