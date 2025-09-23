<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedLayout
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Determine layout based on user role
            if ($user->role && in_array($user->role->name, ['mahasiswa', 'komti', 'wakomti', 'sekretaris_kelas'])) {
                // Mobile-first layout for students
                $request->attributes->set('layout', 'mobile');
            } else {
                // Sidebar layout for PIC and admin roles
                $request->attributes->set('layout', 'sidebar');
            }
        }
        
        return $next($request);
    }
}
