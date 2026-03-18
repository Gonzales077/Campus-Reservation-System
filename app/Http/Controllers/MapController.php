<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $facilities = Facility::where('status', 'active')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('map.index', compact('facilities'));
    }
}
