<?php


namespace view;


class ApplicationView
{

    private $html_view;

    public function __construct(HTML_Template $html_view)
    {
        $this->html_view = $html_view;
    }

    public function Render(){

        $body = <<<HTML
    <div id="map" class="inline-3-4"></div>
    <div id="events" class="inline-3-4"></div>

HTML;

        return $this->html_view->Render($body);
    }

}