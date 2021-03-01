<?php

namespace App\Http\Controllers;

use App\Jobs\ProductProvidersJob;
use App\Repositories\KeywordRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepository;
    private $keywordRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProductRepository $productRepository,
        KeywordRepository $keywordRepository
    ) {
        $this->productRepository = $productRepository;
        $this->keywordRepository = $keywordRepository;
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'keywords' => 'required',
            'price_min' => 'required_with:price_max|numeric',
            'price_max' => 'required_with:price_min|numeric',
            'sorting' => 'alpha_dash'
        ]);

        $parameters = $request->all();

        if (!$this->keywordRepository->hasValidKeyword($parameters['keywords'])) {
            dispatch(new ProductProvidersJob($parameters));
        }

        return response()->json([
            'products' => $this->productRepository->get($parameters)
        ]);
    }
}
