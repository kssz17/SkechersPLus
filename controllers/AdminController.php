<?php
require_once '/../models/UserModel.php';
require_once '/../models/ArticuloModel.php';

class AdminController {

    private $userModel;
    private $articuloModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->articuloModel = new ArticuloModel();
    }

    // Usuarios
    public function listarUsuarios() {
        return $this->userModel->getAll();
    }

    public function eliminarUsuario($id) {
        return $this->userModel->delete($id) ? ['success'=>true,'message'=>'Usuario eliminado'] : ['success'=>false,'message'=>'Error al eliminar'];
    }

    // Artículos
    public function listarArticulos() {
        return $this->articuloModel->getAll();
    }

    public function eliminarArticulo($id) {
        return $this->articuloModel->delete($id) ? ['success'=>true,'message'=>'Artículo eliminado'] : ['success'=>false,'message'=>'Error al eliminar'];
    }
}
