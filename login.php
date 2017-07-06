<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

     <meta name="description" content="">
     <meta name="author" content="">

     <title>Log In</title>

     <!-- Bootstrap Core CSS -->
     <link href="css/bootstrap.min.css" rel="stylesheet">

     <!-- Custom CSS -->
     <link href="css/sb-admin.css" rel="stylesheet">

     <!-- Custom Fonts -->
     <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- <link href="css/style.css" rel="stylesheet" type="text/css"> -->
  <link href="css/app.css" rel="stylesheet" type="text/css">

  <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>

  <script src="js/script.js" type="text/javascript"></script>
</head>
<body class="hold-transition" style="background-color: #F3F3F3">

    <div class="login-box">
        <div class="login-logo">
            <img src="images/lpaUserLoginBG.png" style="max-width: 360px;" alt="..." />
        </div><!-- /.login-logo -->
        <div class="login-box-body">
          <form name="frmLogin" id="frmLogin" method="post" action="login.php">
                <div class="form-group input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input id="UserName" autofocus name="UserName" type="text" class="form-control" placeholder="Login">

                </div>
                <div class="form-group input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input id="Password" name="Password" type="password" class="form-control" placeholder="Password">

                </div>
                <div class="row">
                    <div class="col-xs-8">
                      <span>Version <b>1.1</b></span>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                      <button type="button" class="btn btn-primary btn-block btn-flat btn-login">Entrar</button>
                    </div><!-- /.col -->
                </div>
            </form>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</body>
<script>
  $('.btn-login').click(function(e){
    e.preventDefault();
    login();
  })

  $("#frmLogin").keypress(function(e) {
    if(e.which == 13) {
      // $(this).submit();
      login();
    }
  });

  function login(){
    var form = $('#frmLogin').serialize();

    $.post('./api/auth.php', form)
      .done(function(data){
        if(data.success){
          location.href = '/';
        } else {
          alert(data.message);
        }
      });
  }

</script>
</html>
