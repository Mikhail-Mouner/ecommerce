<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductCategoryRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductCategoryRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_product_categories, list_product_categories' )) {
            return redirect()->route( 'backend.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $categories = ProductCategory::withCount( 'products' )
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )->with( 'parent' )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );


        return view( 'back-end.product_categories.index', compact( 'categories' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_product_categories' )) {
            return redirect()->route( 'backend.index' );
        }

        $main_categories = ProductCategory::select( [ 'id', 'name' ] )->whereNull( 'parent_id' )->get();

        return view( 'back-end.product_categories.create', compact( 'main_categories' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCategoryRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_product_categories' )) {
            return redirect()->route( 'backend.index' );
        }

        try {
            /** Todo: Create Method to save Image */

            if ($request->has( 'cover' )) {
                $img = $request->file( 'cover' );
                $file_name = Str::slug( $request->name ) . '.' . $img->getClientOriginalExtension();
                $path = public_path( "/assets/product_categories/{$file_name}" );
                Image::make( $img->getRealPath() )->resize( 500, NULL, function ($constraint) {
                    $constraint->aspectRatio();
                } )->save( $path, 100 );
            }

            ProductCategory::create( [
                'name' => $request->name,
                'status' => $request->status,
                'cover' => $file_name,
                'parent_id' => $request->parent_id,
            ] );
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.product_categories.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param ProductCategory  $productCategory
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        if (!auth()->user()->ability( 'admin', 'display_product_categories' )) {
            return redirect()->route( 'backend.index' );
        }

        return view( 'back-end.product_categories.show', compact( 'productCategory' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductCategory  $productCategory
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        if (!auth()->user()->ability( 'admin', 'update_product_categories' )) {
            return redirect()->route( 'backend.index' );
        }
        $main_categories = ProductCategory::select( [ 'id', 'name' ] )
            ->whereNull( 'parent_id' )
            ->where( 'id', '!=', $productCategory->id )
            ->get();

        return view( 'back-end.product_categories.edit', compact( [ 'main_categories', 'productCategory' ] ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductCategoryRequest  $request
     * @param ProductCategory         $productCategory
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {

        if (!auth()->user()->ability( 'admin', 'update_product_categories' )) {
            return redirect()->route( 'backend.index' );
        }
        try {

            if ($request->has( 'cover' )) {
                $this->removeImage( $productCategory->id );
                $img = $request->file( 'cover' );
                $file_name = Str::slug( $request->name ) . '.' . $img->getClientOriginalExtension();
                $path = public_path( "/assets/product_categories/{$file_name}" );
                Image::make( $img->getRealPath() )->resize( 500, NULL, function ($constraint) {
                    $constraint->aspectRatio();
                } )->save( $path, 100 );
            } else {
                $file_name = $productCategory->cover;
            }

            $productCategory->update( [
                'name' => $request->name,
                'status' => $request->status,
                'cover' => $file_name,
                'parent_id' => $request->parent_id,
            ] );
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.product_categories.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductCategory  $productCategory
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        if (!auth()->user()->ability( 'admin', 'delete_product_categories' )) {
            return redirect()->route( 'backend.index' );
        }
        $this->removeImage( $productCategory->id );
        $productCategory->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.product_categories.index' );
    }

    public function removeImage($id)
    {
        if (!auth()->user()->ability( 'admin', 'delete_product_categories' )) {
            return redirect()->route( 'backend.index' );
        }
        $productCategory = ProductCategory::findOrFail( $id );
        $path = public_path( "/assets/product_categories/{$productCategory->cover}" );
        if (File::exists( $path ) && $productCategory->cover != NULL) {
            unlink( $path );
            $productCategory->cover = NULL;
            $productCategory->save();
        }

        return TRUE;
    }

}
