<?php

return ["connector" => "app\\common\\queue\\DatabaseConnector", "expire" => 120, "default" => "default", "table" => "jobs", "sweep_interval" => 30, "sweep_jitter" => 5, "dsn" => []];
