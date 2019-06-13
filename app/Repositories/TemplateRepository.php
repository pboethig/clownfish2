<?php

namespace App\Repositories;

use App\Models\Template;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class TemplateRepository.
 */
class TemplateRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Template::class;
    }
}
