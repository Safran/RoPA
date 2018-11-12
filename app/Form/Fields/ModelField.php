<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */

namespace App\Form\Fields;

/**
 * Class ModelField
 *
 * @package App\Form\Fields
 */
class ModelField extends Field
{

	/**
	 * @var bool
	 */
  protected $hasHelp = false;

    public function getValue($value = null)
    {
      return '';
    }

    public function isExportable(): bool
    {
        return false;
    }

}