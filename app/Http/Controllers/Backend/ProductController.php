<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'manage_products, list_products' )) {
            return redirect()->route( 'backend.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config('general.general_order_by');
        $paginate = $request->limit_by ?? config('general.general_paginate');
        $products = Product::with( 'category:name,id' )
            ->with( 'tags:name' )
            ->with( 'firstMedia' )
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );

        return view( 'back-end.products.index', compact( 'products' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_products' )) {
            return redirect()->route( 'backend.index' );
        }

        $main_categories = ProductCategory::select( [
            'id', 'name',
        ] )->whereStatus( TRUE )->get();
        $tags = Tag::select( [ 'id', 'name' ] )->whereStatus( TRUE )->get();

        return view( 'back-end.products.create', compact( [ 'main_categories', 'tags' ] ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_products' )) {
            return redirect()->route( 'backend.index' );
        }

        try {

            $product = Product::create( [
                'name' => $request->name,
                'product_category_id' => $request->category_id,
                'description' => $request->desc,
                'price' => $request->price,
                'qty' => $request->qty,
                'featured' => $request->featured,
                'status' => $request->status,
            ] );
            $product->tags()->attach( $request->tag_id );
            if ($request->has( 'img' )) {
                foreach ($request->img as $index => $img_data) {
                    if ($index + 1 > 5) {
                        break;
                    }
                    $this->imageStore( $img_data, $product, $index + 1 );
                }
            }

            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.product.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('back-end.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product  $product
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!auth()->user()->ability( 'admin', 'update_products' )) {
            return redirect()->route( 'backend.index' );
        }

        $main_categories = ProductCategory::select( [
            'id', 'name',
        ] )->whereStatus( TRUE )->get();
        $tags = Tag::select( [ 'id', 'name' ] )->whereStatus( TRUE )->get();

        return view( 'back-end.products.edit', compact( [ 'main_categories', 'tags', 'product' ] ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest  $request
     * @param Product         $product
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {

        if (!auth()->user()->ability( 'admin', 'update_products' )) {
            return redirect()->route( 'backend.index' );
        }
        try {

            $product->update( [
                'name' => $request->name,
                'product_category_id' => $request->category_id,
                'description' => $request->desc,
                'price' => $request->price,
                'qty' => $request->qty,
                'featured' => $request->featured,
                'status' => $request->status,
            ] );
            $product->tags()->sync( $request->tag_id );

            if ($request->has( 'img' )) {
                $index = $product->media()->count();
                foreach ($request->img as $img_data) {
                    if ($index >= 5) {
                        break;
                    }
                    $index++;

                    $this->imageStore( $img_data, $product, $index );

                }
            }
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.product.index' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product  $product
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!auth()->user()->ability( 'admin', 'delete_products' )) {
            return redirect()->route( 'backend.index' );
        }
        $product->media()->each( function ($medie) {
            $this->removeImage( $medie->id );
        } );
        $product->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.product.index' );


    }

    public function removeImage($id)
    {
        if (!auth()->user()->ability( 'admin', 'delete_products, update_products' )) {
            return redirect()->route( 'backend.index' );
        }
        $media = Media::findOrFail( $id );
        $path = public_path( "/assets/products/{$media->file_name}" );
        if (File::exists( $path ) && $media->file_name != NULL) {
            unlink( $path );
            $media->delete();
        }

        return TRUE;
    }

    public function imageStore($img_data, $product, $index)
    {
        $file_name = $product->slug . '_' . time() . '_' . ( $index ) . '_' . $img_data->getClientOriginalExtension();
        $file_size = $img_data->getSize();
        $file_type = $img_data->getMimeType();

        $path = public_path( "/assets/products/{$file_name}" );
        Image::make( $img_data->getRealPath() )->resize( 500, NULL, function ($constraint) {
            $constraint->aspectRatio();
        } )->save( $path, 100 );

        $product->media()->create( [
            'file_name' => $file_name,
            'file_type' => $file_type,
            'file_size' => $file_size,
            'file_status' => TRUE,
            'file_sort' => $index,
        ] );
    }

}
