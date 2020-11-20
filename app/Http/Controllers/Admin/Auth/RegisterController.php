<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Team;
use Illuminate\Support\Facades\Validator;
use Backpack\CRUD\app\Http\Controllers\Auth\RegisterController as BackpackRegisterController;

class RegisterController extends BackpackRegisterController 
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $users_table = $user->getTable();
        $email_validation = backpack_authentication_column() == 'email' ? 'email|' : '';

        return Validator::make($data, [
            'name'                             => 'required|max:255',
            backpack_authentication_column()   => 'required|'.$email_validation.'max:255|unique:'.$users_table,
            'password'                         => 'required|min:6|confirmed',
            // 'teams'                            => 'required'
        ]);
    
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        // dd($data->teams);
    
     
        $user->create([
            'name'                             => $data['name'],
            backpack_authentication_column()   => $data[backpack_authentication_column()],
            'password'                         => bcrypt($data['password']),
        ]);

        // $user->teams()->sync($data['teams']); 
        

        return  $user;
    }

    public function showRegistrationForm()
    {

        $this->data['title'] = trans('backpack::base.register'); // set the page title
        $teams = Team::all();

        return view(backpack_view('auth.register'), $this->data)->with('teams', $teams);
    }
}

