<?php
// backend/app/Http/Middleware/LogRequests.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    public function handle(Request $request, Closure $next)
    {
        $log = sprintf(
            "[%s] %s %s: %s",
            now()->toDateTimeString(),
            $request->method(),
            $request->path(),
            json_encode($request->all())
        );

        file_put_contents(storage_path('logs/log.txt'), $log . PHP_EOL, FILE_APPEND);

        return $next($request);
    }
}