<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Repositories\TemplateRepository;
use App\Service\ImportTemplatesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class TemplatesController
 *
 * @package App\Http\Controllers\Api
 */
class TemplatesController extends Controller
{
    /**
     * @var TemplateRepository
     */
    private $templateRepository;

    /**
     * @var ImportTemplatesService
     */
    private $importTemplatesService;

    /**
     * TemplatesController constructor.
     *
     * @param \App\Repositories\TemplateRepository $templateRepository
     * @param \App\Service\ImportTemplatesService $importTemplatesService
     */
    public function __construct(
        TemplateRepository $templateRepository,
        ImportTemplatesService $importTemplatesService
    ) {
        $this->templateRepository = $templateRepository;

        $this->importTemplatesService = $importTemplatesService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $filter = json_decode($request->get('filter', null), true);

        return $this->templateRepository->filter($filter);
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
     * @param int $id
     *
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Template $template
     *
     * @return \App\Models\Template
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function upload(Request $request, Template $template)
    {
        list($uploadedFile, $filename) = $this->storeUploadedFile($request, $template);

        $template->file_path = $filename;
        $template->file_type = $uploadedFile->getClientOriginalExtension();

        $template = $this->templateRepository->save($template->fill($request->all()));

        return $template;
    }

    /**
     * @param Template $template
     * @return Template
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function processUploadedFile(Template $template)
    {
        return $this->importTemplatesService->process($template);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Template $template
     *
     * @return array
     */
    private function storeUploadedFile(Request $request, Template $template): array
    {
        $uploadedFile = $request->file('file');

        $filename = $template->id . "_import_table." . $uploadedFile->getClientOriginalExtension();

        $disk = Storage::disk('imports_templates');

        if ($disk->exists($template->file_path)) {
            $disk->deleteDirectory($template->file_path);
        }

        $disk->putFileAs($template->id, $uploadedFile, $filename);

        return [$uploadedFile, $filename];
    }

}
