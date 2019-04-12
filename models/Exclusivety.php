<?php

class Exclusivety {
    public $id;
    public $location_id;
    public $blocked_location_id;
    public $rule_active;
    public $create_dt;
    public $update_dt;
}

/*
`id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `blocked_location_id` int(11) NOT NULL,
  `rule_active` tinyint(4) NOT NULL DEFAULT '1',
  `create_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
  */
?>
