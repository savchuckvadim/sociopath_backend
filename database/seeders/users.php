<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class users extends Seeder
{
    function __construct() {
        
    }
    public $users = [
        'Kolya',
        'Petya',
        'Vasya'
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
   
    public function run()
    {
      $user = User::factory();
    //   ->hasProfile (1, function(array $attributes, User $user){
    //     return [
    //       'user_id' => $user->id,
    //       'name' => $user->name,
    //       'surname' => $user->surname,
    //       'email' => $user->email,
    //     ];
    //   }
    // );
      

      return $user->count(20)->create();
    }
}
