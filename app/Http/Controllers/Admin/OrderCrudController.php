<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
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
        $this->crud->setModel(\App\Models\Order::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order');
        $this->crud->setEntityNameStrings('order', 'orders');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->column('user_id');
        $this->crud->column('products_price');
        $this->crud->column('delivery_price');
        $this->crud->column('discount_id');
        $this->crud->column('total_price');
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
     * Define what happens when the Show operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-show-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->column('user_id');
        $this->crud->column('products_price');
        $this->crud->column('delivery_price');
        $this->crud->column('discount_id');
        $this->crud->column('total_price');
        $this->crud->addColumn('discount');

        $this->crud->addColumn(
            [  // Select
                'label'     => "Category",
                'type'      => 'select',
                'name'      => 'products',
                'entity'    => 'products.product',

                'model'     => "App\Models\Product",
                'attribute' => 'name_en',
                'wrapper'   => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('product/' . $related_key . '/show');
                    },
                ],
            ],
        );

        $this->crud->addColumn(
            [
                'name'  => 'products.product',
                'label' => 'Products',
                'type'  => 'order_products_table',
            ],
        );

        $this->crud->column('created_at');
        $this->crud->column('updated_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(OrderRequest::class);

        $this->crud->field('user_id');
        $this->crud->field('products_price');
        $this->crud->field('delivery_price');
        $this->crud->field('discount_id')->attribute('code');
        $this->crud->addField(
            [
                'name' => 'total_price',
                'label' => 'Total Price',
                'type' => 'number',
                'attributes' => ["step" => "any"],
                'prefix'     => "SAR",
            ],
        );
        $this->crud->addField([   // repeatable
            'name'  => 'products',
            'label' => 'Products',
            'type'  => 'repeatable',
            'subfields' => [
                [
                    'name'            => 'product_id',
                    'label'           => 'Product Name',
                    'type'            => 'select',
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
                //     // 'options'   => (function ($query) {
                //     //     //dd($attribute);
                //     //     dd($query);
                //     //     return $query->where('product_id', 5)->get();
                //     // }), //  you can use this to filter the results show in the select
                // ],
                // [  // Select
                //     'label'     => "Category",
                //     'type'      => 'select',
                //     'name'      => 'product_id.product_option_id', // the db column for the foreign key

                //     // optional
                //     // 'entity' should point to the method that defines the relationship in your Model
                //     // defining entity will make Backpack guess 'model' and 'attribute'
                //    // 'entity'    => 'category',

                //     // optional - manually specify the related model and attribute
                //     //'model'     => "App\Models\Category", // related model
                //     //'attribute' => 'name', // foreign key attribute that is shown to user

                //     // optional - force the related options to be a custom query, instead of all();
                //     'options'   => (function ($query) {
                //         dd($query);
                //          return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
                //      }), //  you can use this to filter the results show in the select
                //  ],
                [
                    'name'            => 'options',
                    'label'           => 'Options',
                    'type'            => 'table',
                    'entity_singular' => 'Option', // used on the "Add X" button
                    'columns'         => [
                        'product_option_id'  => 'product option',
                        //'price' => 'Price'
                    ],
                    'max' => 30,
                    'min' => 1,
                ]
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
