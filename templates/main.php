<!DOCTYPE html>
<html lang="en" ng-app="pokeroll">
<head>
  <?php include_once 'inc/head.php'; ?>

  <base href="/pokeroll-web/public/"/>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
  <script src="assets/js/pokeroll/app.js"></script>
  <script src="assets/js/pokeroll/sessions/SessionsController.js"></script>
</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="#">PokeRoll</a>
      <div class="nav-collapse collapse">
        <p class="navbar-text pull-right">
          Logged in as <a href="#" class="navbar-link">Username (todo)</a>
        </p>
        <ul class="nav">
          <li><a href="#">Home</a></li>
          <li><a href="sessions">Sessions</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

<div class="container-fluid">
  
  <div class="ng-view"></div>

  <hr>

  <footer>
    <p>&copy; Company 2013</p>
  </footer>

</div><!--/.fluid-container-->

<!-- Le javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
