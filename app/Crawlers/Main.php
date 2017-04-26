<?php
namespace App\Crawlers;

use App\Http\Requests;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class Main
{

    public static function crawlerLink($link)
    {
//        set_time_limit(0);
        try{
            $client = new Client();
            $response = $client->request('GET', $link);
            if($response->getStatusCode() == '200'){
                return $response->getBody()->getContents();
            }
        }catch (TransferException $e){
            return;
        }
    }
}