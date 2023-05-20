<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'description', 'attachment', 'status','archived',];

    /*public function project()
    {
        return $this->belongsTo(Project::class);
    }*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*public function comments()
    {
        return $this->hasMany(BugComment::class);
    }*/
}
