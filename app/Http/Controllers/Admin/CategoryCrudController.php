<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $this->crud->setModel(\App\Models\Category::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/category');
        $this->crud->setEntityNameStrings('category', 'categories');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->column('name_en');
        $this->crud->column('name_ar');
        $this->crud->column('type');
        $this->crud->addColumn([
            'label' => "Image",
            'name' =>  "image",
            'type' => 'image',
            'height' => '50px',
            'width'  => '50px',
        ]);
        $this->crud->column('active')->type('check');
        $this->crud->column('featured')->type('check');
        $this->crud->column('created_at');
        $this->crud->column('updated_at');
        // add a "simple" filter called Draft
        $this->crud->addFilter(
            [
                'type'  => 'dropdown',
                'name'  => 'typeFitler',
                'label' => 'Type Fitler'
            ],
            [
                'product'=> 'product',
                'vendor' =>'vendor',
              ],
            function ($value) { // if the filter is active (the GET parameter "draft" exits)
                $this->crud->addClause('where', 'type', $value);
                // we've added a clause to the CRUD so that only elements with draft=1 are shown in the table
                // an alternative syntax to this would have been
                // $this->crud->query = $this->crud->query->where('draft', '1'); 
                // another alternative syntax, in case you had a scopeDraft() on your model:
                // $this->crud->addClause('draft'); 
            }
        );
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CategoryRequest::class);

        $this->crud->field('name_en');
        $this->crud->field('name_ar');
        $this->crud->addField([
            'name'  => 'type',
            'label' => 'type',
            'type'  => 'enum',
        ]);
        $this->crud->addField([
            'name'  => 'separator',
            'type'  => 'custom_html',
            'value' => '<div class="">
            <label for="">activation</label>
          </div>'
        ]);
        $this->crud->addField([
            'label'        => 'is Active?',
            'name'         => 'active',
            'type'         => 'switch',
            'wrapper' => ['class' => 'form-group col-md-6'],
            'color'    => 'success',
            'onLabel' => '✓',
            'offLabel' => '✕',
        ]);
        $this->crud->addField([
            'label'        => 'is Featured?',
            'name'         => 'featured',
            'type'         => 'switch',
            'wrapper' => ['class' => 'form-group col-md-6'],
            'color'    => 'success',
            'onLabel' => '✓',
            'offLabel' => '✕',
        ]);
        $this->crud->addField([
            'label'        => 'Image',
            'name'         => 'image',
            'filename'     => 'image_filename',
            'type'         => 'base64_image',
            'aspect_ratio' => 0,
            'crop'         => true,
            'src'          => NULL,
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - $this->crud->field('price')->type('number');
         * - $this->crud->addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
