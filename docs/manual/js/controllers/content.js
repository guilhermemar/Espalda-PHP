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
		//alert($element.context.attributes.gistUrl.value);
		var s = document.createElement('script');
		s.src = $element.context.attributes.gistUrl.value;
		//$element.append(s);
		
		console.log($scope);
		
		b = $element.context;
		console.log($element);
		
		b.appendChild(s);
		
		//document.write('<script src="https://gist.github.com/guilhermemar/9a82cb98d787278f3d3d.js"></script>');
		
	}, 500);
		
	//console.log($element);
	//console.log($scope);
	
	//$scope.init = function (b) { console.log(b)};

	
	//var s = document.createElement('script');
	
	//$element.append(s);
	//$element.context.innerHTML = 'bla bla bla';
	
	//console.log($element.context.attributes.someting.textContent);
	//return;
});