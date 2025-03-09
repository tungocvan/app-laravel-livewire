<?php

namespace Modules\Base\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
         $this->middleware('permission:base-list|base-create|base-edit|base-delete', ['only' => ['index','show']]);
         $this->middleware('permission:base-create', ['only' => ['create','store']]);
         $this->middleware('permission:base-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:base-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('Base::base');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
