<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoriesRequest;
use App\Http\Requests\Categories\UpdateCategoriesRequest;
use App\Services\CategoryService;
use App\Traits\ApiResponse;

class CategoriesController extends Controller
{
    use ApiResponse;

    protected $CategoriesServices;

    public function __construct(CategoryService $CategoriesServices)
    {
        $this->CategoriesServices = $CategoriesServices;
    }

    public function index()
    {
        $CategoriesServices = $this->CategoriesServices->getAllCategories();
        return $this->successResponse($CategoriesServices);
    }

    public function store(StoreCategoriesRequest $request)
    {
        $CategoriesServices = $this->CategoriesServices->create($request->validated());
        return $this->successResponse($CategoriesServices, 'Category created successfully', 201);
    }

    public function update(UpdateCategoriesRequest $request, $id)
    {
        $CategoriesServices = $this->CategoriesServices->update($id, $request->validated());
        return $this->successResponse($CategoriesServices, 'Category updated successfully');
    }

    public function destroy($id)
    {
        $CategoriesServices = $this->CategoriesServices->delete($id);
        return $this->successResponse($CategoriesServices, 'Category deleted successfully');
    }
}
