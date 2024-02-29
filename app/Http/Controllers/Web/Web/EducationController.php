<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\education;
use App\article;
use App\article_categories;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\CPU\Helpers;
class EducationController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd(0);
        $popularArticles = article::orderbyDesc('views')->limit(12)->get();
            $categories = article_categories::all();
            $data = [];
            foreach ($categories as $category) {
                $articleList = [];
                $articlesQuery = article::where([['category_id', $category->id]])->select('title', 'slug')->get();
                foreach ($articlesQuery as $singleArticle) {
                    $articleList[] = $singleArticle;
                }
                $data[] = ['categories' => $category, 'articles' => $articleList];
            }
            return view('web-views.education.web-views.education.frontend.home', ['data' => $data, 'popularArticles' => $popularArticles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit(education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, education $education)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy(education $education)
    {
        //
    }
    public function home(Request $request)
    {
        if(!Helpers::store_module_permission_check('store.home.show_education')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        if (!$request->has('q')) {
        $popularArticles = article::where('deleted',0)->where('for','stores')->where('status',1)->latest()->limit(12)->get();
            $categories = article_categories::where('deleted',0)->where('for','stores')->get();
            $data = [];
            foreach ($categories as $category) {
                $articleList = [];
                $articlesQuery = article::where('category_id', $category->id)
                ->where('deleted', 0)->where('for','stores')->where('status',1)
                ->select('title', 'slug')
                ->get();
                foreach ($articlesQuery as $singleArticle) {
                    $articleList[] = $singleArticle;
                }
                $data[] = ['categories' => $category, 'articles' => $articleList];
            }
            return view('web-views.education.frontend.home', ['data' => $data, 'popularArticles' => $popularArticles]);
        } else {
            $q = $request->q;
            $articles = article::where('deleted', 0)->where('for','stores')->where('status',1)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', '%' . $q . '%')
                      ->orWhere('slug', 'like', '%' . $q . '%')
                      ->orWhere('content', 'like', '%' . $q . '%')
                      ->orWhere('short_description', 'like', '%' . $q . '%');
            })
            ->select('slug', 'title')
            ->get();
            return view('web-views.education.frontend.search', ['articles' => $articles]);
        }
    }
    public function category($slug)
    {
        if(!Helpers::store_module_permission_check('store.home.show_education')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $categoryy = article_categories::where([['slug', $slug]])->where('deleted',0)->where('for','stores')->first();
        $popularArticles = article::where('deleted',0)->where('for','stores')->where('status',1)->get();
        $categories = article_categories::where('deleted',0)->where('for','stores')->get();
        $data = [];
        foreach ($categories as $category) {
            $articleList = [];
            $articlesQuery = article::where([['category_id', $category->id]])->where('deleted', 0)->where('for','stores')->where('status',1)->select('title', 'slug')->get();
            foreach ($articlesQuery as $singleArticle) {
                $articleList[] = $singleArticle;
            }
            $data[] = ['categories' => $category, 'articles' => $articleList];
        }
        $popularArticles = article::where('deleted',0)->where('for','stores')->where('status',1)->where('status',1)->get();
        if ($categoryy) {
            $articles = article::where('deleted',0)->where('for','stores')->where('status',1)->where('category_id', $categoryy->id)->paginate(10);
            return view('web-views.education.frontend.category', ['category' => $categoryy, 'articles' => $articles, 'data' => $data, 'popularArticles' => $popularArticles]);
        } else {
            return redirect()->route('education.home');
        }
    }

    public function article($slug)
    {
        if(!Helpers::store_module_permission_check('store.home.show_education')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $article = article::where('deleted',0)->where('for','stores')->where('status',1)->where([['slug', $slug]])->with('category')->first();
        $popularArticles = article::where('deleted',0)->where('for','stores')->where('status',1)->get();
            $categories = article_categories::where('deleted',0)->where('for','stores')->get();
            $data = [];
            foreach ($categories as $category) {
                $articleList = [];
                $articlesQuery = article::where('deleted',0)->where('for','stores')->where('status',1)->where([['category_id', $category->id]])->select('title', 'slug')->get();
                foreach ($articlesQuery as $singleArticle) {
                    $articleList[] = $singleArticle;
                }
                $data[] = ['categories' => $category, 'articles' => $articleList];
            }
        $popularArticles = article::where('deleted',0)->where('for','stores')->where('status',1)->get();
        if ($article) {
            return view('web-views.education.frontend.article', ['article' => $article , 'data' => $data, 'popularArticles' => $popularArticles]);
        } else {
            return redirect()->route('education.home');
        }
    }

    public function search(Request $request)
    {
        if(!Helpers::store_module_permission_check('store.home.show_education')){
            Toastr::error( Helpers::translate('You do not have access'));
            return back();
        }
        $q = $request->search;
        $lang = $request->lang;
        $articles = article::where('deleted', 0)->where('for','stores')->where('status',1)
        ->where(function ($query) use ($q) {
            $query->where('title', 'like', '%' . $q . '%')
                  ->orWhere('slug', 'like', '%' . $q . '%')
                  ->orWhere('content', 'like', '%' . $q . '%')
                  ->orWhere('short_description', 'like', '%' . $q . '%');
        })
        ->select('slug', 'title')
        ->get();

        $output = '';
        if ($articles->count() > 0) {
            foreach ($articles as $article) {
                $output .= '<a class="search-item" href="' . route('education.article', $article->slug) . '"> <i class="far fa-file-alt fa-lg me-2"></i>' . $article->title . '</a>';
            }
        } else {
            $output .= '<div class="empty">' . lang("No results found") . '</div>';
        }
        return $output;
    }
}
