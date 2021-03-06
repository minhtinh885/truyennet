<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

	public function books()
	{
		return $this->belongsToMany('App\Book', 'category_of_books', 'category_id', 'book_id');
	}
}
