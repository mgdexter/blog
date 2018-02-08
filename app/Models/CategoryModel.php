<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';

    public function parent()
    {
        return $this->hasOne(CategoryModel::class, 'id' , 'parent_id');
    }

}
