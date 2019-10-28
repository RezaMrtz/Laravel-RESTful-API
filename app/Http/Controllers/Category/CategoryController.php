<?php

namespace App\Http\Controllers\Category;


use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StoreCategory;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store','update']);
        $this->middleware('auth:api')->except(['store','update']);
        $this->middleware('transform.input:' . CategoryTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:read-general')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $category = Category::all();

        return $this->showAll($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $this->allowedAdminAction();

        $validate = $request->validate();

        $newCategory = Category::create($request->all());

        return $this->showOne($newCategory, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->allowedAdminAction();

        $category->fill($request->only([
            'name',
            'description'
        ]));

        if ($category->isClean()) {

            return $this->errorResponse('You have to specify any different value to update', 422);

        }

        $category->save();

        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->allowedAdminAction();

        $category->delete();

        return $this->showOne($category);
    }
}
