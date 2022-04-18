<?php

namespace App\Modules\ModuleModule;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

   protected $table = 'modules';
   protected $primaryKey = 'id';
   protected $fillable = [
      'name',
      'reference',
      'parent_id',
      'icon',
      'state',
      'actions'
   ];

}
