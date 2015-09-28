portfolio.controller('ProjectsController', ['$scope', 'ajaxService', 'formatService',
    function($scope, ajaxService, formatService)
{
    $scope.projects = [];
    $scope.skills = [];
    $scope.files = {
        'projectId': '',
        'images': []
    };
    $scope.newProjectData = {};


    //bool
    $scope.isEditable = false; //watch to see if editable to fetch more data or not.
    $scope.newProject = false;

    $scope.save = function(form, category, data)
    {
        console.log(data);
        console.log($scope.files.images);
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
        $scope.saveImages($scope.files, category);
        //data = formatService.formatAjaxDataObject(category, data);
        //ajaxService.post(data).then(function(returnedData) {
        //    if (Object.keys(returnedData.data).length > 0 && returnedData.status == 200) {
        //       $scope.files.url = formatService.singularise(category) + '/images';
        //       $scope.files.projectId = returnedData.data.id;
        //            $scope.resetForm(form);
        //
        //    }
        //});
    };

    $scope.saveImages = function(obToSave, category)
    {
        console.log('loading images...');
        obToSave.projectId = 13;
        obToSave.url = formatService.singularise(category) + '/images';
        ajaxService.postImages(obToSave);
    };

    $scope.onFileSuccess = function($data)
    {
        $scope.projects[$data.data.projectId].images = $data.data;
        $scope.resetFileObject();
        $scope.newProjectData = {};
        $scope.newProject = false;
    };

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
    }
}]);
