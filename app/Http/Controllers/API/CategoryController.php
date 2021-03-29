<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return response($category, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $category = Category::create($data);

        return response(['category' => $category, 'message' => 'Created successfully'], 200);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (!$this->checkId($category->getAttribute('id'))) {
            return response('Category ID does not exist');
        }
        return response(['category' => $category, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        if (!$this->checkId($category->getAttribute('id'))) {
            return response('Category ID does not exist');
        }

        $category->update($data);

        return response(['category' => $category, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if (!$this->checkId($category->getAttribute('id'))) {
            return response('Category ID does not exist');
        }

        $category->delete();

        return response(['message' => 'Deleted']);
    }

    private function checkId($id) {
        if (!in_array($id, Category::all()->pluck('id')->toArray())) {
            return false;
        }
        return true;
    }
}
