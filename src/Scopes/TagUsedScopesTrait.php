<?php


namespace Hasan\Tagme\Scopes;


trait TagUsedScopesTrait
{
	/**
	 * Tag that was used greater than or equal of the given count
	 *
	 * @param $query
	 * @param $count
	 * @return mixed
	 */
	public function scopeUsed($query)
	{
		return $query->where('count', '>=', 1);
	}

	/**
	 * Tag that was used greater than or equal of the given count
	 *
	 * @param $query
	 * @param $count
	 * @return mixed
	 */
	public function scopeUsedGte($query, $count)
	{
		return $query->where('count', '>=', $count);
	}

	/**
	 * Tag that was used greater than of the given count
	 *
	 * @param $query
	 * @param $count
	 * @return mixed
	 */
	public function scopeUsedGt($query, $count)
	{
		return $query->where('count', '>', $count);
	}

	/**
	 * Tag that was used less than or equal of the given count
	 *
	 * @param $query
	 * @param $count
	 * @return mixed
	 */
	public function scopeUsedLte($query, $count)
	{
		return $query->where('count', '<=', $count);
	}

	/**
	 * Tag that was used less than of the given count
	 *
	 * @param $query
	 * @param $count
	 * @return mixed
	 */
	public function scopeUsedLt($query, $count)
	{
		return $query->where('count', '<', $count);
	}
}
