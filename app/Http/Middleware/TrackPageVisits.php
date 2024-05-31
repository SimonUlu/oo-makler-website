<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrackPageVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Identifizieren der Route-Parameter-ID
        $id = $request->route('id');

        // Cache-Schlüssel konstruieren
        $cacheKey = "immobilien:details:visits:{$id}";

        // Prüfen, ob der Schlüssel im Cache vorhanden ist
        if (! Cache::has($cacheKey)) {
            // Wert initialisieren und für 24 Stunden speichern
            Cache::put($cacheKey, 0, 1440); // TTL in Minuten (24 Stunden * 60 Minuten)
        }

        // Inkrementieren des Click Counts für die ID im Cache
        $visitCount = Cache::increment($cacheKey);

        // Optionale: Speichern des aktualisierten Zählstands mit dem gleichen Ablaufdatum
        // Cache::put($cacheKey, $visitCount, 1440);

        return $next($request);
    }
}
