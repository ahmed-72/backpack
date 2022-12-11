<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        $this->crud->setModel(\App\Models\Product::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product');
        $this->crud->setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the Show operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */

    public $config = [];
    protected function setupShowOperation()
    {
        //  dd($this);
        $this->crud->column('name_en');
        $this->crud->column('name_ar');
        $this->crud->column('description_en');
        $this->crud->column('description_ar');
        $this->crud->column('price');
        $this->crud->addColumn([
            'label' => "Image",
            'name' =>  "avatar",
            'type' => 'image',
            'prefix' => 'storage/',
            'height' => '100px',
            'width'  => '100px',
        ]);
        $this->crud->column('vendor_id');
        $this->crud->column('active')->type('check');
        $this->crud->column('featured')->type('check');
        $this->crud->addColumn(
            // [
            //     'name'  => 'product.options.full_name',
            //     'label' => 'product.options',
            //     'type'  => 'table',
            //     'columns' => [
            //         'name_en'     => 'name_en',
            //         'name_ar'     => 'name_ar',
            //         'type'     => 'type',
            //     ]
            // ],


            /************* links */
            [
                'label'     => 'Options', 
                'type'      => 'select_multiple',
                'name'      => 'options',
                'entity'    => 'options',
                'attribute' => 'title_en',
                'wrapper'   => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('product-option/'.$related_key.'/show');
                    },
                ],
            ],

            /************* json */

            // [
            //     'name'         => 'options',
            //     'type'         => 'relationship',
            //     'label'        => 'Options',
            //     'attribute' => 'config',
            //     // 'tableColumn' => [
            //     //     'name_en'     => 'name_en',
            //     //     'name_ar'     => 'name_ar',
            //     //     'price'     => 'price',
            //     // ],
            //     'wrapper'   => [
            //         // 'element' => 'div',
            //         // 'class' => function ($crud, $column, $entry, $related_key) {
                        
            //         //     return 'badge badge-default';
            //         // },
            //         // 'href' => function ($crud, $column, $entry, $related_key) {
            //         //     //$y=$entry->options[0]->config;
            //         //     foreach ($column['value'] as $key => $attribute) {
            //         //         $attribute = json_decode($attribute);
            //         //         $count = 0;
            //         //         foreach ($attribute as $value) {
            //         //             $this->config[$key][$count]['name_en'] = $value->name_en;
            //         //             $this->config[$key][$count]['name_ar'] = $value->name_ar;
            //         //             $this->config[$key][$count]['price'] = $value->price;
            //         //             ++$count;
            //         //         }
            //         //     }
            //         //     //dd($config);
            //         //     return backpack_url('product-option/' . $count . '/show');
            //         // },
            //     ],
            // ],

            /************* */


            //     [
            //     // 1-n relationship
            //     'label'     => 'relationship', // Table column heading
            //     'type'      => 'array',
            //     'name'      => 'product_id', // the column that contains the ID of that connected entity;
            //     'entity'    => 'options', // the method that defines the relationship in your Model
            //     'attribute' => 'config', // foreign key attribute that is shown to user
            //     //  'model'     => "App\Models\ProductOption", // foreign key model
            //     'columns' => [
            //         'title_en'     => 'title_en',
            //         'title_ar'     => 'title_ar',
            //         /*'label'     => 'relationship',
            //         'label'     => 'relationship', // Table column heading
            //         'type'      => 'select',
            //         'name'      => 'product_id', // the column that contains the ID of that connected entity;
            //         'entity'    => 'options', // the method that defines the relationship in your Model
            //         'attribute' => 'title_en', // foreign key attribute that is shown to user
            //         'model'     => "App\Models\ProductOption", // foreign key model*/
            //     ],
            // ],
        );
        $this->crud->addColumn([
            'name'  => 'id',
            'label'  => 'Options',
            'type'  => 'new_table',
        ],);
        
        //  dd($tt);
        /* $this->crud->addColumn([
            'label'     => 'relationship',
            'type'      => 'relationship',
            'entity'    => 'options.full_name',
            'attribute' => 'full_name',
         ],);
         $this->crud->addColumn([
            'name'  => 'product_id',
            'label' => 'Options',
            'type'  => 'array',
            'entity'    => 'options', // the method that defines the relationship in your Model

        ],);*/
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
        $this->crud->column('name_en');
        $this->crud->column('name_ar');
        $this->crud->column('description_en');
        $this->crud->column('description_ar');
        $this->crud->column('price');
        $this->crud->addColumn([
            'label' => "Image",
            'name' =>  "avatar",
            'type' => 'image',
            'prefix' => 'storage/',
            'height' => '50px',
            'width'  => '50px',
        ]);
        $this->crud->column('vendor_id');
        $this->crud->column('active');
        $this->crud->column('featured');
        $this->crud->column('created_at');
        $this->crud->column('updated_at');

        /*
                  // for example, let's add some new columns
          $this->crud->addColumn([
              'name' => 'tags',
              'label' => 'relationship_count',
              'type' => 'relationship_count',
          ]);
          $this->crud->addColumn([
            // 1-n relationship
            'label'     => 'relationship', // Table column heading
            'type'      => 'select',
           // 'name'      => 'article_id', // the column that contains the ID of that connected entity;
            'entity'    => 'tags.stags', // the method that defines the relationship in your Model
            'attribute' => 'details', // foreign key attribute that is shown to user
 
            // 'entity'    => 'tags.articles',
            //'attribute' => 'slug', // foreign key attribute that is shown to user


          //  'model'     => "App\Models\Tag", // foreign key model
           /* 'columns' => [
                'label'     => 'relationship', // Table column heading
                'type'      => 'select',
                'name'      => 'tag_id', // the column that contains the ID of that connected entity;
                'entity'    => 'stags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => "App\Models\Stag", // foreign key model
            ],
        ],);
        $this->crud->addColumn([
           'label'     => 'relationship',
           'type'      => 'select',
           'entity'    => 'tags.stags.full_name',
           'attribute' => 'full_name',
        ],);
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
        $this->crud->setValidation(ProductRequest::class);

        $this->crud->field('vendor_id');
        $this->crud->field('name_en');
        $this->crud->field('name_ar');
        $this->crud->field('description_en');
        $this->crud->field('description_ar');
        $this->crud->addField([   
            // required
            'name' => 'categories',
            'type' => "relationship",
            // OPTIONALS:
             'label' => "Categories",
             'attribute' => "name",
             'placeholder' => "Select a category",
         ],);
        $this->crud->field('price')->type('number')->size(6);
        $this->crud->addField([  // CustomHTML
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
            'label'        => 'Avatar',
            'name'         => 'avatar',
            'filename'     => 'image_filename', // set to null if not needed
            'type'         => 'base64_image',
            'aspect_ratio' => 0, // set to 0 to allow any aspect ratio
            'crop'         => true, // set to true to allow cropping, false to disable
            'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
        ]);

        $this->crud->addField([   // repeatable
            'name'  => 'options',
            'label' => 'Options',
            'type'  => 'repeatable',
            'subfields' => [
                [
                    'name'            => 'title_en',
                    'label'           => 'Title en',
                    'type'            => 'text',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
                [
                    'name'            => 'title_ar',
                    'label'           => 'Title ar',
                    'type'            => 'text',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
                [
                    'name'  => 'type',
                    'label' => 'Type',
                    'type'  => 'select_from_array',
                    'options'     => ['just_one' => 'Just one', 'zero_or_more' => 'zero or more', 'one_or_more' => 'one or more', 'counter' => 'counter'],
                ],
                [
                    'name'            => 'config',
                    'label'           => 'Option attributes',
                    'type'            => 'table',
                    'entity_singular' => 'Attribute', // used on the "Add X" button
                    'columns'         => [
                        'name_en'  => 'Name en',
                        'name_ar'  => 'Name ar',
                        'price' => 'Price'
                    ],
                    'max' => 30,
                    'min' => 1,
                ]
            ],

            // optional
            'new_item_label'  => 'Add Option',
            'init_rows' => 1,
            'min_rows' => 1,
            'max_rows' => 50,
            'reorder' => true, // hide up&down arrows next to each row (no reordering)
            'reorder' => true, // show up&down arrows next to each row
            'reorder' => 'order', // show arrows AND add a hidden subfield with that name (value gets updated when rows move)
            //'reorder' => ['name' => 'optionAttributes', 'label'=>'Option attribute', 'type' => 'number', 'attributes' => ['data-reorder-input' => true]], // show arrows AND add a visible number subfield
        ],);
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
