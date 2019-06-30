<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 13 Jun 2019 08:01:12 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Condition
 * 
 * @property int $condition_id
 * @property string $name
 * @property int $template_id
 * @property bool $is_active
 * @property string $column_name
 * @property string $class_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Condition extends Eloquent
{
	protected $primaryKey = 'condition_id';

	protected $casts = [
		'template_id' => 'int',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'template_id',
		'is_active',
		'column_name',
		'target_column_name',
		'class_name'
	];
}
