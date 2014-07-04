window.app.controller('controllerMenu', function controllerMenu ($scope, $http) {
	
	$http.get('content/menu.json').success(function (data) {
		
		$scope.menu = data;
	});
	
});