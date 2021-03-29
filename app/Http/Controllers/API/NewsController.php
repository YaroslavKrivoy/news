<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class NewsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index() {
        $news = News::all()->where('isVisible', 1);
        return response(['news' => $news, 'message' => 'Success'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->all();

        if(!$this->validateData($data)) {
            return response('Validation Error');
        }

        if(!$this->checkData($data)) {
            return response(['error' => 'Category or user not found']);
        }

        $news = News::create($data);

        return response(['news' => $news, 'message' => 'Created successfully'], 200);
    }

    /**
     * @param News $news
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(News $news) {
        return response(['news' => $news, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * @param Request $request
     * @param News $news
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Request $request, News $news) {
        $data = $request->all();

        if(!$this->validateData($data, true)) {
            return response('Validation Error');
        }

        if(!$this->checkData($data)) {
            return response(['error' => 'Category or user not found']);
        }

        if (!$this->checkUser($news)) {
            abort(403);
        }

        $news->update($data);

        return response(['news' => $news, 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * @param News $news
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(News $news) {
        if (!$this->checkUser($news)) {
            abort(403);
        }
        $news->delete();

        return response(['message' => 'Deleted']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function showByCategoryId($id) {
        if(!Category::find($id)) {
            return response('Category ID does not exist', 200);
        }
        $news = News::all()->where('isVisible',1)->where('category_id', $id);
        if (is_null($news)) {
            return response('No matches found', 200);
        }
        return response(['news' => $news, 'message' => 'Success'], 200);
    }

    /**
     * @param $data
     * @return bool
     */
    private function checkData($data) {
        if(array_key_exists('category_id', $data) && array_key_exists('user_id', $data)) {
            if(!in_array($data['category_id'], Category::all()->pluck('id')->toArray()) || !in_array($data['user_id'], User::all()->pluck('id')->toArray()) ) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $data
     * @param bool $isUpdate
     * @return bool
     */
    private function validateData($data, $isUpdate = false) {
        if(!$isUpdate) {
            $validator = Validator::make($data, [
                'title' => 'required|max:255',
                'short_description' => 'required|max:255',
                'description' => 'required',
                'isVisible' => 'required',
                'image_url' => 'required|max:255',
                'category_id' => 'required',
                'user_id' => 'required',
            ]);
        } else {
            $validator = Validator::make($data, [
                'title' => 'max:255',
                'short_description' => 'max:255',
                'image_url' => 'max:255',
            ]);
        }

        if ($validator->fails()) {
            return false;
        }
        return true;
    }

    /**
     * @param News $news
     * @return bool
     */
    private function checkUser(News $news) {
        if($news->getAttribute('user_id') == auth()->id()) {
            return true;
        }
        return false;
    }
}
