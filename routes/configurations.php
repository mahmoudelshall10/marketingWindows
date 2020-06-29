<?php
use Illuminate\Support\Facades\Config;
Config::set('filesystems.disks.public.url', url('storage'));
//return dd(config('filesystems.disks.public.url'));
////// direction Function /////////////////////
app()->singleton('direction', function () {
		if (app('l') == 'ar') {
			return '-rtl';
		}
	});
////// direction Function /////////////////////

//////  upload Function /////////////////////
if (!function_exists('it')) {
	function it() {
		return new \App\Http\Controllers\FileUploader;
	}
}
//////  upload Function /////////////////////

////// Admin Url Function /////////////////////
if (!function_exists('aurl')) {
	function aurl($link) {
		if (substr($link, 0, 1) == '/') {
			return url(app('admin').$link);
		} else {
			return url(app('admin').'/'.$link);
		}
	}
}
////// Admin Url Function /////////////////////
////// Get Settings Function /////////////////////
if (!function_exists('setting')) {
	function setting() {
		$setting = \App\Model\Setting::orderBy('id', 'desc')->first();
		if (empty($setting)) {
			return \App\Model\Setting::create(['sitename_ar' => '', 'sitename_en' => '', 'sitename_fr' => '']);
		} else {
			return $setting;
		}
	}
}
////// Get Settings Function /////////////////////

////// Admin Url Function /////////////////////
if (!function_exists('admin')) {
	function admin() {
		return auth()->guard('admin');
	}
}
////// Admin Url Function /////////////////////

////// Admin Url Function /////////////////////
if (!function_exists('active_link')) {
	function active_link($segment, $class = null) {
		if ($segment == null and request()->segment(2) == null) {
			return $class;
		} elseif (preg_match('/'.$segment.'/i', request()->segment(2))) {
			if ($class != null || $class != 'block') {
				if ($segment != null) {
					return $class;
				}
			} else {
				if ($class == 'block') {
					return 'display:block';
				} else {
					return 'display:none';
				}
			}
		}
	}
}
////// Admin Url Function /////////////////////

if (!function_exists('l')) {
	function l($obj) {
		if (app('l') == 'ar') {
			return $obj.'_ar';
		} elseif (app('l') == 'en') {
			return $obj.'_en';
		}
	}
}
