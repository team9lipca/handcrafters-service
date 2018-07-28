<?php

namespace App\Http\Controllers\API;

use App\Craft;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class CraftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $craftsDto = Craft::all();

        foreach($craftsDto as $key => $craft) {
            $craftsDto[$key]['author'] = User::findOrFail($craft['author_id']);
        }

        return $craftsDto;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Craft  $craft
     * @return \Illuminate\Http\Response
     */
    public function show(Craft $craft)
    {
        $craft['author'] = User::find($craft['author_id']);
        return $craft;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Craft  $craft
     * @return \Illuminate\Http\Response
     */
    public function edit(Craft $craft)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Craft  $craft
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Craft $craft)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Craft  $craft
     * @return \Illuminate\Http\Response
     */
    public function destroy(Craft $craft)
    {
        //
    }
}
