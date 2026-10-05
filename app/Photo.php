<?php

namespace App;

use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Photo extends Model
{

    protected $fillable = ['photo_id', 'name', 'title', 'description','path', 'thumbnail_path', 'order'];

    protected $baseDir = 'gallery/photos';


    /**
     * Process uploaded photo to base dir with tuhmbnail and return name.
     *
     * @param $name
     * @return self
     */
    public static function named($name)
    {
        return (new static)->saveAs($name);
    }

    public function saveAs($name)
    {
        $this->name = sprintf("%s-%s", time(), $name);
        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
        $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);

        return $this;
    }

    public function move(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);

        $this->makeThumb();

        return $this;
    }

    public function makeThumb()
    {
        Image::make($this->path)
            ->fit(200)
            ->save($this->thumbnail_path);
    }

    public function page()
    {
        return $this->belongsTo('App\Page');
    }
     public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y. H:i');
    }
}
