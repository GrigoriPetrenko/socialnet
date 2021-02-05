//models
var Constants = {
	regexp: {
		"email": /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
		"username": /^[a-zA-Z]/,
		"password": /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/
		
	},
	apiUrl: 'http://localhost/socialnet/',
	Months: ['January','February','March','April','May','June','Jule','August','September','October','November','December'],
	getYears: function() {
				var date = new Date();
				var y = date.getFullYear();
				yearsList = [];
				for(var i = 1920; i<=y-14; i++) {
					yearsList.push(i);
				}
				return yearsList;
			}
	
}

//app
var app = angular.module('app', ['ui.router']);

app.config(['$stateProvider','$urlRouterProvider', '$locationProvider', function($stateProvider,$urlRouterProvider,$locationProvider) {
	
	$locationProvider.html5Mode(true).hashPrefix('!');
	
	$urlRouterProvider.otherwise("/");
	
	$urlRouterProvider.when('/account', '/account/info');
	
	$stateProvider.state('base', {
		url: '',
		views: {
			'': {
                templateUrl: '../templates/layout.tmpl.html'
			},
			'header@base': {
				templateUrl: '../templates/header.tmpl.html',
				controller: 'headerCtrl'
			},
			'footer@base': {
				templateUrl: '../templates/footer.tmpl.html'
			}
		}
	})
	.state('main', {
		url: '^/',
		parent: 'base',
		templateUrl: '../templates/registration.tmpl.html',
		controller: 'signupCtrl'
	})
	.state('feed', {
		url: '^/feed',
		parent: 'base',
		templateUrl: '../templates/main.tmpl.html',
		controller: 'mainCtrl'
	})
	.state('search', {
		url: '^/search',
		parent: 'base',
		templateUrl: '../templates/search.tmpl.html',
		controller: 'searchCtrl'
	})
	.state('message', {
		url: '^/im?sel',
		parent: 'base',
		templateUrl: '../templates/messenger.tmpl.html',
		controller: 'messengerCtrl'
	})
	.state('gifts', {
		url: '^/gifts?to',
		parent: 'base',
		templateUrl: '../templates/gifts.tmpl.html',
		controller: 'giftsCtrl'
	})
	.state('account', {
		url: '^/account',
		parent: 'base',
		templateUrl: '../templates/account.tmpl.html',
		controller: 'accountCtrl'
	})
	.state('account.edit', {
		url: '/edit',
		templateUrl: '../templates/account-edit.tmpl.html',
		controller: 'accountEditCtrl'
	})
	.state('account.info', {
		url: '/info/:userId',
		templateUrl: '../templates/account-info.tmpl.html',
		controller: 'accountInfoCtrl'
	})
	.state('account.friends', {
		url: '/friends/:userId',
		templateUrl: '../templates/account-friends.tmpl.html',
		controller: 'accountFriendsCtrl'
	})
	.state('account.photos', {
		url: '/photos/:userId',
		templateUrl: '../templates/account-photos.tmpl.html',
		controller: 'accountPhotosCtrl'
	})
 }]);
 
app.factory('localStorageService', ['$http', function($http) {
	return {
		set: function(key,value) {
			return sessionStorage.setItem(key,value);
		},
		get: function(key) {
			return sessionStorage.getItem(key);
		},
		destroy: function(key) {
			$http.post('http://localhost/socialnet/sessionDestroy.php');
			return sessionStorage.removeItem(key);
		}
	}
}]);

app.factory('loginService', ['$http', '$state', '$rootScope', 'localStorageService', function($http, $state, $rootScope, localStorageService) {
	return {
		login: function(data) {
			var $promise = $http.post('http://localhost/socialnet/userLogin.php', data);
			$promise.then(function(msg) {
				var id = msg.data;
				if(msg.data) {
					localStorageService.set('user',id);
					$rootScope.sessionId = id;
					$state.go('feed',{userId: id},{reload:true});
				} else {
					$state.go('main');
				}
			});
		},
		isLogged: function() {
			return $http.get('http://localhost/socialnet/sessionCheck.php');
			//if(localStorageService.get('user')) return true;
		},
		logout: function() {
			var $promise = $http.post('http://localhost/socialnet/userLogOut.php', {'sessionId':$rootScope.sessionId});
			$promise.success(function(response) {
				localStorageService.destroy('user');
				$state.go('main', {reload: 'main'});
				delete $rootScope.sessionId;
			});
		}
	}
}]);
 
