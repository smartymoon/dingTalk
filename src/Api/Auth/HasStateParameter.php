<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) 张铭阳 <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Smartymoon\DingTalk\Api\Auth;

use function Smartymoon\DingTalk\Api\str_random;
use function Smartymoon\DingTalk\Api\tap;

trait HasStateParameter
{
    /**
     * @var bool
     */
    protected $stateless = false;

    /**
     * @return $this
     */
    public function stateless()
    {
        $this->stateless = true;

        return $this;
    }

    /**
     * Generate state.
     *
     * @return string
     */
    protected function makeState()
    {
        return tap(str_random(64), function ($state) {
            $this->app['request']->getSession()->set('state', $state);
        });
    }

    /**
     * @param string|null $state
     *
     * @return bool
     */
    protected function hasValidState($state)
    {
        if ($this->stateless) {
            return true;
        }

        return !is_null($state) && ($state === $this->app['request']->getSession()->get('state'));
    }
}
