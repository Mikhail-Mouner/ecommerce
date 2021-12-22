<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function dashboard()
    {
        return view('front-end.customer.index');
    }

    public function addresses()
    {
        return view('front-end.customer.addresses');
    }
    
    public function profile()
    {
        return view('front-end.customer.profile');
    }
    
    public function orders()
    {
        return view('front-end.customer.orders');
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = auth()->user();

        if ($request->has( 'user_image' )) {
            $img = $request->file( 'user_image' );
            $this->removeImage();
            $file_name = $this->imageStore( $img, $request->username );
        } else {
            $file_name = $user->user_image;
        }

        $user->update( [
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'user_image' => $file_name,
        ] );
        
        if (!empty($request->password) && Hash::check($request->password,$user->password)) {
            $user->password = Hash::make( $request->password );
            $user->save();
        }
        toast('Your Profile Is Update Successfully!', 'success');

        return redirect()->route('frontend.customer.profile');
    }

    
    public function removeProfileImage()
    {
        $this->removeImage();
        toast('Your Profile Image Is Remove Successfully!', 'success');

        return redirect()->route('frontend.customer.profile');
    }

    public function removeImage()
    {
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
