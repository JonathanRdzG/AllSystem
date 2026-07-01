<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends BaseCrudController
{
    protected string $modelClass = User::class;
    protected string $page = 'Users';
    protected array $with = ['company', 'branch', 'roles'];
    protected array $search = ['name', 'email'];
    protected string $resourceName = 'usuario';

    protected function rules(): array
    {
        $userId = request()->route('user');
        $passwordRules = request()->isMethod('post')
            ? ['required', 'string', 'min:8', 'confirmed']
            : ['nullable', 'string', 'min:8', 'confirmed'];

        return [
            'company_id' => ['required', 'exists:companies,id'],
            'branch_id' => [
                'required',
                Rule::exists('branches', 'id')->where(
                    fn ($query) => $query->where('company_id', request('company_id'))
                ),
            ],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120', Rule::unique('users', 'email')->ignore($userId)],
            'password' => $passwordRules,
            'active' => ['nullable', 'boolean'],
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::query()->findOrFail($id);
        $data = $request->validate($this->rules());

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function edit(int $id): Response
    {
        $record = User::query()->findOrFail($id);
        return Inertia::render('Users/Edit', [
            'record' => $record,
            'companies' => Company::query()->select('id', 'name')->orderBy('name')->get(),
            'branches' => Branch::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
        ]);
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->orderBy('name')->get(),
            'branches' => Branch::query()->select('id', 'company_id', 'name')->orderBy('name')->get(),
        ];
    }
}
