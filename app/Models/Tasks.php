<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    protected $table = "tasks";
    protected $fillable = ['name', 'description', 'due_date', 'user_id', 'tag_id', 'category_id'];
    public function getStatusAttribute($value)
    {
        return ($value == 1) ? 'Pending' : 'Completed';
    }

    public function setStatusAttribute($value)
    {
        if ($value == 'Pending') {
            $this->attributes['status'] = 1;
        } elseif ($value == 'Completed') {
            $this->attributes['status'] = 2;
        }
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tags::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

}