app.factory('userInfoService', ['$http','$stateParams','$rootScope', '$state', function($http, $stateParams, $rootScope, $state) {
	return {
		getUser: function() {
			return $http.get('http://localhost/socialnet/getUserById.php?id=' + $stateParams.userId);
		},
		getAllUsers: function() {
			return $http.get('http://localhost/socialnet/getAllUsers.php');
		},
		getRecentRegistered: function() {
			return $http.get('http://localhost/socialnet/getRecentRegistered.php');
		},
		getUserPhotos: function() {
			return $http.get('http://localhost/socialnet/getUserPhotos.php?id=' + $stateParams.userId);
		},
		getUserFriends: function() {
			return $http.get('http://localhost/socialnet/getUserFriends.php?id=' + $stateParams.userId);
		},
		getUserGifts: function() {
			return $http.get('http://localhost/socialnet/getUserGifts.php?id=' + $stateParams.userId);
		},
		getUserWall: function() {
			return $http.get('http://localhost/socialnet/getUserWall.php?id=' + $stateParams.userId);
		},
		getFriendsPosts: function() {
			return $http.get('http://localhost/socialnet/getFriendsPosts.php?id=' + $stateParams.userId);
		},
		getPossibleFriends: function() {
			return $http.get('http://localhost/socialnet/getPossibleFriends.php?id=' + $stateParams.userId);
		},
		searchUsers: function() {
			return $http.get('http://localhost/socialnet/searchUsers.php');
		},
		getOnlineFriends: function() {
			return $http.get('http://localhost/socialnet/getOnlineFriends.php?id=' + $stateParams.userId);
		},
		getFollowers: function() {
			return $http.get('http://localhost/socialnet/getFollowers.php?id=' + $stateParams.userId);
		},
		getFollowersByIgnored: function() {
			return $http.get('http://localhost/socialnet/getFollowersByIgnored.php?id=' + $stateParams.userId);
		},
		sendFriendRequest: function(id) {
			return $http.post('http://localhost/socialnet/sendFriendRequest.php', {'sessionId':$rootScope.sessionId, 'friendId':id});
		},
		userIsFriend: function(id) {
			return $http.post('http://localhost/socialnet/userIsFriend.php', {'sessionId': $rootScope.sessionId,'userId':id});
		},
		goToUser: function(id) {
			$state.go('account.info', {userId: id}, {reload:true});
		}
	}
}]);


app.run(['$rootScope','$state', '$log', 'localStorageService', function($rootScope,$state,$log,localStorageService) {
    $state.transitionTo('main');
	$rootScope.$log = $log;
	$rootScope.$state = $state;
	if(localStorageService.get('user')) {
		$rootScope.sessionId = localStorageService.get('user');
	}
}]);

/*app.run(['$rootScope','$state', function($rootScope,$state) {
	//var permissionState = ['feed'];
	$rootScope.$on('$stateChangeStart', function(){
		//console.log($state.href());
		//if(permissionState.indexOf($state.go()) != -1) {
			//var connected = loginService.isLogged();
			//connected.then(function(msg) {
				//if(!msg.data) $state.go('main');
			//});
			if(!$rootScope.sessionId) $state.go('main');
	});
}]);*/

//directives

