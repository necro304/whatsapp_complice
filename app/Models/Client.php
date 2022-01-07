<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string nombre
 * @property string celular
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable= ['establecimiento', 'nombre', 'cedula', 'celular'];

}
