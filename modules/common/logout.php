<?php
    $db = new Database();
        $db->s->deleteSession('user-token');
        $db->s->deleteSession('fullname');
        $db->c->deleteCookie('user-token');
        $db->c->deleteCookie('fullname');
        $db->r->redirects($db->r->getUrl('qlthuexe/?module=common&action=login'));
?>
