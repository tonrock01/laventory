<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockLog\StockInOutRequest;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\StockLogService;
use App\Traits\VersioningControllerTrait;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;

class StockLogController extends Controller
{
    use VersioningControllerTrait;

    protected $stockLogService, $productService;

    public function __construct(StockLogService $stockLogService, ProductService $productService)
    {
        $this->stockLogService = $stockLogService;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the stock logs.
     */
    #[QueryParameter('search', description: 'search by using name', type: 'string', example: "Milk")]
    #[QueryParameter('action_type', description: 'search by action_type 1 = in, 2 = out', type: 'integer', example: 1)]
    #[QueryParameter('start_date', description: 'search by date', type: 'string', example: "2025-6-25")]
    #[QueryParameter('end_date', description: 'search by date', type: 'string', example: "2025-6-25")]
    #[QueryParameter('page', description: 'page', type: 'string', example: "2")]
    #[QueryParameter('per_page', description: 'per page', type: 'string', example: "5")]
    public function index(Request $request)
    {
        $data = $this->stockLogService->index($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created stock in.
     */
    public function stockIn(StockInOutRequest $request)
    {
        $product = $this->productService->findProduct($request->product_id);

        // check version
        if ($error = $this->checkVersion($product, $request->product_version)) {
            return $error;
        }

        $data = $this->stockLogService->stockIn($request->all(), $product);

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 201);
    }

    /**
     * Store a newly created stock out.
     */
    public function stockOut(StockInOutRequest $request)
    {
        $product = $this->productService->findProduct($request->product_id);

        // check version
        if ($error = $this->checkVersion($product, $request->product_version)) {
            return $error;
        }

        $data = $this->stockLogService->stockOut($request->all(), $product);

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 201);
    }

    /**
     * Display a listing of the product logs.
     */
    #[QueryParameter('page', description: 'page', type: 'string', example: "2")]
    #[QueryParameter('per_page', description: 'per page', type: 'string', example: "5")]
    public function productLogs(Request $request, Product $product)
    {
        $data = $this->stockLogService->productLogs($request->all(), $product);

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
}
