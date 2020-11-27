<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductType;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Request;
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
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        
        
        // $this->crud->setColumns([
        //     [
        //         'label'     => "Product Type",
        //         'type'      => 'select',
        //         'name'      => 'producttype',
        //         'entity'    => 'producttype', 
        //         'model'     => "App\Models\ProductType",
        //         'attribute' => 'name',
                
        //     ]
        // ]);
        
        CRUD::setFromDb(); // columns
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        
        CRUD::addFields([
            [ 
                'type' => "relationship",
                'name' => 'product_type_id',
                // OPTIONALS:
                'label' => "What specific products are expected from this work?",
                'attribute' => "name", 
                'entity' => 'product_type',
                'model' => "App\Models\ProductType",
                'placeholder' => "Select a Product Type", 
                
            ],
            [
                'type' => "text",
                'name' => 'audience',  
                'label' => 'Describe the audience to whom the product is aimed '
            ],
            [
                'type' => "number",
                'name' => 'audience_size',  
                'label' => 'Can you provide an indication of the number of users of this product that you confidently expect to have '
            ],
            [
                'type' => "text",
                'name' => 'publication',  
                'label' => 'If this product is published, where will it be published? '
            ],
            [
                'type' => "text",
                'name' => 'distribution',  
                'label' => 'What is the mechanism or means of distribution of the product? '
            ],
            [
                'type' => "date",
                'name' => 'publication_date',  
                'label' => 'Date when the product is/will be available '
            ],
            [
                'type' => "url",
                'name' => 'publication_url',  
                'label' => 'URL where the product can be found'
            ],
            [
                'type' => "text",
                'name' => 'partner',  
                'label' => 'Indicate any partners that have contributed to this specific product '
            ],
            [
                'type' => "text",
                'name' => 'info_hosted',  
                'label' => 'If the product is "hosted" by an organisation or platform, please indicate who hosts the product '
            ],
            [
                'type' => "url",
                'name' => 'url',  
                'label' => 'Please indicate the URL where the product is hosted if different from the one provided above '
            ],
            [
                'type' => "text",
                'name' => 'access_conditions',  
                'label' => 'If there are any special conditions for accessing the product please describe them '
            ],


        ]); 
          
        // CRUD::setFromDb(); // fields

        
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

    public function fetchProduct_type()
    {
        return $this->fetch([
            'model' => ProductType::class,
            'query' => function ($model) {
            return $model->where('is_other', '=', false);
            }
        ]);
    }

    // public function store(Request $request)
    // {
    //     dd($request);
    //     $response = $this->traitStore();

    //   // do something before validation, before save, before everything

     
    //     return $response;
    // }
}
