var app = angular.module('app', []);

app.config(['$routeProvider', function($routeProvider) {
		$routeProvider.
			when('/about', {templateUrl: 'about.html'}).
			when('/outro', {template: 'OUTRO'}).
			otherwise({redirectTo: '/about'});
}]);

