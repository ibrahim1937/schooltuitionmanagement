<?php

namespace App\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Log;
use Carbon\Carbon;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // return $next($request);
        // If user is not logged in...
    if (!Auth::check()) {
        return $next($request);
      }
   
      $user = Auth::user();
   
      $now = Carbon::now();

      $log = Log::where('id_user' , $user->id )->latest('last_seen_at')->first();
   
      $last_seen = Carbon::parse($log->last_seen_at);
   
      $absence = $now->diffInMinutes($last_seen);
   
      // If user has been inactivity longer than the allowed inactivity period
      if ($absence > config('session.lifetime')) {
        Auth::logout();

        $log->update([
            'end_session_at' => $now->format('Y-m-d H:i:s')
        ]);
   
        $request->session()->invalidate();
        
   
        // return $next($request);
        return redirect('/');
      }
   
      $log->last_seen_at = $now->format('Y-m-d H:i:s');
      $log->save();
   
      return $next($request);
    }
}
