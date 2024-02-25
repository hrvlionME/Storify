<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{

    use SoftDeletes;
       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'type',
        'status',
        'image'
    ];

    // protected $guarded = [];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function getTitleAttribute($value): String
    {
        return ucfirst($value);
    }

    protected function getFootnoteAttribute(): String
    {
        return $this->type . ' Type created at ' . date('Y-m-d', strtotime($this->created_at));
    }

    protected function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
/*
    protected function getImageAttribute(): String
    {
        if($this->image) {
            return asset('storage/' . $this->image);
        } 
        return asset('storage/thumbnail.jpg');
    }

    use HasFactory;*/
}
