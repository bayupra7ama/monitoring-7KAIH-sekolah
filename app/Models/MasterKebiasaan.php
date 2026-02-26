<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKebiasaan extends Model
{
    protected $table = 'master_kebiasaans';
    protected $fillable = ['nama_kebiasaan', 'icon'];
}