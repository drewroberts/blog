<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Models;

use Tipoff\Support\Models\BaseModel;
use Tipoff\Support\Traits\HasCreator;
use Tipoff\Support\Traits\HasPackageFactory;
use Tipoff\Support\Traits\HasUpdater;

class Layout extends BaseModel
{
    use HasCreator;
    use HasPackageFactory;
    use HasUpdater;
}
