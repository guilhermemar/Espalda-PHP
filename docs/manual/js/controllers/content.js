window.app.controller('controllerContent', function controllerContent ($scope, $rootScope, loadContent) {
	
	$scope.allContent = [];
	
	$rootScope.$watch('loadContent', function(newContent) {
		
		if (newContent) {
			
			loadContent(newContent, function (data) {
				$scope.allContent = data;
				
			});
			
			
		}
	});
	
});

window.app.controller('controllerLoadGist', function controllerLoadGist ($scope, $element) {
	
	//console.log($element);
	//console.log($scope);
	
	$scope.init = function (b) { console.log(b)};

	
	//var s = document.createElement('script');
	
	//$element.append(s);
	//$element.context.innerHTML = 'bla bla bla';
	
	//console.log($element.context.attributes.someting.textContent);
	//return;
});