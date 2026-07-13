<?php

class BaseRepositoryImplementation implements BaseRepositoryInterface {

    protected string $modelClass;

    public function __construct(string $modelClass) {
        $this->modelClass = $modelClass;
    }

    public function all(): array {
        return $this->modelClass::all()->toArray();
    }

    public function paginate(array $params = []): array {
        $model      = new $this->modelClass;
        $search     = trim($params['search'] ?? '');
        $sortBy     = $params['sort_by'] ?? $model->getKeyName();
        $sortDir    = strtoupper($params['sort_dir'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';
        $page       = max(1, (int)($params['page'] ?? 1));
        $perPage    = min(100, max(1, (int)($params['per_page'] ?? 10)));
        $searchable = $this->modelClass::$searchable ?? [];

        // Validate sort column
        if (!in_array($sortBy, array_merge($model->getFillable(), [$model->getKeyName()]))) {
            $sortBy = $model->getKeyName();
        }

        $query = $this->modelClass::query();

        if ($search !== '' && !empty($searchable)) {
            $query->where(function($q) use ($search, $searchable) {
                foreach ($searchable as $field) {
                    $q->orWhereRaw("unaccent(CAST({$field} AS TEXT)) ILIKE unaccent(?)", ["%{$search}%"]);
                }
            });
        }

        $total   = $query->count();
        $results = $query->orderBy($sortBy, $sortDir)
                         ->offset(($page - 1) * $perPage)
                         ->limit($perPage)
                         ->get();

        return [
            'data'      => $results->toArray(),
            'total'     => $total,
            'page'      => $page,
            'per_page'  => $perPage,
            'last_page' => (int) ceil($total / $perPage),
        ];
    }

    public function find(int $id): ?array {
        $result = $this->modelClass::find($id);
        return $result?->toArray();
    }

    public function create(array $data): array {
        return $this->modelClass::create($data)->toArray();
    }

    public function update(int $id, array $data): bool {
        $record = $this->modelClass::find($id);
        if (!$record) return false;
        $record->update($data);
        return true;
    }

    public function delete(int $id): bool {
        $record = $this->modelClass::find($id);
        if (!$record) return false;
        $record->delete();
        return true;
    }

    public function findBy(string $field, mixed $value): ?array {
        return $this->modelClass::where($field, $value)->first()?->toArray();
    }

    public function count(string $search = ''): int {
        return $this->modelClass::count();
    }

    public function sum(string $column): float {
        return (float) $this->modelClass::sum($column);
    }
}
