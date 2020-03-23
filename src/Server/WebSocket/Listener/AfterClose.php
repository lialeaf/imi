<?php
namespace Imi\Server\WebSocket\Listener;

use Imi\ServerManage;
use Imi\ConnectContext;
use Imi\RequestContext;
use Imi\Bean\Annotation\ClassEventListener;
use Imi\Server\Event\Param\CloseEventParam;
use Imi\Server\Event\Listener\ICloseEventListener;

/**
 * Close事件后置处理
 * @ClassEventListener(className="Imi\Server\WebSocket\Server",eventName="close",priority=Imi\Util\ImiPriority::IMI_MIN)
 */
class AfterClose implements ICloseEventListener
{
    /**
     * 事件处理方法
     * @param CloseEventParam $e
     * @return void
     */
    public function handle(CloseEventParam $e)
    {
        $groups = ConnectContext::get('__groups', []);
        var_dump('close:', $groups);

        // 当前连接离开所有组
        $e->getTarget()->getBean('FdMap')->leaveAll($e->fd);

        ConnectContext::set('__groups', $groups);

        ConnectContext::destroy($e->fd);
    }
}