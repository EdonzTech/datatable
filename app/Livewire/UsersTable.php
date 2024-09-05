<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    public $perPage = '10';
    public $search = '';
    public $admin = '';

    public $sortBy = 'created_at';
    public $sortDir = 'DESC';


    public function delete(User $user) {
        $user->delete();
    }

    public function setsortBy($sortByField) {
        if($this->sortBy === $sortByField ){
            $this->sortDir = ($this->sortDir == "ASC") ?  'DESC' : "ASC";
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }
    public function render()
    {
        return view('livewire.users-table',
                ['users' => User::search($this->search)
                        ->when($this->admin !== '', function($query)
                            {
                                $query->where('is_admin', $this->admin);
                            }
                        )
                        ->orderBy($this->sortBy, $this->sortDir)
                        ->paginate($this->perPage)]);
              
    }
}
