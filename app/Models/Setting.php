<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string $type
 * @property mixed $label
 * @property int $hidden
 * @property string|null $value
 * @property string $group
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereValue($value)
 * @mixin \Eloquent
 * @property int $active
 * @property int $ordering
 * @property-read mixed $input
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereOrdering($value)
 */
class Setting extends Model implements Sortable
{
	use HasTranslations, SortableTrait;

	public $translatable = [ 'label' ];

	public $sortable = [
		'order_column_name' => 'ordering',
		'sort_when_creating' => true,
	];

	public $fillable = [
		'value',
	];

	protected $casts = [
		'active' => 'boolean',
	];


	/**
	 * @return HtmlString
	 */
	public function getInputAttribute()
	{
		$html = '';
		switch($this->type)
		{
			case 'FILE':
				$html = view('partials.settings.file', ['key' => $this->key, 'value' => $this->value]);
				break;
		}
		return new HtmlString($html);
	}


	/**
	 * @param $key
	 *
	 * @return mixed|null|string
	 */
	public static function get($key)
	{
		$setting = new self();
		$entry = $setting->where('key', $key)->first();
		if (!$entry) {
			return null;
		}
		return $entry->value;
	}


	/**
	 * @param      $key
	 * @param null $value
	 *
	 * @return bool
	 * @throws \Throwable
	 */
	public static function set($key, $value = null)
	{
		$prefixed_key = 'settings.'.$key;
		$setting = new self();
		$entry = $setting->where('key', $key)->firstOrFail();

		$entry->value = $value;
		$entry->saveOrFail();
		\Config::set($prefixed_key, $value);
		if (\Config::get($prefixed_key) == $value) {
			return true;
		}
		return false;
	}
}
