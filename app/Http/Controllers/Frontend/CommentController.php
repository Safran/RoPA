<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */






namespace App\Http\Controllers\Frontend;

use App\Events\StatementCommented;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Comment;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser;

/**
 * Class CommentController
 *
 * @package App\Http\Controllers\Frontend
 */
class CommentController extends Controller
{

	/**
	 * @param Request $request
	 * @param Answer  $answer
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function store(Request $request, Answer $answer)
	{
		$this->authorize('comment', $answer);

		$request->validate([
			'body'        => 'required|min:3',
			'attachment' => 'nullable|mimes:jpg,bmp,png,doc,docx,odt,csv,xls,ods,pdf',
		]);

		$comment = Comment::create([
			'answer_id'  => $answer->id,
			'created_by' => auth()->user()->id,
			'body'       => $request->get('body'),
		]);

		$response = [
			'id'          => $comment->id,
			'body'        => $comment->body,
			'created'     => $comment->created_at,
			'author'      => $comment->author->full_name,
			'attachment' => [],
		];

		// Manage attachments
		if ($request->hasFile('attachment'))
		{
			$attachment = $request->file('attachment');

			if ($attachment->isValid())
			{
				// Prepare folder
				if ( ! File::exists(storage_path('statements')))
				{
					File::makeDirectory(storage_path('statements'));
				}
				if ( ! File::exists(storage_path('statements/' . $answer->statement->id . '/')))
				{
					File::makeDirectory(storage_path('statements/' . $answer->statement->id . '/'));
				}

				// Store file
				$path = $attachment->store($answer->statement->id, [ 'disk' => 'statements' ]);

				$att                     = $comment->attachments()->create([
					'uuid'       => \Uuid::generate()->string,
					'md5'        => md5($attachment->getClientSize()),
					'path'       => $path,
					'name'       => $attachment->getClientOriginalName(),
					'type'       => $attachment->getMimeType(),
					'size'       => $attachment->getSize(),
					'created_by' => auth()->user()->id,
				]);
				$guesser = new MimeTypeExtensionGuesser;
				$response['attachment'] = [[
					'id'   => $att->id,
					'md5'  => $att->md5,
					'name' => $att->name,
					'type' => 'type_' . $guesser->guess($att->type),
					'size' => $att->size,
					'link' => route('frontend.attachments.show', $att),
				]];
			}
		}
		event(new StatementCommented($answer->statement, $comment));

		return response(json_encode($response), 201);
	}
}
