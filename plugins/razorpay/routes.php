<?php
$r->post("/callback", [\RazorpayGateway::class, "webhook"]);
