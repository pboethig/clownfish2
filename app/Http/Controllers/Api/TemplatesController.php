<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Repositories\TemplateRepository;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    /**
     * @var TemplateRepository
     */
    private $templateRepository;

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->templateRepository->all();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Template $template
     *
     * @return \App\Models\Template
     */
    public function store(Request $request, Template $template)
    {
        return $this->templateRepository->save($template->fill($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Template $template
     *
     * @return \App\Models\Template
     */
    public function update(Request $request, Template $template)
    {
        return $this->templateRepository->save($template->fill($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
