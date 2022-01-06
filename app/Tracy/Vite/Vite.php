<?php

class VitePanel implements Tracy\IBarPanel
{
    public function getTab()
    {
        return file_get_contents(__DIR__ . '/Vite.html');
    }

    public function getPanel()
    {
        return '';
    }
}
