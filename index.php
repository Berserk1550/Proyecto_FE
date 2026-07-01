<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio SENA CAB - Fondo Emprender</title>

    <link rel="stylesheet" href="static/css/index_vista.css">
    <script src="static/js/funciones.js"></script>
</head>

<body>

    <main id="caja_padre">

        <!-- Encabezado -->

        <header id="encabezado">

            <div id="cont_encabezado">

                <img src="static/img/logoFondoEmprender.svg" width="160" height="50" loading="eager">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#39a900" stroke-width="2" id="medalla_programa">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 3h6l3 7l-6 2l-6 -2z" />
                    <path d="M12 12l-3 -9" />
                    <path d="M15 11l-3 -8" />
                    <path d="M12 19.5l-3 1.5l.5 -3.5l-2 -2l3 -.5l1.5 -3l1.5 3l3 .5l-2 2l.5 3.5z" />
                </svg>

                <p id="texto_programa" style="display: none;">ANÁLISIS Y DESARROLLO DE SOFTWARE | 2931527</p>

            </div>

        </header>

        <!-- Contenido principal -->

        <section id="pagina_principal">

            <!-- Tarjeta de registro -->

            <article id="cont_registro">

                <h3 id="tlo_registro">REGISTRO</h3>

                <p id="texto_1">Regístrate y da el primer paso para convertir tu proyecto en realidad.</p>

                <p id="texto_2">Crea tu cuenta y comencemos juntos.</p>

                <a href="vista/registro_emprendedores_vista.php">Registrarme</a>

                <p id="texto_3">(Al registrarse autorizas el tratamiento de tus datos conforme a la Ley 1581 de 2012 y normas concordantes de Habeas Data)</p>

            </article>

            <!-- Tarjeta de inicio de sesión -->

            <article id="cont_inicio_sesion">

                <h3 id="tlo_sesion">INICIO DE SESIÓN</h3>

                <form action="<!-- ruta al inicio de sesión -->" method="post">

                    <div id="datos_documento">

                        <label>Número de documento</label>

                        <input type="text" id="numero_documento" name="numero_documento" pattern="[a-zA-Z0-9]{6-16}" title="Ingrese un número de documento válido" minlength="6" maxlength="16" tabindex="1" required>

                    </div>

                    <div id="datos_contraseña">

                        <label>Contraseña</label>

                        <input type="password" id="contraseña" name="contraseña" pattern="[a-zA-Z0-9!#$%^&*_+]{6,20}" title="Ingrese una contraseña válida y segura" minlength="6" maxlength="20" tabindex="2" required>

                    </div>

                    <button type="submit" id="btn_iniciar_sesion" tabindex="3">Ingresar</button>

                </form>

            </article>

            <article id="cont_convocatoria">

                <h3 id="tlo_convocatoria">CONVOCATORIAS</h3>

                <p id="texto_conv_1">Conoce las convocatorias vigentes del Fondo Emprender. Aquí encontrarás requisitos, beneficios y cronogramas para transformar tu idea en una empresa sostenible con el acompañamiento del SENA.</p>

                <p id="texto_conv_2">Explora las convocatorias y descubre la ruta que mejor se adapta a ti.</p>

                <a href="https://www.fondoemprender.com/SitePages/FondoEmprenderConvocatorias2020.aspx">Ver convocatorias -></a>

            </article>

        </section>

        <section id="estadisticas">

            <article id="cont_emprendedores_orientados">

                <div id="titulo_orientados">

                    <h3 id="tlo_emprendedores_orientados">Emprendedores orientados</h3>

                    <p id="total_orientados"><!-- todos los aprendices orientados -->24.832</p>

                </div>

                <div id="nuevo_año">

                    <p id="año">2023</p>

                    <p><!-- número de emprendedores orientados en 2023 -->5.050</p>

                </div>

                <div id="nuevo_año">

                    <p id="año">2024</p>

                    <p><!-- número de emprendedores orientados en 2024 -->3.509</p>

                </div>

                <div id="nuevo_año">

                    <p id="año">2025</p>

                    <p><!-- número de emprendedores orientados en 2025 -->1.304</p>

                </div>

            </article>

            <article id="cont_top_municipios">

                <h3 id="titulo_municipios">Top 3 municipios alcanzados</h3>

                <div id="municipios">

                    <p id="top_municipio"><!-- top 3 municipios -->Guadalajara de Buga</p>

                    <p><!-- numero de emprendedores -->3.209</p>

                </div>

                <div id="municipios">

                    <p id="top_municipio"><!-- top 3 municipios -->Medellín</p>

                    <p><!-- numero de emprendedores -->2.850</p>

                </div>

                <div id="municipios">

                    <p id="top_municipio"><!-- top 3 municipios -->Bogotá</p>

                    <p><!-- numero de emprendedores -->2.500</p>

                </div>

            </article>

            <article id="cont_top_niveles_de_estudio">

                <h3 id="titulo_estudio">Top 3 niveles de estudio de emprendedores</h3>

                <div id="top_nivel_estudio">

                    <p id="top_nivel"><!-- top 3 niveles de estudio -->Tecnico</p>

                    <p><!-- numero de emprendedores -->2.500</p>

                </div>

                <div id="top_nivel_estudio">

                    <p id="top_nivel"><!-- top 3 niveles de estudio -->Tecnologo</p>

                    <p><!-- numero de emprendedores -->2.000</p>

                </div>

                <div id="top_nivel_estudio">

                    <p id="top_nivel"><!-- top 3 niveles de estudio -->Profesional</p>

                    <p><!-- numero de emprendedores -->1.500</p>

                </div>

            </article>

            <article id="top_tipificaciones">

                <h3 id="titulo_tipificaciones">Top 3 tipificaciones de nuestros emprendedores</h3>

                <div id="tipificaciones">

                    <p id="top_tipificacion"><!-- top 3 tipificaciones -->Adolecente mayor</p>

                    <p><!-- numero de emprendedores -->1.432</p>

                </div>

                <div id="tipificaciones">

                    <p id="top_tipificacion"><!-- top 3 tipificaciones -->Joven</p>

                    <p><!-- numero de emprendedores -->1.200</p>

                </div>

                <div id="tipificaciones">

                    <p id="top_tipificacion"><!-- top 3 tipificaciones -->Adulto</p>

                    <p><!-- numero de emprendedores -->1.000</p>

                </div>

            </article>

        </section>

        <footer id="pie_pagina">

            <div id="cont_pie_pagina">

                <img src="static/img/logocolombiaporlavidatrabajo.png" width="80" height="30" loading="eager">

                <img src="static/img/mintrabajo.png" width="70" height="30" loading="eager">

            </div>

        </footer>

    </main>

</body>

</html>