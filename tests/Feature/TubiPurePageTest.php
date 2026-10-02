<?php

namespace Tests\Feature;

use Tests\TestCase;

class TubiPurePageTest extends TestCase
{
    public function test_homepage_contains_the_customer_and_staff_workflows(): void
    {
        $response = $this->get('/');

        $response->assertSeeText('Fresh & Clean Water');
        $response->assertSeeText('Delivered to Your Door');
        $response->assertSeeHtml([
            'id="page-dashboard"',
            'id="page-customers"',
            'id="page-scheduler"',
            'id="page-kmr"',
            'id="page-myaccount"',
            'id="page-about"',
            'id="page-contact"',
            'id="customerModal"',
            'id="detailModal"',
            'id="deliveryModal"',
            'id="toastStack"',
            'id="ordersReportType"',
            'value="products">Product performance report',
            'Tubipure+Water+Refilling+Station',
        ]);
    }
}
