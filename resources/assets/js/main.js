var portfolio = angular.module('portfolio', ['ui.router', 'ngSanitize', 'flow']);
var baseUrl = 'http://localhost/';
portfolio.config(['flowFactoryProvider', function (flowFactoryProvider) {

    var targetUrl = 1; // default value

    flowFactoryProvider.defaults = {
        target: baseUrl + targetUrl,
        testChunks:false,
        singleFile: true,
        permanentErrors: [404, 500, 501],
        maxChunkRetries: 1,
        chunkRetryInterval: 5000,
        simultaneousUploads: 4
    };
    flowFactoryProvider.getTargetUrl = function(){
        return targetUrl;
    };
    flowFactoryProvider.setTargetUrl = function(input){
        flowFactoryProvider.defaults.target = baseUrl + input;
    };
}
]);
portfolio.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){

    var routeUrl = baseUrl + 'route-master/';

    $urlRouterProvider.otherwise('/');
    $stateProvider.state('/', {
        url: '/',
        templateUrl: routeUrl + 'about'
    }).state('projects', {
        url: '/projects',
        controller: 'ProjectsController',
        templateUrl: routeUrl + 'projects'
    }).state('projlets', {
        url: '/projlets',
        controller: 'ProjectsController',
        templateUrl: routeUrl + 'projlets'
    }).state('skills', {
        url: '/skills',
        controller: 'SkillController',
        templateUrl: routeUrl + 'skills'
    }).state('work-experience', {
        url: '/work-experience',
        controller: 'WorkController',
        templateUrl: routeUrl + 'skills'
    }).state('contact', {
        url: '/contact',
        templateUrl: routeUrl + 'contact'
    });
}]);
