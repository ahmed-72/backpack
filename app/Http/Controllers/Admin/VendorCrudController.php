<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VendorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VendorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VendorCrudController extends CrudController
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
        $this->crud->setModel(\App\Models\Vendor::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/vendor');
        $this->crud->setEntityNameStrings('vendor', 'vendors');
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
        $this->crud->column('description');
        $this->crud->column('location');
        $this->crud->column('email');
        $this->crud->column('phone');
        $this->crud->column('open_at');
        $this->crud->column('close_at');
        $this->crud->column('avatar');
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
        $this->crud->setValidation(VendorRequest::class);

        $this->crud->field('name_en');
        $this->crud->field('name_ar');
        $this->crud->field('description');
        $this->crud->field('location');
        $this->crud->field('email');
        $this->crud->field('phone');

        $this->crud->addField([   
            // required
            'name' => 'categories',
            'type' => "relationship",
            // OPTIONALS:
             'label' => "Categories",
             'attribute' => "name_en",
             'placeholder' => "Select a category",
         ],
     /*   // for 1-n relationships (ex: category)
[
    'type'          => "relationship",
    'name'          => 'classifications',
    'ajax'          => true,
    'inline_create' => true, // <--- THIS
],
// for n-n relationships (ex: tags)
[
    'type'          => "relationship",
    'name'          => 'classifications', // the method on your model that defines the relationship
    'ajax'          => true,
    'inline_create' => true // <--- OR THIS
],
// in this second example, the relation is called `tags` (plural),
// but we need to define the entity as "tag" (singural)*/
);
        //  $this->crud->addField([   // Table
        //     'name'            => 'options',
        //     'label'           => 'Options',
        //     'type'            => 'table',
        //     'entity_singular' => 'option', // used on the "Add X" button
        //     'columns'         => [
        //         'name'  => 'Name',
        //         'desc'  => 'Description',
        //         'price' => 'Price'
        //     ],
        //     'max' => 5, // maximum rows allowed in the table
        //     'min' => 0, // minimum rows allowed in the table
        // ],);
        $this->crud->addField([
            'label'        => 'Location',
            'name'         => 'location',
            'type'         => 'address_google',
        ]);
        $this->crud->field('open_at');
        $this->crud->field('close_at');
        $this->crud->addField([
            'label'        => 'Avatar',
            'name'         => 'avatar',
            'filename'     => 'image_filename', // set to null if not needed
            'type'         => 'image',
            'aspect_ratio' => 0, // set to 0 to allow any aspect ratio
            'crop'         => true, // set to true to allow cropping, false to disable
            'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
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
