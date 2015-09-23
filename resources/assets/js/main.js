var portfolio = angular.module('portfolio', ['ui.router', 'ngSanitize']);

portfolio.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){

    var baseUrl = 'http://localhost/route-master/';

    $urlRouterProvider.otherwise('/');
    $stateProvider.state('/', {
        url: '/',
        templateUrl: baseUrl + 'about'
    }).state('projects', {
        url: '/projects',
        controller: 'ProjectsController',
        templateUrl: baseUrl + 'skills'
    }).state('projlets', {
        url: '/projlets',
        controller: 'ProjectsController',
        templateUrl: baseUrl + 'skills'
    }).state('skills', {
        url: '/skills',
        controller: 'SkillController',
        templateUrl: baseUrl + 'skills'
    }).state('work-experience', {
        url: '/work-experience',
        controller: 'WorkController',
        templateUrl: baseUrl + 'skills'
    }).state('contact', {
        url: '/contact',
        controller: 'ContactController',
        templateUrl: baseUrl + 'skills'
    });

}]);