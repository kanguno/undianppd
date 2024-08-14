<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wpdatas extends Model
{
    use HasFactory;
    protected $table = 'wp_datas';
    protected $fillable = ['nik','nm_wp','alm_wp','no_hp','email'];

}
