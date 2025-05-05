<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pen extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'location',
    'capacity',
    'description',
  ];

  /**
   * Get the sheep that belong to the pen.
   */
  public function sheep()
  {
    return $this->hasMany(Sheep::class);
  }
}