<?php

namespace App\Models;

use App\Traits\RestCache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes ,RestCache,HasFactory;

    protected $fillable = [
        'title', 'cover_image', 'body', 'pinned', 'user_id'
    ];

    protected $casts = [
        'pinned' => 'boolean',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function postTags(): HasMany
    {
        return $this->hasMany(PostTag::class, 'post_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id')
            ->using(PostTag::class);
    }

    public function coverImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => asset('storage/' . $this->cover_image),
        );
    }

    public function deleteCoverImage(): void
    {
        if (\Storage::exists($this->cover_image)){
            \Storage::delete($this->cover_image);
        }
    }
}
