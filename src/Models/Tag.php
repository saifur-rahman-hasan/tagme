<?php

namespace Hasan\Tagme\Models;

use Hasan\Tagme\Scopes\TagUsedScopesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use TagUsedScopesTrait;
}
