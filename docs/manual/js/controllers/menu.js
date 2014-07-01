app.controller('controllerMenu', function controllerMenu ($scope, $http) {
	
	console.log('controller iniciado');
	
	$http.get('content/menu.json').success(function (data) {
		
		console.log('http.get success function');
		
		$scope.menu = data;
	});
});