portfolio.controller('ProjectsController', ['$scope', 'ajaxService', 'formatService',
    function($scope, ajaxService, formatService)
{
    //obj | array
    $scope.projects = [];
    $scope.skills = [];
    $scope.files = {
        'parentId': '',
        'images': []
    };
    $scope.projectData = {};

    //string
    $scope.category;

    //bool
    $scope.isEditable = false; //watch to see if editable to fetch more data or not.
    $scope.newProject = false;
    $scope.editProjectSelected = false;
    $scope.readMoreSelected = false;

    $scope.getProjects = function()
    {
        ajaxService.get(formatService.singularise($scope.category)).then(function(returnedData) {
            if (returnedData.status == 200 && returnedData.data.length > 0) {
                $scope.projects = returnedData.data;
            }
        });
    };

    $scope.save = function(form, category, data)
    {
        if ($scope.files.images) {
            angular.forEach($scope.files.images, function(file, key) {
                if (file.flow.files.length == 0) {
                    delete $scope.files.images[key];
                }
            });
        }
        if (data.skillTags && data.skillTags.length <= 0) {
            delete data.skillTags;
        } else {
            angular.forEach(data.skillTags, function(value, key) {
                if (typeof(value) == 'string') {
                    data.skillTags[key] = {
                        'skillId': value
                    }
                }
            });
        }
        data = formatService.formatAjaxDataObject(category, data);
        ajaxService.post(data).then(function(returnedData) {
            if (Object.keys(returnedData.data).length > 0 && returnedData.status == 200) {
                if (Object.keys($scope.files.images).length > 0) {
                    $scope.files.url = formatService.singularise(category) + '/images';
                    $scope.files.parentId = returnedData.data.id;
                    $scope.saveImages($scope.files);
                    $scope.resetForm(form);
                } else {
                    $scope.uploader.renderResult();
                }
            }
        });
    };

    $scope.saveImages = function(obToSave)
    {
        ajaxService.postImages(obToSave);
    };

    $scope.deleteImage = function(imageId, index, imageNo)
    {
        var data = 'image/' + imageId;
        ajaxService.delete(data).then(function(returnedData) {
            if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                $scope.projects[index].images.splice(imageNo, 1);
                $scope.resetFileObject();
            }
        });
    };

    $scope.delete = function(index, parentId)
    {
        data = formatService.singularise($scope.category) + '/' + parentId;
        ajaxService.delete(data).then(function(returnedData) {
            if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                $scope.projects.splice(index, 1);
            }
        });
    };

    $scope.update = function(index, form, instance)
    {
        var category = formatService.singularise($scope.category);
        var sentData = $scope.projects[index];

        angular.forEach(sentData.skillTags, function(skillTag, key) {
            var skillId = skillTag.id;
            sentData.skillTags[key] = {
                'skillId' : skillId
            };
            sentData.skillTags[key][category+'Id'] = sentData.id;
        });

        var data = {
            'url': category,
            data: sentData
        };

        ajaxService.update(data).then(function(returnedData) {
            if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                ajaxService.get(category + '/' + returnedData.data.id).then(function(result) {
                    if (result.status == 200 && Object.keys(result).length > 0) {
                        if (result.data.skillTags) {
                            $scope.projects[index].skillTags = result.data.skillTags;
                        }
                        $scope.resetForm(form);
                        instance.editProjectSelected = false;
                    }
                });
            }
        });
    };

    $scope.uploader = {
        controllerFn: function ($flow, $file, $message) {
            if (!$scope.projectData.images) {
                $scope.projectData.images = [];
            }
            $scope.projectData.images.push(JSON.parse($message));
            this.renderResult();
        },
        handleImageCallback: function($flow, $file, $message, $index, imageNo)
        {
            if (!$scope.projects[$index].images) {
                $scope.projects[$index].images = [];
            }
            $scope.projects[$index].images[imageNo] = JSON.parse($message);
        },
        renderResult: function() {
            $scope.projects.push($scope.projectData);
            $scope.resetFileObject();
            $scope.projectData = {};
            $scope.newProject = false;
        }
    };

    $scope.$watch($scope.isEditable, function()
    {
        if ($scope.skills.length <= 0) {
            var data = 'skill';
            ajaxService.get(data).then(function(returnedData) {
                if (returnedData.data.length > 0 && returnedData.status == 200) {
                    for(var i = 0; i < returnedData.data.length; i++) {
                        returnedData.data[i].skillId = returnedData.data[i].id;
                    }
                    $scope.skills = returnedData.data;
                }
            });
        }
    });

    $scope.$watch($scope.category, function(){
        $scope.getProjects();
    });

    $scope.resetForm = function(form)
    {
        form.$setPristine();
        form.$setUntouched();
        form.$rollbackViewValue();
    };

    $scope.resetFileObject = function()
    {
        $scope.files = {
          'parentId': '',
            images: []
        };
    };
}]);
