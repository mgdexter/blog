<?php

namespace App\Admin\Controllers;

use App\Models\CategoryModel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CategoryController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Kategoriler');
            $content->description('Liste');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Kategoriler');
            $content->description('Düzenle');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('Kategoriler');
            $content->description('Ekle');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(CategoryModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('Kategori Adı')->display(function () {
                if ($this->parent) {
                    return $this->parent['name'] . " > " . $this->name;
                } else {
                    return $this->name;
                }
            });
            $grid->slug('Url');
            $grid->created_at('Eklenme Tarihi');
            $grid->updated_at('Güncellenme Tarihi');

            $grid->model()->orderBy('created_at', 'desc');
            $grid->disableExport();
            $grid->paginate(15);

            $grid->filter(function ($filter) {
                $filter->disableIdFilter();

                $filter->where(function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                }, 'Kategori Adı');
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(CategoryModel::class, function (Form $form) {


            $form->select('parent_id', 'Üst Kategori')->options(function ($parent_id) {
                $category = CategoryModel::find($parent_id);
                if ($category) {
                    return [$category->id => $category->name];
                }
            })->ajax(admin_url('/api/category/list'))->setWidth(3);

            $form->text('name', 'Kategori Adı')->rules('required')->setWidth(5);
            $form->text('slug', 'Url')->rules('required')->setWidth(5);

            $form->hidden('id');
            $form->hidden('created_at');
            $form->hidden('updated_at');
        });
    }
}
