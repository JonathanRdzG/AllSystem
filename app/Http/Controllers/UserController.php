<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends BaseCrudController
{
    protected string $modelClass = User::class;
    protected string $page = 'Users';

    protected function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'string', 'min:8'],
            'active' => ['boolean'],
        ];
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['password'] = Hash::make($data['password'] ?? 'password');
        User::create($data);
        return redirect()->route('users.index');
    }

    public function edit(int $id): Response
    {
        $record = User::query()->findOrFail($id);
        return Inertia::render('Users/Edit', [
            'record' => $record,
            'companies' => Company::query()->select('id', 'name')->get(),
            'branches' => Branch::query()->select('id', 'name')->get(),
        ]);
    }

    protected function extraPayload(): array
    {
        return [
            'companies' => Company::query()->select('id', 'name')->get(),
            'branches' => Branch::query()->select('id', 'name')->get(),
        ];
    }
}
