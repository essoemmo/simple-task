<?php

namespace App\Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Product\Http\Resources\ProductResource;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Services\ProductService;
use App\Modules\Product\Http\Requests\ProductRequest;
use App\Shared\Requests\PageRequest;
use App\Shared\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;

    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(PageRequest $pageRequest): JsonResponse
    {
        $products = Product::paginate($pageRequest->page_count);
        return self::successResponsePaginate(data: ProductResource::collection($products)->response()->getData(true));
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $productData = $request->validated();
        $product = $this->productService->createProduct($productData);
        return self::successResponse(__("application.created"), ProductResource::make($product));
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $product = $this->productService->updateProduct($product, $request->validated());
        return self::successResponse(__("application.updated"), ProductResource::make($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return self::successResponse(__("application.deleted"));
    }

}
