<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interface\BaseRepositoryInterface;

class BaseRepositoryImplementation implements BaseRepositoryInterface {

    protected string $modelClass;

    public function __construct(string $modelClass) {
        $this->modelClass = $modelClass;
    }

    public function all(int $limit = 1000): array {
        return $this->modelClass::limit($limit)->get()->toArray();
    }

    private function applySearch($query, string $search): void {
        $searchable = $this->modelClass::$searchable ?? [];
        if ($search === '' || empty($searchable)) return;

        $query->where(function($q) use ($search, $searchable) {
            foreach ($searchable as $field) {
                $q->orWhereRaw("unaccent(CAST({$field} AS TEXT)) ILIKE unaccent(?)", ["%{$search}%"]);
            }
        });
    }

    public function paginate(array $params = []): array {
        $model   = new $this->modelClass;
        $search  = trim($params['search'] ?? '');
        $sortBy  = $params['sort_by'] ?? $model->getKeyName();
        $sortDir = strtoupper($params['sort_dir'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';
        $page    = max(1, (int)($params['page'] ?? 1));
        $perPage = min(100, max(1, (int)($params['per_page'] ?? 10)));

        if (!in_array($sortBy, array_merge($model->getFillable(), [$model->getKeyName()]))) {
            $sortBy = $model->getKeyName();
        }

        $query = $this->modelClass::query();
        $this->applySearch($query, $search);

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
        return $record->update($data);
    }

    public function delete(int $id): bool {
        $record = $this->modelClass::find($id);
        if (!$record) return false;
        return (bool) $record->delete();
    }

    public function findBy(string $field, mixed $value): ?array {
        return $this->modelClass::where($field, $value)->first()?->toArray();
    }

    public function count(string $search = ''): int {
        $query = $this->modelClass::query();
        $this->applySearch($query, trim($search));
        return $query->count();
    }

    public function sum(string $column): float {
        return (float) $this->modelClass::sum($column);
    }
}
