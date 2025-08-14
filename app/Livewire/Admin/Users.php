<?php

namespace App\Livewire\Admin;

use App\Enums\UserStatus;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    protected $paginationTheme='bootstrap';
    public $search;

    // ریست کردن صفحه هنگام تغییر جستجو
    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function changeUserStatus($id)
    {

        $user = User::query()->find($id);

        if ($user->status == UserStatus::Active->value) {
            $user->update([
                'status' => UserStatus::InActive->value
            ]);
        } else {
            $user->update([
                'status' => UserStatus::Active->value
            ]);
        }
    }

    public function render()
    {
        $users = User::query()
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('mobile', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.admin.users', compact('users'));
    }
}
