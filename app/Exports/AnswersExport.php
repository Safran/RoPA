<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Exports;

use App\Models\Statement;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Class AnswersExport
 *
 * @package App\Exports
 */
class AnswersExport implements FromQuery, Responsable, WithHeadings, WithMapping
{
	use Exportable;


	private $fileName;

	/**
	 * @var Statement
	 */
	protected $statement;


	public function __construct(Statement $statement)
	{
		$this->statement = $statement;
		$this->fileName  = 'Declaration_' . $statement->id . '.xlsx';
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
	 */
	public function query()
	{
		return $this->statement->answers()->where('statement_id', $this->statement->id);
	}


	/**
	 *
	 * @return array
	 */
	public function headings(): array
	{
		$colums = [
			'#',
			'Intitulé',
			'Valeur',
		];

		return $colums;
	}


	/**
	 *
	 * @param mixed $answer
	 *
	 * @return array
	 */
	public function map($answer): array
	{
	    if(in_array($answer->element->type, ['model', 'static']))
        {
            return [];
        }
		try
		{
			$value   = $answer->answer;
			$columns = [
				$answer->id,
				$answer->element->label,
				( isset($value) ? $answer->element->getValueAsString($value) : '' ),
			];
		}
		catch (\Exception $e)
		{
			dd($e);
		}

		return $columns;
	}
}