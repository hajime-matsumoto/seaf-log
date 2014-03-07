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
     * ログレベル
     */
    const LOG_FATAL = 1;
    const LOG_ERR   = 2;
    const LOG_WARN  = 4;
    const LOG_INFO  = 8;
    const LOG_DEBUG = 16;
    const LOG_ALL   = 31;

    /**
     * エラーラベルマップ
     */
    public static $error_map = array(
        self::LOG_FATAL => 'FATAL',
        self::LOG_ERR   => 'ERR',
        self::LOG_WARN  => 'WARN',
        self::LOG_INFO  => 'INFO',
        self::LOG_DEBUG => 'DEBUG'
    );

    /**
     * PHPエラーマップ
     */
    public static $php_error_map = array(
        E_COMPILE_ERROR     => self::LOG_FATAL,
        E_ERROR             => self::LOG_FATAL,
        E_PARSE             => self::LOG_FATAL,
        E_CORE_ERROR        => self::LOG_FATAL,
        E_RECOVERABLE_ERROR => self::LOG_ERR,
        E_USER_ERROR        => self::LOG_ERR,
        E_WARNING           => self::LOG_ERR,
        E_CORE_WARNING      => self::LOG_ERR,
        E_COMPILE_WARNING   => self::LOG_ERR,
        E_USER_WARNING      => self::LOG_WARN,
        E_DEPRECATED        => self::LOG_INFO,
        E_USER_DEPRECATED   => self::LOG_INFO,
        E_NOTICE            => self::LOG_DEBUG,
        E_USER_NOTICE       => self::LOG_DEBUG,
        E_STRICT            => self::LOG_DEBUG
    );

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
        set_error_handler(function ($no, $msg, $file, $line, $context) {
            $lv = Log::$php_error_map[$no];
            $message = 'PHP: '.$msg.' '.$file.' '.$line;
            Log::post($lv, $message);
        });

        set_exception_handler(function ($e) use($logger) {
            Log::post(Log::LOG_FATAL, (string) $e);
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

    /**
     * ログを送信する
     */
    public static function post ($message, $level = self::LOG_INFO)
    {
        foreach (self::$handlers as $handler) {
            $handler->post($meesage, $level);
        }
    }
}

/* vim: set expandtab ts=4 sw=4 sts=4: et*/
