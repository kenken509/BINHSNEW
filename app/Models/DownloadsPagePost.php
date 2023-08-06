<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadsPagePost extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
