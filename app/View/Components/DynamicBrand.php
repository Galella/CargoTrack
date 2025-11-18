<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\AvatarService;

class DynamicBrand extends Component
{
    public $brandHtml;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $displayName = $user->name ?? $user->email;

            // Generate initials
            $initials = AvatarService::getInitials($displayName);

            // Generate background color
            $backgroundColor = AvatarService::getBackgroundColor($displayName);

            $this->brandHtml = "
                <span class='brand-avatar' style='display: inline-block; width: 33px; height: 33px; border-radius: 50%; background-color: {$backgroundColor}; text-align: center; line-height: 33px; color: white; font-size: 14px; margin-right: 8px;'>
                    {$initials}
                </span>
                <span class='brand-text font-weight-light'>" . e($user->name ?? $user->email) . "</span>
            ";
        } else {
            $this->brandHtml = "
                <img src='vendor/adminlte/dist/img/AdminLTELogo.png'
                     alt='Admin Logo'
                     class='brand-image img-circle elevation-3'
                     style='opacity:.8'>
                <span class='brand-text font-weight-light'>
                    <b>Cargo</b>Track
                </span>
            ";
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dynamic-brand');
    }
}
