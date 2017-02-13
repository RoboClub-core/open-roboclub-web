const base_url = $('#base_url').text();

// Initialize Firebase

var config = {
	apiKey: "AIzaSyB375ZkbrouviVJ1YG7_3n8K3jAhIXlsOU",
	authDomain: "amu-roboclub.firebaseapp.com",
	databaseURL: "https://amu-roboclub.firebaseio.com",
	storageBucket: "amu-roboclub.appspot.com",
	messagingSenderId: "911524271284"
};

firebase.initializeApp(config);

function toggleVisibility(show, view) {
  if (show) {
    view.style.display = 'block';
  } else {
    view.style.display = 'none';
  }
}

function progress(show) {
  const progressBar = document.getElementById('progress-bar');
  toggleVisibility(show, progressBar);
}

window.addEventListener('load', function() {
  const signinButton = $('#signin-button');
  const signinLink = $('#signin-link');

  firebase.auth().onAuthStateChanged(function(user) {
  	if(user) {
  	  signinButton.text('Admin Panel');
  	  signinButton.removeClass('btn-primary');
  	  signinButton.addClass('btn-info');

  	  signinLink.prop('href', base_url + '/admin');
  	} else {
  	  signinButton.text('Sign In');
  	  signinButton.removeClass('btn-info');
  	  signinButton.addClass('btn-primary');

  	  signinLink.prop('href', base_url + '/signin');
  	}
  }, function(error) {
    console.log(error);
  });
});