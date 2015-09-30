portfolio.controller('SkillController', ['$scope', '$http', 'dataService','ajaxService',
    function($scope, $http, dataService, ajaxService)
{
    $scope.skillCategory = [];
    $scope.newSkill = false;
    $scope.newCategory = false;
    $scope.category = {};
    $scope.updateCategory = {};
    $scope.skillData = {};
    $scope.updateSkill = {};
    $scope.updateSkillData = {};
    $scope.updateSkillSelected = false;
    $scope.updateCategorySelected = false;

    var skillUrl = 'skill';
    var catUrl = 'skillCategory';

    $scope.save = function(form, category, newData, parentIndex, watch)
    {
        if (category == 'skill') {
            newData.categoryId = $scope.skillCategory[parentIndex].id;
        }
        var url = $scope.determineUrlRequired(category);
        var data = $scope.setData(url, newData);

        ajaxService.post(data).then(function(returnedData) {
            if (returnedData.status == 200) {
                switch (category) {
                    case 'skill':
                        watch.newSkill = false;
                        if (!$scope.skillCategory[parentIndex].skills) {
                            $scope.skillCategory[parentIndex].skills = [];
                        }
                        $scope.skillCategory[parentIndex].skills.push(returnedData.data);
                        $scope.skillData = {};
                        break;
                    case 'skillCategory':
                        $scope.newCategory = false;
                        $scope.skillCategory.push(returnedData.data);
                        $scope.category = {};
                        break;
                }
                $scope.resetForm(form);
            } else {
                alert('something went wrong, failed with code: '+returnedData.status);
            }
        });
    };

    $scope.delete = function(category, key, id, parentIndex)
    {
        var url = $scope.determineUrlRequired(category);

        ajaxService.delete(url + '/' + id).then(function(returnedData) {
           if (returnedData.status == 200) {
                if (category == 'skill') {
                   $scope.skillCategory[parentIndex].skills.splice(key, 1);
                } else if(category == 'skillCategory') {
                    $scope.skillCategory.splice(key, 1);
                }
           } else {
               alert('something went wrong, failed with code: '+returnedData.status);
           }
        });
    };

    $scope.update = function(category, instance, data)
    {
        if (category == 'skill') {
            data.id = instance.skill.id;
            data.categoryId = instance.$parent.category.id;
        } else if (category == 'skillCategory') {
            data.id = instance.category.id;
        }
        var url = $scope.determineUrlRequired(category);
        var data = $scope.setData(url, data);

        ajaxService.update(data).then(function(returnedData) {
            if (returnedData.status == 200) {
                switch (category) {
                    case 'skill':
                        $scope.skillCategory[instance.$parent.$index].skills[instance.$index] = returnedData.data;
                        instance.updateSkillSelected = false;
                        $scope.updateSkill = {};
                        $scope.resetForm(instance.updateSkillDataForm);
                        break;
                    case 'skillCategory':
                        instance.updateCategorySelected = false;
                        $scope.skillCategory[instance.$index].name = returnedData.data.name;
                        $scope.updateCategory = {};
                        $scope.resetForm(instance.updateSkillCategoryForm);
                        break;
                }
            }
        });
    };

    $scope.formatUpdateForm = function(category, data) {
        if (category == 'skillCategory') {
            data.updateCategory.name = data.category.name;
        } else {
            data.updateSkill.name = data.skill.name;
            data.updateSkill.desc = data.skill.desc;
        }
    };

    $scope.getSkills = function()
    {
        ajaxService.get(catUrl).then(function(returnedData) {
            if (returnedData.status == 200 && returnedData.data.length > 0) {
                $scope.skillCategory = returnedData.data;
            }
        });
    };

    $scope.getSkills();

    $scope.resetForm = function(form)
    {
        form.$setPristine();
        form.$setUntouched();
        form.$rollbackViewValue();
    };

    $scope.setData = function(url, data)
    {
        return {
            'url': url,
            'data': data
        };
    };

    $scope.determineUrlRequired = function(category)
    {
        if (category == 'skill') {
            return skillUrl;
        }

        return catUrl;
    };

}]);
