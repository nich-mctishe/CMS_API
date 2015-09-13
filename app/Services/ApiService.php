<?php

namespace Portfolio\Services;

use Exception;
use Portfolio\Exceptions\SectionNotValidException;
use Illuminate\Http\Request;


class ApiService
{
    /**
     * @var string
     */
    protected $modelsNamespace;

    /**
     * Constructor
     *
     * @return void
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
                return $model->all();
            }

            return $model->where('id', '=', $id)->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
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
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return 'data saved!'; //maybe place id and db info in here.
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
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $section.' updated!';
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
            $model = $this->setClass($section);
            $model->destroy($id);
        } catch (Exception $e) {
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
        $className = lcfirst(explode("\\", get_class($model))[2]);

        foreach ($request->all() as $key => $value) {
            switch ($key) {
                case $key == 'images':
                    $dependants['images'] = [];
                    foreach ($value as $image) {
                        //upload image
                        $newData = $this->uploadImages();
                        //save to dependants array with the name of the dependant;
                        array_push($dependants['image'], $newData);
                    }
                    break;
                case $key == 'skillTags':
                    //havent decided how to save skill cat data just yet.
                    //save to dependants array with the name of the dependant;
                    $dependants[$key] = $value;
                    break;
                default:
                    if ($key != 'CSRF-TOKEN') {
                        $model->$key = $value;
                    }
                    break;
            }
        }
        $model->save();
        if (count($dependants) > 0) {
            $dependancyIdName = $className.'Id';
            foreach ($dependants as $dependant => $data) {
                foreach($data as $key => $value) {
                    $model->$dependant()->$key = $value;
                }
                $model->$dependant()->$dependancyIdName = $model->id;
                $model->$dependant()->save();
            }
        }

        return $model;
    }

    private function uploadImages()
    {
        //this will need to be sorted out once i am aware of the uploader criteria.

        //might need a model to ensure images dont exist already. or do we just assume all image changes are new.

        //essentually this function needs to upload the images to a new place and then return an array with
        //all the required data to be saved in to the model.

        //also a check will need to be done to find out if the 'image' is actually a link to an external source.
    }
}
