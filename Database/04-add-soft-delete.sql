-- Adicionar coluna deleted_at para soft delete

ALTER TABLE produtos ADD COLUMN deleted_at TIMESTAMP NULL;
ALTER TABLE clientes ADD COLUMN deleted_at TIMESTAMP NULL;
