'use strict';

var app = angular.module('Historia',['ngRoute','ngAnimate','textAngular']);


app.config(['$routeProvider',function($routeProvider) {
	
	$routeProvider.when('/', {
		templateUrl: 'partials/home.html',
		controller: 'HomeCtrl'
	});
	$routeProvider.when('/titulos', {
		templateUrl: 'partials/titulos.html',
		controller: 'titulosCtrl'
	});
	$routeProvider.when('/titulo/:item', {
		templateUrl: 'partials/titulo.html',
		controller: 'tituloCtrl'
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
    $scope.pageClass='ng-enter';
}]);
app.factory('EventoService',  function(){
	var evento={};

	return {
		set:function(obj){evento=obj;},
		get:function(){return evento;}
	};
});
app.controller('titulosCtrl', ['$scope','$http','EventoService', 
	function($scope,$http,EventoService){
		"use strict";
		$scope.min=1;
		$scope.pageClass='ng-enter';
	    $scope.url = 'callHandlerMVC.php';
	    $scope.items = [];
	    $scope.limit=200;
	    $scope.idFilter = function (item) {
	        return item.IdEvento >= $scope.min;
	    };
	    $scope.fetchitems = function() {
	        $http.post($scope.url, {
                data:'',
                Controlador:'Evento',
                Accion:'getEventos'
            }).then(function(result){
	            $scope.items = result.data;
	            $scope.items.push({"IdEvento":"0","EventoP":"","Nombre":"Nuevo","Detalle":"...","DiaI":"","MesI":"","AnioI":"2000","DiaF":"","MesF":"","AnioF":"","Tags":[]});
	        });
	    };
	    $scope.sendEvento=function(myobj){
	    	EventoService.set(myobj);
	    };
	    $scope.setTags=function(){
	    	//console.log($scope.items);
	    };
	    $scope.save=function(item){
	    	item.Tags=item.Tags.split(',');
	    	$http.post($scope.url, {
                data:item,
                Controlador:'Evento',
                Accion:'guardaEvento'
            }).then(function(result){
	            $scope.message = result.data;
	            alert($scope.message);
	        });
	    };
	    /**Actualizacion de combo*/
	    $scope.update = function() {
			console.log($scope.item.IdEvento, $scope.item.Nombre)
		};
	    $scope.fetchitems();
}]);

app.controller('tituloCtrl', ['$scope','EventoService',
	function($scope,EventoService){
		"use strict";
	    $scope.item = EventoService.get();
	    $scope.pageClass='ng-enter';
}]);