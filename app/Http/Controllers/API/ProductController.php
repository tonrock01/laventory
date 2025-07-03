<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\VersioningControllerTrait;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use VersioningControllerTrait;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the product.
     */
    #[QueryParameter('search', description: 'search by using name', type: 'string', example: "Milk")]
    #[QueryParameter('start_date', description: 'search by date', type: 'string', example: "2025-6-25")]
    #[QueryParameter('end_date', description: 'search by date', type: 'string', example: "2025-6-25")]
    #[QueryParameter('page', description: 'page', type: 'string', example: "2")]
    #[QueryParameter('per_page', description: 'per page', type: 'string', example: "5")]
    public function index(Request $request)
    {
        $data = $this->productService->index($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $this->productService->store($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 201);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $data = $this->productService->show($product);

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // check version
        if ($error = $this->checkVersion($product, $request->version)) {
            return $error;
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $product
        ], 200);
    }
}
