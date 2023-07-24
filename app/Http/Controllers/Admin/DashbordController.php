<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\dashbord;
use Illuminate\Http\Request;

class DashbordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('dabri.pages.dashboard');
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
     * @param  \App\Models\Admin\dashbord  $dashbord
     * @return \Illuminate\Http\Response
     */
    public function show(dashbord $dashbord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\dashbord  $dashbord
     * @return \Illuminate\Http\Response
     */
    public function edit(dashbord $dashbord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\dashbord  $dashbord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dashbord $dashbord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\dashbord  $dashbord
     * @return \Illuminate\Http\Response
     */
    public function destroy(dashbord $dashbord)
    {
        //
    }
}
