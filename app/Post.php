<?php

namespace App;

use App\Traits\HasComments;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Post extends Model
{
    use \Conner\Tagging\Taggable;
    use HasComments;

    protected $fillable = ['post_title', 'slug', 'post_desc', 'post_image', 'post_thumb', 'posts_tags', 'post_body', 'active', 'user_id'];

    protected $with = ['comments.creator', 'comments.children',  'comments.children.creator'];


    public function author()
    {
        return $this->belongsTo(User::class);
    }


    public function setSlugAttribute($value)

    {
        $this->attributes['slug'] =  Str::slug($value);
    }

    public function setActiveAttribute($value)
    {
        if($value == null){
            return $this->attributes['active'] = false;
        }
         return $this->attributes['active'] = true;
    }

    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y.');;
    }



}
