<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class CrawlTitle extends Model
{
    protected $table = 'crawl_title';
    protected $fillable = ['slug', 'using'];
}