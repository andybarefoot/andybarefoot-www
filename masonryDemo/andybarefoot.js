var andybarefoot = angular.module('andybarefoot', ['wu.masonry',]);

andybarefoot.controller('mainController', ['$scope', '$filter', '$http', '$sce', '$timeout', function ($scope, $filter, $http, $sce, $timeout) {
	$scope.instagramPage = 1;
	$scope.instagramOffset = 0;
	$scope.instagramCount = 6;
	$scope.instagrams = [];
	$scope.showMoreSocial = false;
	$scope.noMoreSocial = false;

	$scope.renderHtml = function (htmlCode) {
        return $sce.trustAsHtml(htmlCode);
    };
	
	$scope.facebookPostLink = function (id) {
		parts = id.split('_')
		return "https://www.facebook.com/" + parts[0] + "/posts/" + parts[1]
	};
	$scope.userNameString = function (userId) {
		if(userId == 1697196773){
			return "Gunter | "
		}else if(userId == 1539646){
			return "Andy | "
		}
	};
	$scope.userURLString = function (userId) {
		if(userId == 1697196773){
			return "https://www.instagram.com/gunterguntychops/"
		}else if(userId == 1539646){
			return "https://www.instagram.com/andybarefoot/"
		}
	};
	$scope.getImage = function (file) {
		return "images/instagram/" + file;
	};
	$scope.getVideo = function (file) {
		return "videos/instagram/" + file;
	};

	$scope.loadMoreSocial = function () {
		$scope.showMoreSocial = false;
		$scope.noMoreSocial = false;
		url = 'andybarefoot' + $scope.instagramPage + '.txt';
		$http.get(url)
			.success(function (result){
				console.log(result);
				if(result.nodes.length>0){
					$scope.instagrams.push.apply($scope.instagrams, result.nodes);
					$scope.instagramOffset += $scope.instagramCount;
					$scope.showMoreSocial = true;
// make sure masonry reconfigures layout once new images have loaded
// We need to:
// a) make sure  Angular has rendered new content in DOM
// b) make sure new images are fully loaded
// c) make sure Masonry layout is optimised for new image dimensions
					$container = $("#container");
// Firstly wait until images are rendered in DOM using $timeout 
					$timeout(function(){
// Then use imagesLoaded jQuery plugin to manage when all images are loaded
						$container.imagesLoaded()
// "always" specifies all images must be downloaded or confirmed broken
							.always( function() {
// run masonry layout on social div
								$("#container").masonry();
							})
						;
					})
				}else{
					$scope.showMoreSocial = false;
					$scope.noMoreSocial = true;
				}
			})
			.error(function (data,status){
				console.log(data);
			})
	};


	$scope.loadMoreSocial();

}]);
