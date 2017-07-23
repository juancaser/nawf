<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Not Another Web Framework">
<meta name="author" content="">
<title><?=$this->title;?> &mdash; Not Another Web Framework</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=asset('/css/ie10-viewport-bug-workaround.css');?>" rel="stylesheet">
<link href="<?=asset('/css/jumbotron-narrow.css');?>" rel="stylesheet">
<!--[if lt IE 9]><script src="<?=asset('/js/ie8-responsive-file-warning.js');?>"></script><![endif]-->
<script src="<?=asset('/js/ie-emulation-modes-warning.js');?>"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
     <div class="container">
          <header class="header clearfix">
               <nav>
                    <ul class="nav nav-pills pull-right">
                         <li role="presentation" class="active"><a href="/">Home</a></li>
                         <li role="presentation"><a href="/about ">About</a></li>
                    </ul>
               </nav>
               <h3 class="text-muted"><?=config('app.name');?></h3>
          </header>
          <?php $this->block('body');?>
          <footer class="footer">
               <p>&copy; <?=date('Y');?> <?=config('app.name');?></p>
          </footer>     
     </div>
     <script src="<?=asset('/js/ie10-viewport-bug-workaround.js');?>"></script>
</body>
</html>