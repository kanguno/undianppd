<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regs extends Model
{
    use HasFactory;
    protected $table = 'regs';
    protected $fillable = ['nik','merchant_id','tgl_bill','status_id','bill_img','status_tappingbox','tappingbox_id','keterangan'];
}
