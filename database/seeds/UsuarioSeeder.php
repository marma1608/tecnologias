<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'name'=>'Javier',
            'email'=>'Javier@correo.com',
            'password'=>Hash::make('12345678'),
            'url'=>'http://itszo.com',
        ]);
        
        $user2=User::create([
            'name'=>'Rafael',
            'email'=>'Rafael@correo.com',
            'password'=>Hash::make('12345678'),
            'url'=>'http://itszo.com',
        ]);
        
    }
}
