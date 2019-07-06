<?php

namespace App\Repositories;

use App\Models\Condition;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;


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

    /**
     * @param Condition $condition
     * @return Condition
     */
    public function save(Condition $condition) : Condition
    {
        $condition->save();

        return $condition;
    }
}
