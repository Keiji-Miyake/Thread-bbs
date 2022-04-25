<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\Listing;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = Auth::user()->listings;

        return view('listings.index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListingRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            $listing = new Listing();
            $listing->create($data);
        } catch (Exception $error) {
            DB::rollBack();
            Log::error($error->getMessage());
            return redirect()->back()->with('error', 'メッセージの投稿ができませんでした。');
        }
        DB::commit();

        return redirect()->route('listings.index')->with('success', 'Listing created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listing = Listing::find($id);
        return view('listings.edit', compact('listing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ListingRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            $listing = Listing::find($id);
            $listing->update($data);
        } catch (Exception $error) {
            DB::rollBack();
            Log::error($error->getMessage());
            return redirect()->back()->with('error', 'メッセージの投稿ができませんでした。');
        }
        DB::commit();

        return redirect()->route('listings.index')->with('success', 'Listing created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $listing = Listing::find($id);
        $listing->delete();

        return redirect()->route('listings.index')->with('success', "{$listing->name} を削除しました。");
    }
}
