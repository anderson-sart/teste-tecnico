<?php

/**
 * Input padronizado para consultas paginadas.
 * Equivalente ao InputData do padrão UseCase.
 */
class PaginationInputData {
    
    public readonly string $search;
    public readonly string $sort_by;
    public readonly string $sort_dir;
    public readonly int $page;
    public readonly int $per_page;
    
    public function __construct(
        string $search = '',
        string $sort_by = 'id',
        string $sort_dir = 'DESC',
        int $page = 1,
        int $per_page = 10
    ) {
        $this->search = trim($search);
        $this->sort_by = $sort_by;
        $this->sort_dir = strtoupper($sort_dir) === 'ASC' ? 'ASC' : 'DESC';
        $this->page = max(1, $page);
        $this->per_page = min(100, max(1, $per_page));
    }
    
    /**
     * Cria instância a partir dos query params da request
     */
    public static function fromRequest(string $defaultSortBy = 'id'): self {
        return new self(
            search: Request::query('search', ''),
            sort_by: Request::query('sort_by', $defaultSortBy),
            sort_dir: Request::query('sort_dir', 'DESC'),
            page: (int) Request::query('page', 1),
            per_page: (int) Request::query('per_page', 10),
        );
    }
    
    /**
     * Converte para array compatível com Model::paginate()
     */
    public function toArray(): array {
        return [
            'search' => $this->search,
            'sort_by' => $this->sort_by,
            'sort_dir' => $this->sort_dir,
            'page' => $this->page,
            'per_page' => $this->per_page,
        ];
    }
}
