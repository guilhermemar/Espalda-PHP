window.app = angular.module('documentation', []);

window.app.factory('loadContent', function loadContent ($http) {
	
	return function loadContent (content, success, error) {
		$http.get('content/' + content + '.json').success(success).error(error);
	}
	
});
/*
window.app.config(['$routeProvider', function($routeProvider) {
		$routeProvider.
			when('/about', {templateUrl: 'about.html'}).
			when('/outro', {template: 'OUTRO'}).
			otherwise({redirectTo: '/about'});
}]);
*/