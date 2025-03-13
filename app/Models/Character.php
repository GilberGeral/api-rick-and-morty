<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model {
  use HasFactory;

  protected $table = 'characters';
  protected $primaryKey = 'id';

  protected $fillable = [
    'id_externo',
    'name',
    'status',
    'species',
    'type',
    'gender',
    'origin',
    'image',
    'created_at',
    'created_by',
    'updated_at',
    'updated_by',
  ];

  public $timestamps = false;
}
