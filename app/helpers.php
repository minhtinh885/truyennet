<?php
/**
 * [human_filesize description] Return sizes readble by human
 * @param  [type]  $bytes    [description]
 * @param  integer $decimals [description]
 * @return [type]            [description]
 */
function human_filesize($bytes, $decimals = 2)
{
	$sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
	$factor = floor((strlen($bytes) - 1)/3);

	return sprintf("%.{$decimals}f", $bytes/pow(1024, $factor)) . @$size[$factor];
}

/**
 * [is_image description] Is the mime type an image
 * @param  [type]  $mimeType [description]
 * @return boolean           [description]
 */
function is_image($mimeType)
{
	return starts_with($mimeType, 'image/');
}

function checked($value)
{
	return $value ? 'checked' : '';
}

function page_image($value = null)
{
	if(empty($value)){
		$value = config('truyennet.page_image');
	}

	if(! starts_with($value, 'http') && $value[0] !== '/'){
		$value = config('truyennet.uploads.webpath').'/'.$value;
	}
	return $value;
}

function semi_value($value1 = null, $value2 = null)
{
	if(empty($value1) || empty($value2)){
		return '';
	}
	if($value1 == $value2){
		return '';
	}
	return ', ';
}

