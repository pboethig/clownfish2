<?php

namespace App\Repositories;

use App\Models\Condition;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ConditionRepository.
 */
class ConditionRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Condition::class;
    }
}
