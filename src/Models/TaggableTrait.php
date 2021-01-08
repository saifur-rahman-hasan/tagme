<?php


namespace Hasan\Tagme\Models;


use Hasan\Tagme\Scopes\TaggableScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait TaggableTrait
{
	use TaggableScopesTrait;

	/**
	 * A Model Morph to Many Tags
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function tags()
	{
		return $this->morphToMany(Tag::class, 'taggable');
	}

	/**
	 * Attach Tags to a Model
	 *
	 * @param array $tags
	 */
	public function tag($tags)
	{
		$this->addTags($this->getWorkableTags($tags));
	}

	/**
	 * Detach tags from a model
	 *
	 * @param null $tags
	 */
	public function untag($tags = null)
	{
		if($tags === null){
			$this->removeAllTags();
			return;
		}

		$this->removeTags( $this->getWorkableTags($tags) );
	}

	/**
	 * Re attach tags
	 *
	 * @param $tags
	 */
	public function retag($tags)
	{
		$this->removeAllTags();
		$this->tag($tags);
	}

	/**
	 * Remove All tags
	 */
	private function removeAllTags()
	{
		$this->removeTags($this->tags);
	}

	/**
	 * Remove the given tags
	 *
	 * @param Collection $tags
	 */
	private function removeTags(Collection $tags)
	{
		$this->tags()->detach($tags);

		// Decrement tags count
		foreach ($tags->where('count', '>', 0) as $tag){
			$tag->decrement('count');
		}
	}

	/**
	 * Attach the given tags
	 *
	 * @param Collection $tags
	 */
	private function addTags(Collection $tags)
	{
		$sync = $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

		// Increment the attached tags count if any attached tags found
		foreach ( Arr::get($sync, 'attached') as $attachedId ){
			$tags->where('id', $attachedId)->first()->increment('count');
		}
	}

	/**
	 * Get all Workable tags
	 *
	 * @param $tags
	 * @return Collection
	 */
	private function getWorkableTags($tags)
	{
		if(is_array($tags)){
			return $this->getTagModels($tags);
		}

		if($tags instanceof Model){
			return $this->getTagModels([ $tags->slug ]);
		}

		return $this->filterTagsCollection($tags);
	}

	/**
	 * @param Collection $tags
	 * @return Collection
	 */
	private function filterTagsCollection(Collection $tags): Collection
	{
		return $tags->filter(function($tag){
			return $tag instanceof Model;
		});
	}

	/**
	 * Get tag Models
	 *
	 * @param array $tags
	 * @return mixed
	 */
	private function getTagModels(array $tags)
	{
		return Tag::whereIn('slug', $this->normaliseTagNames($tags))->get();
	}

	/**
	 * Normalise the tag names
	 *
	 * @param array $tags
	 * @return array
	 */
	private function normaliseTagNames(array $tags): array
	{
		return array_map(function($tag) {
			return Str::slug($tag);
		}, $tags);
	}
}
