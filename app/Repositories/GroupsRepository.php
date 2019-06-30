<?php

namespace App\Repositories;

use App\Models\Group;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class GroupsRepository.
 */
class GroupsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Group::class;
    }
}
