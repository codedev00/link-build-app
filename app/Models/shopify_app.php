<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopify_app extends Model
{
    use HasFactory;
    protected $primarykey="id";
    protected $table="tbl_usersettings";
}
