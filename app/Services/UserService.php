<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Paginated list of users.
     */
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->where('is_deleted', 0)->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Find a user by id or throw ModelNotFoundException.
     */
    public function find(int $id): User
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update a user by id with data (handles password hashing).
     * $data may contain 'password' — if empty it will be removed.
     */
    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        // If password is present and not empty, hash it. Otherwise remove it.
        if (array_key_exists('password', $data)) {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
        }

        // Filter only fillable (optional).
        $fillableData = Arr::only($data, $user->getFillable());
        $user->fill($fillableData);
        $user->save();

        return $user;
    }


    public function assignRate($id, $rate)
    {
        return DB::transaction(function () use ($id, $rate) {
            $user = User::findOrFail($id);
            $user->assign_rate = $rate;
            $user->save();

            return $user;
        });
    }
}
