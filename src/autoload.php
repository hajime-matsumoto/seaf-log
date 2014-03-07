<?php
/**
 * Seaf Auto Load
 */
Seaf::di('autoLoader')->addNamespace(
    'Seaf\\Component\\Logger',
    null,
    dirname(__FILE__).'/Logger'
);
