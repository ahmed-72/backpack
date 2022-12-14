<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderProductOptionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderProductOptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderProductOptionCrudController extends CrudController
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
        $this->crud->setModel(\App\Models\OrderProductOption::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order-product-option');
        $this->crud->setEntityNameStrings('order product option', 'order product options');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->column('order_product_id');
        $this->crud->column('created_at');
        $this->crud->column('updated_at');
        $this->crud->column('deleted_at');

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
        $this->crud->setValidation(OrderProductOptionRequest::class);

        $this->crud->field('order_product_id');
        $this->crud->addField([   // repeatable
            'name'  => 'products',
            'label' => 'Products',
            'type'  => 'repeatable',
            'subfields' => [
                [
                    'name'            => 'options',
                    'label'           => 'option Name',
                    'type'            => 'select',
                    'model'     => "App\Models\ProductOption", // related model
                    'attribute' => 'title_en', // foreign key attribute that is shown to user
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
                [
                    'name'            => 'quantity',
                    'label'           => 'Quantity',
                    'type'            => 'number',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
                // [
                //     'name'            => 'product_option_id',
                //     'label'           => 'Options',
                //     'type'            => 'select',
                //     'model'     => "App\Models\ProductOption", // related model
                //     'attribute' => 'title_en', // foreign key attribute that is shown to user
                //     'wrapper' => ['class' => 'form-group col-md-6'],
                //     'options'   => (function ($query) {
                //         //dd($attribute);
                //         dd($query);
                //         return $query->where('product_id', 5)->get();
                //     }), //  you can use this to filter the results show in the select
                // ],
                // [
                //     'name'            => 'options',
                //     'label'           => 'Options',
                //     'type'            => 'table',
                //     'entity_singular' => 'Option', // used on the "Add X" button
                //     'columns'         => [
                //         //'product_option_id'  => 'product option',
                //         'price' => 'Price'
                //     ],
                //     'max' => 30,
                //     'min' => 1,
                // ]
            ],

            // optional
            'new_item_label'  => 'Add Product',
            'init_rows' => 1,
            'min_rows' => 1,
            'max_rows' => 50,
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
