portfolio.controller('WorkExperienceController', ['$scope', 'ajaxService', 'formatService',
    function($scope, ajaxService, formatService) {

        $scope.previousExperience = [];
        $scope.clients = [];
        $scope.clientFiles = {
            parentId: '',
            images: []
        };
        $scope.workExperienceFiles = {
            parentId: '',
            images: []
        };

        $scope.editWorkExperienceSelected = false;
        $scope.editClientFormSelected = false;
        $scope.clientFormSelected = false;
        $scope.workExperienceFormSelected = false;

        $scope.uploader = {
            handleImageCall: function(url, parentId)
            {
                var files = [];
                switch (url) {
                    case 'workExperience':
                        files = $scope.workExperienceFiles;
                        break;
                    case 'client':
                        files = $scope.clientFiles;
                        break;
                }

                files.url = url + '/images';
                files.parentId = parentId;
                this.saveImage(files);
            },
            saveImage: function(data)
            {
                ajaxService.postImages(data);
            },
            successCallback: function($flow, $file, $message, category, $index)
            {
                if (category == 'workExperience') {
                    $scope.workExperience.callback($flow, $file, $message, $index);
                } else {
                    $scope.client.callback($flow, $file, $message, $index);
                }
            }
        };

        $scope.client = {
            url: 'client',
            data: {},
            save: function(form)
            {
                var data = formatService.formatAjaxDataObject(this.url, this.data);
                ajaxService.post(data).then(function(returnedData) {
                    if (returnedData.status == 200) {
                        $scope.client.data = returnedData.data;
                        $scope.uploader.handleImageCall($scope.client.url, returnedData.data.id);
                        $scope.private.reset.form(form);
                    }
                });
            },
            remove: function(instance, id, parentId)
            {
                console.log('hjello');
                if (typeof parentId == 'undefined') {
                    var data = this.url + '/' + id;
                }
                if (typeof parentId == 'string' || typeof parentId == 'number') {
                    var data = 'image/' + id;
                }
                console.log(parentId);
                console.log(data);
                console.log(id);
                ajaxService.delete(data).then(function(returnedData) {
                    console.log(returnedData);
                    if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                        if (typeof parentId == 'undefined') {
                            $scope.clients.splice(instance.$index, 1);
                        }
                        if (typeof parentId == 'string' || typeof parentId == 'number') {
                            delete $scope.clients[instance.$index].image;
                        }
                    }
                });
            },
            update: function(index, form, instance)
            {
                var sentData = $scope.clients[index];
                var data = {
                    'url': this.url,
                    data: sentData
                };

                ajaxService.update(data).then(function(returnedData) {
                    if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                        $scope.private.reset.form(form);
                        instance.editClientFormSelected = false;
                    }
                });
            },
            get: function()
            {
                ajaxService.get(this.url).then(function(returnedData) {
                    if (returnedData.status == 200) {
                        $scope.clients = returnedData.data;
                    }
                });
            },
            callback: function($flow, $file, $message, $index)
            {
                if (typeof $index == 'undefined') {
                    this.data.image = JSON.parse($message);
                    $scope.clients.push(this.data);
                }
                this.data = {};
                $scope.clientFiles = $scope.private.reset.fileObject();
                $scope.clientFormSelected = false;
            }
        };

        $scope.workExperience = {
            url : 'workExperience',
            data: {},
            save: function(form)
            {
                var data = formatService.formatAjaxDataObject(this.url, this.data);
                ajaxService.post(data).then(function(returnedData) {
                    if (returnedData.status == 200 && Object.keys(returnedData.data).length > 0) {
                        $scope.workExperience.data = returnedData.data;
                        $scope.uploader.handleImageCall($scope.workExperience.url, returnedData.data.id);
                        $scope.private.reset.form(form);
                    }
                });
            },
            remove: function(instance, id, parentId)
            {
                if (typeof parentId == 'undefined') {
                    var data = this.url + '/' + id;
                }
                if (typeof parentId == 'string' || typeof parentId == 'number') {
                    var data = 'image/' + id;
                }
                ajaxService.delete(data).then(function(returnedData) {
                    if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                        if (typeof(parentId) == 'undefined') {
                            $scope.previousExperience.splice(instance.$index, 1);
                        }
                        if (typeof(parentId) == 'string' || typeof parentId == 'number') {
                            console.log($scope.previousExperience[instance.$index]);
                            delete $scope.previousExperience[instance.$index].image;
                        }
                    }
                });
            },
            update: function(index, form, instance)
            {
                var sentData = $scope.previousExperience[index];
                var data = {
                    'url': this.url,
                    data: sentData
                };

                ajaxService.update(data).then(function(returnedData) {
                    if (returnedData.status == 200 && Object.keys(returnedData).length > 0) {
                        $scope.private.reset.form(form);
                        instance.editWorkExperienceSelected = false;
                    }
                });
            },
            get: function()
            {
                ajaxService.get(this.url).then(function(returnedData) {
                    if (returnedData.status == 200) {
                        $scope.previousExperience = returnedData.data;
                        console.log($scope.previousExperience);
                    }
                });
            },
            callback: function($flow, $file, $message, $index)
            {
                if (typeof $index == 'undefined') {
                    this.data.image = JSON.parse($message);
                    $scope.previousExperience.push(this.data);
                }
                this.data = {};
                $scope.workExperienceFiles = $scope.private.reset.fileObject();
                $scope.workExperienceFormSelected = false;
            }
        };

        $scope.private = {
            reset : {
                form: function(form)
                {
                    form.$setPristine();
                    form.$setUntouched();
                    form.$rollbackViewValue();
                },
                fileObject: function()
                {
                    return {
                        parentId: '',
                        images: []
                    };
                }
            }
        };

        $scope.client.get();
        $scope.workExperience.get();
}]);
