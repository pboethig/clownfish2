<?php

namespace App\Repositories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @param \App\Models\Template $template
     *
     * @return \App\Models\Template
     */
    public function save(Template $template) : Template
    {
        $template->save();

        return $template;
    }

    /**
     * Get all the model records in the database.
     *
     * @param array $columns
     *
     * @return Collection|static[]
     */
    public function filter(array $filter = null)
    {

        if (isset($filter['searchTerm']) && !empty(trim($filter['searchTerm']))) {

            $result =  Template::search($filter['searchTerm'])->get();

            return $result;
        }

        $this->newQuery()->eagerLoad();

        $models = $this->query->get();

        $this->unsetClauses();

        return $models;
    }
}
