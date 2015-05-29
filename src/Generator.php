<?php namespace SKAgarwal\Generators;

use Illuminate\Filesystem\Filesystem;

class Generator
{

    /**
     * The Laravel Filesystem.
     *
     * @var Filesystem
     */
    protected $file;

    /**
     * Model Class path.
     *
     * @var string
     */
    protected $modelPath;

    /**
     * Requested Model Name.
     *
     * @var string
     */
    protected $model;

    /**
     * @param Filesystem $file
     */
    public function __construct(Filesystem $file)
    {
        $this->file = $file;
    }


    /**
     * set the properties
     *
     * @param $model
     */
    protected function config($model)
    {
        $this->setModel($model);

        $this->setModelPath("app/{$this->model}");
    }

    /**
     * Set the model.
     *
     * @param string $model
     */
    protected function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Set the model path.
     *
     * @param string $modelPath
     */
    protected function setModelPath($modelPath)
    {
        $this->modelPath = $modelPath;
    }

    /**
     * check if the directory/file exists.
     *
     * @param string $path
     *
     * @return bool
     */
    protected function exists($path)
    {
        return $this->file->exists($path);
    }

    /**
     * Create a directory.
     *
     * @param string $path
     * @param bool   $recursive
     */
    public function makeDirectory($path, $recursive = false)
    {
        if (!$this->exists($path)) {
            return $this->file->makeDirectory($path, 0755, $recursive);
        }
    }

    /**
     * Create a directory for the Requesting Model.
     */
    protected function makeModelDirectory()
    {
        return $this->makeDirectory($this->modelPath);
    }

    /**
     * Create subdirectories under Model Directory
     *
     * @param $subDirectory
     */
    protected function makeSubDirectory($subDirectory)
    {
        $path = "{$this->modelPath}/{$subDirectory}";

        return $this->makeDirectory($path, true);
    }

    /**
     * Get a template.
     *
     * @param $from
     *
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getTemplate($from)
    {
        $templatePath = __DIR__ . "/Templates/{$from}.txt";

        return $this->file->get($templatePath);
    }

}
