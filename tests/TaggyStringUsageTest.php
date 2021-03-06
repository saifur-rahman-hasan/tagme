<?php

use Illuminate\Support\Str;

class TaggyStringUsageTest extends TestCase
{
	protected $lesson;

	protected function setUp(): void
	{
		parent::setUp(); // TODO: Change the autogenerated stub

		// Create predefined tags
		foreach (['PHP', 'Laravel', 'Lumen', 'MySQL', 'Javascript', 'Python', 'TypeScript', 'Redis'] as $tag){
			TagStub::create([
				'name' => $tag,
				'slug' => Str::slug($tag),
				'count' => 0
			]);
		}

		// Create new Lesson
		$this->lesson = LessonStub::create(['title' => 'A Lesson title']);
	}

	/** @test */
	public function can_tag_to_a_model()
	{
		$this->lesson->tag(['laravel', 'php']);

		$this->assertCount(2, $this->lesson->tags);

		foreach (['Laravel', 'PHP'] as $tag) {
			$this->assertContains($tag, $this->lesson->tags->pluck('name'));
		}
	}

	/**
	 * @test
	 */
	public function can_untag_from_a_model()
	{
		$this->lesson->tag(['laravel', 'php', 'lumen']);
		$this->lesson->untag(['laravel']);

		$this->assertCount(2, $this->lesson->tags);

		foreach (['PHP', 'Lumen'] as $tag) {
			$this->assertContains($tag, $this->lesson->tags->pluck('name'));
		}
	}

	/**
	 * @test 
	 */
	public function can_untag_all_tags_from_a_model()
	{
		$this->lesson->tag(['laravel', 'php', 'lumen']);
		$this->lesson->untag();

		$this->lesson->load('tags');

		$this->assertCount(0, $this->lesson->tags);
		$this->assertEquals(0, $this->lesson->tags->count());
	}

	/**
	 * @test 
	 */
	public function can_retag_tags_to_a_model()
	{
		$this->lesson->tag(['laravel', 'php', 'lumen']); // Before
		$this->lesson->retag(['laravel', 'redis', 'javascript']); // After

		$this->lesson->load('tags');

		$this->assertCount(3, $this->lesson->tags);

		foreach (['Laravel', 'Redis', 'Javascript'] as $tag) {
			$this->assertContains($tag, $this->lesson->tags->pluck('name'));
		}
	}

	/**
	 * @test
	 */
	public function non_existing_tags_are_ignored_on_tagging()
	{
		$this->lesson->tag(['laravel', 'invalid-tag', 'lumen']);

		$this->assertCount(2, $this->lesson->tags);

		foreach (['Laravel', 'Lumen'] as $tag) {
			$this->assertContains($tag, $this->lesson->tags->pluck('name'));
		}
	}

	/**
	 * @test
	 */
	public function inconsistent_tag_cases_are_normalised()
	{
		$this->lesson->tag(['Laravel', 'JaVaScript', 'lumen', 'MYSQL']);

		$this->assertCount(4, $this->lesson->tags);

		foreach (['Laravel', 'Javascript', 'Lumen', 'MySQL'] as $tag) {
			$this->assertContains($tag, $this->lesson->tags->pluck('name'));
		}
	}
}
