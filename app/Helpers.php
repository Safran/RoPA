<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


use App\Services\Html\Html;

if (! function_exists('getUrlWithSelectedLocale'))
{
	/**
	 * Switch actual url to an other locale
	 *
	 * @param $locale new locale
	 *
	 * @return string new url
	 */
	function getUrlWithSelectedLocale($locale)
	{
		$uri = request()->segments();
		if (isValidLocale($locale) && isValidLocale($uri[0]))
		{
			$uri[0] = $locale;
		}

		return '/' . implode($uri, '/');
	}
}

if (! function_exists('isActiveUrl'))
{
	function isActiveUrl(...$patterns)
	{
		$current = trim(request()->getPathInfo(), '/');
		$current = rawurldecode($current);
		$current = explode('/', trim($current, '/'));
		if(count($current) > 0 && isValidLocale($current[0]))
		{
			array_shift($current);
		}
		$current = (implode("/", $current));

		foreach ($patterns as $pattern)
		{
			if (\Illuminate\Support\Str::is(url($pattern), url($current)))
			{
				return true;
			}
		}

		return false;
	}
}

if (! function_exists('isValidLocale'))
{
	function isValidLocale($locale)
	{
		if ( ! is_string($locale))
		{
			return false;
		}

		return in_array($locale, config('app.locales'));
	}
}

if (! function_exists('tryToDetermineCurrenteLocale'))
{
	function tryToDetermineCurrenteLocale()
	{
		$urlLocale = app()->request->segment(1);
		if (isValidLocale($urlLocale))
		{
			return $urlLocale;
		}
		try
		{
			$cookieLocale = app(Illuminate\Contracts\Encryption\Encrypter::class)->decrypt(request()->cookie('locale'));
			if (isValidLocale($cookieLocale))
			{
				return $cookieLocale;
			}
		}
		catch (Exception $exception)
		{
		}
		$browserLocale = collect(request()->getLanguages())->first();
		if (isValidLocale($browserLocale))
		{
			return $browserLocale;
		}

		return app()->getLocale();
	}
}

if (! function_exists('locale'))
{
	function locale(): string
	{
		return app()->getLocale();
	}
}

function html2()
{
	return app(Html::class);
}

if (! function_exists('locales'))
{
	function locales(): \Illuminate\Support\Collection
	{
		return collect(config('app.locales'));
	}
}

if (! function_exists('include_route_files')) {
	function include_route_files($folder)
	{
		try {
			$rdi = new recursiveDirectoryIterator($folder);
			$it = new recursiveIteratorIterator($rdi);
			while ($it->valid()) {
				if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
					require $it->key();
				}
				$it->next();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}