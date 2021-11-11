<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductReviewRequest;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductReviewRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductReviewRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'manage_product_reviews, list_product_reviews' )) {
            return redirect()->route( 'admin.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? config( 'general.general_order_by' );
        $paginate = $request->limit_by ?? config( 'general.general_paginate' );
        $reviews = ProductReview::query()
            ->with( 'product' )
            ->with( 'user' )
            ->when( $request->keyword, function ($q) use ($request) {
                return $q->search( $request->keyword );
            } )->when( $request->status !== NULL, function ($q) use ($request) {
                return $q->whereStatus( $request->status );
            } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );


        return view( 'back-end.product_reviews.index', compact( 'reviews' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_product_reviews' )) {
            return redirect()->route( 'admin.index' );
        }


        return view( 'back-end.product_reviews.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductReviewRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductReviewRequest $request)
    {

        if (!auth()->user()->ability( 'admin', 'create_product_reviews' )) {
            return redirect()->route( 'admin.index' );
        }

        try {
            ProductReview::create( $request->validated() );
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.product_reviews.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param ProductReview  $product_review
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProductReview $product_review)
    {
        if (!auth()->user()->ability( 'admin', 'display_product_reviews' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.product_reviews.show', compact( 'product_review' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductReview  $product_review
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductReview $product_review)
    {
        if (!auth()->user()->ability( 'admin', 'update_product_reviews' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.product_reviews.edit', compact( 'product_review' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductReviewRequest  $request
     * @param ProductReview         $product_review
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductReviewRequest $request, ProductReview $product_review)
    {
        if (!auth()->user()->ability( 'admin', 'update_product_reviews' )) {
            return redirect()->route( 'admin.index' );
        }

        try {
            $product_review->update( $request->validated() );
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.product_reviews.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductReview  $product_review
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductReview $product_review)
    {
        if (!auth()->user()->ability( 'admin', 'delete_product_reviews' )) {
            return redirect()->route( 'admin.index' );
        }
        $product_review->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.product_reviews.index' );
    }

}
