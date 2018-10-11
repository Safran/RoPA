<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Services;

use JShrink\Minifier;
use Mariuzzo\LaravelJsLocalization\Generators\LangJsGenerator as BaseGenerator;

/**
 * Class LangJsGenerator
 *
 * @package App\Services
 */
class LangJsGenerator extends BaseGenerator
{
	public function __construct()
	{
		$app   = app();
		$files = $app['files'];
		$langs     = $app['path.base'] . '/resources/lang';
		$messages  = $app['config']->get('localization-js.messages');
		parent::__construct($files, $langs, $messages);
	}

	protected function manageMessages(&$messages, $key="", $locale='fr')
	{
		if (is_array($messages))
		{
			ksort($messages);

			foreach ($messages as $k => &$value)
			{
				$this->manageMessages($value, "$key.$k", $locale);
			}
		} else {
			$messages = __($key, [], $locale);
		}
	}

	protected function sortMessages(&$translations)
	{
		foreach($translations as $file => &$messages)
		{
			list($lang, $path) = explode(".", $file, 2);

			$this->manageMessages($messages, $path, $lang);
		}
	}
}