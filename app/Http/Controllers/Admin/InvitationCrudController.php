<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\User;
use App\Mail\InviteUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\InvitationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InvitationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvitationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
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
        CRUD::setModel(\App\Models\Invitation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invitation');
        CRUD::setEntityNameStrings('invitation', 'invitations');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // columns

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
        CRUD::setValidation(InvitationRequest::class);
        // CRUD::setFromDb(); // fields
        CRUD::field('name');
        CRUD::field('email');
        CRUD::addField(
        [   // select2_from_array
            'name'        => 'teams',
            'label'       => "Teams",
            'type'        => 'select2_from_array',
            'options'     => $this->getTeams(),
            'allows_null' => false,
            'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]
        );




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

    public function store(InvitationRequest $request)
    {
        // do something before validation, before save, before everything
        $response = $this->traitStore();
        $invitation = $this->crud->getCurrentEntry();
        $text_password = Str::random(8);
        $password = Hash::make($text_password);
      
        $user = User::create([
            'name' => $invitation['name'],
            'email' => $invitation['email'],
            'password'=> $password,

        ]);
        
        
        $user->save();
        $user->teams()->sync($request['teams']); 
        
        Mail::to(backpack_user())->send(new InviteUser($user, $text_password));
        // do something after save
        return $response;

    }

    public function getTeams()
    {
        return Team::get()->pluck('name', 'id');
    }
}
