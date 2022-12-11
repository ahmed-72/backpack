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
        $this->crud->setModel(\App\Models\Article::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/article');
        $this->crud->setEntityNameStrings('article', 'articles');
    }

      // show whatever you want
      protected function setupShowOperation()
      { 
          // MAYBE: do stuff before the autosetup
  
          // automatically add the columns
          $this->autoSetupShowOperation();
  
          // MAYBE: do stuff after the autosetup
          $this->crud->modifyColumn('image',[
            'label' => "Image",
            'name' =>  "image",
            'type' => 'image',
            'prefix'=>'storage/',
            'height' => '100px',
            'width'  => '100px',
            ]);
           
     $this->crud->modifyColumn('created_at',['type'=>'date ']);

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
            ],*/
         ],);
         $this->crud->addColumn([
            'label'     => 'relationship',
            'type'      => 'select',
            'entity'    => 'tags.stags.full_name',
            'attribute' => 'full_name',
         ],);
        
/*
$this->crud->addColumn([
              'name' => 'tags.articles',
              'label' => 'relatiship_count',
              'type' => 'relationship_count',
          ]);*/

         //articles
         $this->crud->addColumn([
            'name'  => 'separator',
            'type'  => 'custom_html',
            'value' => '<div class="col-6"><a class="btn btn-block btn-primary" href='.route("test").'>show
          </a></div>'
         ],);
  
          // or maybe remove a column
          //$this->crud->removeColumn('fake_table');
      }



    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->column('category_id');
        $this->crud->column('title');
        $this->crud->column('tags')->type('relationship_count');
       /* $this->crud->addColumn([
            // 1-n relationship
            'label'     => 'tags', // Table column heading
            'type'      => 'select',
            'name'      => 'article_id', // the column that contains the ID of that connected entity;
            'entity'    => 'tags', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => "App\Models\Tag", // foreign key model
         ],);
        $this->crud->column('slug');*/
        $this->crud->column('content');
        $this->crud->addColumn([
        'label' => "Image",
        'name' =>  "image",
        'type' => 'image',
        'prefix'=>'storage/',
        'height' => '50px',
        'width'  => '50px',
        ]);
        $this->crud->modifyColumn('featured',['type'=>'check']);

        $this->crud->column('date');
        $this->crud->column('featured')->type('check');

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
        $this->crud->setValidation(ArticleRequest::class);

        $this->crud->field('category_id');
        $this->crud->field('title')->size(6);
        $this->crud->field('slug')->size(6);
        $this->crud->field('content')->type('ckeditor');
        $this->crud->addField([   
            'label'        => "Profile Image",
            'name'         => "image",
            'filename'     => "image_filename", // set to null if not needed
            'type'         => 'base64_image',
            'aspect_ratio' => 1, // set to 0 to allow any aspect ratio
            'crop'         => true, // set to true to allow cropping, false to disable
            'src'          => NULL, // null to read straight from DB, otherwise set to model accessor function
        ]);
        $this->crud->field('status')->type('enum')->size(6);
        
       /* $this->crud->addField([  // CustomHTML
            'name'  => 'separator',
            'type'  => 'custom_html',
            'value' => '<div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
          </div>'
        
    ]);*/
        $this->crud->field('date')->size(6);
        $this->crud->field('featured')->type('switch')->size(6);
        $this->crud->addField([   // Checklist
            'label'     => 'Tags',
            'type'      => 'checklist',
            'name'      => 'tags',
            'entity'    => 'tags',
            'attribute' => 'name',
            'model'     => "App\Models\Tag",
            'pivot'     => true,
            // 'number_of_columns' => 3,
        ]);
      /*  $this->crud->addField([   // SelectMultiple = n-n relationship (with pivot table)
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
            })
        ]);
,*/
      /*  $this->crud->addField([ 'name'        => 'template',
        'label'       => "Template",
        'type'        => 'select2_from_array',
        'options'     => ['one' => 'One', 'two' => 'Two'],
        'allows_null' => false,
        'default'     => 'one',]);
*/
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
