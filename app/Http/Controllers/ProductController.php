<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // get all products sorted by id
        $products = Product::orderBy('id')->paginate(10);

        if ($products->isEmpty()) {
            throw new NotFoundHttpException('No products found');
        }

        return ApiResponse::successCollection(200, 'OK', $products);
    }

    public function search($keyword) {
        // check if keyword more than 1 words and split it
        if (str_word_count($keyword) > 1) {
            $keyword = explode(' ', $keyword);

            // get all products that contain the keywords in their name case-insensitive
            $products = Product::where(function ($query) use ($keyword) {
                foreach ($keyword as $word) {
                    $query->orWhere('name', 'ilike', "%$word%");
                }
            })->orderBy('id')->paginate(10);
        } else {
            // get all products that contain the keyword in their name case-insensitive
            $products = Product::where('name', 'ilike', "%$keyword%")->orderBy('id')->paginate(10);
        }


        if ($products->isEmpty()) {
            throw new NotFoundHttpException('No products found');
        }

        return ApiResponse::successCollection(200, 'OK', $products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) {
        $request->validated();

        $product = Product::create($request->all());

        return ApiResponse::success(201, 'CREATED', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) {
        return ApiResponse::success(200, 'OK', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product) {
        $request->validated();

        $product->update($request->all());

        return ApiResponse::success(200, 'OK', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {
        $product->delete();

        return ApiResponse::success(204, 'NO CONTENT');
    }
}
