<?php


use Hasan\Tagme\Models\TaggableTrait;
use Illuminate\Database\Eloquent\Model;

class LessonStub extends Model
{
    use TaggableTrait;

 	protected $connection = 'testbench';
 	public $table = 'lessons';
}
