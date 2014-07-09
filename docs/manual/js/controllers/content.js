window.app.controller('controllerContent', function controllerContent ($scope, $rootScope, loadContent) {
	
	$scope.allContent = [];
	
	$rootScope.$watch('loadContent', function(newContent) {
		
		if (newContent) {
			
			loadContent(newContent, function (data) {
				console.log(data);
				$scope.allContent = data;
				
			});

		}
	});
	
});