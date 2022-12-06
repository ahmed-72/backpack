<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticleCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article');
        CRUD::setEntityNameStrings('article', 'articles');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('category_id');
        CRUD::column('title');
        CRUD::column('tags')->type('relationship_count');
        CRUD::column('slug');
        CRUD::column('content');
        CRUD::addColumn([
        'label' => "Image",
        'name' =>  "image",
        'type' => 'image',
        'prefix'=>'storage/',
        'height' => '50px',
        'width'  => '50px',
        ]);
        CRUD::column('status');
        CRUD::column('date');
        CRUD::column('featured');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
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
        CRUD::setValidation(ArticleRequest::class);

        CRUD::field('category_id');
        CRUD::field('title')->size(6);
        CRUD::field('slug')->size(6);
        CRUD::field('content')->type('summernote');
        CRUD::addField([   
            'label'     => "image",
            'name'      =>'image',
            'type'      => 'upload',
            'upload'    => true,
        ]);
        CRUD::field('status')->type('enum')->size(6);
        CRUD::field('date')->size(6);
        CRUD::field('featured')->type('checkbox')->size(6);
        CRUD::addField([   // SelectMultiple = n-n relationship (with pivot table)
            'label'     => "Tags",
            'type'      => 'select_multiple',
            'name'      => 'tags', // the method that defines the relationship in your Model
        
            // optional
            'entity'    => 'tags', // the method that defines the relationship in your Model
            'model'     => "App\Models\Tag", // foreign key model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
        
            // also optional
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }),
        ]);

      /*  CRUD::addField([ 'name'        => 'template',
        'label'       => "Template",
        'type'        => 'select2_from_array',
        'options'     => ['one' => 'One', 'two' => 'Two'],
        'allows_null' => false,
        'default'     => 'one',]);
*/
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
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
