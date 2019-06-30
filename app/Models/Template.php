<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 13 Jun 2019 08:00:52 +0000.
 */

namespace App\Models;

use App\User;
use Sofa\Eloquence\Eloquence;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Template
 * 
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property int $project_id
 * @property array $groups
 * @property string $file_path
 * @property string $file_type
 * @property bool $is_active
 * @property string $import_table
 * @property string $export_table
 * @property string $adapter_class
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Template extends Eloquent
{
    use Eloquence;

    protected $searchableColumns=['name','file_type','file_path','created_at', 'id','user.name', 'project.name'];

	protected $casts = [
		'user_id' => 'int',
		'project_id' => 'int',
		//'groups' => 'json',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'user_id',
		'project_id',
		//'groups',
		'file_path',
		'file_type',
		'is_active',
		'import_table',
		'export_table',
		'adapter_class'
	];

    protected $with=[
        'project',
        'user'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function project()
    {
        return $this->hasOne(Project::class,'project_id', 'project_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class,'id', 'user_id');
    }


}
