<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'name',
        'gender',
        'address',
        'entry_year',
        'photo',
    ];

    public function subject()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id');
    }
}
