<?php
/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		\App\Models\User::class              => \App\Policies\UserPolicy::class,
		\App\Models\FormElement::class       => \App\Policies\FormElementPolicy::class,
		\App\Models\FormPage::class          => \App\Policies\FormPagePolicy::class,
		\App\Models\Form::class              => \App\Policies\FormPolicy::class,
		\App\Models\Translation::class       => \App\Policies\TranslationPolicy::class,
		\App\Models\Staticpage::class        => \App\Policies\StaticpagePolicy::class,
		\App\Models\Menu::class              => \App\Policies\MenuPolicy::class,
		\App\Models\Statement::class         => \App\Policies\StatementPolicy::class,
		\App\Models\Setting::class           => \App\Policies\SettingPolicy::class,
		\App\Models\Answer::class            => \App\Policies\AnswerPolicy::class,
		\App\Models\StatementTemplate::class => \App\Policies\StatementTemplatePolicy::class,
		\App\Models\Attachment::class        => \App\Policies\AttachmentPolicy::class,
		\App\Models\CommentTemplate::class   => \App\Policies\CommentTemplatePolicy::class,
		\App\Models\Company::class           => \App\Policies\CompanyPolicy::class,
	];


	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		//
	}
}
