<?php
namespace App\Services;

use App\Book;
use App\Category;
use App\Author;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Array_;

class SiteMap
{
    public function getSiteMap()
    {
//        if(Cache::has('site-map')){
//            return Cache::get('site-map');
//        }

        $siteMap = $this->buildSiteMap();
//        Cache::add('site-map', $siteMap, 1);
        return $siteMap;
    }

    protected function buildSiteMap()
    {
        $booksInfo = Book::where('published_at', '<=', Carbon::now())->orderBy('published_at', 'desc')->lists('updated_at', 'slug')->all();
        $dates = array_values($booksInfo);
        sort($dates);
        $lastmod = last($dates);
        $url = url('/');
        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?'.'>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $xml[] = '    <url>';
        $xml[] = "        <loc>$url</loc>";
        $xml[] = "        <lastmod>$lastmod</lastmod>";
        $xml[] = '        <changefreq>daily</changefreq>';
        $xml[] = '        <priority>0.8</priority>';
        $xml[] = '    </url>';
        foreach ($booksInfo as $slug => $lastmod){
            $xml[] = '    <url>';
            $xml[] = "        <loc>{$url}$slug</loc>";
            $xml[] = "        <lastmod>$lastmod</lastmod>";
            $xml[] = "    </url>";
        }
        $xml[] = '</urlset>';
        return join("\n", $xml);
    }
}
?>