<?php
// api/index.php

// Vercel will treat this as a serverless function entrypoint.
// All requests (except static assets defined in vercel.json) land here.
// We just bootstrap Laravel from the normal public/index.php.

require __DIR__ . '/../public/index.php';