app.directive('avatar', function() {
    return {
		restrict: 'A',
        link: function(scope,element,attributes) {
			element.on('load', function() {
				var elem_width = element[0].clientWidth,
					elem_height = element[0].clientHeight;
					
				if(elem_width > elem_height) {
					element.css('height','100%');
				} else {
					element.css('width','100%');
				}
			});
		}
    }
});
app.directive('fileInput', ['$parse', function($parse) {
	return {
		restrict: 'A',
		link: function($scope,element,attributes) {
			element.on('change', function(event) {
				var files = event.target.files;
				//console.log(files[0].name);
				$parse(attributes.fileInput).assign($scope, element[0].files);
				$scope.$apply();
			});
		}
	}
}]);
//controllers
app.controller('headerCtrl', ['$scope','$rootScope','$state','$http','$stateParams','loginService','localStorageService','userInfoService', function($scope,$rootScope,$state,$http,$stateParams,loginService,localStorageService,userInfoService) {
	$scope.userID = $stateParams.userId;
	$scope.apiUrl = Constants.apiUrl;
	
	$scope.getUser = function() {
		var $promise = $http.get('http://localhost/socialnet/getUserById.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.userData = data;
		});
	}
	$scope.getFollowersByIgnored = function() {
		var $promise = $http.get('http://localhost/socialnet/getFollowersByIgnored.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.followers = data;
		});
	}
	$scope.confirmFriendRequest = function(id) {
		var $promise = $http.post('http://localhost/socialnet/confirmFriendRequest.php', {'friendshipID': id});
		$promise.success(function(data) {
			$scope.getFollowersByIgnored();
		});
	}
	$scope.ignoreFriendRequest = function(id) {
		var $promise = $http.post('http://localhost/socialnet/ignoreFriendRequest.php', {'friendshipID': id});
		$promise.success(function(data) {
			$scope.getFollowersByIgnored();
		});
	}
	
	$scope.getUser();
	$scope.getFollowersByIgnored();
	
	$scope.logout = function() {
		loginService.logout();
	}
}]);
app.controller('signupCtrl', ['$scope', '$http', '$state', 'localStorageService','loginService', function($scope,$http,$state,localStorageService,loginService) {
	$scope.user = {};
	$scope.userLog = {};
	$scope.emailPattern = Constants.regexp.email;
	$scope.usernamePattern = Constants.regexp.username;
	$scope.passwordPattern = Constants.regexp.password;
	
	$scope.login = function() {
		loginService.login($scope.userLog);
	}
	
	$scope.register = function() {
		$http.post(
			'http://localhost/socialnet/registration.php',
			{
				'firstname': $scope.user.firstname,
				'surname': $scope.user.surname,
				'email': $scope.user.email,
				'password': $scope.user.pass,
				'rep_password': $scope.user.rep_pass,
				'gender': $scope.user.gender
			}
		)
		.success(function(data) {
			alert(data);
			$scope.user.firstname = null;
			$scope.user.surname = null;
			$scope.user.email = null,
			$scope.user.pass = null,
			$scope.user.rep_pass = null,
			$scope.user.gender = null
		});
	}
}]);
app.controller('messengerCtrl',['$scope','$rootScope', '$stateParams','$state','$http',
	function($scope,$rootScope,$stateParams,$state,$http) {
		$scope.apiUrl = Constants.apiUrl;
		$scope.userID = $stateParams.sel;
		$scope.Message = {};
		$scope.filters = {};
		$scope.getUser = function() {
			var $promise = $http.get('http://localhost/socialnet/getUserById.php?id=' + $scope.userID)
			$promise.success(function(data) {
				$scope.userData = data;
			});
		}
		$scope.getConversation = function(id) {
			var $promise = $http.post('http://localhost/socialnet/getConversation.php', {'sessionId':$rootScope.sessionId, 'userId':id})
			$promise.success(function(data) {
				//alert(data);
				$scope.messages = data;
			});
		}
		$scope.showConversation = function(id) {
			$state.go('message', {sel:id}); //{reload:true}
		}
		$scope.getPenpals = function() {
			var $promise = $http.post('http://localhost/socialnet/getPenpals.php', {'sessionId':$rootScope.sessionId})
			$promise.success(function(data) {
				//alert(data);
				$scope.penpals = data;
			});
		}
		$scope.sendMessage = function() {
			var $promise = $http.post('http://localhost/socialnet/sendMessage.php', {'sessionId':$rootScope.sessionId, 'userId': $scope.userID, 'text': $scope.Message.text})
			$promise.success(function(data) {
				//alert(data);
				$scope.Message.text = null;
				$scope.getConversation($scope.userID);
				$scope.getPenpals();
			});
		}
		$scope.getPenpals();
		$scope.getUser();
		$scope.getConversation($scope.userID);
	}]);
app.controller('giftsCtrl',['$scope','$rootScope', '$stateParams','$state','$http',
	function($scope,$rootScope,$stateParams,$state,$http) {
		$scope.apiUrl = Constants.apiUrl;
		$scope.userID = $stateParams.to;
		$scope.Gift = {}
		$scope.getAllGifts = function() {
			var $promise = $http.get('http://localhost/socialnet/getAllGifts.php')
			$promise.success(function(data) {
				//alert(data);
				$scope.gifts = data;
			});
		}
		$scope.sendGift = function(gift,user) {
			//console.log(gift,user);
			var $promise = $http.post('http://localhost/socialnet/sendGift.php', {'giftId':gift,'userId':user,'sessionId':$rootScope.sessionId})
			$promise.success(function(data) {
				alert(data);
			});
		}
		$scope.getAllGifts();
	}]);
