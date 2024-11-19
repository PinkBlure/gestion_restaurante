<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de pedidos en una Cadena de Restaurantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./styles.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

  <div class="card shadow p-4" style="width: 22rem;">
    <div class="card-body">
      <h5 class="card-title text-center mb-4">Iniciar Sesión</h5>
      <form>
        <div class="mb-3">
          <label for="user" class="form-label">Usuario</label>
          <input name="user" id="user" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="passwd" class="form-label">Contraseña</label>
          <input name="passwd" id="passwd" type="password" class="form-control" required>
        </div>
        <div class="d-grid">
          <input type="submit" class="btn btn-primary" value="Acceder">
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
