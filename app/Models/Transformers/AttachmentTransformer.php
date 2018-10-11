<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\Attachment;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser;

/**
 * Class AttachmentTransformer
 *
 * @package App\Models\Transformers
 */
class AttachmentTransformer extends TransformerAbstract
{

	/**
	 * @param Attachment $attachment
	 *
	 * @return array
	 */
	public function transform(Attachment $attachment)
	{
		$guesser = new MimeTypeExtensionGuesser;
		return [
			'id'   => $attachment->id,
			'uuid' => $attachment->uuid,
			'name' => $attachment->name,
			'type' => 'type_' . $guesser->guess($attachment->type),
			'link' => route('frontend.attachments.show', [$attachment]),
		];
	}
}