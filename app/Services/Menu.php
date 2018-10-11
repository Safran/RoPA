<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Services;

/**
 * Class Menu
 * Simple service to generate menu / navigation
 *
 * @package App\Services
 */
class Menu
{

	/**
	 *
	 * @param       $slug
	 * @param array $options
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public static function render($slug, array $options = [])
	{
		$me = auth()->user();
		$items = \Cache::rememberForever('menu.' . $me->role . '.' . locale() . '.' . $slug, function () use ($slug) {
			$menu  = \App\Models\Menu::where('slug', $slug)->firstOrFail();
			$items = $menu->items->where('active', true)->filter(function ($item) {
				$me = auth()->user();

				return $me->hasMinimumRights($item->role);
			});

			foreach ($items as $key => &$item)
			{
				if ( ! $item->role || auth()->user()->hasRole($item->role))
				{
					$item->link  = url(locale() . '/' . trim($item->path));
					$item->class = ( isActiveUrl(trim($item->path)) ? ' active' : '' );
				}
				else
				{
					$items->forget($key);
				}
			}
			return $items;
		});
		if ( ! isset($options['class']))
		{
			$options['class'] = '';
		}
		if (isset($options['vuejsmode']) && $options['vuejsmode'])
		{
			$declinaison = 'vuejs';
		}
		else
		{
			$declinaison = '';
		}

		return view('layouts/common/_bwmenu' . $declinaison, compact('items', 'options'));
	}
}