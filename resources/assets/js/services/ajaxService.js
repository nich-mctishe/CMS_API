portfolio.service('ajaxService', ['$http', function($http) {
    var apiUrl = baseUrl + 'api/';
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var buildPostData = function(data) {
        data.method = 'POST';
        data.headers = {
            'Content-Type': 'application/json',
            "X-CSRF-TOKEN": CSRF_TOKEN
        };

        return data;
    };

    return {
        post: function(data) {
            data.url = apiUrl + data.url;
            data = buildPostData(data);
            console.log(data);
            return $http(data).then(function(result) {
                return result;
            });
        },
        postImages: function(files) {
            console.log(files);
            var url = apiUrl + files.url + '/' + files.projectId;
            if (files.id) {
                url = url + '/' + files.id;
            }
            angular.forEach(files.images, function(image, key){
                image.flow.opts.target = url;
                image.flow.opts.headers = {
                    "X-CSRF-TOKEN": CSRF_TOKEN
                };
                image.flow.upload();
            });
        },
        get: function(data) {
            data = apiUrl + data;

            return $http.get(data).then(function(result) {
                return result;
            });
        },
        delete: function(data) {
            data = apiUrl + data;

            return $http.delete(data).then(function(result) {
               return result;
            });
        },
        update: function(data) {
            data.url = apiUrl + data.url + '/update/' + data.data.id;
            data = buildPostData(data);

            return $http(data).then(function(result) {
                return result;
            });
        }
    }
}]);
