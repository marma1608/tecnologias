<?php

namespace App;

use App\User;
use App\CategoriaReceta;
use Illuminate\Database\Eloquent\Model;


class Receta extends Model
{
    //use HasFactory;
    /**
     * Get the user that owns the Receta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes', 'imagen','categoria_id',
    ];
    public function categoria()
    {
        return $this->belongsTo(CategoriaReceta::class);
    }
    //obtiene la informacion del usuario via FK
    public function autor()
    {
        return $this->belongsTo(User::class,'user_id');//FK de esta tabla 
    }
//likes ha recibido una receta
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes_receta');//FK de esta tabla 
    }

}
