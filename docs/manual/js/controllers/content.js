window.app.controller('controllerContent', function controllerContent ($scope, $rootScope, loadContent) {
	
	$scope.allContent = [];
	
	$rootScope.$watch('loadContent', function(newContent) {
		
		if (newContent) {
			
			loadContent(newContent, function (data) {
				
				$scope.allContent = data;
				
			}, function (data) {
				
				console.log('deu pau no loading');
				
			});

		}
	});
	
});