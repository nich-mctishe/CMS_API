portfolio.service('ajaxService', ['$http', function($http) {
    var baseUrl = 'http://localhost/api/';
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
            data.url = baseUrl + data.url;
            data = buildPostData(data);

            return $http(data).then(function(result) {
                return result;
            });
        },
        get: function(data) {
            data = baseUrl + data;

            return $http.get(data).then(function(result) {
                return result;
            });
        },
        delete: function(data) {
            data = baseUrl + data;

            return $http.delete(data).then(function(result) {
               return result;
            });
        },
        update: function(data) {
            data.url = baseUrl + data.url + '/update/' + data.data.id;
            data = buildPostData(data);

            return $http(data).then(function(result) {
                return result;
            });
        }
    }
}]);
