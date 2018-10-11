<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatementTemplateAnswer
 *
 * @property int $id
 * @property int $statement_template_id
 * @property int $form_element_id
 * @property string $answer
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\FormElement $element
 * @property-read \App\Models\StatementTemplate $template
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplateAnswer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplateAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplateAnswer whereFormElementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplateAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplateAnswer whereStatementTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StatementTemplateAnswer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatementTemplateAnswer extends Model
{
	protected $fillable = [
		'form_element_id',
		'statement_template_id',
		'answer',
	];

	public function template()
	{
		return $this->belongsTo(StatementTemplate::class, 'statement_template_id');
	}

	public function element()
	{
		return $this->belongsTo(FormElement::class, 'form_element_id');
	}
}
