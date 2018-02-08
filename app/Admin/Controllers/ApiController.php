<?php

namespace App\Admin\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function makeslug(Request $request)
    {
        $name = $request->get('title');
        return \Safeurl::make($name);
    }

    public function categories(Request $request)
    {
        $q = $request->get('q');
        return CategoryModel::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }
}
