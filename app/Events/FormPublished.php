<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Events;

use App\Models\Form;
use Illuminate\Queue\SerializesModels;

class FormPublished
{
    use SerializesModels;

	/**
	 * @var Form
	 */
    protected $form;


	/**
	 * FormPublished constructor.
	 *
	 * @param Form $form
	 */
    public function __construct(Form $form)
    {
       $this->form = $form;
    }

	/**
	 * @return mixed
	 */
	public function subject()
	{
		return $this->form;
	}
}
