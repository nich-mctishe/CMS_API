portfolio.controller('SkillController', ['$scope', '$http', 'dataService','ajaxService',
    function($scope, $http, dataService, ajaxService)
{
    $scope.skillCategory = [];
    $scope.currentCategoryNames = [];
    $scope.newSkill = false;
    $scope.newCategory = false;
    $scope.category = {};
    $scope.skillData = {};
    $scope.updateSkillData = {};
    $scope.updateSkillSelected = false;
    $scope.updateCategorySelected = false;

    var skillUrl = 'skill';
    var catUrl = 'skillCategory';

    $scope.save = function(form, category, newData, parentIndex, watch)
    {
        switch (category) {
            case 'skill':
                var url = skillUrl;
                newData.category = $scope.skillCategory[parentIndex].name;
                break;
            case 'skillCategory':
                var url = catUrl;
                break;
        }
        var data = {
            url: url,
            data: newData
        };

        ajaxService.post(data).then(function(returnedData) {
            if (returnedData.status == 200) {
                switch (category) {
                    case 'skill':
                        watch.newSkill = false;
                        $scope.skillCategory[parentIndex].skills.push(returnedData.data);
                        $scope.skillData = {};
                        break;
                    case 'skillCategory':
                        $scope.newCategory = false;
                        $scope.skillCategory.push(returnedData.data);
                        $scope.currentCategoryNames.push(returnedData.data.name);
                        $scope.category = {};
                        break;
                }
                form.$setPristine();
                form.$setUntouched();
                form.$rollbackViewValue();
            } else {
                alert('something went wrong, failed with code: '+returnedData.status);
            }
        });
    };

    $scope.delete = function(category, key, id, parentIndex)
    {
        if (category == 'skill') {
            var url = skillUrl;
        } else {
            var url = catUrl;
        }

        ajaxService.delete(url + '/' + id).then(function(returnedData) {
           if (returnedData.status == 200) {
                if (category == 'skill') {
                   $scope.skillCategory[parentIndex].skills.splice(key, 1);
                } else if(category == 'skillCategory') {
                    $scope.skillCategory.splice(key, 1);
                    $scope.currentCategoryNames.splice(key, 1);
                }
           } else {
               alert('something went wrong, failed with code: '+returnedData.status);
           }
        });
    };

    $scope.update = function(category, instance, data)
    {
        if (category == 'skill') {
            var url = skillUrl;
        } else {
            var url = catUrl;
        }

        var data = {
            'url' : url,
            'data': data
        };

        ajaxService.update(data).then(function(returnedData) {
            if (returnedData.status == 200 && returnedData.data.length > 0) {
                switch (category) {
                    case 'skill':
                        $scope.skillCategory[instance.$parent.$index].skills[instance.$index] = returnedData.data;
                        instance.updateSkillSelected = false;
                        instance.updateSkillDataForm.$setPristine();
                        instance.updateSkillDataForm.$setUntouched();
                        instance.updateSkillDataForm.$rollbackViewValue();
                        break;
                    case 'skillCategory':
                        instance.updateCategorySelected = false;
                        $scope.skillCategory[instance.$index] = returnedData.data;
                        $scope.currentCategoryNames[instance.$index] = returnedData.data.name;
                        $scope.category = {};
                        instance.updateSkillCategoryForm.$setPristine();
                        instance.updateSkillCategoryForm.$setUntouched();
                        instance.updateSkillCategoryForm.$rollbackViewValue();
                        break;
                };
            }
        });
    };

    $scope.getSkills = function()
    {
        ajaxService.get(catUrl).then(function(returnedData) {
            if (returnedData.status == 200 && returnedData.data.length > 0) {
                $scope.skillCategory = returnedData.data;
                $scope.skillCategory.forEach(function(entry){
                    $scope.currentCategoryNames.push(entry.name);
                });
            }
        });
    };

    $scope.getSkills();

}]);
