<?php
require_once '/../models/PedidoModel.php';
require_once '/../models/ArticuloModel.php';

class PedidoController {

    private $pedidoModel;
    private $articuloModel;

    public function __construct() {
        $this->pedidoModel = new PedidoModel();
        $this->articuloModel = new ArticuloModel();
    }

    public function crearPedido($userId, $carrito) {
        if(empty($carrito)) return ['success'=>false,'message'=>'Carrito vacío'];

        $total = 0;
        foreach($carrito as $item) {
            $producto = $this->articuloModel->getById($item['id']);
            if(!$producto) continue;
            $total += $producto['precio'] * $item['quantity'];
        }

        $pedidoId = $this->pedidoModel->create($userId, $total);
        if(!$pedidoId) return ['success'=>false,'message'=>'Error al crear pedido'];

        foreach($carrito as $item) {
            $this->pedidoModel->addDetalle($pedidoId, $item['id'], $item['quantity']);
        }

        return ['success'=>true,'message'=>'Pedido confirmado','pedidoId'=>$pedidoId];
    }

    public function listarPedidos($userId) {
        return $this->pedidoModel->getByUser($userId);
    }
}
