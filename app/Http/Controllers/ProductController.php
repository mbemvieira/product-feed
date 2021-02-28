<?php

namespace App\Http\Controllers;

use App\Services\ProductProviders\Clients\EBayClient;
use App\Services\ProductProviders\Mappers\EbayMapper;
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

    public function get(Request $request, EBayClient $provider)
    {
        $response = $provider->sendRequest([
            'keywords' => 'harry potter',
            'entriesPerPage' => 2,
            'pageNumber' => 1
        ]);

        if ($response === null) return response('Error', 500);

        // return response()->json(json_decode($response));

        $mapper = new EbayMapper(json_decode($response));

        if (!$mapper->isValidContent()) return response('Error', 500);

        return response()->json(['products' => $mapper->getProducts()]);
    }
}
