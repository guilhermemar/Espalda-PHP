window.app = angular.module('documentation', ['ngRoute']);

window.app.factory('loadContent', function loadContent ($http) {
	
	return function loadContent (content, success) {
		$http.get('content/' + content + '.json').success(success).error(function(){
			success([{type : 'title', content : 'There is a problem. Sorry!'}]);
		});
	}
	
});