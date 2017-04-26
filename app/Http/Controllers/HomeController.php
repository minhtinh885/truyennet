<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Category;
use App\Chapter;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Cast\Object_;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->getAllCategories();
        $allBooks = Book::where('published_at', '<=',Carbon::now())->orderBy('review', 'DESC')->take(23);
        $top = $allBooks->take(1)->get();
        $topBooks = $allBooks->skip(1)->take(12)->get();
        $books = $allBooks->with('categories')->skip(13)->take(10)->get();
        return view('app.index', compact(['categories', 'top', 'topBooks', 'books']));
    }
//
//    public function rss()
//    {
//
//    }
//
//    public function siteMap(SiteMap $siteMap)
//    {
//        $map = $siteMap->getSiteMap();
//        return response($map, 200)->header('Content-type', 'text/xml');
//    }

    public function show($book_slug)
    {
        $categories = $this->getAllCategories();
        $book = Book::whereSlug($book_slug)->first();
        $chapters = $book->chapters()->where('published_at', '<=',Carbon::now())->orderBy('ordinal', 'ASC')->paginate(50);
        $breadScrumbs = [];
        $authors = $book->authors()->get();
        array_push($breadScrumbs, [$book_slug, $book->name]);
        $title = $book->name;
        return view('app.show', compact(['book', 'categories', 'chapters','authors','breadScrumbs', 'title']));
    }

    public function chapter($book_slug, $chapter_slug)
    {
        $categories = $this->getAllCategories();

        $book = Book::whereSlug($book_slug)->select(['id', 'slug', 'name'])->first();
        $book_id = $book->id;
        $chapter = Chapter::where('book_id', $book_id)->where('slug_chapter', $chapter_slug)->where('published_at', '<=',Carbon::now())->first();
        $prev = null;
        $next = null;
        $prevChapter =  Chapter::where('book_id', $book_id)->where('slug_chapter', 'chuong-'.($chapter->ordinal - 1))->where('published_at', '<=',Carbon::now())->first();
        $nextChapter =  Chapter::where('book_id', $book_id)->where('slug_chapter', 'chuong-'.($chapter->ordinal + 1))->where('published_at', '<=',Carbon::now())->first();
        if($prevChapter){
            $prev = 'chuong-' . ($chapter->ordinal - 1);
        }
        if($nextChapter){
            $next = 'chuong-' . ($chapter->ordinal + 1);
        }
        $breadScrumbs = [];
        array_push($breadScrumbs, [$book_slug, $book->name]);
        array_push($breadScrumbs, [$book_slug.'/'.$chapter_slug, $chapter->title]);
        $title = $book->name . ' - ' . $chapter->title;
        return view('app.chapter', compact(['chapter', 'prev', 'next', 'categories', 'breadScrumbs', 'book', 'title']));
    }
    public function category($category_slug)
    {
        $categories = $this->getAllCategories();

        $category = Category::whereSlug($category_slug)->first();
        $books = $category->books()->orderBy('name', 'ASC')->paginate(50);
        $breadScrumbs = [];
        array_push($breadScrumbs, [$category_slug, $category->name]);
        $title = 'Truyện ' . $category->name;
        return view('app.category', compact(['books','category', 'categories', 'breadScrumbs', 'title']));
    }

    public function listOption($list_slug)
    {
        $listOptions = ['truyen-moi'=> 'Truyện mới cập nhật', 'truyen-hot'=>'Truyện Hot', 'truyen-hoan-thanh'=> 'Truyện hoàn thành'];
        $categories = $this->getAllCategories();
        $breadScrumbs = [];
        $caption = '';
        $page = \Request::has('page') ? \Request::get('page') : 1;
        if($list_slug == 'truyen-moi'){
            if(Cache::has('truyen-moi'.$page)){
                $books = Cache::get('truyen-moi'.$page);
            }else{
                $books = Book::with(['categories' => function($query){
                    $query->select(['slug', 'name'])->orderBy('name', 'asc');
                }, 'chapters' => function($query){
                    $query->select(['ordinal']);
                }])->where('published_at', '<=', Carbon::now())->select(['id', 'slug', 'name'])->orderBy('updated_at', 'DESC')->paginate(50);
                Cache::add('truyen-moi'.$page, $books, 60);
            }
/*            $books = Book::with(['categories' => function($query){
                $query->select(['slug', 'name'])->orderBy('name', 'asc');
            }, 'chapters' => function($query){
                $query->select(['ordinal']);
            }])->where('published_at', '<=', Carbon::now())->select(['id', 'slug', 'name'])->orderBy('updated_at', 'DESC')->paginate(50);*/

            $caption = $listOptions[$list_slug];
            array_push($breadScrumbs, [$list_slug, $listOptions[$list_slug]]);
            $title = 'Danh sách truyện mới';
            $description = "Danh sách truyện chữ được cập nhật (vừa ra mắt, thêm chương mới, sửa nội dung,..) gần đây.";
            $keyword = "Truyện mới cập nhật, truyen moi cap nhat, danh sach truyen moi cap nhat";
        }
        if($list_slug == 'truyen-hot'){

            if(Cache::has('truyen-hot'.$page)){
                $books = Cache::get('truyen-hot'.$page);
            }else{
                $books = Book::with(['categories' => function($query){
                    $query->select(['slug', 'name'])->orderBy('name', 'asc');
                }, 'chapters' => function($query){
                    $query->select(['ordinal']);
                }])->where('published_at', '<=', Carbon::now())->select(['id', 'slug', 'name'])->orderBy('review', 'DESC')->paginate(50);
                Cache::add('truyen-hot'.$page, $books, 60);
            }
            /*$books = Book::with(['categories' => function($query){
                $query->select(['slug', 'name'])->orderBy('name', 'asc');
            }, 'chapters' => function($query){
                $query->select(['ordinal']);
            }])->where('published_at', '<=', Carbon::now())->select(['id', 'slug', 'name'])->orderBy('review', 'DESC')->paginate(50);*/
            $caption = $listOptions[$list_slug];
            array_push($breadScrumbs, [$list_slug, $listOptions[$list_slug]]);
            $title = 'Danh sách truyện hot';
            $description = "Danh sách những truyện đang hot, có nhiều người đọc và quan tâm nhất trong tháng này.";
            $keyword = "Truyện Hot, truyen hot, danh sach truyen hot";
        }
        if($list_slug == 'truyen-hoan-thanh'){
            if(Cache::has('truyen-hoan-thanh'.$page)){
                $books = Cache::get('truyen-hoan-thanh'.$page);
            }else{
                $books = Book::with(['categories' => function($query){
                    $query->select(['slug', 'name'])->orderBy('name', 'asc');
                }, 'chapters' => function($query){
                    $query->select(['ordinal']);
                }])->where('published_at', '<=', Carbon::now())->whereStatus('Đã hoàn thành')->select(['id', 'slug', 'name'])->orderBy('name', 'DESC')->paginate(50);
                Cache::add('truyen-hoan-thanh'.$page, $books, 60);
            }
            /*$books = Book::with(['categories' => function($query){
                $query->select(['slug', 'name'])->orderBy('name', 'asc');
            }, 'chapters' => function($query){
                $query->select(['ordinal']);
            }])->where('published_at', '<=', Carbon::now())->whereStatus('Đã hoàn thành')->select(['id', 'slug', 'name'])->orderBy('name', 'DESC')->paginate(50);*/
            $caption = $listOptions[$list_slug];
            array_push($breadScrumbs, [$list_slug, $listOptions[$list_slug]]);
            $title = 'Danh sách truyện đã hoàn thành';
            $description = "Danh sách những truyện đã hoàn thành, ra đủ chương.";
            $keyword = "Truyện Full, truyen full, danh sach truyen full";
        }
        if(isset($books)){
            return view('app.list', compact(['books', 'categories', 'breadScrumbs', 'caption', 'title', 'description', 'keyword']));
        }
        return redirect('/home')->withErrors('Không tồn tại đường link dẫn đến '.$list_slug);
    }

    public function search()
    {
        $search = \Request::get('tu-khoa');
        $books = Book::where('name', 'like', '%'.$search.'%')->orderBy('name', 'ASC')->paginate(10);
        $categories = Category::orderBy('name', 'ASC')->select(['slug', 'name'])->get();
        $breadScrumbs = [];
        array_push($breadScrumbs, ['tim-kiem', 'Tìm kiếm']);
        array_push($breadScrumbs, ['tu-khoa', $search]);
        $title = "Tìm truyện với từ khóa: " . $search;
        return view('app.search', compact(['books', 'categories', 'breadScrumbs', 'title', 'search']));
    }

    protected function getAllCategories()
    {
        if(Cache::has('all-categories')){
            $categories = Cache::get('all-categories');
        }else{
            $categories = Category::orderBy('name', 'ASC')->select(['slug', 'name'])->get();
            Cache::add('all-categories', $categories, 360);
        }
        return $categories;
    }
}
