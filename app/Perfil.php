<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //reelacion de 1 a 1 de perfil con usuario
    public function usuario(){
        return $this->BelongsTo(User::class,'user_id');
    }
}
