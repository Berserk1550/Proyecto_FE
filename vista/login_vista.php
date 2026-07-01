<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>

    <link rel="stylesheet" href="login.css">
</head>

<body>

    <main id="caja_padre">

        <section id="caja_contenedora">

            <article id="lado_izquierdo">

                <img src="discapacitado.png">

            </article>

            <article id="lado_derecho">

                <h1>Iniciar sesión</h1>

                <form id="formulario_login" method="POST">

                    <label>Numero de documento</label>

                    <input type="text" id="documento" name="documento" placeholder="Ingrese su número de documento" required>

                    <label>Contraseña</label>

                    <input type="password" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña" required>

                    <button type="submit">Iniciar sesión</button>

                </form>

            </article>

        </section>

    </main>
</body>

</html>