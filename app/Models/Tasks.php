<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    protected $table = "tasks";
    protected $fillable =['name','description','due_date','user_id','tag_id','category_id'];
}
