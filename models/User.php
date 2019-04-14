<?php

class User {
    public $id;
    public $username;
    public $password;
    public $active;
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
