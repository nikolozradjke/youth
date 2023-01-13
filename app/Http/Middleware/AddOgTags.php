<?php

namespace App\Http\Middleware;

use Closure;
use App\OgTag;

class AddOgTags
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        # defayult tag: used if route has no ogTag registered
        $defaultOgTag = OgTag::where('route_name', OgTag::$DEFAULT_ROUTE)->first();

        # get tag by route's name
        $routeName = $request->getPathInfo();

        # Remove Locales
        $locales = ['/en', '/ka'];
        if (in_array(substr($routeName, 0, 3), $locales))
            $routeName = substr($routeName, 3);
        $ogTag = OgTag::where('route_name', $routeName)->first();

        # if route has no tag use default
        if ($ogTag == null) {
            $ogTag = $defaultOgTag;
        }

        # if no default tag is specified use hardcoded
        if ($ogTag == null) {
            $ogTag = new OgTag([
                'title' => 'Youth Platform',
                'description' => 'Youth Platform',
                'image' => '/storage/faker_images/image.png'
            ]);
        }

        $request->request->add(['ogTag' => $ogTag]);
        return $next($request);
    }
}
