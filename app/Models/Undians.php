<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Undians extends Model
{
    use HasFactory;
    protected $table = 'undians';
    protected $fillable = ['reg_id','keterangan'];
}
