<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        if ($request->query('with_products')) {
            $categories = Category::with('products')->get();
        } else {
            $categories = Category::all();
        }

        if ($categories->isEmpty()) {
            throw new NotFoundHttpException('No categories found');
        }

        return ApiResponse::success(200, 'OK', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request) {
        $request->validated();

        $category = Category::create($request->all());

        return ApiResponse::success(201, 'CREATED', $category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, Request $request) {
        if ($request->query('with_products')) {
            $category->load('products');
        }

        return ApiResponse::success(200, 'OK', $category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category) {
        $request->validated();

        $category->update($request->all());

        return ApiResponse::success(200, 'OK', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category) {
        $category->delete();

        return ApiResponse::success(204, 'NO CONTENT');
    }
}
