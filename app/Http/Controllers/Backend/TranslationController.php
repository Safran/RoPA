<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Http\Controllers\Backend;

use App\Services\LangJsGenerator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;

/**
 * Class TranslationController
 *
 * @package App\Http\Controllers\Backend
 */
class TranslationController extends Controller
{

	/**
	 * Translations list
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$files = new Filesystem;

		$translations = [];
		foreach ($files->directories(\App::langPath()) as $languagePath)
		{
			$locale = basename($languagePath);
			if ($locale == 'vendor')
			{
				continue;
			}
			foreach ($files->allfiles($languagePath) as $languageFile)
			{
				$group = pathinfo($languageFile)['filename'];
				if (basename($languageFile->getPath()) != $locale)
				{
					$group = basename($languageFile->getPath()) . '/' . $group;
				}
				$translationLines = array_dot(trans($group, [], $locale));

				foreach ($translationLines as $lineKey => $lineValue)
				{
					if (empty($lineValue))
					{
						continue;
					}
					if (array_key_exists($group . '.' . $lineKey, $translations))
					{
						$translations[$group . '.' . $lineKey]['text'][$locale] = $lineValue;
					}
					else
					{
						$translations[$group . '.' . $lineKey] = [
							'id'    => null,
							'key'   => $lineKey,
							'group' => $group,
							'text'  => [
								$locale => $lineValue,
							]
						];
					}
				}
			}
		}
		$translations = collect($translations)->map(function ($translation, $key) {
				return (object) $translation;
			});

		$groups = $translations->pluck('group')->unique()->sortBy('group');//->pluck('group')->groupBy('group')->pluck('group');

		$groups = $groups->merge(LanguageLine::select('group')->groupBy('group')->pluck('group'))->unique();

		if ($request->has('filter-group') && $request->get('filter-group'))
		{
			$selectedGroup = $request->get('filter-group');
			$translations  = $translations->where('group', $request->get('filter-group'));
			$lines         = LanguageLine::where('group', $request->get('filter-group'))->get();
			if ($lines)
			{
				foreach ($lines as $line)
				{
					if ($translations->has($line->group . '.' . $line->key))
					{
						$translations[$line->group . '.' . $line->key]->id   = $line->id;
						$translations[$line->group . '.' . $line->key]->text = $line->text;
					}
					else
					{
						$translations[$line->group . '.' . $line->key] = (object) $line;
					}
				}
			}
		}
		else
		{

			$selectedGroup = '';
			$lines         = LanguageLine::all();
			if ($lines)
			{
				foreach ($lines as $line)
				{
					if ($translations->has($line->group . '.' . $line->key))
					{
						$translations[$line->group . '.' . $line->key]->id   = $line->id;
						$translations[$line->group . '.' . $line->key]->text = $line->text;
					}
					else
					{
						$translations[$line->group . '.' . $line->key] = (object) $line;
					}
				}
			}
		}

		return view('backend.translations.index', compact('translations', 'selectedGroup', 'groups'));
	}


	/**
	 * Save translation
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request)
	{
		$line = LanguageLine::firstOrNew([
			'key' => $request->key,
		], [
				'group' => $request->group,
			]);
		foreach (locales() as $locale)
		{
			if (isset($request->text[$locale]))
			{
				$line->setTranslation($locale, $request->text[$locale]);
			}
			$line->save();
		}

		return redirect(route('admin.translations', ['filter-group' => $request->get('filter-group')]));
	}


	/**
	 * Update translation
	 *
	 * @param Request      $request
	 * @param LanguageLine $languageLine
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, LanguageLine $languageLine)
	{
		$lang         = $request->get('locale');
		$key          = str_replace(".", "_", $languageLine->key);
		$translations = $request->get($key);
		$line         = $languageLine;
		$line->setTranslation($lang, $translations[$lang])->save();

		try
		{
			$generator = new LangJsGenerator();
			$result = $generator->generate(\Config::get('localization-js.path', public_path('messages.js')), [
				'compress' => false,
				'no-lib'   => false,
				'source'   => '',
				'json'     => true,
			]);
		}
		catch (\Exception $e)
		{
			dd($e);
		}


		return redirect(route('admin.translations', ['filter-group' => $request->get('filter-group')]))->with('success', __('admin/translations.update-successful'));
	}

	public function refresh(Request $request)
	{
		try
		{
			$generator = new LangJsGenerator();
			$result = $generator->generate(\Config::get('localization-js.path', public_path('messages.js')), [
				'compress' => false,
				'no-lib'   => false,
				'source'   => '',
				'json'     => true,
			]);
		}
		catch (\Exception $e)
		{
			dd($e);
		}

		return redirect(route('admin.translations', ['filter-group' => $request->get('filter-group')]))->with('success', __('admin/translations.refresh-successful'));
	}
}
