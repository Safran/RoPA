<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Exports;

use App\Http\Repositories\StatementRepository;
use App\Models\Form;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StatementsExport implements FromQuery, Responsable, WithHeadings, WithMapping, WithColumnFormatting
{

	use Exportable;

	/**
	 * @var string
	 */
	private $fileName;

	/**
	 * @var StatementRepository
	 */
	protected $statements;

	protected $type;


	public function __construct($type = 'inprogress')
	{
		$this->type       = $type;
		$this->statements = new StatementRepository;
		$this->fileName   = 'Declaration_' . $type . '.xlsx';
	}


	public function query()
	{
		switch ($this->type)
		{
			case 'inprogress':
				return $this->statements->getInprogressQuery();
				break;
			case 'pending':
				return $this->statements->getPendingQuery();
				break;
			case 'finished':
				return $this->statements->getFinishedQuery();
				break;
		}
		return [];
	}

	public function headings(): array
	{
		$colums =  [
			__('export.statements.heading.ID'),
			__('export.statements.heading.revision'),
			__('export.statements.heading.date'),
			__('export.statements.heading.supervisor'),
			__('export.statements.heading.owner'),
			__('export.statements.heading.author'),
			__('export.statements.heading.validated'),
			__('export.statements.heading.archived'),
			__('export.statements.heading.created'),
			__('export.statements.heading.modified'),
		];

		$form = Form::current();

		foreach($form->elements as $element)
		{
			$colums[] = $element->label;
		}


		return $colums;
	}

	public function map($statement): array
	{
		$columns = [
			$statement->id,
			$statement->form->title,
			Date::dateTimeToExcel($statement->form->created_at),
			$statement->supervisor->full_name ?? 'Not set',
			$statement->owner->full_name ?? 'Not set',
			$statement->author->full_name ?? 'Not set',
			$statement->validated ? __('locale.yes'): __('locale.no'),
			$statement->archived ? __('locale.yes'): __('locale.no'),
			Date::dateTimeToExcel($statement->created_at),
			Date::dateTimeToExcel($statement->updated_at),
		];

		$form = Form::current();

		foreach($form->elements as $element)
		{
			if($element->type == 'datepicker')
			{
				$date = $statement->get($element->name);
				if(is_string($date) || ! isset($date))
				{
					$columns[] = "";
				} else {
					$columns[] = Date::dateTimeToExcel($date);

				}
			} else {
				$columns[] = $statement->getAsString($element->name);
			}
		}


		return $columns;
	}

	public function columnFormats(): array
	{
		$columns =  [
			'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
			'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
			'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
		];

		$form = Form::current();
		$count = 'K';
		foreach($form->elements as $element)
		{
			if($element->type == 'datepicker')
			{
				$columns[$count] =  NumberFormat::FORMAT_DATE_DDMMYYYY;
			}
			$count++;
		}


		return $columns;
	}

}
