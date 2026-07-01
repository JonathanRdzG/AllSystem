<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

abstract class BaseCrudController extends Controller
{
    protected string $modelClass;
    protected string $page;
    protected array $with = [];
    protected array $search = [];
    protected string $resourceName = 'registro';

    public function index(Request $request): Response
    {
        $search = trim((string) $request->input('search', ''));

        $query = $this->modelClass::query()->with($this->with);

        if ($search !== '' && $this->search !== []) {
            $query->where(function (Builder $builder) use ($search): void {
                foreach ($this->search as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $builder->{$method}($column, 'like', "%{$search}%");
                }
            });
        }

        $rows = $query
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render("{$this->page}/Index", [
            'rows' => $rows,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render("{$this->page}/Create", $this->extraPayload());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $this->modelClass::create($data);

        return $this->redirectToIndex("{$this->resourceTitle()} creada correctamente.");
    }

    public function edit(int $id): Response
    {
        $record = $this->modelClass::query()->findOrFail($id);
        return Inertia::render("{$this->page}/Edit", ['record' => $record] + $this->extraPayload());
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $record = $this->modelClass::query()->findOrFail($id);
        $record->update($request->validate($this->rules()));

        return $this->redirectToIndex("{$this->resourceTitle()} actualizada correctamente.");
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->modelClass::query()->findOrFail($id)->delete();

        return back()->with('success', "{$this->resourceTitle()} eliminada correctamente.");
    }

    protected function routeBase(): string
    {
        return str()->kebab(class_basename($this->modelClass))->plural()->toString();
    }

    protected function extraPayload(): array
    {
        return [];
    }

    protected function resourceTitle(): string
    {
        return str($this->resourceName)->ucfirst()->toString();
    }

    protected function redirectToIndex(string $message): RedirectResponse
    {
        return redirect()
            ->route($this->routeBase().'.index')
            ->with('success', $message);
    }

    abstract protected function rules(): array;
}
