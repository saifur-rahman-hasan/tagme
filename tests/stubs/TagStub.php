<?php


use Hasan\Tagme\Scopes\TagUsedScopesTrait;
use Illuminate\Database\Eloquent\Model;

class TagStub extends Model
{
	use TagUsedScopesTrait;

 	protected $connection = 'testbench';
 	public $table = 'tags';
}
