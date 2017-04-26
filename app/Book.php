<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	public function setNameAttribute($value)
	{
		$this->attributes['name'] = $value;
		if (!$this->exists) {
			$this->attributes['slug'] = str_slug($value);
		} else {
			if ($this->whereSlug(str_slug($value))->count()) {
				return redirect()->back()->withErrors("Slug (được tạo tự động) đã tồn tại");
			} else {
				$this->attributes['slug'] = str_slug($value);
			}
		}
	}

	public function authors()
	{
		return $this->belongsToMany('App\Author', 'author_of_books', 'book_id', 'author_id');
	}

	public function categories()
	{
		return $this->belongsToMany('App\Category', 'category_of_books', 'book_id', 'category_id');
	}

	public function chapters()
	{
		return $this->hasMany('App\Chapter');
	}
}
