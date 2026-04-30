<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../static/css/registro_emprendedores.css">

    <script src="../static/js/registro_emprendedores.js"></script>

    <script src="../static/js/funciones.js"></script>

</head>

<body>

    <main id="caja_padre">

        <header id="encabezado">

            <div id="cont_encabezado">

                <img src="../static/img/logoFondoEmprender.svg" with="160" height="50" loading="eager">

                <div id="caja_separadora">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#39a900" stroke-width="2" id="medalla_programa">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 3h6l3 7l-6 2l-6 -2z" />
                        <path d="M12 12l-3 -9" />
                        <path d="M15 11l-3 -8" />
                        <path d="M12 19.5l-3 1.5l.5 -3.5l-2 -2l3 -.5l1.5 -3l1.5 3l3 .5l-2 2l.5 3.5z" />
                    </svg>

                    <a id="volver_inicio" href="../index.php">Volver al inicio</a>

                </div>

                <p id="texto_programa" style="display: none;">ANÁLISIS Y DESARROLLO DE SOFTWARE | 2931527</p>

            </div>

        </header>

        <section id="pagina_principal">

            <article id="tarjeta_informacion">

                <h2>ORIENTACIÓN A EMPRENDEDORES 2025</h2>

                <p>Centros de Desarrollo Empresarial - Regional Valle</p>

                <p>¡Bienvenido/a Emprendedor(a)! Por favor registre su asistencia a la orientación sobre los servicios de los Centros de Desarrollo Empresarial del SENA CAB Regional Valle. Este espacio permite acceder a la <b>Ruta Emprendedora</b> y a las herramientas necesarias para fortalecer sus habilidades blandas, desarrollar competencias emprendedoras y acceder a oportunidades como participar en convocatorias Fondo Emprender.</p>

                <p><b>CONSENTIMIENTO INFORMADO Y PROTECCIÓN DE DATOS:</b> Entiendo que mi participación consiste en el diligenciamiento del presente formulario. La información es confidencial(Ley 1581 de 2012).</p>

            </article>

            <article id="contenido_registro">

                <div id="cont_progreso">

                    <h1>Registro Ruta Emprendedora 2025</h1>

                    <div class="progreso_total" id="progreso_total"></div>

                    <div id="caja_progreso">

                        <span id="progreso_no" class="step active" data-step="1">1</span>
                        <span id="progreso_no" class="step" data-step="2">2</span>
                        <span id="progreso_no" class="step" data-step="3">3</span>
                        <span id="progreso_no" class="step" data-step="4">4</span>
                        <span id="progreso_no" class="step" data-step="5">5</span>
                        <span id="progreso_no" class="step" data-step="6">6</span>

                    </div>

                    <form action="../controller/registro.php" id="formulario" method="POST">

                        <!-- FASE 1 Lmao -->
                        <div id="fase_1" class="">

                            <h3>Información Personal</h3>

                            <div id="cont_fase_1">

                                <div id="grupos">

                                    <div id="caja">

                                        <label>Nombres</label>

                                        <input type="text" id="nombre_emprendedor" name="nombre_emprendedor" required minlength="1" maxlength="100" pattern="[a-záéíóúñA-ZÁÉÍÓÚÑ\s]{1,100}" title="Solo se permiten letras y espacios" placeholder="Ej: Juan Carlos">

                                    </div>

                                    <div id="caja">

                                        <label>Apellidos</label>

                                        <input type="text" id="apellido_emprendedor" name="apellido_emprendedor" required minlength="1" maxlength="100" pattern="[a-záéíóúñA-ZÁÉÍÓÚÑ\s]{1,100}" title="Solo se permiten letras y espacios" placeholder="Ej: García Rodríguez">

                                    </div>

                                </div>

                                <div id="grupos">

                                    <div id="caja">

                                        <label>Tipo de documento</label>

                                        <select id="tipo_documento_emprendedor" name="tipo_documento_emprendedor" required>
                                            <option value="" disabled selected>Seleccione</option>
                                            <option value="CC">Cédula de Ciudadanía</option>
                                            <option value="CE">Cédula de Extranjería</option>
                                            <option value="TI">Tarjeta de Identidad</option>
                                            <option value="PEP">Permiso especial de permanencia</option>
                                            <option value="PAS">Pasaporte</option>
                                            <option value="PPT">Permiso de Protección Temporal</option>
                                        </select>

                                    </div>

                                    <div id="caja">

                                        <label>Número de documento</label>

                                        <input type="text" id="documento_emprendedor" name="documento_emprendedor" required minlength="5" maxlength="17" inputmode="numeric" pattern="[0-9]{5,17}" title="Solo números (5-15 dígitos)" placeholder="Ej: 1234567890">

                                        <div id="mensajeErrorDocumento" style="color: red; font-size: 12px; margin-top: 5px; display: none;"></div>

                                    </div>

                                </div>

                                <div id="grupos">

                                    <div id="caja">

                                        <label>Numero de telefono</label>

                                        <input type="tel" id="telefono_emprendedor" name="telefono_emprendedor" required minlength="10" maxlength="10" inputmode="tel" pattern="[0-9]{10,10}" title="Ingresa 10 dígitos" placeholder="Ej: 3001234567">

                                    </div>

                                    <div id="caja">

                                        <label>Fecha de nacimiento</label>

                                        <input type="date" id="fecha_nacimiento_emprendedor" name="fecha_nacimiento_emprendedor" required title="Selecciona tu fecha de nacimiento">

                                    </div>

                                </div>

                                <div id="grupos">

                                    <div id="caja">

                                        <label>Sexo</label>

                                        <select id="sexo_emprendedor" name="sexo_emprendedor" required>
                                            <option value="" disabled selected>Seleccione</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>

                                    </div>

                                    <div id="caja">

                                        <label>Correo electrónico</label>

                                        <input type="email" id="correo_emprendedor" name="correo_emprendedor" minlength="7" maxlength="70" pattern="[a-zA-Z0-9\.\-\_]+@+[a-zA-Z]+\.+[a-z\.]{7,70}" placeholder="Ej: soyemprendedor@gmail.com" required>

                                        <div id="mensajeErrorCorreo" style="color: red; font-size: 12px; margin-top: 5px; display: none;"></div>

                                    </div>

                                </div>

                            </div>

                            <div id="navegacion_botones">
                                <button type="button" id="btn_fase1">Siguiente</button>
                            </div>

                        </div>

                        <!-- FASE 2  -->
                        <div id="fase_2">

                            <h3>Nacionalidad</h3>

                            <div id="cont_fase_2">

                                <label>Pais</label>

                                <select name="paises" id="paises" required>

                                    <option disabled selected>Selecciona un pais</option>
                                    <option value="Colombia" selected>Colombia</option>
                                </select>

                                <label>Nacionalidad</label>

                                <span id="nacionalidad" name="nacionalidad"></span>

                                <label>Departamento (si es de otro pais, elija otro)</label>

                                <select id="departamento" name="departamento" required>

                                    <option disabled selected>Selecciona un departamento</option>
                                    <option value="Amazonas">Amazonas</option>
                                    <option value="Antioquia">Antioquia</option>
                                    <option value="Arauca">Arauca</option>
                                    <option value="Atlántico">Atlántico</option>
                                    <option value="Bogotá D.C.">Bogotá D.C.</option>
                                    <option value="Bolívar">Bolívar</option>
                                    <option value="Boyacá">Boyacá</option>
                                    <option value="Caldas">Caldas</option>
                                    <option value="Caquetá">Caquetá</option>
                                    <option value="Casanare">Casanare</option>
                                    <option value="Cauca">Cauca</option>
                                    <option value="Cesar">Cesar</option>
                                    <option value="Chocó">Chocó</option>
                                    <option value="Córdoba">Córdoba</option>
                                    <option value="Cundinamarca">Cundinamarca</option>
                                    <option value="Guainía">Guainía</option>
                                    <option value="Guaviare">Guaviare</option>
                                    <option value="Huila">Huila</option>
                                    <option value="La Guajira">La Guajira</option>
                                    <option value="Magdalena">Magdalena</option>
                                    <option value="Meta">Meta</option>
                                    <option value="Nariño">Nariño</option>
                                    <option value="Norte de Santander">Norte de Santander</option>
                                    <option value="Putumayo">Putumayo</option>
                                    <option value="Quindío">Quindío</option>
                                    <option value="Risaralda">Risaralda</option>
                                    <option value="San Andrés y Providencia">San Andrés y Providencia</option>
                                    <option value="Santander">Santander</option>
                                    <option value="Sucre">Sucre</option>
                                    <option value="Tolima">Tolima</option>
                                    <option value="Valle del Cauca" selected>Valle del Cauca</option>
                                    <option value="Vaupés">Vaupés</option>
                                    <option value="Vichada">Vichada</option>
                                    <option value="Otro">Otro</option>

                                </select>

                                <label>Municipio</label>

                                <input type="text" id="municipio" name="municipio" required minlength="3" maxlength="28" pattern="[a-záéíóúñA-ZÁÉÍÓÚÑ\s]{3,28}" placeholder="Ej: Cali">

                            </div>

                            <div id="navegacion_botones">

                                <button type="button" id="btn_volver">

                                    <svg width="30" height="30" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                        <path d="M3.57813 12.4981C3.5777 12.6905 3.65086 12.8831 3.79761 13.0299L9.7936 19.0301C10.0864 19.3231 10.5613 19.3233 10.8543 19.0305C11.1473 18.7377 11.1474 18.2629 10.8546 17.9699L6.13418 13.2461L20.3295 13.2461C20.7437 13.2461 21.0795 12.9103 21.0795 12.4961C21.0795 12.0819 20.7437 11.7461 20.3295 11.7461L6.14168 11.7461L10.8546 7.03016C11.1474 6.73718 11.1473 6.2623 10.8543 5.9695C10.5613 5.6767 10.0864 5.67685 9.79362 5.96984L3.84392 11.9233C3.68134 12.0609 3.57812 12.2664 3.57812 12.4961L3.57813 12.4981Z" fill="#fdfdfd" />
                                    </svg>

                                </button>

                                <button type="button" id="btn_fase2">Siguiente</button>

                            </div>

                        </div>

                        <!-- FASE 3 -->
                        <div id="fase_3">

                            <h3>Caracterización</h3>

                            <div id="cont_fase_3">

                                <label>Clasificación de población (si aplica)</label>

                                <select id="clasificacion" name="clasificacion" required">
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Adolescente trabajador">Adolescente trabajador</option>
                                    <option value="Adolescente en conflicto con la ley penal">Adolescente en conflicto con la ley penal</option>
                                    <option value="Adolescentes y jóvenes vulnerables">Adolescentes y jóvenes vulnerables</option>
                                    <option value="Afrocolombianos">Afrocolombianos</option>
                                    <option value="Campesinos">Campesinos</option>
                                    <option value="Desplazado por fenómenos naturales">Desplazado por fenómenos naturales</option>
                                    <option value="Migrantes que retornan al país">Migrantes que retornan al país</option>
                                    <option value="Mujer cabeza de hogar">Mujer cabeza de hogar</option>
                                    <option value="Negritudes">Negritudes</option>
                                    <option value="Palenqueros">Palenqueros</option>
                                    <option value="Reintegrados (ARN)">Participantes del programa de reintegración - Reintegrados (ARN)</option>
                                    <option value="Personas en reincorporación">Personas en Proceso de Reincorporación</option>
                                    <option value="Población con discapacidad">Población con discapacidad</option>
                                    <option value="Población indígena">Población indígena</option>
                                    <option value="Población LGBTI">Población LGBTI</option>
                                    <option value="Víctima de minas antipersona">Población víctima de minas antipersona</option>
                                    <option value="Pueblo ROM">Pueblo ROM</option>
                                    <option value="Raizales">Raizales</option>
                                    <option value="Remitidos por PAL">Remitidos por programa de adaptación laboral - PAL</option>
                                    <option value="Soldados campesinos">Soldados campesinos</option>
                                    <option value="Tercera edad">Tercera edad</option>
                                    <option value="Víctima de la violencia">Víctima de la violencia</option>
                                    <option value="Víctima de otros hechos">Víctima de otros hechos victimizantes</option>
                                    <option value="Sobrevivientes de agentes químicos">Víctimas sobrevivientes con agentes químicos</option>
                                </select>

                                <label>Si es persona en condición de discapacidad, seleccione el tipo</label>

                                <select id="discapacidad" name="discapacidad" required>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="Ninguna">Ninguna</option>
                                    <option value="Auditiva">Auditiva</option>
                                    <option value="Cognitiva">Cognitiva</option>
                                    <option value="Física">Física</option>
                                    <option value="Múltiple">Múltiple</option>
                                    <option value="Psicosocial">Psicosocial</option>
                                    <option value="Sordoceguera">Sordoceguera</option>
                                    <option value="Visual">Visual</option>
                                </select>

                            </div>

                            <div id="navegacion_botones">
                                <button type="button" id="btn_volver">
                                    <svg width="30" height="30" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                        <path d="M3.57813 12.4981C3.5777 12.6905 3.65086 12.8831 3.79761 13.0299L9.7936 19.0301C10.0864 19.3231 10.5613 19.3233 10.8543 19.0305C11.1473 18.7377 11.1474 18.2629 10.8546 17.9699L6.13418 13.2461L20.3295 13.2461C20.7437 13.2461 21.0795 12.9103 21.0795 12.4961C21.0795 12.0819 20.7437 11.7461 20.3295 11.7461L6.14168 11.7461L10.8546 7.03016C11.1474 6.73718 11.1473 6.2623 10.8543 5.9695C10.5613 5.6767 10.0864 5.67685 9.79362 5.96984L3.84392 11.9233C3.68134 12.0609 3.57812 12.2664 3.57812 12.4961L3.57813 12.4981Z" fill="#fdfdfd" />
                                    </svg>
                                </button>
                                <button type="button" id="btn_fase3">Siguiente</button>
                            </div>

                        </div>

                        <!-- FASE 4 -->
                        <div id="fase_4">

                            <h3>Caracterización educativa</h3>

                            <div id="cont_fase_4">

                                <label>Tipo de emprendedor</label>

                                <select id="tipo_emprendedor" name="tipo_emprendedor" required>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="Aprendiz">Aprendiz</option>
                                    <option value="Instructor">Instructor</option>
                                    <option value="Egresado de Otras Instituciones">Egresado de Otras Instituciones</option>
                                    <option value="Egresado SENA Complementaria">Egresado SENA Complementaria</option>
                                    <option value="Egresado SENA Titulada">Egresado SENA Titulada</option>
                                    <option value="No cuenta con formación">No cuenta con formación</option>
                                    <option value="Otro">Otro</option>
                                </select>

                                <label>Nivel de formación en el momento actual</label>

                                <select id="nivel_formacion" name="nivel_formacion" required>
                                    <option value="" disabled selected>Selecciona</option>
                                    <option value="Técnico">Técnico</option>
                                    <option value="Tecnólogo">Tecnólogo</option>
                                    <option value="Operario">Operario</option>
                                    <option value="Auxiliar">Auxiliar</option>
                                    <option value="Profesional">Profesional</option>
                                    <option value="Especialización">Especialización</option>
                                    <option value="Maestría">Maestría</option>
                                    <option value="Doctorado">Doctorado</option>
                                    <option value="Sin título">Sin título</option>
                                </select>

                                <select id="carrera_tecnologo" name="carrera_tecnologo" style="display:none;margin-top:10px">
                                    <option value="" disabled selected>
                                        Elige tu Tecnólogo
                                    </option>
                                    <option value="Análisis y desarrollo de software">Análisis y desarrollo de software</option>
                                    <option value="Gestión de talento humano">Gestión de talento humano</option>
                                    <option value="Gestión agroempresarial">Gestión agroempresarial</option>
                                    <option value="Gestión de recursos naturales">Gestión de recursos naturales</option>
                                    <option value="Prevención y control ambiental">Prevención y control ambiental</option>
                                    <option value="Desarrollo multimedia y web">Desarrollo multimedia y web</option>
                                    <option value="Gestión contable y de información financiera">Gestión contable y de información financiera</option>
                                    <option value="Desarrollo publicitario">Desarrollo publicitario</option>
                                    <option value="Gestión de la seguridad y salud en el trabajo">Gestión de la seguridad y salud en el trabajo</option>
                                    <option value="Gestión de redes de datos">Gestión de redes de datos</option>
                                    <option value="Mantenimiento electromecánico industrial">Mantenimiento electromecánico industrial</option>
                                    <option value="Producción de multimedia">Producción de multimedia</option>
                                    <option value="Animación digital">Animación digital</option>
                                    <option value="Gestión empresarial">Gestión empresarial</option>
                                    <option value="Gestión documental">Gestión documental</option>
                                    <option value="Actividad física y entrenamiento deportivo">Actividad física y entrenamiento deportivo</option>
                                    <option value="Regencia de farmacia">Regencia de farmacia</option>
                                    <option value="Producción ganadera">Producción ganadera</option>
                                    <option value="Gestión de empresas agropecuarias">Gestión de empresas agropecuarias</option>
                                    <option value="Supervisión de redes de distribución de energía eléctrica">Supervisión de redes de distribución de energía eléctrica</option>
                                    <option value="Procesamiento de alimentos">Procesamiento de alimentos</option>
                                    <option value="Control de calidad de alimentos">Control de calidad de alimentos</option>
                                    <option value="Gestión logística">Gestión logística</option>
                                    <option value="Mecanización agrícola y producción agrícola">Mecanización agrícola y producción agrícola</option>
                                    <option value="Otro">Otro</option>
                                </select>

                                <select id="carrera_tecnico" name="carrera_tecnico" style="display:none;margin-top:10px">
                                    <option value="" disabled selected>Elige tu Técnico</option>
                                    <option value="Asistencia administrativa">Asistencia administrativa</option>
                                    <option value="Cocina">Cocina</option>
                                    <option value="Conservación de recursos naturales">Conservación de recursos naturales</option>
                                    <option value="Contabilización de operaciones comerciales y financieras">Contabilización de operaciones comerciales y financieras</option>
                                    <option value="Ejecución de programas deportivos">Ejecución de programas deportivos</option>
                                    <option value="Enfermería">Enfermería</option>
                                    <option value="Monitoreo ambiental">Monitoreo ambiental</option>
                                    <option value="Operación turística local">Operación turística local</option>
                                    <option value="Sistemas agropecuarios ecológicos">Sistemas agropecuarios ecológicos</option>
                                    <option value="Sistemas teleinformáticos">Sistemas teleinformáticos</option>
                                    <option value="Sistemas atención integral al cliente">Sistemas atención integral al cliente</option>
                                    <option value="Cultivo de agrícolas">Cultivo de agrícolas</option>
                                    <option value="Elaboración de productos alimenticios">Elaboración de productos alimenticios</option>
                                    <option value="Instalación de sistemas eléctricos residenciales y comerciales">Instalación de sistemas eléctricos residenciales y comerciales</option>
                                    <option value="Programación de software">Programación de software</option>
                                    <option value="Proyectos agropecuarios">Proyectos agropecuarios</option>
                                    <option value="Recursos humanos y comercialización de productos masivos">Recursos humanos y comercialización de productos masivos</option>
                                    <option value="Integración de operaciones logísticas">Integración de operaciones logísticas</option>
                                    <option value="Manejo de viveros">Manejo de viveros</option>
                                    <option value="Mecánica de maquinaria industrial">Mecánica de maquinaria industrial</option>
                                    <option value="Integración de contenidos digitales">Integración de contenidos digitales</option>
                                    <option value="Electricista industrial">Electricista industrial</option>
                                    <option value="Mantenimiento de motocicletas y motocarros">Mantenimiento de motocicletas y motocarros</option>
                                    <option value="Mantenimiento de vehículos livianos">Mantenimiento de vehículos livianos</option>
                                    <option value="Soldadura de productos metalócios en platina">Soldadura de productos metalócios en platina</option>
                                    <option value="Producción pecuario">Producción pecuario</option>
                                    <option value="Operaciones de comercio exterior">Operaciones de comercio exterior</option>
                                    <option value="Servicios comerciales y financieros">Servicios comerciales y financieros</option>
                                    <option value="Servicios farmacéuticos">Servicios farmacéuticos</option>
                                    <option value="Servicio de restaurante y bar">Servicio de restaurante y bar</option>
                                    <option value="Operaciones comerciales en retail">Operaciones comerciales en retail</option>
                                    <option value="Operaciones de maquinaria agrícola">Operaciones de maquinaria agrícola</option>
                                    <option value="Procesamiento de carnes">Procesamiento de carnes</option>
                                    <option value="Técnico en operaciones forestales y producción ovino-caprina">Técnico en operaciones forestales y producción ovino-caprina</option>
                                </select>

                                <select id="carrera_operario" name="carrera_operario" style="display:none;margin-top:10px">
                                    <option value="" disabled selected>
                                        Elige tu Operario
                                    </option>
                                    <option value="Procesos de panadería">Procesos de panadería</option>
                                    <option value="Cuidado básico de personas con dependencia funcional">Cuidado básico de personas con dependencia funcional</option>
                                    <option value="Instalaciones eléctricas para viviendas">Instalaciones eléctricas para viviendas</option>
                                    <option value="Otro">Otro</option>
                                </select>

                                <select id="carrera_auxiliar" name="carrera_auxiliar" style="display:none;margin-top:10px">
                                    <option value="" disabled selected>Elige tu Auxiliar</option>
                                    <option value="Servicios de apoyo al cliente">Servicios de apoyo al cliente</option>
                                    <option value="Otro">Otro</option>
                                </select>

                                <select id="carrera_profesional" name="carrera_profesional" style="display:none; margin-top: 10px;">
                                    <option value="" disabled selected>Selecciona tu carrera profesional</option>

                                    <optgroup label="Ingenierías y Tecnología">
                                        <option value="Ingeniería de Sistemas">Ingeniería de Sistemas</option>
                                        <option value="Ingeniería de Software">Ingeniería de Software</option>
                                        <option value="Ingeniería Informática">Ingeniería Informática</option>
                                        <option value="Ingeniería en Computación">Ingeniería en Computación</option>
                                        <option value="Ingeniería Electrónica">Ingeniería Electrónica</option>
                                        <option value="Ingeniería Eléctrica">Ingeniería Eléctrica</option>
                                        <option value="Ingeniería en Telecomunicaciones">Ingeniería en Telecomunicaciones</option>
                                        <option value="Ingeniería Mecánica">Ingeniería Mecánica</option>
                                        <option value="Ingeniería Mecatrónica">Ingeniería Mecatrónica</option>
                                        <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                                        <option value="Ingeniería Civil">Ingeniería Civil</option>
                                        <option value="Ingeniería Ambiental">Ingeniería Ambiental</option>
                                        <option value="Ingeniería Química">Ingeniería Química</option>
                                        <option value="Ingeniería Biomédica">Ingeniería Biomédica</option>
                                        <option value="Ingeniería Aeroespacial">Ingeniería Aeroespacial</option>
                                        <option value="Ingeniería Naval">Ingeniería Naval</option>
                                        <option value="Ingeniería Geológica">Ingeniería Geológica</option>
                                        <option value="Ingeniería de Petróleos">Ingeniería de Petróleos</option>
                                        <option value="Ingeniería de Minas">Ingeniería de Minas</option>
                                        <option value="Ingeniería Agroindustrial">Ingeniería Agroindustrial</option>
                                        <option value="Ingeniería de Alimentos">Ingeniería de Alimentos</option>
                                        <option value="Ingeniería en Energías Renovables">Ingeniería en Energías Renovables</option>
                                        <option value="Ingeniería en Materiales">Ingeniería en Materiales</option>
                                        <option value="Ingeniería Topográfica">Ingeniería Topográfica</option>
                                        <option value="Ingeniería de Transporte">Ingeniería de Transporte</option>
                                        <option value="Ingeniería de Datos">Ingeniería de Datos</option>
                                        <option value="Ciencia de Datos">Ciencia de Datos</option>
                                        <option value="Analítica de Negocios">Analítica de Negocios</option>
                                        <option value="Inteligencia Artificial">Inteligencia Artificial</option>
                                        <option value="Ciberseguridad">Ciberseguridad</option>
                                        <option value="Robótica">Robótica</option>
                                        <option value="Geomática">Geomática</option>
                                        <option value="Logística e Ingeniería Logística">Logística e Ingeniería Logística</option>
                                    </optgroup>

                                    <optgroup label="Ciencias de la Salud">
                                        <option value="Medicina">Medicina</option>
                                        <option value="Enfermería">Enfermería</option>
                                        <option value="Odontología">Odontología</option>
                                        <option value="Fisioterapia">Fisioterapia</option>
                                        <option value="Terapia Ocupacional">Terapia Ocupacional</option>
                                        <option value="Fonoaudiología">Fonoaudiología</option>
                                        <option value="Nutrición y Dietética">Nutrición y Dietética</option>
                                        <option value="Instrumentación Quirúrgica">Instrumentación Quirúrgica</option>
                                        <option value="Bacteriología">Bacteriología</option>
                                        <option value="Microbiología">Microbiología</option>
                                        <option value="Química Farmacéutica (Farmacia)">Química Farmacéutica (Farmacia)</option>
                                        <option value="Optometría">Optometría</option>
                                        <option value="Terapia Respiratoria">Terapia Respiratoria</option>
                                        <option value="Salud Pública">Salud Pública</option>
                                        <option value="Radiología e Imágenes Diagnósticas">Radiología e Imágenes Diagnósticas</option>
                                    </optgroup>

                                    <optgroup label="Ciencias Sociales y Humanas">
                                        <option value="Psicología">Psicología</option>
                                        <option value="Sociología">Sociología</option>
                                        <option value="Antropología">Antropología</option>
                                        <option value="Trabajo Social">Trabajo Social</option>
                                        <option value="Filosofía">Filosofía</option>
                                        <option value="Historia">Historia</option>
                                        <option value="Geografía">Geografía</option>
                                        <option value="Ciencia Política">Ciencia Política</option>
                                        <option value="Relaciones Internacionales">Relaciones Internacionales</option>
                                        <option value="Arqueología">Arqueología</option>
                                        <option value="Lingüística">Lingüística</option>
                                        <option value="Literatura">Literatura</option>
                                        <option value="Estudios Culturales">Estudios Culturales</option>
                                        <option value="Teología">Teología</option>
                                        <option value="Desarrollo Territorial">Desarrollo Territorial</option>
                                    </optgroup>

                                    <optgroup label="Economía, Negocios y Gestión">
                                        <option value="Administración de Empresas">Administración de Empresas</option>
                                        <option value="Contaduría Pública">Contaduría Pública</option>
                                        <option value="Economía">Economía</option>
                                        <option value="Finanzas">Finanzas</option>
                                        <option value="Mercadeo">Mercadeo</option>
                                        <option value="Negocios Internacionales">Negocios Internacionales</option>
                                        <option value="Comercio Exterior">Comercio Exterior</option>
                                        <option value="Administración Pública">Administración Pública</option>
                                        <option value="Gestión Empresarial">Gestión Empresarial</option>
                                        <option value="Banca y Finanzas">Banca y Finanzas</option>
                                        <option value="Dirección de Empresas">Dirección de Empresas</option>
                                        <option value="Emprendimiento">Emprendimiento</option>
                                        <option value="Gerencia Logística">Gerencia Logística</option>
                                        <option value="Gestión de Proyectos">Gestión de Proyectos</option>
                                        <option value="Gestión del Talento Humano">Gestión del Talento Humano</option>
                                        <option value="Administración Turística y Hotelera">Administración Turística y Hotelera</option>
                                    </optgroup>

                                    <optgroup label="Educación (Licenciaturas)">
                                        <option value="Licenciatura en Educación Preescolar">Licenciatura en Educación Preescolar</option>
                                        <option value="Licenciatura en Educación Básica Primaria">Licenciatura en Educación Básica Primaria</option>
                                        <option value="Licenciatura en Lengua Castellana">Licenciatura en Lengua Castellana</option>
                                        <option value="Licenciatura en Matemáticas">Licenciatura en Matemáticas</option>
                                        <option value="Licenciatura en Ciencias Naturales">Licenciatura en Ciencias Naturales</option>
                                        <option value="Licenciatura en Educación Física">Licenciatura en Educación Física</option>
                                        <option value="Licenciatura en Idiomas (Inglés)">Licenciatura en Idiomas (Inglés)</option>
                                        <option value="Licenciatura en Educación Especial">Licenciatura en Educación Especial</option>
                                        <option value="Licenciatura en Artes">Licenciatura en Artes</option>
                                        <option value="Licenciatura en Música">Licenciatura en Música</option>
                                        <option value="Licenciatura en Tecnología e Informática">Licenciatura en Tecnología e Informática</option>
                                    </optgroup>

                                    <optgroup label="Artes, Arquitectura y Diseño">
                                        <option value="Arquitectura">Arquitectura</option>
                                        <option value="Diseño Gráfico">Diseño Gráfico</option>
                                        <option value="Diseño Industrial">Diseño Industrial</option>
                                        <option value="Diseño de Modas">Diseño de Modas</option>
                                        <option value="Diseño de Interiores">Diseño de Interiores</option>
                                        <option value="Artes Plásticas">Artes Plásticas</option>
                                        <option value="Artes Visuales">Artes Visuales</option>
                                        <option value="Fotografía">Fotografía</option>
                                        <option value="Cine y Televisión">Cine y Televisión</option>
                                        <option value="Animación Digital">Animación Digital</option>
                                        <option value="Música">Música</option>
                                        <option value="Danza">Danza</option>
                                        <option value="Teatro">Teatro</option>
                                        <option value="Producción Multimedia">Producción Multimedia</option>
                                    </optgroup>

                                    <optgroup label="Ciencias Básicas y Naturales">
                                        <option value="Matemáticas">Matemáticas</option>
                                        <option value="Estadística">Estadística</option>
                                        <option value="Física">Física</option>
                                        <option value="Química">Química</option>
                                        <option value="Biología">Biología</option>
                                        <option value="Bioquímica">Bioquímica</option>
                                        <option value="Geología">Geología</option>
                                        <option value="Ciencias de la Tierra">Ciencias de la Tierra</option>
                                        <option value="Astronomía">Astronomía</option>
                                        <option value="Nanociencia y Nanotecnología">Nanociencia y Nanotecnología</option>
                                        <option value="Ciencias del Mar">Ciencias del Mar</option>
                                    </optgroup>

                                    <optgroup label="Agropecuarias y Ambiente">
                                        <option value="Medicina Veterinaria">Medicina Veterinaria</option>
                                        <option value="Zootecnia">Zootecnia</option>
                                        <option value="Agronomía">Agronomía</option>
                                        <option value="Ingeniería Agronómica">Ingeniería Agronómica</option>
                                        <option value="Ingeniería Forestal">Ingeniería Forestal</option>
                                        <option value="Ingeniería Agroecológica">Ingeniería Agroecológica</option>
                                        <option value="Ingeniería Agrícola">Ingeniería Agrícola</option>
                                        <option value="Ingeniería Pesquera">Ingeniería Pesquera</option>
                                        <option value="Acuicultura">Acuicultura</option>
                                        <option value="Administración Ambiental">Administración Ambiental</option>
                                        <option value="Gestión Ambiental">Gestión Ambiental</option>
                                        <option value="Ciencias Ambientales">Ciencias Ambientales</option>
                                        <option value="Hidrología">Hidrología</option>
                                        <option value="Meteorología">Meteorología</option>
                                    </optgroup>

                                    <optgroup label="Comunicación y Medios">
                                        <option value="Comunicación Social">Comunicación Social</option>
                                        <option value="Periodismo">Periodismo</option>
                                        <option value="Publicidad">Publicidad</option>
                                        <option value="Relaciones Públicas">Relaciones Públicas</option>
                                        <option value="Comunicación Audiovisual">Comunicación Audiovisual</option>
                                        <option value="Comunicación Digital">Comunicación Digital</option>
                                        <option value="Producción de Radio y TV">Producción de Radio y TV</option>
                                        <option value="Comunicación Organizacional">Comunicación Organizacional</option>
                                    </optgroup>

                                    <optgroup label="Derecho, Gobierno y Seguridad">
                                        <option value="Derecho">Derecho</option>
                                        <option value="Criminología">Criminología</option>
                                        <option value="Criminalística">Criminalística</option>
                                        <option value="Gobierno y Asuntos Públicos">Gobierno y Asuntos Públicos</option>
                                        <option value="Gestión Pública">Gestión Pública</option>
                                        <option value="Seguridad y Salud en el Trabajo">Seguridad y Salud en el Trabajo</option>
                                        <option value="Gestión de la Seguridad">Gestión de la Seguridad</option>
                                        <option value="Investigación Criminal">Investigación Criminal</option>
                                    </optgroup>

                                    <optgroup label="Turismo, Gastronomía y Deporte">
                                        <option value="Turismo">Turismo</option>
                                        <option value="Administración Turística y Hotelera">Administración Turística y Hotelera</option>
                                        <option value="Gastronomía">Gastronomía</option>
                                        <option value="Guianza Turística">Guianza Turística</option>
                                        <option value="Gestión Deportiva">Gestión Deportiva</option>
                                        <option value="Recreación y Deporte">Recreación y Deporte</option>
                                    </optgroup>

                                    <option value="Otro">Otro</option>
                                </select>

                                <!-- ESPECIALIZACIÓN -->
                                <select id="posgrado_especializacion" name="posgrado_especializacion" style="display:none;margin-top:10px;">
                                    <option value="" disabled selected>Selecciona tu especialización</option>
                                    <option value="Especialización en Gerencia de Proyectos">Especialización en Gerencia de Proyectos</option>
                                    <option value="Especialización en Seguridad y Salud en el Trabajo">Especialización en Seguridad y Salud en el Trabajo</option>
                                    <option value="Especialización en Finanzas">Especialización en Finanzas</option>
                                    <option value="Especialización en Analítica de Datos">Especialización en Analítica de Datos</option>
                                    <option value="Especialización en Docencia Universitaria">Especialización en Docencia Universitaria</option>
                                    <option value="Otro">Otro</option>
                                </select>

                                <!-- MAESTRÍA -->
                                <select id="posgrado_maestria" name="posgrado_maestria" style="display:none;margin-top:10px;">
                                    <option value="" disabled selected>Selecciona tu maestría</option>
                                    <option value="Maestría en Ingeniería de Software">Maestría en Ingeniería de Software</option>
                                    <option value="Maestría en Administración (MBA)">Maestría en Administración (MBA)</option>
                                    <option value="Maestría en Dirección de Proyectos">Maestría en Dirección de Proyectos</option>
                                    <option value="Maestría en Ciencias de Datos">Maestría en Ciencias de Datos</option>
                                    <option value="Maestría en Educación">Maestría en Educación</option>
                                    <option value="Maestría en Salud Pública">Maestría en Salud Pública</option>
                                    <option value="Maestría en Ingeniería Industrial">Maestría en Ingeniería Industrial</option>
                                    <option value="Otro">Otro</option>
                                </select>

                                <!-- DOCTORADO -->
                                <select id="posgrado_doctorado" name="posgrado_doctorado" style="display:none;margin-top:10px;">
                                    <option value="" disabled selected>Selecciona tu doctorado</option>
                                    <option value="Doctorado en Ingeniería">Doctorado en Ingeniería</option>
                                    <option value="Doctorado en Ciencias">Doctorado en Ciencias</option>
                                    <option value="Doctorado en Educación">Doctorado en Educación</option>
                                    <option value="Doctorado en Salud Pública">Doctorado en Salud Pública</option>
                                    <option value="Doctorado en Economía">Doctorado en Economía</option>
                                    <option value="Otro">Otro</option>
                                </select>

                                <label>Si eres aprendiz o egresado SENA, escribe tu numero de ficha, de lo contrario escribe "No aplica"</label>

                                <input type="text" id="numero_ficha" name="numero_ficha" required minlength="7" maxlength="7" inputmode="numeric" pattern="[0-9]{7,7}" placeholder="Ej: 12345 o No aplica">

                            </div>
                            <div id="navegacion_botones">
                                <button type="button" id="btn_volver">
                                    <svg width="30" height="30" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                        <path d="M3.57813 12.4981C3.5777 12.6905 3.65086 12.8831 3.79761 13.0299L9.7936 19.0301C10.0864 19.3231 10.5613 19.3233 10.8543 19.0305C11.1473 18.7377 11.1474 18.2629 10.8546 17.9699L6.13418 13.2461L20.3295 13.2461C20.7437 13.2461 21.0795 12.9103 21.0795 12.4961C21.0795 12.0819 20.7437 11.7461 20.3295 11.7461L6.14168 11.7461L10.8546 7.03016C11.1474 6.73718 11.1473 6.2623 10.8543 5.9695C10.5613 5.6767 10.0864 5.67685 9.79362 5.96984L3.84392 11.9233C3.68134 12.0609 3.57812 12.2664 3.57812 12.4961L3.57813 12.4981Z" fill="#fdfdfd" />
                                    </svg>
                                </button>
                                <button type="button" id="btn_fase4">Siguiente</button>
                            </div>

                        </div>

                        <!-- FASE 5  -->
                        <div id="fase_5">

                            <h3>Información complementaria del emprendedor</h3>

                            <div id="cont_fase_5">

                                <label>Eres un emprendedor que tiene...</label>

                                <select id="situacion_negocio" name="situacion_negocio">
                                    <option value="" disabled selected>Selecciona</option>
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Idea de negocio">Una idea de negocio</option>
                                    <option value="Unidad productiva">Una unidad productiva (informal)</option>
                                    <option value="Empresa persona natural">Una empresa como persona natural</option>
                                    <option value="Empresa persona jurídica">Una empresa como persona jurídica</option>
                                    <option value="Asociación">Una asociación</option>
                                </select>

                                <label>¿Pertenece a alguno de los siguientes programas especiales?</label>

                                <select id="programa" name="programa" required>
                                    <option value="" disabled selected>Selecciona</option>
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Jóvenes en paz">Jóvenes en paz</option>
                                    <option value="Indígenas amazónicos">Indígenas amazónicos</option>
                                    <option value="Parques nacionales">Parques nacionales</option>
                                    <option value="ICBF">ICBF</option>
                                    <option value="Economía popular">Economía popular</option>
                                    <option value="Ninguno">Cuidadores</option>
                                </select>

                                <label>¿Usted ejerce la actividad relacionada con el proyecto que desea presentar?</label>

                                <select id="ejercer_actividad_proyecto" name="ejercer_actividad_proyecto" required>
                                    <option value="" disabled selected hidden>Selecciona</option>
                                    <option value="SI">Sí</option>
                                    <option value="NO">No</option>
                                </select>

                                <label>¿Usted tiene empresa formalizada ante Cámara de Comercio?</label>

                                <select id="empresa_formalizada" name="empresa_formalizada" required>
                                    <option value="" disabled selected hidden>Selecciona</option>
                                    <option value="SI">Sí</option>
                                    <option value="NO">No</option>
                                </select>

                            </div>

                            <div id="navegacion_botones">
                                <button type="button" id="btn_volver">
                                    <svg width="30" height="30" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                        <path d="M3.57813 12.4981C3.5777 12.6905 3.65086 12.8831 3.79761 13.0299L9.7936 19.0301C10.0864 19.3231 10.5613 19.3233 10.8543 19.0305C11.1473 18.7377 11.1474 18.2629 10.8546 17.9699L6.13418 13.2461L20.3295 13.2461C20.7437 13.2461 21.0795 12.9103 21.0795 12.4961C21.0795 12.0819 20.7437 11.7461 20.3295 11.7461L6.14168 11.7461L10.8546 7.03016C11.1474 6.73718 11.1473 6.2623 10.8543 5.9695C10.5613 5.6767 10.0864 5.67685 9.79362 5.96984L3.84392 11.9233C3.68134 12.0609 3.57812 12.2664 3.57812 12.4961L3.57813 12.4981Z" fill="#fdfdfd" />
                                    </svg>
                                </button>
                                <button type="button" id="btn_fase5">Siguiente</button>

                            </div>

                        </div>


                        <!-- FASE 6  -->
                        <div id="fase_6">

                            <h3>Centro y orientador</h3>

                            <div id="cont_fase_6">

                                <label>¿Cuál es el centro de Desarrollo Empresarial que brinda la orientación?</label>

                                <select id="centro_orientacion" name="centro_orientacion" required>
                                    <option value="">-- Selecciona un centro --</option>

                                    <option value="CAB">Centro Agropecuario de Buga (CAB)</option>
                                    <option value="CBI">Centro de Biotecnología Industrial (CBI Palmira)</option>
                                    <option value="CDTI">Centro de Diseño Tecnológico Industrial (CDTI Cali)</option>
                                    <option value="CEAI">Centro de Electricidad y Automatización Industrial (CEAI Cali)</option>
                                    <option value="CGTS">Centro de Gestión Tecnológica de Servicios (CGTS Cali)</option>
                                    <option value="ASTIN">Centro Nacional de Asistencia Técnica a la Industria (ASTIN - Cali)</option>
                                    <option value="CTA">Centro de Tecnologías Agroindustriales (CTA - Cartago)</option>
                                    <option value="CLEM">Centro Latinoamericano de Especies Menores (CLEM - Tuluá)</option>
                                    <option value="CNP">Centro Náutico y Pesquero (CNP - Buenaventura)</option>
                                    <option value="CC">Centro de la Construcción (CC - Cali)</option>
                                </select>

                                <label>¿Cuál fue el orientador que brindó la orientación?</label>

                                <select id="orientador" name="orientador" required>
                                    <option value="" disabled selected>-- Selecciona primero un centro --</option>
                                    <option value="CAB">Carlos Alberto Bernal</option>
                                    <option value="CBI">Diana Carolina Rodríguez</option>
                                    <option value="CDTI">Jorge Iván Martínez</option>
                                </select>
                            </div>

                            <div id="navegacion_botones">
                                <button type="button" id="btn_volver">
                                    <svg width="30" height="30" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0 0 0)">
                                        <path d="M3.57813 12.4981C3.5777 12.6905 3.65086 12.8831 3.79761 13.0299L9.7936 19.0301C10.0864 19.3231 10.5613 19.3233 10.8543 19.0305C11.1473 18.7377 11.1474 18.2629 10.8546 17.9699L6.13418 13.2461L20.3295 13.2461C20.7437 13.2461 21.0795 12.9103 21.0795 12.4961C21.0795 12.0819 20.7437 11.7461 20.3295 11.7461L6.14168 11.7461L10.8546 7.03016C11.1474 6.73718 11.1473 6.2623 10.8543 5.9695C10.5613 5.6767 10.0864 5.67685 9.79362 5.96984L3.84392 11.9233C3.68134 12.0609 3.57812 12.2664 3.57812 12.4961L3.57813 12.4981Z" fill="#fdfdfd" />
                                    </svg>
                                </button>
                                <button type="submit" id="btn_fase6">Enviar formulario</button>
                            </div>

                    </form>

            </article>

        </section>

        <footer id="pie_pagina">

            <div id="cont_pie_pagina">

                <img src="../static/img/logocolombiaporlavidatrabajo.png" width="80" height="30" loading="eager">

                <img src="../static/img/mintrabajo.png" width="70" height="30" loading="eager">

            </div>

        </footer>

    </main>

    <script src="../static/js/validacion.js"></script>

</body>

</html>