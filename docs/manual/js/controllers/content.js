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
	setTimeout(function(){
		var s = document.createElement('iframe');
		s.src = "loadgist.html?url=" + $element.context.attributes.gistUrl.value;
		s.onload = function ajustHeight () {
			var b = s.document.body;
			s.height = b.scrollHeight + (b.offsetHeight - b.clientHeight);
		}
		$element.append(s);
	});
});