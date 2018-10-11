<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\FormElement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AdminFormTest extends TestCase
{

	use RefreshDatabase, WithFaker;


	public function testAdminHasAccessToForm()
	{
		$this->withExceptionHandling()->signInAdmin()->get(route('admin.forms'))->assertStatus(Response::HTTP_OK);
	}


	public function testNewForm()
	{
		$this->withExceptionHandling()->signInAdmin()->get(route('admin.forms.create'))->assertStatus(Response::HTTP_FOUND);

		$current = Form::first();

		// Only one version is available at a time
		$this->withExceptionHandling()->signInAdmin()->get(route('admin.forms.create'))->assertStatus(Response::HTTP_FORBIDDEN);

		// Publish it
		$response = $this->withExceptionHandling()->signInAdmin()->followingRedirects()->get(route('admin.forms.publish',
			[ $current ]));

		$response->assertStatus(Response::HTTP_OK)->assertViewIs('backend.forms.index')->assertSee('Success');

		// Check current is ok
		$this->assertEquals($current->id, Form::current()->id);

		// Create a new version
		$response = $this->withExceptionHandling()->signInAdmin()->followingRedirects()->get(route('admin.forms.create'))->assertSeeText('Success');

		$last    = Form::orderBy('id', 'desc')->first();
		$current = Form::current();

		$this->assertEquals($last->elements->toArray(), $current->elements->toArray());

		// Add A page
		$this->withExceptionHandling()->signInAdmin()->followingRedirects()->post(route('admin.pages.store', [ $last ]),
			[
				'title'      => [
					'fr' => $this->faker('fr')->sentence,
					'en' => $this->faker('en')->sentence
				],
				'disclaimer' => [
					'fr' => $this->faker('fr')->paragraphs,
					'en' => $this->faker('en')->paragraphs
				],
			])->assertSeeText('Success');

		$this->assertTrue($last->pages->count() === 1);
		$last->refresh();
		$page = $last->first();


		// Try add elements
		foreach (FormElement::types() as $type => $name)
		{
			$this->withExceptionHandling()->signInAdmin()
				->followingRedirects()
				->post(route('admin.elements.store',
					[ $last ]),
					[
						'page_id'        => $page->id,
						'created_by'     => auth()->id(),
						'field_required' => $this->faker->randomElement([ true, false ]),
						'cnil_required'  => $this->faker->randomElement([ true, false ]),
						'type'           => $type,
						'name'           => $this->faker->slug,
						'label'          => [
							'fr' => $this->faker('fr')->sentence,
							'en' => $this->faker('en')->sentence
						],
						'help'           => [
							'fr' => $this->faker('fr')->paragraphs,
							'en' => $this->faker('en')->paragraphs
						],
						'placeholder'    => [
							'fr' => $this->faker('fr')->sentence,
							'en' => $this->faker('en')->sentence
						],
					])->assertSeeText('Success');
		}
		$last->refresh();
		$this->assertTrue($last->elements->count() === FormElement::types()->count(), 'elements count ' . $last->elements->count());
		$this->assertTrue($last->pages->first()->elements->count() === FormElement::types()->count(), 'elements count ' . $last->pages->first()->elements->count());

	   // Check policies
		$this->withExceptionHandling()->signIn()
			->followingRedirects()
			->post(route('admin.elements.store',
				[ $last ]),
				[
					'page_id'        => $page->id,
					'created_by'     => auth()->id(),
					'field_required' => $this->faker->randomElement([ true, false ]),
					'cnil_required'  => $this->faker->randomElement([ true, false ]),
					'type'           => $type,
					'name'           => $this->faker->slug,
					'label'          => [
						'fr' => $this->faker('fr')->sentence,
						'en' => $this->faker('en')->sentence
					],
					'help'           => [
						'fr' => $this->faker('fr')->paragraphs,
						'en' => $this->faker('en')->paragraphs
					],
					'placeholder'    => [
						'fr' => $this->faker('fr')->sentence,
						'en' => $this->faker('en')->sentence
					],
				])->assertStatus(Response::HTTP_FORBIDDEN);


		$this->withExceptionHandling()
			->signInLawyer()
			->followingRedirects()
			->post(route('admin.elements.store',
				[ $last ]),
				[
					'page_id'        => $page->id,
					'created_by'     => auth()->id(),
					'field_required' => $this->faker->randomElement([ true, false ]),
					'cnil_required'  => $this->faker->randomElement([ true, false ]),
					'type'           => $type,
					'name'           => $this->faker->slug,
					'label'          => [
						'fr' => $this->faker('fr')->sentence,
						'en' => $this->faker('en')->sentence
					],
					'help'           => [
						'fr' => $this->faker('fr')->paragraphs,
						'en' => $this->faker('en')->paragraphs
					],
					'placeholder'    => [
						'fr' => $this->faker('fr')->sentence,
						'en' => $this->faker('en')->sentence
					],
				])->assertStatus(Response::HTTP_FORBIDDEN);
	}
}
