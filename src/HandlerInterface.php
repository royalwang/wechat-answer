<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-05
 */

namespace Runner\WechatAnswer;

use EasyWeChat\Message\AbstractMessage;

interface HandlerInterface
{

    /**
     * @param string $message
     * @return AbstractMessage
     */
    public function handle($message);

}