app.controller('mainCtrl', ['loginService', '$scope', '$rootScope', '$http', 'userInfoService', '$stateParams', function(loginService, $scope, $rootScope, $http, userInfoService, $stateParams) {
	$scope.wallPost = {};
	$scope.apiUrl = Constants.apiUrl;
	$scope.filters = {};
	
	$scope.isLogged = function() {
		loginService.isLogged().success(function(response) {
			alert(response);
		});
	}
	$scope.sendFriendRequest = function(id) {
		userInfoService.sendFriendRequest(id).success(function(data) {
			alert(data);
			//$scope.getPossibleFriends();
		});
	}
	$scope.addNewPost = function() {
		$http.post('http://localhost/socialnet/addNewPost.php?id=' + $rootScope.sessionId, {'sessionId': $rootScope.sessionId, 'postText': $scope.wallPost.text})
		.success(function(data) {
			$scope.wallPost.text = null;
		});
	}
	$scope.getUser = function() {
		var $promise = $http.get('http://localhost/socialnet/getUserById.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.userData = data;
		});
	}
	$scope.getOnlineFriends = function() {
		var $promise = $http.get('http://localhost/socialnet/getOnlineFriends.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.onlineFriends = data;
		});
	}
	$scope.getFriendsPosts = function() {
		var $promise = $http.get('http://localhost/socialnet/getFriendsPosts.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.recentPosts = data;
		});
	}
	$scope.likePost = function(postId) {
		var $promise = $http.post('http://localhost/socialnet/likePost.php', {'postId':postId,'sessionId':$rootScope.sessionId});
		$promise.success(function(data) {
			//alert(data);
			$scope.isLiked = true;
			$scope.getFriendsPosts();
		})
	}
	$scope.getPossibleFriends = function() {
		var $promise = $http.get('http://localhost/socialnet/getPossibleFriends.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.possibleFriends = data;
		});
	}
	$scope.getRecentRegistered = function() {
		userInfoService.getRecentRegistered().success(function(data) {
			$scope.recentUsers = data;
		});
	}
	
	$scope.getOnlineFriends();
	$scope.getRecentRegistered();
	$scope.getPossibleFriends();
	$scope.getFriendsPosts();
	$scope.getUser();
}]); 

app.controller('searchCtrl', ['$scope', '$rootScope','userInfoService','$http', function($scope, $rootScope, userInfoService, $http) {
	$scope.search = {};
	$scope.apiUrl = Constants.apiUrl;
	
	$scope.getUser = function() {
		var $promise = $http.get('http://localhost/socialnet/getUserById.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.userData = data;
		});
	}
	$scope.getOnlineFriends = function() {
		var $promise = $http.get('http://localhost/socialnet/getOnlineFriends.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.onlineFriends = data;
		});
	}
	$scope.getAllUsers = function() {
		userInfoService.getAllUsers().success(function(data) {
			$scope.resultUsers = data;
		});
	}
	$scope.searchUsers = function() {
		$http.post(
			'http://localhost/socialnet/searchUsers.php',
			{
				'searchQuery': $scope.search.query
			}
		)
		.success(function(data) {
			$scope.resultUsers = data;
		});
	}
	
	$scope.getAllUsers();
	$scope.getUser();
	$scope.getOnlineFriends();

}]); 

