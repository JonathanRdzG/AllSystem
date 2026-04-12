<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

abstract class BaseCrudController extends Controller
{
    protected string $modelClass;
    protected string $page;
    protected array $with = [];

    public function index(): Response
    {
        $rows = $this->modelClass::query()->with($this->with)->latest('id')->paginate(15);
        return Inertia::render("{$this->page}/Index", ['rows' => $rows]);
    }

    public function create(): Response
    {
        return Inertia::render("{$this->page}/Create", $this->extraPayload());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $this->modelClass::create($data);

        return redirect()->route($this->routeBase().'.index');
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

        return redirect()->route($this->routeBase().'.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->modelClass::query()->findOrFail($id)->delete();
        return back();
    }

    protected function routeBase(): string
    {
        return str()->kebab(class_basename($this->modelClass))->plural()->toString();
    }

    protected function extraPayload(): array
    {
        return [];
    }

    abstract protected function rules(): array;
}
