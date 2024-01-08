<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Policy;

class StrictCspPolicy extends Policy
{
    public function configure()
    {
        $this->addDirective(Directive::BASE, 'self')
         ->addDirective(Directive::CONNECT, 'self')
         ->addDirective(Directive::DEFAULT, 'self')
         ->addDirective(Directive::FONT, ['self', 'fonts.bunny.net'])
         ->addDirective(Directive::FRAME, 'self')
         ->addDirective(Directive::IMG, 'self')
         ->addDirective(Directive::MEDIA, 'self')
         ->addDirective(Directive::OBJECT, 'self')
         ->addDirective(Directive::SCRIPT, ['self', "'unsafe-inline'", 'localhost:5173'])
         ->addDirective(Directive::STYLE, ['self', "'unsafe-inline'", 'localhost:5173', 'fonts.bunny.net']);
    }
}
