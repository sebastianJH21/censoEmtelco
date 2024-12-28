<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./views/css/style.css">
    <link rel="stylesheet" href="./views/css/login.css">
</head>
<body class="align body">

  <div class="login">

    <header class="login__header">
      <h2><svg class="icon">
          <use xlink:href="#icon-lock" />
        </svg>Iniciar Sesión</h2>
    </header>

    <form action="./views/index.php" class="login__form" method="POST">
      <div>
        <label for="user">Usuario</label>
        <input type="text" id="user" name="user" placeholder="Usuario" required>
      </div>
      <div>
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Contraseña" required>
      </div>
      <div>
        <input class="button" type="submit" value="Sign In">
      </div>
    </form>
  </div>
  <svg xmlns="http://www.w3.org/2000/svg" class="icons">
    <symbol id="icon-lock" viewBox="0 0 448 512">
      <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" />
    </symbol>
  </svg>
</body>
<!-- https://fontawesome.com/icons/lock?style=solid -->
</html>