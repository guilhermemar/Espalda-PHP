window.app.controller('controllerMenu', function controllerMenu ($scope, $rootScope, loadContent ) {
	
	$scope.loadNewContent = function loadNewContent (content) {	
		$rootScope.loadContent = content;
	}
	
	loadContent('menu', function(data){
		
		$scope.menu = data;
		console.log(data);
		$scope.loadNewContent(data[0].itens[0].content);
		
	});
	
});