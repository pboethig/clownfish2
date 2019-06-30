<?php

namespace App\Service;

use App\Models\Template;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Class ImportTemplatesService
 *
 * @package App\Service
 */
class ImportTemplatesService
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $disk;

    /**
     * ImportTemplatesService constructor.
     */
    public function __construct()
    {
        $this->disk = Storage::disk('imports_templates');
    }

    /**
     * @param Template $template
     * @param bool $dropExistingData
     * @return Template
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function process(Template $template, $dropExistingData = false)
    {
        $this->createImportTable($template, $this->getColumnsFromImportFile($template), $dropExistingData);

        exec
        (
            $this->buildImportCommand
            (
                $this->createImportScript($template, $this->getInputFile($template))
            )
        );

        $this->disk->delete($this->getSqlImportScriptFile($template));

        return Template::find($template->id);
    }

    /**
     * @param \App\Models\Template $template
     *
     * @return mixed
     */
    private function getInputFile(Template $template)
    {
        return $this->disk->path($template->id . "/" . $template->file_path);
    }

    /**
     * @param Template $template
     * @param $header
     * @param bool $dropExistingData
     */
    private function createImportTable(Template $template, $header, bool $dropExistingData = false): void
    {
        if ($dropExistingData) {
            Schema::dropIfExists($template->import_table);
        }

        try {
            Schema::create(
                $template->import_table,
                function (Blueprint $table) use ($header) {
                    foreach ($header as $column) {
                        $table->text($column)->nullable(true);
                    }
                }
            );
        } catch (\Exception $exception) {
            //ignore table recreation
        }


    }

    /**
     * Get SQL Script, copy it to templatedolder, populate data
     *
     * @param \App\Models\Template $template
     * @param string $inputFile
     *
     * @return string
     */
    private function createImportScript(Template $template, string $inputFile): string
    {
        $sql = strtr(
            file_get_contents(__DIR__ . '/../../database/scripts/importCsv.sql'),
            [
                '{filePath}' => $inputFile,
                '{importTable}' => $this->getDatabaseName() . "." . $template->import_table,
                '{lineEnds}' => '\r',
            ]
        );

        $sqlScriptFile = $this->getSqlImportScriptFile($template);

        $this->disk->put($sqlScriptFile, $sql);

        return $this->disk->path($sqlScriptFile);
    }

    /**
     * @param \App\Models\Template $template
     *
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function getColumnsFromImportFile(Template $template): array
    {
        if ($template->file_type == "csv") {
            $header = fgets(@fopen($this->getInputFile($template), "r"), 4096);

            return explode(",", explode("\r", $header)[0]);
        }

        throw new InvalidFileException("Only Csv with delimeter , and \\r allowed at the moment. Given:" . $template->file_type);
    }

    /**
     * @param $path
     *
     * @return string
     */
    private function buildImportCommand($path): string
    {
        $command = 'mysql -u ' . $this->getDatabaseUserName() . ' -p' . $this->getDatabasePassword() . ' < ' . $path;

        return $command;
    }

    /**
     * @return mixed
     */
    private function getDatabaseName(): string
    {
        $database = Config::get('database.connections.' . Config::get('database.default') . '.database');

        return $database;
    }

    /**
     * @return string
     */
    private function getDatabaseUserName(): string
    {
        $username = Config::get('database.connections.' . Config::get('database.default') . '.username');

        return $username;
    }

    /**
     * @return string
     */
    private function getDatabasePassword(): string
    {
        $password = Config::get('database.connections.' . Config::get('database.default') . '.password');

        return $password;
    }

    /**
     * @param \App\Models\Template $template
     *
     * @return string
     */
    private function getSqlImportScriptFile(Template $template): string
    {
        $sqlScriptFile = $template->id . "/importCsv.sql";

        return $sqlScriptFile;
    }
}