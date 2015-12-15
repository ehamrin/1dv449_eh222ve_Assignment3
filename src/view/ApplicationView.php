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
        <div id="event_controller"></div>
        <div id="map" class="inline-3-4"></div>
        <div id="events" class="inline-3-4">
            <div class="category-controls">
                <ul>
                    <li><a href="#" class="category-option show" data-category="Vägtrafik">Vägtrafik</a></li>
                    <li><a href="#" class="category-option show" data-category="Kollektivtrafik">Kollektivtrafik</a></li>
                    <li><a href="#" class="category-option show" data-category="Planerad störning">Planerad störning</a></li>
                    <li><a href="#" class="category-option show" data-category="Övrigt">Övrigt</a></li>
                </ul>
            </div>
            <ul id="event-list"></ul>
        </div>

HTML;

        return $this->html_view->Render($body);
    }

}