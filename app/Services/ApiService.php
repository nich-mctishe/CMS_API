<?php

namespace Portfolio\Services;

use Exception;
use League\Flysystem\File;
use Portfolio\Exceptions\SectionNotValidException;
use Illuminate\Http\Request;
use Portfolio\Services\ApiFileService;


class ApiService
{
    /**
     * @var string
     */
    protected $modelsNamespace;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelsNamespace = 'Portfolio\\Models\\';
    }

    /**
     * Read
     *
     * @param $section
     * @param $id
     * @throws Exception
     * @throws SectionNotValidException
     *
     * @return mixed
     */
    public function read($section, $id)
    {
        $model = $this->setClass($section);

        try {
            if ($id == null) {
                return $model->withDependencies()->orderBy('id', 'desc')->get();
            }

            return $model->withDependencies()->where('id', '=', $id)->orderBy('id', 'desc')->first();
        } catch (\Exception $e) {
            if (gettype($e->getCode()) == 'string') {
                throw new \Exception($e->getMessage(), 400);
            }
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Write
     *
     * @param $section
     * @param Request $request
     * @throws Exception
     * @throws SectionNotValidException
     *
     * @return string
     */
    public function write($section, Request $request)
    {
        try {
            $validator = new ValidationService();
            $validator->runValidation($section, $request);
            $model = $this->setClass($section);
            $saved = $this->runUploadToDb($model, $request);
        } catch (\Exception $e) {
            if (gettype($e->getCode()) == 'string') {
                throw new \Exception($e->getMessage(), 400);
            }
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return $saved; //maybe place id and db info in here.
    }

    /**
     * Update
     *
     * @param $section
     * @param $id
     * @param Request $request
     * @throws Exception
     *
     * @return string
     */
    public function update($section, $id, Request $request)
    {
        try {
            $validator = new ValidationService();
            $validator->runValidation($section, $request);
            $model = $this->setClass($section);
            $saved = $this->runUploadToDb($model->findOrFail($id), $request);
        } catch (Exception $e) {
            if (gettype($e->getCode()) == 'string') {
                throw new \Exception($e->getMessage(), 400);
            }
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $saved;
    }

    /**
     * Delete
     *
     * @param $section
     * @param $id
     * @throws Exception
     *
     * @return string
     */
    public function delete($section, $id)
    {
        try {
            if ($section == 'image') {
                $fileService = new ApiFileService(null, null);
                $fileService->handleImageDelete($id);
            } else {
                $model = $this->setClass($section);
                $model->findOrFail($id)->delete();
            }
        } catch (Exception $e) {
            if (gettype($e->getCode()) == 'string' || $e->getCode() == 0) {
                throw new \Exception($e->getMessage(), 400);
            }
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $section.' with id '.$id.' deleted';
    }

    /**
     * Set Class
     *
     * @param $section
     * @return mixed
     *
     * @throws SectionNotValidException
     */
    private function setClass($section) {
        $section = ucfirst($section);
        $class = "{$this->modelsNamespace}$section";

        if (class_exists($class)) {
            return new $class();
        }

        throw new SectionNotValidException('The Section is not a valid Section', 404);
    }

    private function runUploadToDb($model, Request $request)
    {
        $dependants = [];
        ($model->id) ? $isForEdit = true : $isForEdit = false;
        $className = lcfirst(explode("\\", get_class($model))[2]);
        foreach ($request->all() as $key => $value) {
            switch ($key) {
                case $key == 'skillTags' || $key == 'skills':
                    $dependants[$key] = $value;
                    break;
                default:
                    if ($key != 'CSRF-TOKEN' && $key != 'id' && $key != '$$hashKey'
                        && $key != 'created_at' && $key != 'updated_at' && $key != 'images' && $key != 'image') {
                        $model->$key = $value;
                    }
                    break;
            }
        }
        $model->save();
        if (count($dependants) > 0) {
            $dependencyIdName = $className.'Id';
            $validator = new ValidationService();
            foreach ($dependants as $dependant => $data) {
                $validator->runValidationFromArray(ucfirst(str_singular($dependant)), $data);
                if ($isForEdit) {
                    $model->$dependant()->delete();
                }
                foreach($data as $parentKey => $insert) {
                    $newDependant = $this->setClass(str_singular(ucfirst($dependant)));
                    foreach ($insert as $key => $value) {
                        if ($key != 'id' && $key != '$$hashKey'
                            && $key != 'created_at' && $key != 'updated_at') {
                            $newDependant->$key = $value;
                        }
                    }
                    $newDependant->$dependencyIdName = $model->id;
                    $model->$dependant()->save($newDependant);
                }
            }
        }

        return $model;
    }
}
