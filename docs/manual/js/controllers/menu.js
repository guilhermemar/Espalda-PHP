app.controller('controllerMenu', function ($scope, $http) {
	$http.get('content/menu.js').success(function (data)) {
		$scope.menu = data;
	}
}