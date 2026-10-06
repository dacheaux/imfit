<?php

namespace App;

use App\Traits\SerializesDates;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use SerializesDates;
}
