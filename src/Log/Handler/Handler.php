<?php
/**
 * Seaf: Simple Easy Acceptable micro-framework.
 *
 * クラスを定義する
 *
 * @author HAjime MATSUMOTO <mail@hazime.org>
 * @copyright Copyright (c) 2014, Seaf
 * @license   MIT, http://seaf.hazime.org
 */

namespace Seaf\Log;


/**
 * ロガーハンドラクラス
 *
 * LoggerHandler::register
 */
class Log
{
    /**
     * @var Log
     */
    private static $instance;

    /**
     * ハンドラを保存する
     */
    static $handlers = array();

    /**
     *
     */
    private function __construct ( )
    {
        $logger = new Logger( );

        set_error_handler(function ($no, $msg, $file, $line, $context) use ($logger) {
            $lv = $logger->translatePHPLogLevel($no);
            $name = $logger->logLevel($lv);
            $message = 'PHP: '.$msg.' '.$file.' '.$line;
            $logger->$name($message);
        });

        set_exception_handler(function ($e) use($logger) {
            $logger->fatal ((string) $e);
        });
    }

    /**
     * ハンドラを登録する
     */
    public static function register ($type, $level = Logger::INFO, $config = array( ))
    {
        $clss = __NAMESPACE__.'\\Handler\\'.ucfirst($type).'Handler';

        if (!class_exists($class)) {
            throw new Exception\HandlerNotExists($type);
        }

        return self::$handlers[] = new $class($level, $config);
    }

    /**
     * シングルトンインスタンスを取得する
     */
    public static function getInstance () {
        if (self::$instance) return self::$instance;
        return self::$instance = new Log();
    }
}

/* vim: set expandtab ts=4 sw=4 sts=4: et*/
