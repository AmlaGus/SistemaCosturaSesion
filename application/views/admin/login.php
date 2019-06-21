<html>
<head>
    <title>Admin - Login</title>
    <link rel="stylesheet" href="<?php base_url()?>informacion/css/bootstrap.min.css">
</head>
<body>

    <div class="login col-md-4 mx-auto text-center">
        <h1>Admin Login</h1>
        <form method="post" action="<?php echo base_url("admin/login/verify")?>">
            <div class="form-group">
                <input type="text" name="usuario" placeholder="Ingresa Usuario" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Ingresa Password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Login" class="btn btn-primary">
            </div>

        </form>
    </div>

</body>
</html>