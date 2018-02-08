<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentModel extends Model
{
    protected $table = 'contents';

    public function category()
    {
        return $this->belongsToMany(CategoryModel::class, 'contents_to_category', 'content_id', 'category_id');
    }

}
