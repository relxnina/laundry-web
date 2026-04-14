<?php
require_once __DIR__ . '/../models/Service.php';

class ServiceController {

    public function getServices() {
        $service = new Service();
        return $service->getAll();
    }

    public function getServiceById($id) {
        $service = new Service();
        return $service->find($id);
    }
}