<?php

namespace Xigen\NotFound\App\Router;

/**
 * Class NoRouteHandler
 * @package Xigen\NotFound\App\Routers
 */
class NoRouteHandler implements \Magento\Framework\App\Router\NoRouteHandlerInterface
{
    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function process(\Magento\Framework\App\RequestInterface $request)
    {
        $request->setModuleName('page')
            ->setControllerName('not')
            ->setActionName('found');

        return true;
    }
}
