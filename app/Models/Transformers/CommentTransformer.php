<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Models\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

/**
 * Class CommentTransformer
 *
 * @package App\Models\Transformers
 */
class CommentTransformer extends TransformerAbstract
{

	/**
	 * @var array
	 */
	protected $defaultIncludes = [
		'attachments',
	];


	/**
	 *
	 * @param Comment $comment
	 *
	 * @return array
	 */
	public function transform(Comment $comment)
	{
		return [
			'author'  => $comment->author->full_name,
			'body'    => $comment->body,
			'created' => $comment->created_at,
		];
	}


	/**
	 * @param Comment $comment
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	protected function includeAttachments(Comment $comment)
	{
		$attachments = $comment->attachments;

		return $this->collection($attachments, new AttachmentTransformer);
	}
}