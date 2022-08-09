<?php
	require_once 'app/models/DocenteDAO.class.php';
	require_once 'app/utils/Mail.class.php';

function importarDocentes(array $docentes, int $centroId, array $opciones = [])
{
    $sobreEscribirPass = isset($opciones['sobreEscribirPass']) ? $opciones['sobreEscribirPass'] : false;
    $sobreEscribirDatos = isset($opciones['sobreEscribirDatos']) ? $opciones['sobreEscribirDatos'] : false;
    $enviarMailBienvenida = isset($opciones['enviarMailBienvenida']) ? $opciones['enviarMailBienvenida'] : true;
    
    $status = [];

    foreach ($docentes as $docente) {
        $pass = bin2hex(random_bytes(10));
        try {
            $usuario_id = UserControl::register($docente['email'], $pass); // Tenemos que registrar al usuario que por defecto se registra como docente.
            $newUser = true; 
        } catch (\PDOException $th) {
            if($th->getCode() == 23000){
                $usuario = (new UsuariosDAO())->getUsuarioByEmail($docente['email']);
                $usuario_id = $usuario['id'];
                $newUser = false; 
                if($usuario){
                    if($sobreEscribirPass){
                        UserControl::updatePass($usuario_id, $pass);
                    }
                }else{
                    $usuario_id = false;
                }
            }else{
                $usuario_id = false; 
            }
        }
        //var_dump($usuario_id);
        if($usuario_id){
            $docenteData['usuario_id'] = $usuario_id;
            $docenteData['centro_id'] = $centroId;
            $docenteData['estado'] = 'Perfil incompleto';
            if($newUser){
                (new DocenteDAO())->insert($docenteData);
            }else if($sobreEscribirDatos){
                (new DocenteDAO())->update($docenteData);
            }
            if(($newUser || $sobreEscribirPass) && $enviarMailBienvenida){
                $result = Mail::emailBienvenida($docente['email'], $pass);
                if ($result) {
                    $status[$docente['email']] = ['ok' => true];
                }else{
                    $status[$docente['email']] = ['ok' => false, 'error' => 'Error al enviar el email de bienvenida'];
                }
            }else{
                $status[$docente['email']] = ['ok' => true];
            }
        }else{
            $status[$docente['email']] = ['ok' => false, 'error' => 'Error al crear el usuario'];
        }
        

    }
    return $status; 

}