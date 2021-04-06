<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $table='config';
    protected $fillable = [
        'key', 'value'
    ];

    public static function findByKey($key)
    {
        return self::where('key', $key)->first();
    }

    public static function getValueByKey($key)
    {
        $obj = self::findByKey($key);
        return $obj ? $obj->value : null;
    }
}
