<?php

namespace App\Tests\Form;

use PHPUnit\Framework\TestCase;
use App\Model\Animals;

class AnimalFormTest extends TestCase
{
    public function testFormView(): void{
        $formData = new AnimalForm();

        $view = $this->factory->create(Animals::class, $formData)->createView();

        $this->assertArrayHasKey('custom_var', $view->vars);
        $this->assertSame('expected value', $view->vars['custom_var']);
    }
}
