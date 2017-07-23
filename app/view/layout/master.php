<!DOCTYPE html>
<html>
<head>
    <title><?=$this->title;?></title>
    <?php $this->block('header');?>
</head>
<body>
     <?php $this->block('body');?>
     <?php $this->block('footer', function(){?>
          Test
     <?php });?>
</body>
</html>
