<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the category.
     */
    #[QueryParameter('search', description: 'search by using name', type: 'string', example: "Electronics, Groceries, Clothing")]
    #[QueryParameter('page', description: 'page', type: 'string', example: "2")]
    #[QueryParameter('per_page', description: 'per page', type: 'string', example: "9")]
    public function index(Request $request)
    {
        $data = $this->categoryService->index($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $this->categoryService->store($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $data
        ], 201);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $category
        ], 200);
    }

    /**
     * Update the specified category.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $category
        ], 200);
    }
}
