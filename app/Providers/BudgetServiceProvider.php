<?php

namespace App\Providers;

use App\Budget;
use App\User;
use Illuminate\Support\ServiceProvider;

class BudgetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Budget::creating(
            function ($budget) {
                $budget->status_id = Budget::STATUS_PENDING;

                $budget->user()->associate(
                    User::updateOrCreate(
                        [
                            'email' => request()->get('email')
                        ],
                        [
                            'phone' => request()->get('phone'),
                            'address' => request()->get('address')
                        ]
                    )
                );
            }
        );
    }
}
