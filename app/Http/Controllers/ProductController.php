<?php

namespace App\Http\Controllers;

use App\Services\ProductProviders\EBay;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function get(Request $request, EBay $provider)
    {
        $response = $provider->sendRequest([
            'keywords' => 'harry potter',
            'entriesPerPage' => 2,
            'pageNumber' => 1
        ]);

        // if ($response->getStatusCode() !== 200) return response()->json('Error');

        // return response()->json(['name' => 'Abigail', 'state' => 'CA']);
        return response()->json(json_decode($response));
    }
}
