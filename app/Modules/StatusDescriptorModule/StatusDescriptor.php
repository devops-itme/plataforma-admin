<?php

namespace App\Modules\StatusDescriptorModule;

use App\Modules\RoleModule\Role;
use App\Modules\StatusMatrixModule\StatusMatrix;
use Illuminate\Database\Eloquent\Model;

class StatusDescriptor extends Model
{
    protected $table = 'status_descriptors';
    protected $fillable = [
        'description',
        'role_id',
        'status_matrix_id',
    ];

    public function getStatus()
    {
        return $this->belongsTo(StatusMatrix::class, 'status_matrix_id');
    }

    public function getRole()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
