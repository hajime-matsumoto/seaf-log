<?php
/**
 * Seaf Auto Load
 */
Seaf::di('autoLoader')->addNamespace(
    'Seaf\\Log',
    null,
    dirname(__FILE__).'/Log'
);

Seaf::register('log', function ( ) {
    return Seaf\Log\Log::getInstance();
});
