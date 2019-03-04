<?php

namespace App\Modules\Argaam\Http\Controllers\Front;

use App\Modules\Generic\Http\Controllers\Front\GenericFrontController;

use Illuminate\Container\Container as Application;
use App\Modules\Argaam\Http\Requests\ArticleRequest;
use App\Modules\Argaam\Repositories\ArticleRepository;
use App\Modules\Argaam\Models\Article;

class ArticleFrontController extends GenericFrontController
{
    public $ArticleRepository;

    public function __construct()
    {
        parent::__construct();

        $this->ArticleRepository=new ArticleRepository(new Application);
    }

    public function articles($category_id, $category)
    {

        $title = 'articles';
        $this->request_array = ['id'];
        $request_array = $this->request_array;
        foreach ($request_array as $item) $$item = request()->has($item) ? request()->$item : false;

        $articles = $this->ArticleRepository->with('category')->where('category_id', $category_id)->orderBy('id', 'DESC');
        $search_query = request()->query();
        $articles = $articles->paginate(10);
        $total = $articles->count();

        return view('argaam::Front.articles', compact('articles','title', 'total', 'search_query'));
    }
    public function article($id, $article)
    {
        $this->request_array = ['id'];
        $article = $this->ArticleRepository->with('category')->where('id', $id)->first();

        $title = $article->title;

        return view('argaam::Front.article', compact('article','title'));
    }
}
