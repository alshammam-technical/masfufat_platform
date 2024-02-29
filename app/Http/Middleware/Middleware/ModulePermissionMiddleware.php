<?php

namespace App\Http\Middleware;

use App\CPU\Helpers;
use Brian2694\Toastr\Facades\Toastr;
use Closure;

class ModulePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {
        if (Helpers::module_permission_check($module)) {
            foreach($request->all() as $key => $req){
                if(Helpers::input_permission_check_edit($key)){

                }else{
                    if($key !== 'lang' && $key !== 'lang[]'){
                        unset($request[$key]);
                    }
                }
            }
            return $next($request);
        }

        Toastr::error( Helpers::translate('You do not have access'));
        return back();
    }
}
