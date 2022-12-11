<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductOptionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductOptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductOptionCrudController extends CrudController
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
        $this->crud->setModel(\App\Models\ProductOption::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product-option');
        $this->crud->setEntityNameStrings('product option', 'product options');
    }

    /**
     * Define what happens when the Show operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->column('product_id');
        $this->crud->column('title_en');
        $this->crud->column('title_ar');
        $this->crud->column('type');
        $this->crud->addColumn([
            'name'  => 'id',
            'label'  => 'Attributes',
            'type'  => 'new_table2',
        ],);
        $this->crud->column('created_at');
        $this->crud->column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - $this->crud->column('price')->type('number');
         * - $this->crud->addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->column('product_id');
        $this->crud->column('title_en');
        $this->crud->column('title_ar');
        $this->crud->column('type');
        $this->crud->column('order');
        $this->crud->column('created_at');
        $this->crud->column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - $this->crud->column('price')->type('number');
         * - $this->crud->addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ProductOptionRequest::class);

        $this->crud->field('product_id');
        $this->crud->field('title');
        $this->crud->addField(
            [
                'name'  => 'type',
                'label' => 'Type',
                'type'  => 'enum',
            ],
        );
        $this->crud->addField([   // repeatable
            'name'  => 'config',
            'label' => 'Option attributes',
            'type'  => 'repeatable',
            'subfields' => [ // also works as: "fields"
                [
                    'name'    => 'name',
                    'type'    => 'text',
                    'label'   => 'Name',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
                [
                    'name'    => 'price',
                    'type'    => 'number',
                    'label'   => 'Price',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
            ],

            // optional
            'new_item_label'  => 'Add attribute', // customize the text of the button
            'init_rows' => 1, // number of empty rows to be initialized, by default 1
            'min_rows' => 1, // minimum rows allowed, when reached the "delete" buttons will be hidden
            'max_rows' => 50, // maximum rows allowed, when reached the "new item" button will be hidden
            // allow reordering?
            'reorder' => true, // hide up&down arrows next to each row (no reordering)
            'reorder' => true, // show up&down arrows next to each row
            'reorder' => 'order', // show arrows AND add a hidden subfield with that name (value gets updated when rows move)
            //'reorder' => ['name' => 'optionAttributes', 'label'=>'Option attribute', 'type' => 'number', 'attributes' => ['data-reorder-input' => true]], // show arrows AND add a visible number subfield
        ],);

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
