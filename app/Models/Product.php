<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Config;
use DateTime;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    public $incrementing = false;
    public $timestamps = true;
    protected $keytype = 'string';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'status',
        // 'created_by',
        // 'updated_by',
    ];

    // public function getCreatedAtAttribute($value){
    //     $date = new DateTime($this->attributes['createdAt']);
    //     return $date->format(Config::get('constants.get_date_time_format'));
    // }
}