<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CrawlTitle;
use Illuminate\Support\Facades\Auth;

//use App\CrawlTitle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;
use GuzzleHttp\Exception\TransferException;

use App\Services\UploadsManager;
use Illuminate\Support\Facades\File;
use App\Crawlers;

use App\Book;
use App\Chapter;
use App\Author;
use App\Category;
use Carbon\Carbon;


class AutoCrawlController extends Controller
{

    private $listAuthorId = [];
    private $listCategoryId = [];
    private $current_book_id = 0;
    private $page_access_token = 'EAACEdEose0cBAHiLJnAKbvdPO0EvQOHMPRqQxPrU99QyB6j6Pu3hSI6ySpj0vaIG6oi79IPfmYuxEsgpP1Y1EwYx5bfQ0PwM1W9KfZA6s3HYSyn4cRtpTa2gRK5OdxDLca98I7KdPnHZCmI42SD1crfakAWLDbTL5L5nkZBMgZDZD';
    private $page_id = '1087584591306736';

    protected $manager;
    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
        $this->listAuthorId = [];
        $this->listCategoryId = [];
        $this->current_book_id = 0;
    }

    public function __destruct()
    {
        $this->listAuthorId = [];
        $this->listCategoryId = [];
        $this->current_book_id = 0;
    }

    public function index(){
        $crawlerTitles = CrawlTitle::orderBy('updated_at', 'DESC')->paginate(50);
        return view('admin.crawlers.index', compact('crawlerTitles'));
    }
    
    public function create()
    {
        $slug = old('slug', 'http://');
        $using = old('using', '0');
        $limit = old('using', '1');
        return view('admin.crawlers.create', ['slug' => $slug, 'using' => $using, 'limit' => $limit]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required|unique:crawl_title,slug',
//            'using' => 'required',
            'limit' => 'required',
        ]);
        $crawlerTitle = new CrawlTitle();
        $crawlerTitle->slug = $request->get('slug');
        $crawlerTitle->using = $request->get('using')?1:0;
        $crawlerTitle->limit = $request->get('limit');

        $crawlerTitle->save();
        return redirect('admin/auto-crawl')->withSuccess("Đường dẫn '$crawlerTitle->slug' đã được tạo thành công !");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $crawlerTitle = CrawlTitle::findOrFail($id);
        $data = ['id' => $id];
        $data['slug'] = old('slug', $crawlerTitle->slug);
        $data['using'] = old('using', $crawlerTitle->using);
        $data['limit'] = old('limit', $crawlerTitle->limit);

        return view('admin.crawlers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'slug' => 'required',
//            'using' => 'required',
            'limit' => 'required',
        ]);
        $crawlerTitle = CrawlTitle::findOrFail($id);
        $crawlerTitle->slug = $request->get('slug');
        $crawlerTitle->using = $request->get('using')=='on'?1:0;
        $crawlerTitle->limit = $request->get('limit');

        $crawlerTitle->save();
        return redirect("/admin/auto-crawl/$id/edit")->withSuccess("Đã lưu thay đổi.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $crawlerTitle = CrawlTitle::findOrFail($id);
        $crawlerTitle->delete();

        return redirect('/admin/auto-crawl')->withSuccess("Đường dẫn '$crawlerTitle->slug' đã được xóa.");
    }

    ///auto-crawl-link-start

    public function auto_crawl_link()
    {
        $crawlTitle = CrawlTitle::where('using', false)->first();
        if ($crawlTitle){
            $url = $crawlTitle->slug;
            $limit = $crawlTitle->limit;
            if($this->TruyenFullDotVn($url, $limit)){
                $crawlTitle->using = true;
                $crawlTitle->save();
                return $url . " -- All OK!!!";
            }else{
                return $url . " -- It not OK!!!";
            }
        }else{
            return "Empty!!!";
        }
    }

    protected function TruyenFullDotVn($url = '', $limit)
    {
//        set_time_limit(0);
//        $html = Main::crawlerLink('http://truyenfull.vn/tao-hoa-chi-mon/');
        //$html = Main::crawlerLink($url);
        $html = Crawlers\Main::crawlerLink($url);
        $crawler = new Crawler($html);
        $title = $crawler->filter('h3.title')->first();
        $bookName = $title->text();
        $bookImageSrc = $crawler->filter('.book img')->first()->attr('src');
        $description = trim($crawler->filter('div.desc-text')->html());
        $bookDescription = $description;
        $authors = $crawler->filter("div.info > div:first-child a");

        foreach ($authors as $author){

            $authorName = $author->nodeValue;
            $authors = Author::where('name', $authorName);
            $authorCount = $authors->count();
            if($authorCount == 0){
                $author = new Author();
                $author->name = $authorName;

                $author->save();
                array_push($this->listAuthorId, $author->id);

            }else{
                foreach ($authors->get() as $author){
                    array_push($this->listAuthorId, $author->id);
                }
            }
        }
        $categories = $crawler->filter("div.info > div:nth-child(2) a");

        foreach ($categories as $category){
            $categoryName = $category->nodeValue;
            $categories = Category::where('name', $categoryName);
            $categoriesCount = $categories->count();
            if($categoriesCount == 0){
                $category = new Category();
                $category->name = $categoryName;
                $category->save();
                array_push($this->listCategoryId, $category->id);
            }else{
                foreach ($categories->get() as $category){
                    array_push($this->listCategoryId, $category->id);
                }
            }
        }


        $status = $crawler->filter("div.info > div:nth-child(3) > span.text-success");
        if($status->count() != 0){
            $bookStatus = $status->eq(0)->text();
        }else{
            $status = $crawler->filter("div.info > div:nth-child(3) > span.text-primary");
            if($status->count() != 0){
                $bookStatus = $status->eq(0)->text();
            }else{
                $status = $crawler->filter("div.info > div:nth-child(4) > span.text-primary");
                if($status->count() != 0){
                    $bookStatus = $status->eq(0)->text();
                }else{
                    $status = $crawler->filter("div.info > div:nth-child(4) > span.text-success");
                    if($status->count() != 0){
                        $bookStatus = $status->eq(0)->text();
                    }
                }
            }
        }



        $booksCount = Book::whereName($bookName)->count();


        if($booksCount == 0){

            $book = new Book();

            $book->name = $bookName;
            $book->description = $bookDescription;
            $path = "/Books/" . str_slug($bookName) . ".jpg";
            $result = $this->manager->saveFile($path, file_get_contents($bookImageSrc));

            $book->image_url = '/uploads'.$path;
            $book->source_from = "truyenfull.vn";
            $book->published_at = Carbon::Now();

            if ($bookStatus == "Full"){
                $book->status = "Đã hoàn thành";
            }

            $book->review = 1;
//            $book->user_id = Auth::user()->id;
            $book->user_id = 1;

            $book->save();
            //Facebook open
            $data['picture'] = $book->image_url;
            $data['link'] = "http://www.truyennet.xyz" . $book->image_url;
            $data['message'] = "Truyện mới đăng hấp dẫn hãy ghé thăm website và đọc ngay nhá!!!";
            $data['caption'] = $book->name;
            $data['description'] = $book->description;
            $data['access_token'] = $this->page_access_token;
            $post_url = 'https://graph.facebook.com/'.$this->page_id.'/feed';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($ch);
            curl_close($ch);
            //Facebook end

            $this->current_book_id = $book->id;
            $book->authors()->sync($this->listAuthorId);
            $book->categories()->sync($this->listCategoryId);

        }


        $min = 1;
        $max = $limit;
        if($max >= $min){
            for ($i = $min; $i<=$max; $i++){
                if(isset($book)){
                    $book_id = $book->id;
                }else{
                    $book_id = Book::where("name", $bookName)->first()->id;
                }
                $chapterCount = Chapter::where('slug_chapter', 'chuong-'.$i)->where("book_id", $book_id)->count();
                if($chapterCount < 1){
                    $urlChapter = $url . "chuong-" . $i;
                    $htmlChapter = Crawlers\Main::crawlerLink($urlChapter);
                    if($htmlChapter != null){

                        $crawler = new Crawler($htmlChapter);

                        if($crawler->filter("a.truyen-title")->count() > 0){
                            $book_title = $crawler->filter("a.truyen-title")->first()->text();


                            $chapterTitle = $crawler->filter("a.chapter-title")->first()->text();
                            if($crawler->filter("div.chapter-content")->count()){
                                $chapterContent = trim($crawler->filter("div.chapter-content")->first()->html());
                            }else{
                                $chapterContent = trim($crawler->filter("div.chapter-content-rb")->first()->html());
                            }

                            $chapter = new Chapter();
                            $chapter->title = $chapterTitle;
                            $chapter->ordinal = $i;
                            $chapter->content = $chapterContent;
                            $chapter->book_id = $book_id;

                            $chapter->user_id = 1;
                            $chapter->published_at = Carbon::now();
                            $chapter->save();
                        }else{
                            $chapter = new Chapter();
                            $chapter->title = 'Nhảy chương';
                            $chapter->ordinal = $i;
                            $chapter->content = 'Chương bị nhảy hoặc thiếu chương.';
                            $chapter->book_id = $book_id;

                            $chapter->user_id = 1;
                            $chapter->published_at = Carbon::now();
                            $chapter->save();

                        }
                    }

                }
            }
        }

        return true;
    }
}
