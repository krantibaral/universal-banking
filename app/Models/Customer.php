<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Define the relationship with the User model.
     *
     * A Customer belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
