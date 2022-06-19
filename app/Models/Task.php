<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'project_id',
        'client_id',
        'user_id'
    ];
    // protected $with = ['user', 'project'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    



    protected function status(): Attribute
    {
        return Attribute::make(
            get: function(){

                if($this->is_active && $this->end_date > now() && $this->project->status){
                    return true;
                }
                return false;

            }
        );
    }

    protected function endsIn(): Attribute
    {
        return Attribute::make(
            get: function(){
                if($this->end_date > now()){
                    return now()->diffInDays($this->end_date) . ' Days';
                }
                return '<span class="bg-red-400 cursor-default text-white px-2 py-1 rounded-md">Expired</span>';
            }
        );
    }

}
