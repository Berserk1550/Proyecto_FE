<?php
require_once "../conexion.php";
require_once "../models/limpiador.php";
require_once "../models/m_orientadores.php";

class Emprendedor {
    private $db;

    public function __construct($conn) {
        $this->db = $conn;
    }

    //Validamos si el documento existe
    public function buscarDocumento($documento) {
        $sql = "SELECT numero_id 
                FROM orientacion_rcde2025_valle 
                WHERE numero_id = ? 
                LIMIT 1";

        $stmt = $this->db->prepare($sql); 
        if (!$stmt) {
            die("Error prepare: " . $this->db->error);
        }

        $stmt->bind_param("s", $documento);
        $stmt->execute();

        $result = $stmt->get_result();
        $existe = $result->num_rows > 0;

        $stmt->close();
        return $existe;
    }

    
    public function insertar($data) {
        $nombres = Vigilante::sanitizarTexto($data['nombre_emprendedor'] ?? '');
        $apellidos = Vigilante::sanitizarTexto($data['apellido_emprendedor'] ?? '');
        $tipo_id = Vigilante::sanitizarTexto($data['tipo_documento_emprendedor'] ?? '');
        $numero_id = Vigilante::sanitizarDocumento($data['documento_emprendedor'] ?? '');
        $correo = Vigilante::sanitizarCorreo($data['correo_emprendedor'] ?? '');
        $celular = Vigilante::sanitizarTelefono($data['telefono_emprendedor'] ?? '');
        $fecha_nacimiento = Vigilante::sanitizarTexto($data['fecha_nacimiento_emprendedor'] ?? '');
        $sexo = Vigilante::sanitizarTexto($data['sexo_emprendedor'] ?? '');
        $pais = Vigilante::sanitizarTexto($data['paises'] ?? '');
        $nacionalidad = Vigilante::sanitizarTexto($data['nacionalidad'] ?? '');
        $departamento = Vigilante::sanitizarTexto($data['departamento'] ?? '');
        $municipio = Vigilante::sanitizarTexto($data['municipio'] ?? '');
        $clasificacion = Vigilante::sanitizarTexto($data['clasificacion'] ?? '');
        $discapacidad = Vigilante::sanitizarTexto($data['discapacidad'] ?? '');
        $tipo_emprendedor = Vigilante::sanitizarTexto($data['tipo_emprendedor'] ?? '');
        $nivel_formacion = Vigilante::sanitizarTexto($data['nivel_formacion'] ?? '');
        $carrera = Vigilante::sanitizarTexto($data['carrera'] ?? '');
        $ficha = Vigilante::sanitizarFicha($data['numero_ficha'] ?? '');
        $situacion_negocio = Vigilante::sanitizarTexto($data['situacion_negocio'] ?? '');
        $programa = Vigilante::sanitizarTexto($data['programa'] ?? '');
        $ejercer_actividad = Vigilante::sanitizarTexto($data['ejercer_actividad_proyecto'] ?? '');
        $empresa_formalizada = Vigilante::sanitizarTexto($data['empresa_formalizada'] ?? '');
        $centro_orientacion = Vigilante::sanitizarTexto($data['centro_orientacion'] ?? '');
        $orientador = Vigilante::sanitizarTexto($data['orientador'] ?? '');

        $orientadoresModel = new Orientadores($this->db);
        $lista = $orientadoresModel->listarOrientadores();

        $orientador_id = null;
        foreach ($lista as $o) {
            $nombreCompleto = $o['nombres'] . " " . $o['apellidos'];
            if ($nombreCompleto === $orientador) {
                $orientador_id = $o['id_orientador'];
                break;
            }
        }

        // Inserción
        $stmt = $this->db->prepare("INSERT INTO orientacion_rcde2025_valle 
            (nombres, apellidos, tipo_id, numero_id, correo, celular, fecha_nacimiento, sexo, pais, nacionalidad, departamento, municipio, clasificacion, discapacidad, tipo_emprendedor, nivel_formacion, carrera, ficha, situacion_negocio, programa, ejercer_actividad_proyecto, empresa_formalizada, centro_orientacion, orientador, orientador_id, fecha_registro, rol, estado_proceso) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'emprendedor', 'pendiente')");

        $stmt->bind_param("ssssssssssssssssssssssss", 
            $nombres, $apellidos, $tipo_id, $numero_id, $correo, $celular, $fecha_nacimiento, $sexo, $pais, $nacionalidad, $departamento, $municipio, $clasificacion, $discapacidad, $tipo_emprendedor, $nivel_formacion, $carrera, $ficha, $situacion_negocio, $programa, $ejercer_actividad, $empresa_formalizada, $centro_orientacion, $orientador, $orientador_id);

        return $stmt->execute();
    }

      /*   // Buscar orientador por su id(doc)
        $orientador_id = $this->buscarOrientadorId($orientador);

        $stmt = $this->db->prepare("INSERT INTO orientacion_rcde2025_valle 
            (nombres, apellidos, tipo_id, numero_id, correo, celular, fecha_nacimiento, sexo, pais, nacionalidad, departamento, municipio, clasificacion, discapacidad, tipo_emprendedor, nivel_formacion, carrera, ficha, situacion_negocio, programa, ejercer_actividad_proyecto, empresa_formalizada, centro_orientacion, orientador, orientador_id, fecha_registro, rol, estado_proceso) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'emprendedor', 'pendiente')");

        $stmt->bind_param("ssssssssssssssssssssssss", 
            $nombres, $apellidos, $tipo_id, $numero_id, $correo, $celular, $fecha_nacimiento, $sexo, $pais, $nacionalidad, $departamento, $municipio, $clasificacion, $discapacidad, $tipo_emprendedor, $nivel_formacion, $carrera, $ficha, $situacion_negocio, $programa, $ejercer_actividad, $empresa_formalizada, $centro_orientacion, $orientador, $orientador_id);

        return $stmt->execute();
    }

    //  nombre del orientador
    private function buscarOrientadorId($orientador) {
        $stmt = $this->db->prepare("SELECT id FROM orientadores WHERE nombre = ?");
        $stmt->bind_param("s", $orientador);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($fila = $resultado->fetch_assoc()) {
            return $fila['id'];
        }
        return null;
    } */
}
?>