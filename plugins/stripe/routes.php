<?php
$r->post("/callback", [\StripeGateway::class, "webhook"]);
