<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
	public function setOrdinalAttribute($value)
	{
		$this->attributes['ordinal'] = $value;
		$this->attributes['slug_chapter'] = 'chuong-'.$value;
	}

	public function book()
	{
		return $this->belongsTo('App\Book');
	}
}
