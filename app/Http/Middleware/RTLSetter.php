<?php

namespace App\Http\Middleware;

use App\Providers\GenericHelperServiceProvider;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class RTLSetter extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $actionName = $request->route()->getActionMethod();
        if (in_array($actionName, ['install']) || (GenericHelperServiceProvider::getSiteDirection() == 'ltr')) {
            return $response;
        }

        $buffer = $response->getContent();

        $replacePreps = [
            // Margins
            '/mr-/' => 'mtl-',
            '/ml-/' => 'mtr-',
            // Paddings
            '/pr-/' => 'ptl-',
            '/pl-/' => 'ptr-',
            // Borders
            '/border-left/' => 'brdr-',
            '/border-right/' => 'brdl-',
            // Flexs
            '/flex-row/' => 'flexr-',
            '/flex-row-reverse/' => 'flexrr-',
            '/flex-row-no-rtl/' => 'flex-row-nortl',
        ];

        $replace = [
            // Margins
            '/mtl-/' => 'ml-',
            '/mtr-/' => 'mr-',
            // Paddings
            '/ptr-/' => 'pr-',
            '/ptl-/' => 'pl-',
            // Borders
            '/brdr-/' => 'border-right',
            '/brdl-/' => 'border-left',
            // Flexs
            '/flexr-/' => 'flex-row-reverse',
            '/flexrr-/' => 'flex-row',
            '/flex-row-nortl/'=> 'flex-row',
        ];

        $buffer = preg_replace(array_keys($replacePreps), array_values($replacePreps), $buffer);
        $buffer = preg_replace(array_keys($replace), array_values($replace), $buffer);

        $response->setContent($buffer);

        return $response;
    }
}
