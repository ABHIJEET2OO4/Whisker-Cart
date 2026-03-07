<?php
$r->post("/callback", [\NowPaymentsGateway::class, "webhook"]);
