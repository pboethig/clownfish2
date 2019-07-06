<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use App\Models\Template;
use App\Repositories\conditionRepository;
use App\Service\ImportTemplatesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Class ConditionsController
 *
 * @package App\Http\Controllers\Api
 */
class ConditionsController extends Controller
{
    /**
     * @var ConditionRepository
     */
    private $conditionRepository;

    /**
     * TemplatesController constructor.
     *
     * @param \App\Repositories\ConditionRepository $conditionRepository
     * @param \App\Service\ImportTemplatesService $importTemplatesService
     */
    public function __construct(
        ConditionRepository $conditionRepository
    ) {
        $this->conditionRepository = $conditionRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $filter = json_decode($request->get('filter', null), true);

        return $this->conditionRepository->filter($filter);
    }

    /**
     * @param Request $request
     * @param Condition $condition
     * @return Template
     */
    public function store(Request $request, Condition $condition)
    {
        return $this->conditionRepository->save($condition->fill($request->all()));
    }

    /**
     * @param Request $request
     * @param Template $template
     * @return Condition
     */
    public function update(Request $request, Template $template)
    {
        return $this->conditionRepository->save($template->fill($request->all()));
    }

    /**
     * @param Condition $condition
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Condition $condition)
    {
        return response()->json(["message"=>$condition->delete()]);
    }
}
