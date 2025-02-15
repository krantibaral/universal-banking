<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $guarded = ['id'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // The 'receiver' is related to the 'Customer' model (the recipient of the transfer)
    public function receiver()
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }
}
