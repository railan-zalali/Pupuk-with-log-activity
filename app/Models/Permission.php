<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    use LogsActivity;

    protected $activityLogType = 'master data';
    protected $activityLogModule = 'Permission';

    protected $fillable = ['name', 'slug'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
