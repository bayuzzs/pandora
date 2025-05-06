<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheep extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'uid',
    'name',
    'gender',
    'birth_date',
    'breed',
    'weight',
    'health_status',
    'pen_id',
    'last_check_date',
    'last_vaccination_date'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'birth_date' => 'date',
    'last_check_date' => 'date',
    'last_vaccination_date' => 'date',
  ];

  /**
   * Get the pen that the sheep belongs to.
   */
  public function pen()
  {
    return $this->belongsTo(Pen::class);
  }
}