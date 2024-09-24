<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wpdatas extends Model
{
    use HasFactory;
    protected $table = 'wp_datas';
    protected $fillable = ['nik','nm_wp','desa_wp','rt_wp','rw_wp','kecamatan_wp','daerah_wp','provinsi_wp','no_hp','email'];

}
