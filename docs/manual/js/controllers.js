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

window.app.controller('controllerMenu', function controllerMenu ($scope, $rootScope, loadContent ) {
	
	$scope.loadNewContent = function loadNewContent (content) {	
		$rootScope.loadContent = content;
	}
	
	loadContent('menu', function(data){
		
		$scope.menu = data;
		$scope.loadNewContent(data[0].itens[0].content);
		
	});
	
});

window.app.controller('controllerLoadGist', function controllerLoadGist ($scope, $element) {
	setTimeout(function(){
		var s = document.createElement('iframe');
		s.scrolling="no";
		s.src = "loadgist.html?url=" + $element.context.attributes.gistUrl.value + ".js";
		$element.append(s);
	});
});