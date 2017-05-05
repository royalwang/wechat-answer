<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-04
 */

namespace Runner\WechatAnswer;

use EasyWeChat\Message\Text;
use Runner\WechatAnswer\Exceptions\NotHandlerMatchedException;
use Exception;

class Dispatcher
{

    /**
     * @var HandlerCollection
     */
    protected $handlers;

    /**
     * @var HandlerInterface
     */
    protected $defaultHandler;

    /**
     * @var HandlerInterface
     */
    protected $exceptionHandler;

    public function __construct(HandlerCollection $collection)
    {
        $this->handlers = $collection;
    }

    public function setDefaultHandler(HandlerInterface $handler)
    {
        $this->defaultHandler = $handler;

        return $this;
    }

    public function setExceptionHandler(HandlerInterface $handler)
    {
        $this->exceptionHandler = $handler;

        return $this;
    }

    public function dispatch($message)
    {
        try {
            $handler = $this->handlers->match($message);
        } catch (Exception $e) {
            if (($e instanceof NotHandlerMatchedException) && !is_null($this->defaultHandler)) {
                $handler = $this->defaultHandler;
            } else {
                $handler = $this->exceptionHandler;
            }
        }

        $response = $handler->handle($message);

        is_string($response) && $response = new Text($response);

        return $response;
    }

    /**
     * @return HandlerCollection
     */
    public function handlers()
    {
        return $this->handlers;
    }
}
