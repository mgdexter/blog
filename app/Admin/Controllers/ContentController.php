<?php

namespace App\Admin\Controllers;

use App\Models\CategoryModel;
use App\Models\ContentModel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ContentController extends Controller
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

            $content->header('Yazılar');
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

            $content->header('Yazılar');
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

            $content->header('Yazılar');
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
        return Admin::grid(ContentModel::class, function (Grid $grid) {

            $grid->model()->where('type', 'content');

            $grid->id('ID')->sortable();
            $grid->title('Başlık')->sortable();
            $grid->slug('Url');
            $grid->created_at('Eklenme Tarihi')->sortable();
            $grid->updated_at('Güncellenme Tarihi')->sortable();

            $grid->model()->orderBy('created_at', 'desc');
            $grid->disableExport();
            $grid->paginate(15);

            $grid->filter(function ($filter) {
                $filter->disableIdFilter();

                $filter->where(function ($query) {
                    $query->where('title', 'like', "%{$this->input}%");
                }, 'Başlık');
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
        return Admin::form(ContentModel::class, function (Form $form) {

            Admin::script($this->script());

            $form->multipleSelect('category')->options(CategoryModel::all()->pluck('name', 'id'));

            $form->text('title', 'Başlık')->rules('required|min:3|max:300')->setWidth(5);
            $form->text('slug', 'Url')->rules('required|min:3|max:300')->setWidth(5);
            $form->summernote('description', 'Açıklama')->rules('required|min:10')->setWidth(10);

            $form->divider();

            $form->text('meta_title', 'Meta Başlık')->rules('required|min:3|max:300')->setWidth(10);
            $form->textarea('meta_description', 'Meta Açıklama')->rules('required|min:3|max:300')->rows(2)->setWidth(10);
            $form->text('meta_keywords', 'Meta Keywords')->rules('required|min:3|max:300')->setWidth(10);

            $form->divider();
            $form->image('image', 'Ana Fotoğraf')->setWidth(5);

            $form->divider();

            $states = [
                'on' => ['value' => 1, 'text' => 'Açık', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'Kapalı', 'color' => 'danger'],
            ];

            $form->switch('comment', 'Yorumlar')->states($states);
            $form->switch('status', 'Durum')->states($states);

            $form->hidden('type')->value('content');
            $form->hidden('id');
            $form->hidden('created_at');
            $form->hidden('updated_at');
        });
    }

    protected function script()
    {
        return <<<SCRIPT
        $("#description").summernote({ height: 350 });
        $("#title").change(function () {
            var name = $('#title').val();
            $.get("/admin/api/slug/?title=" + name).done(function (data) {
                $('#slug').val(data);
            });
        });
SCRIPT;
    }

}