app.controller('accountCtrl', ['$scope','$rootScope', 'userInfoService','$http','$state', '$stateParams', function($scope, $rootScope, userInfoService, $http, $state,$stateParams) {
	$scope.ratingLimit = 100; 
	$scope.wallPost = {};
	$scope.months = Constants.Months;
	$scope.userID = $stateParams.userId;
	$scope.apiUrl = Constants.apiUrl;
	$scope.filters = {};
	
	$rootScope.goToUser = function(id) {
		userInfoService.goToUser(id);
	}
	$scope.showConversation = function(id) {
		$state.go('message', {sel:id}); //{reload:true}
	}
	$scope.showGifts = function(id) {
		$state.go('gifts', {to:id}); //{reload:true}
	}
	$scope.userIsFriend = function(id) {
		userInfoService.userIsFriend(id).success(function(data) {
			$scope.isFriend = data;
		});
	}
	
	$scope.userIsFriend($scope.userID);
	
	$scope.sendFriendRequest = function(id) {
		userInfoService.sendFriendRequest(id).success(function(data) {
			alert(data);
		});
	}
	
	$scope.getUser = function() {
		userInfoService.getUser().success(function(data) {
			$scope.userData = data;
			if($scope.userData.user_birthday != null) {
				$scope.birthDate = $scope.userData.user_birthday.split('-');
				$scope.userBirthday = {
					year: parseInt($scope.birthDate[0]),
					day: $scope.birthDate[2],
					month: $scope.months[parseInt($scope.birthDate[1] - 1)]
				};
			} else {
				$scope.userBirthday = {
					year: 1920,
					day: '01',
					month: $scope.months[0]
				};
			}
		});
	}
	$scope.getUserFriends = function() {
		userInfoService.getUserFriends().success(function(data) {
			$scope.userFriends = data;
		});
	}
	$scope.getUserGifts = function() {
		userInfoService.getUserGifts().success(function(data) {
			$scope.userGifts = data;
		});		
	}
	$scope.getOnlineFriends = function() {
		userInfoService.getOnlineFriends().success(function(data) {
			$scope.onlineFriends = data;
		});
	}
	$scope.getFollowers = function() {
		userInfoService.getFollowers().success(function(data) {
			$scope.followers = data;
		});
	}
	$scope.getUserPhotos = function() {
		userInfoService.getUserPhotos().success(function(data) {
			$scope.userPhotos = data;
		});
	}
	$scope.getUserWall = function() {
		userInfoService.getUserWall().success(function(data) {
			$scope.userWall = data;
		});
	}
	$scope.likePost = function(postId) {
		var $promise = $http.post('http://localhost/socialnet/likePost.php', {'postId':postId,'sessionId':$rootScope.sessionId});
		$promise.success(function(data) {
			//alert(data);
			$scope.isLiked = true;
			$scope.getUserWall();
		})
	}			
	$scope.addNewPost = function() {
		$http.post('http://localhost/socialnet/addNewPost.php?id=' + $stateParams.userId, {'sessionId':$rootScope.sessionId, 'postText': $scope.wallPost.text})
		.success(function(data) {
			$scope.wallPost.text = null;
			$scope.getUserWall();
		});
	}
	
	$scope.deletePost = function(id) {
		var $promise = $http.post('http://localhost/socialnet/deletePost.php', {'postID': id});
		$promise.success(function(data) {
			$scope.getUserWall();
		});
	}
	
	$scope.deleteFriend = function(id) {
		confirm("Are you sure?");
		var $promise = $http.post('http://localhost/socialnet/deleteFriend.php', {'sessionId':$rootScope.sessionId, 'friendshipID': id});
		$promise.success(function(data) {
			$scope.getUserFriends();
			$scope.getOnlineFriends();
			$scope.getFollowers();
			$scope.userIsFriend($scope.userID);
		});
	}
					
	$scope.confirmFriendRequest = function(id) {
		var $promise = $http.post('http://localhost/socialnet/confirmFriendRequest.php', {'friendshipID': id});
		$promise.success(function(data) {
			$scope.getUserFriends();
			$scope.getOnlineFriends();
			$scope.getFollowers();
		});
	}
	
	$scope.setTab = function(tab) {
		$scope.currentTab = tab;
		return $scope.currentTab;
	}

	$scope.getUser();
	$scope.getUserGifts();
	$scope.getUserFriends();
	$scope.getOnlineFriends();
	$scope.getFollowers();
	$scope.getUserWall();
	$scope.getUserPhotos();
}]);

app.controller('accountInfoCtrl', ['$scope','userInfoService','$http', function($scope,userInfoService,$http) {
	$scope.currentTab = 1;
	$scope.setTab = function(tab) {
		$scope.currentTab = tab;
		return $scope.currentTab;
	}
}]);

app.controller('accountPhotosCtrl', ['$scope','$http','$rootScope', function($scope,$http,$rootScope) {
	$scope.uploadPhoto = function() {
		var form_data = new FormData();
		form_data.append('sessionId',$rootScope.sessionId);
		angular.forEach($scope.files, function(file) {
			form_data.append('file',file);
			console.log(file);
		});
		$http.post('http://localhost/socialnet/addPhoto.php', form_data, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined, 'Process-Data': false}
		}).success(function(data) {
			//alert(data);
			$scope.getUserPhotos();
			angular.element(document.querySelector('#user-photo')).val(null);
		})
	}
	$scope.deletePhoto = function(id) {
		$http.post('http://localhost/socialnet/deletePhoto.php', {'sessionId':$rootScope.sessionId, 'photoID': id})
		.success(function(data) {
			$scope.getUserPhotos();
		})
	}
}]);

