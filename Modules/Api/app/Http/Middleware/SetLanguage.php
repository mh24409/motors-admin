<?php

namespace Modules\Api\Http\Middleware;

use Closure;
use App\Models\Language;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = $request->language;
        if (!$language) {
            $language = $request->header('x-language');
        }

        if (!$language) {
            $language = Language::where('is_default', 1)->first()?->code;
        }

        if ($language) {
            app()->setLocale($language);
        }

        return $next($request);
    }
}