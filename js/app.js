'use strict';

var app = angular.module('Historia',['ngRoute','filters']);
angular.module('filters', []).
    filter('truncate', function () {
        return function (text, length, end) {
            if (isNaN(length))
                length = 10;

            if (end === undefined)
                end = "...";

            if (text.length <= length || text.length - end.length <= length) {
                return text;
            }
            else {
                return String(text).substring(0, length-end.length) + end;
            }

        };
    });

app.config(['$routeProvider',function($routeProvider) {
	$routeProvider.when('/', {
		templateUrl: 'partials/home.html',
		controller: 'HomeCtrl'
	});
	$routeProvider.when('/titulos', {
		templateUrl: 'partials/titulos.html',
		controller: 'titulosCtrl'
	});
	$routeProvider.when('/RegistroEvento', {
		templateUrl: 'partials/RegistroEvento.html',
		controller: 'titulosCtrl'
	});
	$routeProvider.when('/login', {
		templateUrl: 'partials/login.html',
		controller: 'titulosCtrl'
	});
	$routeProvider.otherwise({redirecTo: '/'});
}]);
app.config(['$httpProvider',function($httpProvider) {
  // Use x-www-form-urlencoded Content-Type
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

  /**
   * The workhorse; converts an object to x-www-form-urlencoded serialization.
   * @param {Object} obj
   * @return {String}
   */ 
  var param = function(obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;
      
    for(name in obj) {
      value = obj[name];
        
      if(value instanceof Array) {
        for(i=0; i<value.length; ++i) {
          subValue = value[i];
          fullSubName = name + '[' + i + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value instanceof Object) {
        for(subName in value) {
          subValue = value[subName];
          fullSubName = name + '[' + subName + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value !== undefined && value !== null)
        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }
      
    return query.length ? query.substr(0, query.length - 1) : query;
  };

  // Override $http service's default transformRequest
  $httpProvider.defaults.transformRequest = [function(data) {
    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
}];
}]);

app.controller('HomeCtrl', ['$scope', function($scope){
    $scope.message = 'Welcome to Inspire';
}]);
app.controller('titulosCtrl', ['$scope','$http', 
	function($scope,$http){
		"use strict";

	    $scope.url = 'callHandlerMVC.php';
	    $scope.items = [];
	     $scope.message = 'Welcome to Inspire';
	    $scope.fetchitems = function() {
	        $http.post($scope.url, {
                data:'',
                Controlador:'Evento',
                Accion:'getEventos'
            }).then(function(result){
	            $scope.items = result.data;
	        });
	    }
	    /**Actualizacion de combo*/
	    $scope.update = function() {
			console.log($scope.item.code, $scope.item.name)
		}
	    $scope.fetchitems();
}]);
