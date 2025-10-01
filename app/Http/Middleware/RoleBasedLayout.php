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
        try {
            if (auth()->check()) {
                $user = auth()->user();
                
                // Ensure user is a proper User model instance
                if (!$user || !is_object($user) || !($user instanceof \App\Models\User)) {
                    \Log::warning('RoleBasedLayout: Invalid user object', [
                        'user' => $user,
                        'type' => gettype($user),
                        'is_user_instance' => $user instanceof \App\Models\User
                    ]);
                    $request->attributes->set('layout', 'sidebar');
                    return $next($request);
                }
                
                // Load role if not already loaded
                if (!$user->relationLoaded('role')) {
                    $user->load('role');
                }
                
                // Determine layout based on user role
                if ($user->role && is_object($user->role) && isset($user->role->name) && in_array($user->role->name, ['mahasiswa', 'komti', 'wakomti', 'sekretaris_kelas'])) {
                    // Mobile-first layout for students
                    $request->attributes->set('layout', 'mobile');
                } else {
                    // Sidebar layout for PIC and admin roles
                    $request->attributes->set('layout', 'sidebar');
                }
            } else {
                $request->attributes->set('layout', 'sidebar');
            }
        } catch (\Exception $e) {
            \Log::error('RoleBasedLayout: Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $request->attributes->set('layout', 'sidebar');
        }
        
        return $next($request);
    }
}
