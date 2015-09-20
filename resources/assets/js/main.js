var portfolio = angular.module('portfolio', ['ui.router', 'ngSanitize']);

portfolio.config(['$stateProvider', function($stateProvider){

    var baseUrl = 'http://localhost/views/';
    var uri;

    $stateProvider.state(uri, {
        views: {
            'content': {
                templateUrl: baseUrl + 'me'
            }
        }
    });

}]);