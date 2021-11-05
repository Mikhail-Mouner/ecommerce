<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TagRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TagRequest $request)
    {
        if (!auth()->user()->ability( 'admin', 'manage_tags, list_tags' )) {
            return redirect()->route( 'admin.index' );
        }

        $sort_by = $request->sort_by ?? 'id';
        $order_by = $request->order_by ?? 'asc';
        $paginate = $request->limit_by ?? 10;
        $tags = Tag::withCount( 'products' )
            ->when( $request->keyword, function ($q) use ($request) {
            return $q->search( $request->keyword );
        } )->when( $request->status !== NULL, function ($q) use ($request) {
            return $q->whereStatus( $request->status );
        } )
            ->orderBy( $sort_by, $order_by )
            ->paginate( $paginate );


        return view( 'back-end.tags.index', compact( 'tags' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->ability( 'admin', 'create_tags' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.tags.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        try {
            Tag::create( [
                'name' => $request->name,
                'status' => $request->status,
            ] );
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Insert Data Successfully' ] );
        } catch (\Exception $exception) {
            session()->flash( 'mssg', [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();
        }

        return redirect()->route( 'backend.tag.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param Tag  $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        if (!auth()->user()->ability( 'admin', 'display_tags' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.tag.show', compact( 'tag' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tag  $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        if (!auth()->user()->ability( 'admin', 'update_tags' )) {
            return redirect()->route( 'admin.index' );
        }

        return view( 'back-end.tags.edit', compact( 'tag' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagRequest  $request
     * @param Tag         $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {

        if (!auth()->user()->ability( 'admin', 'update_tags' )) {
            return redirect()->route( 'admin.index' );
        }

        try {
            $tag->update( [
                'name' => $request->name,
                'status' => $request->status,
            ] );
            session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Update Data Successfully' ] );

        } catch (\Exception $exception) {
            session()->flash( 'mssg',
                [ 'status' => 'danger', 'data' => "Something Goes Wrong" ] );

            return redirect()->back();

        }

        return redirect()->route( 'backend.tag.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag  $tag
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if (!auth()->user()->ability( 'admin', 'delete_tags' )) {
            return redirect()->route( 'admin.index' );
        }
        $tag->delete();
        session()->flash( 'mssg', [ 'status' => 'success', 'data' => 'Remove Data Successfully' ] );

        return redirect()->route( 'backend.tag.index' );
    }

}
