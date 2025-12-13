<?php
require_once '/../models/ArticuloModel.php';

class ArticuloController {

    private $articuloModel;

    public function __construct() {
        $this->articuloModel = new ArticuloModel();
    }

    public function listarArticulos() {
        return $this->articuloModel->getAll();
    }

    public function agregarArticulo($data) {
        if(empty($data['nombre']) || empty($data['precio'])) {
            return ['success'=>false,'message'=>'Campos obligatorios faltantes'];
        }
        return $this->articuloModel->create($data) ? ['success'=>true,'message'=>'Artículo agregado'] : ['success'=>false,'message'=>'Error al agregar'];
    }

    public function actualizarArticulo($id, $data) {
        return $this->articuloModel->update($id, $data) ? ['success'=>true,'message'=>'Artículo actualizado'] : ['success'=>false,'message'=>'Error al actualizar'];
    }

    public function eliminarArticulo($id) {
        return $this->articuloModel->delete($id) ? ['success'=>true,'message'=>'Artículo eliminado'] : ['success'=>false,'message'=>'Error al eliminar'];
    }
}