app.controller('accountFriendsCtrl', ['$scope', 'userInfoService', function($scope, userInfoService) {
	$scope.currentTab = 1;
	$scope.setTab = function(tab) {
		$scope.currentTab = tab;
		return $scope.currentTab;
	}
}]);

app.controller('accountEditCtrl', ['$scope','$http', '$rootScope', '$stateParams', function($scope,$http, $rootScope, $stateParams) {
	$scope.currentTab = 1;
	$scope.years = Constants.getYears();
	$scope.months = Constants.Months;
	$scope.userGender = {
		type: "Male"
	};
	$scope.avatar = {};
	
	$scope.getUser = function() {
		var $promise = $http.get('http://localhost/socialnet/getUserById.php?id=' + $rootScope.sessionId)
		$promise.success(function(data) {
			$scope.userData = data;
		});
	}
	
	$scope.formateDate = function(day,month,year,type) {
		var monthNum;
		for(var i = 0; i < $scope.months.length; i++) {
			if($scope.months[i] == month) {
				if(i+1 < 10) monthNum = '0'+(i+1)
				else monthNum = i+1;
			}
		}
		return year + type + monthNum + type + day;
	}
	
	$scope.getCountries = function() {
		var $promise = $http.get('http://localhost/socialnet/getCountries.php');
		$promise.success(function(data) {
			$scope.countries = data;
		});
	}
	
	$scope.getRelationshipTypes = function() {
		var $promise = $http.get('http://localhost/socialnet/getRelationshipTypes.php');
		$promise.success(function(data) {
			$scope.relationships = data;
		});
	}
	
	$scope.getCountries();
	$scope.getRelationshipTypes();
	
	$scope.getDays = function(month,year) {
		var daysNum, daysList = [];
		if(month == 'February') {
			if((year%4 == 0 && year%100 != 0) || year%400 == 0) daysNum = 29
			else daysNum = 28
		}
		else if(month == 'April' || month == 'June' || month == 'September' || month == 'November') daysNum = 30
		else daysNum = 31;
		for(var i = 1; i<=daysNum; i++) {
			if(i<10) daysList.push('0' + i)
			else daysList.push(i);
		}
		$scope.days = daysList;
	}

	$scope.updateUserAbout = function() {
		var $promise = $http.post('http://localhost/socialnet/updateUserAbout.php?id=' + $rootScope.sessionId,
			{
				'userName': $scope.userData.user_name,
				'userSurName': $scope.userData.user_surname,
				'userBirthday': $scope.formateDate($scope.userBirthday.day,$scope.userBirthday.month,$scope.userBirthday.year,'-'),
				'userCountry': $scope.userData.user_country,
				'userMaritalStatus': $scope.userData.user_marital_status,
				'userGender': $scope.userGender.type,
				'userShortBio': $scope.userData.user_short_bio,
				'userVk': $scope.userData.user_vk,
				'userFb': $scope.userData.user_fb,
				'userInstagram': $scope.userData.user_instagram,
				'userTwitter': $scope.userData.user_twitter,
				'userYouTube': $scope.userData.user_youTube,
				'userLinkedin': $scope.userData.user_linkedin,
				'userGooglePlus': $scope.userData.user_google_plus,
				'activity': $scope.userData.user_activity,
				'interests': $scope.userData.user_interests,
				'favMus': $scope.userData.user_fav_mus,
				'favMov': $scope.userData.user_fav_mov,
				'favBooks': $scope.userData.user_fav_books,
				'favGames': $scope.userData.user_fav_games
			}
		);
		$promise.success(function(data) {
			alert(data);
			$scope.getUser();
		});
	}
	$scope.setTab = function(tab) {
		$scope.currentTab = tab;
		return $scope.currentTab;
	}
	$scope.updateAvatar = function() {
		var form_data = new FormData();
		form_data.append('sessionId',$rootScope.sessionId);
		angular.forEach($scope.avatar.files, function(file) {
			form_data.append('file',file);
		});
		$http.post('http://localhost/socialnet/updateAvatar.php', form_data, {
			transformRequest: angular.identity,
			headers: {'Content-Type': undefined, 'Process-Data': false}
		}).success(function(data) {
			//alert(data);
			$scope.getUser();
			angular.element(document.querySelector('#user-avatar')).val(null);
		})
	}
}]);