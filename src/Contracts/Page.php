<?php

namespace Vellum\Contracts;


interface Page {

    /**
     * Page title
     *
     * @return void
     */
    public function title();

    /**
     * Page content
     *
     * @return void
     */
    public function content();

}