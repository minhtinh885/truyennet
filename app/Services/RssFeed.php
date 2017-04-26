<?php
/*namespace App\Services;
use App\Book;
use App\Category;
use App\Author;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RssFeed
{
//    Return the content of the Rss Feed
    public function getRSS()
    {
        if(Cache::has('rss-feed')){
        return Cache::get('rss-feed');
    }
        $rss = $this->buildRssData();
//        Cache::add('rss-feed', $rss, 120);
        return $rss;
    }
    protected function buildRssData()
    {
        $now = Carbon::now();
        $feed = new Feed();
        $channel = new Channel();
        $channel->title("Đọc Truyện Net, truyennet, truyennet rss")
            ->description("TruyenNet online,Đọc truyện online, đọc truyện chữ, truyện hay, truyện net. Truyện NET luôn tổng hợp và cập nhật các chương truyện một cách nhanh nhất.")
            ->url(url())
            ->language('vi')
            ->copyright('Copyright (c) TruyenNet.xyz')
            ->lastBuildDate($now->timestamp)
            ->appendTo($feed);

        $books = Book::where('published_at', '<=', $now)->orderBy('published_at', 'desc')->take(25)->get();

        foreach ($books as $book){
            $categories_name = "";
            $authors_name = "";
            $authors = $book->authors()->get();
            foreach ($authors as $author){
                $authors_name .= ", " . $author->name;
            }
            $categories = $book->categories()->get();
            foreach ($categories as $category) {
                $categories_name .= ", " . $category->name;
            }
            $item = new Item();
            $item->title($book->name)
                ->description($book->description)
                ->author($authors_name)
                ->category($categories_name)
                ->url(url($book->slug))
                ->guid(url($book->slug), true)
                ->appendTo($channel);
        }
//        $feed = (string)$feed;

//        $feed = str_replace('<rss version="2.0">', '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">', $feed);
//        $feed = str_replace('<channel>', '<channel>' . "\n" . ' <atom:link href="' . url('/rss') . '" rel="self" type="application/rss+xml"/>', $feed);
        var_dump()
        return $feed;
    }
    
}*/