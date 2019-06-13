<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 13 Jun 2019 08:01:01 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Group
 * 
 * @property int $group_id
 * @property string $name
 * @property string $key
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Group extends Eloquent
{
	protected $primaryKey = 'group_id';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'key',
		'is_active'
	];
}
