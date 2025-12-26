<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    // Nombre de la tabla (asegúrate que coincida con tu migración)
    protected $table = 'targets';

    // CAMPOS PERMITIDOS: Si un campo no está aquí, Laravel lo ignora al guardar
    protected $fillable = [
        'name',
        'ip',
        'user_agent',
        'location',
        'photo_path',
    ];

    

    // Opcional: Si quieres que Laravel trate las fechas automáticamente
    protected $dates = ['created_at', 'updated_at'];
}