<?php

namespace Portfolio\Services;

use Portfolio\Models\Image;
use Flow\Config as FlowConfig;
use Flow\Request as FlowRequest;
use Flow\ConfigInterface;
use Flow\RequestInterface;
use Flow\Basic;

class ApiFileService {
    /**
     * @var string
     */
    protected $directory;
    /**
     * @var string
     */
    protected $parentId;
    /**
     * @var string
     */
    protected $location;
    /**
     * @var string
     */
    protected $parentSection;
    /**
     * Constructor
     *
     * @param $parentSection
     * @param $parentId
     */
    public function __construct($parentSection, $parentId)
    {
        $this->directory = $_SERVER['DOCUMENT_ROOT'];
        $this->location = '/assets/uploadedImages/'.$parentSection.'/';
        $this->parentId = $parentId;
        $this->parentSection = $parentSection;
    }

    /**
     * Handle Images
     *
     * @param $id
     * @throws Exception
     * @throws \Exception
     * @return ApiFileService
     */
    public function handleImages($id)
    {
        if ($id != null) {
            $this->handleImageDelete($id);
        }

        return $this->handleImageUpload();
    }

    /**
     * Handle Image Upload
     *
     * @throws \Exception
     *
     * @return ApiFileService
     */
    private function handleImageUpload()
    {
        try {
            $config = new FlowConfig();
            $request = new FlowRequest();
            $basic = new Basic();

            $config->setTempDir(storage_path() . '/tmp');
            $config->setDeleteChunksOnSave(false);
            $totalSize = $request->getTotalSize();
            $uploadFile = $request->getFile();
            $fileName = md5($request->getFileName());
            $extension = explode('.', $request->getFileName())[1];
            $extraNumber = 1;

            if ($totalSize && $totalSize > (1024 * 1024 * 4))
            {
                throw new \Exception('File size exceeds 4MB', 400);
            }

            while ($this->isNameDuplicated($fileName.'.'.$extension, $this->location)) {
                $fileName = $fileName.$extraNumber;
                ++$extraNumber;
            }

            $fileName = $fileName.'.'.$extension;
            if ($basic->save($this->directory.$this->location.$fileName, $config, $request)) {
                $file = $this->handleImageSave($fileName, $this->location);
            }

            return $file;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Handle image Save
     *
     * @param $fileName
     * @param $path
     * @return static
     */
    private function handleImageSave($fileName, $path)
    {
        //['fileName', 'folderLocation', 'parentId', 'parentSection', 'local']
        $image = new Image();
        return $image->create([
            'folderLocation' => $path,
            'parentSection' => $this->parentSection,
            'parentId' => $this->parentId,
            'fileName' => $fileName,
            'local' => true,
        ]);
    }

    /**
     * Handle Image Delete
     *
     * @param $id
     * @throws Exception
     * @throws \Exception
     */
    private function handleImageDelete($id)
    {
        $image = new Image();
        $file = new File();
        try {
            $image->findOrFail($id);
            if ($image->local) {
                $file->delete($image->folderLocation.$image->fileName);
            }
            $image->delete();
        } catch (Exception $e) {
            if (gettype($e->getCode()) == 'string' || $e->getCode() == 0) {
                throw new \Exception($e->getMessage(), 400);
            }
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Is Name Duplicated
     *
     * @param $fileName
     * @param $path
     *
     * @return bool
     */
    private function isNameDuplicated($fileName, $path)
    {
        try {
            $directoryFileList = scandir($this->directory.$path);
            if (array_search($fileName, $directoryFileList) == false) {
                return false;
            }
        } catch (Exception $e) {
            die($e);
        }

        return true;
    }
}
