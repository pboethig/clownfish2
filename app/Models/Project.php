<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 13 Jun 2019 08:00:43 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Project
 * 
 * @property int $project_id
 * @property string $name
 * @property int $user_id
 * @property array $groups
 * @property bool $is_active
 * @property string $import_table
 * @property string $export_table
 * @property string $adapter_class
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Project extends Eloquent
{
	protected $primaryKey = 'project_id';

	protected $casts = [
		'user_id' => 'int',
		'groups' => 'json',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'user_id',
		'groups',
		'is_active',
		'import_table',
		'export_table',
		'adapter_class'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Temlate');
    }
}
