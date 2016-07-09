var andybarefoot = angular.module('andybarefoot', []);

andybarefoot.controller('mainController', ['$scope', '$filter', '$http', function ($scope, $filter, $http) {
	$scope.loadMoreSocial = function () {
		url = '/api/instagram/allData.php?offset=' + $scope.instagramOffset + '&count=' + $scope.instagramCount;
		$http.get(url)
			.success(function (result){
				console.log(result);
			})
			.error(function (data,status){
				console.log(data);
			})
	};

	$scope.detectImage = function () {
		
		$scope.imageFile = "images/test01.jpg";
		console.log($scope.imageFile);

       	$http({
            method: "POST",
            data: '{"requests":[{"image":{"source":{"gcsImageUri": "gs://andybarefoot-image-detection/test01.jpg"}},"features":[{"type":"LABEL_DETECTION","maxResults":1}]}]}',
            url: "https://vision.googleapis.com/v1/images:annotate?key=AIzaSyAePBRf0_ur64H8Z0T6HWuHF47RGn7in9A"
        }).success(function (result) {
            console.log("SUCCESS");
            $scope.results = result;
            console.log(result);
        }).error(function (err) {
            console.log("FAIL");
            console.log(err);
        })
	};

	$scope.loadMoreSocial();
	$scope.detectImage();


}]);