<?php

namespace Modules\Settings\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
         $this->middleware('permission:settings-list|settings-create|settings-edit|settings-delete', ['only' => ['index','show']]);
         $this->middleware('permission:settings-create', ['only' => ['create','store']]);
         $this->middleware('permission:settings-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:settings-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        //dd(generateMenuJson());
        return view('Settings::settings');
    }
    public function help()
    {
        return view('Settings::help');
    }
    public function menu()
    {
        return view('Settings::menu');
    }
    public function artisan()
    {
        return view('Settings::artisan');
    }
    public function components()
    {
        return view('Settings::components');
    }

}
