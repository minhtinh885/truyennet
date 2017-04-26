<?php

namespace App\Console\Commands;

use App\Crawlers\Main;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

use App\CrawlTitle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;
use GuzzleHttp\Exception\TransferException;

use App\Services\UploadsManager;
use Illuminate\Support\Facades\File;


use App\Book;
use App\Chapter;
use App\Author;
use App\Category;
use Carbon\Carbon;

class StartCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'crawler:start {--insert=} {--limit=}';
    protected $signature = 'crawler-link:start';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lây thông tin truyện tự động với thông tin truyện được đánh dấu theo số thứ tự được hiển thị trực tiếp trên đường dẫn.';
    private $listAuthorId = [];
    private $listCategoryId = [];
    private $current_book_id = 0;

    protected $manager;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UploadsManager $manager)
    {
        parent::__construct();
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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            $crawlTitle = CrawlTitle::where('using', false)->first();
            if ($crawlTitle){
                $url = $crawlTitle->slug;
                $limit = $crawlTitle->limit;
                if($this->TruyenFullDotVn($url, $limit)){
                    $crawlTitle->using = true;
                    $crawlTitle->save();
                    $this->line($crawlTitle->slug. ' ----ALL OK---');
                }else{
                    $this->line($crawlTitle->slug. ' ----NOT ALL OK---');
                }
            }else{
                $this->line('Empty!!!');
            }
    }

    protected function TruyenFullDotVn($url = '', $limit)
    {
        set_time_limit(0);
//        $html = Main::crawlerLink('http://truyenfull.vn/tao-hoa-chi-mon/');
        $html = Main::crawlerLink($url);
        $crawler = new Crawler($html);
        $this->line('Beginning...');
        $title = $crawler->filter('h3.title')->first();
        $bookName = $title->text();
        $bookImageSrc = $crawler->filter('.book img')->first()->attr('src');
        $this->line($bookImageSrc);
        $description = trim($crawler->filter('div.desc-text')->html());
        $bookDescription = $description;
        $authors = $crawler->filter("div.info > div:first-child a");
        $this->line('Authors...');

        foreach ($authors as $author){

            $authorName = $author->nodeValue;
            $authors = Author::where('name', $authorName);
            $authorCount = $authors->count();
            if($authorCount == 0){
                $author = new Author();
                $author->name = $authorName;

                $author->save();
                array_push($this->listAuthorId, $author->id);
                $this->line($author->name . '----OK----');

            }else{
                foreach ($authors->get() as $author){
                    array_push($this->listAuthorId, $author->id);
                }
            }
        }
        $categories = $crawler->filter("div.info > div:nth-child(2) a");
        $this->line('Authors OK...');

        $this->line('categories...');

        foreach ($categories as $category){
            $categoryName = $category->nodeValue;
            $categories = Category::where('name', $categoryName);
            $categoriesCount = $categories->count();
            if($categoriesCount == 0){
                $category = new Category();
                $category->name = $categoryName;
                $category->save();
                array_push($this->listCategoryId, $category->id);
                $this->line($category->name . '----OK----');
            }else{
                foreach ($categories->get() as $category){
                    array_push($this->listCategoryId, $category->id);
                }
            }
        }

        $this->line('categories OK...');
        $this->line('Books...');

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

            if ($result === true) {
                $this->line("Upload image success");
            }else{
                $this->line("Upload error");
            }

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
            $this->current_book_id = $book->id;
            $book->authors()->sync($this->listAuthorId);
            $book->categories()->sync($this->listCategoryId);
            $this->line($book->name . ' -----OK----');

        }
        $this->line('Books OK...');

        $this->line('Chapters...');

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
                    $htmlChapter = Main::crawlerLink($urlChapter);
                    if($htmlChapter != null){

                        $crawler = new Crawler($htmlChapter);
//                        $this->line($crawler->filter("a.truyen-title")->count());

                        if($crawler->filter("a.truyen-title")->count() > 0){
                            $book_title = $crawler->filter("a.truyen-title")->first()->text();


                            $chapterTitle = $crawler->filter("a.chapter-title")->first()->text();
                            if($crawler->filter("div.chapter-content")->count()){
                                $chapterContent = trim($crawler->filter("div.chapter-content")->first()->html());
                            }else{
                                $chapterContent = trim($crawler->filter("div.chapter-content-rb")->first()->html());
                            }
                            $this->line('Chapters111...');

                            $chapter = new Chapter();
                            $chapter->title = $chapterTitle;
                            $chapter->ordinal = $i;
                            $chapter->content = $chapterContent;
                            $chapter->book_id = $book_id;

                            $chapter->user_id = 1;
                            $chapter->published_at = Carbon::now();
                            $chapter->save();
                            $this->line($urlChapter . '--------OK-------');
                        }else{
                            $chapter = new Chapter();
                            $chapter->title = 'Nhảy chương';
                            $chapter->ordinal = $i;
                            $chapter->content = 'Chương bị nhảy hoặc thiếu chương.';
                            $chapter->book_id = $book_id;

                            $chapter->user_id = 1;
                            $chapter->published_at = Carbon::now();
                            $chapter->save();
                            $this->line($urlChapter . '--------OK-------');

                        }
                    }

                }
            }
        }
        $this->line('Chapters OK...');

        return true;
    }
}
