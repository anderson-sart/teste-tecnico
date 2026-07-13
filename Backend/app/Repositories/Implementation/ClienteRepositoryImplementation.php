<?php

/**
 * Implementação do Repository de Cliente.
 */
class ClienteRepositoryImplementation extends BaseRepositoryImplementation implements ClienteRepositoryInterface {
    
    public function __construct() {
        parent::__construct(Cliente::class);
    }
}
