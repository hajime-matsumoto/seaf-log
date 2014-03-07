ロガー
======================

Environmentにロギングメソッドを追加する。


ハンドラはグローバルに存在する
------------------------------


	LoggingHandler::register(
		'name',
		'type',
		$options = array()
	);


	$loggerA = new Logger('nameA');
	$loggerB = new Logger('nameB');

	$loggerA->debug('aaa');
	$loggerB->debug('bbb');

