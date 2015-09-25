portfolio.controller('ProjectsController', ['$scope', 'Upload', 'ajaxService', 'formatService',
    function($scope, Upload, ajaxService, formatService)
{
    $scope.projects = [];
    $scope.skills = [];

    $scope.newProjectData = {};


    //bool
    $scope.isEditable = false; //watch to see if editable to fetch more data or not.
    $scope.newProject = false;

    $scope.save = function(form, category, data)
    {
        console.log($scope.newProjectData.mainImage);
        if (form.mainImage && form.mainImage.$valid && $scope.file && !$scope.file.$error) {
            console.log($scope.file);
        }
        if (form.secondImage && form.secondImage.$valid && $scope.file && !$scope.file.$error) {
            console.log($scope.file);
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

        console.log(data);
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
}]);
