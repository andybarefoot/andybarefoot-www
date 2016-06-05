var andybarefoot = angular.module('andybarefoot', ['wu.masonry']);

andybarefoot.controller('mainController', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {
	$scope.instagramOffset = 0;
	$scope.instagramCount = 6;
	$scope.instagrams = [];
	$scope.showMoreSocial = false;
	$scope.noMoreSocial = false;
	$scope.userNameString = function (userId) {
		if(userId == 1697196773){
			return "Günter | "
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
	$scope.loadMoreSocial = function () {
		$scope.showMoreSocial = false;
		$scope.noMoreSocial = false;
		url = 'http://andybarefoot.sites.dev/api/instagram/allData.php?offset=' + $scope.instagramOffset + '&count=' + $scope.instagramCount;
		$http.get(url)
			.success(function (result){
				console.log(result);
				if(result.nodes.length>0){
					$scope.instagrams.push.apply($scope.instagrams, result.nodes);
					$scope.instagramOffset += $scope.instagramCount;
					$scope.showMoreSocial = true;
					$scope.noMoreSocial = false;
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