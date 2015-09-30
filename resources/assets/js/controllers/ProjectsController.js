portfolio.controller('ProjectsController', ['$scope', 'ajaxService', 'formatService',
    function($scope, ajaxService, formatService)
{
    //obj | array
    $scope.projects = [];
    $scope.skills = [];
    $scope.files = {
        'projectId': '',
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
        if (data.images && Object.keys(data.images).length >= 0) {
            $scope.files.images = data.images;
            delete data.images;
        }
        if (data.skillTags && data.skillTags.length <= 0) {
            delete data.skillTags;
        } else {
            angular.forEach(data.skillTags, function(value, key) {
                data.skillTags[key] = {
                    'skillId' : value
                }
            });
        }
        data = formatService.formatAjaxDataObject(category, data);
        ajaxService.post(data).then(function(returnedData) {
            if (Object.keys(returnedData.data).length > 0 && returnedData.status == 200) {
               $scope.files.url = formatService.singularise(category) + '/images';
               $scope.files.projectId = returnedData.data.id;
                    $scope.saveImages($scope.files);
                    $scope.resetForm(form);
            }
        });
    };

    $scope.saveImages = function(obToSave)
    {
        console.log('loading images...');
        ajaxService.postImages(obToSave);
    };

    $scope.deleteImage = function(parentId, imageId, index, imageNo)
    {
        data = formatService.singularise($scope.category) + '/images/' + parentId + '/' + imageId;
        ajaxService.delete(data).then(function(returnedData) {
            if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                $scope.projects[index].images[imageNo] = returnedData.data;
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
        if (sentData.images) {
            delete sentData.images;
        }
        angular.forEach(data.skillTags, function(value, key) {
            data.skillTags[key] = {
                'skillId' : value
            };
            data.skillTags[key][category+'Id'] = sentData.id;
        });
        
        console.log(sentData);
        console.log($scope.projects[index]);
        var data = {
            'url': category,
            data: sentData
        };

        ajaxService.update(data).then(function(returnedData) {
            if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                $scope.resetForm(form);
                instance.editProjectSelected = false;
            }
        });
    };

    $scope.$on('flow::filesSubmitted', function (event, $flow, flowFile) {
        $scope.projects = [];
        $scope.getProjects();
        $scope.resetFileObject();
        $scope.projectData = {};
        $scope.newProject = false;
    });

    $scope.$watch($scope.isEditable, function()
    {
        if ($scope.skills.length <= 0) {
            var data = 'skill';
            ajaxService.get(data).then(function(returnedData) {
                if (returnedData.data.length > 0 && returnedData.status == 200) {
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
          'projectId': '',
            images: []
        };
    };
}]);
