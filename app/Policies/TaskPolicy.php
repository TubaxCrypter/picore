<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Tüm görevlerin görüntülenip görüntülenemeyeceğini belirler.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Belirli bir görevin görüntülenip görüntülenemeyeceğini belirler.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Kullanıcının yeni görev oluşturup oluşturamayacağını belirler.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Kullanıcının bir görevi düzenleyip düzenleyemeyeceğini belirler.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Kullanıcının bir görevi silip silemeyeceğini belirler.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Kullanıcının görevleri geri yükleyip yükleyemeyeceğini belirler.
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * Kullanıcının görevleri kalıcı olarak silip silemeyeceğini belirler.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
} 