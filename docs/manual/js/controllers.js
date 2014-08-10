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

window.app.controller('controllerMenu', function controllerMenu ($scope, $rootScope, loadContent) {
	
	$scope.loadNewContent = function loadNewContent (content, url) {
		
		if (window.history) {
			window.history.pushState('Object', 'Espalda ', '#/'+url);
		}
		$rootScope.loadContent = content;
	}
	
	loadContent('menu', function(data){
		$scope.menu = data;
		
		var content = data[0].itens[0].content;
		var url = data[0].itens[0].url;
		
		for(i in data) {
			for(ii in data[i].itens)
			if (document.URL.match(data[i].itens[ii].url)) {
				content = data[i].itens[ii].content;
				url = data[i].itens[ii].url;
				
				break;
			}
		}
		
		$scope.loadNewContent(content, url);
		
		
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