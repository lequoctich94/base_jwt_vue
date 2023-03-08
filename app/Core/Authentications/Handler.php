<?php

namespace App\Core\Authentications;

use App\Exceptions\InternalErrorException;
use Illuminate\Support\Facades\App;
use App\Core\Authentications\Internal\InternalInterface;
use App\Core\Authentications\SSO\SSOInterface;
use App\Core\Authentications\Internal\Def\Authenticate as Def;
use Illuminate\Support\Facades\Log;

class Handler
{
    protected $auth_type;
    protected $guard;
    protected $service_type;
    protected $info_data;

    /**
     * make input data
     */
    protected function make(array $input)
    {
        $this->auth_type     = $input['type']    ?? config('constants.authenticate.internal.type');
        $this->guard         = $input['guard']   ?? config('constants.authenticate.guards.default');
        $this->service_type  = $input['service'] ?? null;
        $this->info_data     = $input['info']    ?? null;
    }

    /**
     * return instance authenticate
     */
    protected function getAuthenticate()
    {
       
        switch ($this->auth_type) {
            case config('constants.authenticate.internal.type'):
                //vd
                $this->setAuthenticateInternal($this->guard);
                return App::make(InternalInterface::class);
            case config('constants.authenticate.sso.type'):
                $this->setAuthenticateSSO($this->guard, $this->service_type);
                return App::make(SSOInterface::class);
            default:
                Log::error('Authentication type unknown at '.__FILE__.': Function['.__FUNCTION__.']');
                throw new InternalErrorException();
        }
    }

    /**
     * internal authenticate
     */
    protected function setAuthenticateInternal($guard)
    {
        switch ($guard) {
            // case config('constants.authenticate.guards.<...>'):
            //     App::bind(InternalInterface::class, function () use($guard) {
            //         return new <...>($guard);
            //     });
            //     break;
            default:
                App::bind(InternalInterface::class, function () use($guard) {
                    return new Def($guard);
                });
        }
    }

    /**
     * sso authenticate
     */
    protected function setAuthenticateSSO($guard, $service)
    {
        switch ($service) {
            case 1: // example
                App::bind(SSOInterface::class, function() use($guard) {
                    return new \App\Core\Authentications\SSO\ServiceExample\Authenticate($guard);
                });
                break;
            // case 'apple':
            //     // bind apple
            //     break;
            default:
                Log::error('SSO type unknown at '.__FILE__.': Function['.__FUNCTION__.']');
                throw new InternalErrorException();
        }
    }
}