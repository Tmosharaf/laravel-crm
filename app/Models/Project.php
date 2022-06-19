<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'is_active',
        'client_id',
        'user_id'
    ];
    // protected $with = ['user', 'client', 'tasks'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    
    public function tasks()
    {

        return $this->hasMany(Task::class)->with(['user']);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function(){
                if($this->is_active && $this->end_date > now()){
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
