<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    /**
     * Поля, которые разрешены для массового заполнения.
     */
    protected $fillable = [
        'title',
        'content',
        'status',
        'user_id',
        'file_path',
    ];
 

    /**
     * Связь с моделью User (владелец резюме).
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    /**
     * Define the relationship with categories.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'resume_category', 'resume_id', 'category_id');
    }

    /**
     * Define the relationship with skills.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'resume_skill', 'resume_id', 'skill_id');
    }

}
