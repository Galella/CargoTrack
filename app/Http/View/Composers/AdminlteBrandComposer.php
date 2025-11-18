<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\AvatarService;

class AdminlteBrandComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $displayName = $user->name ? $user->name : $user->email;
            
            // Generate initials
            $initials = AvatarService::getInitials($displayName);
            
            // Generate background color
            $backgroundColor = AvatarService::getBackgroundColor($displayName);
            
            $view->with('dynamicBrandHtml', "
                <span class='brand-avatar' style='display: inline-block; width: 33px; height: 33px; border-radius: 50%; background-color: {$backgroundColor}; text-align: center; line-height: 33px; color: white; font-size: 14px; margin-right: 8px;'>
                    {$initials}
                </span>
                <span class='brand-text font-weight-light'>".($user->name ? $user->name : $user->email)."</span>
            ");
        } else {
            // Default brand if not authenticated
            $view->with('dynamicBrandHtml', '
                <img src="vendor/adminlte/dist/img/AdminLTELogo.png" 
                     alt="Admin Logo" 
                     class="brand-image img-circle elevation-3" 
                     style="opacity:.8">
                <span class="brand-text font-weight-light">
                    <b>Cargo</b>Track
                </span>
            ');
        }
    }
}