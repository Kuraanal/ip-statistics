<?php

exec('snmpwalk -c community -v 1 IP_addr .1.3.6.1.2.1.4.22.1.2 | cut -d . -f 3-6 | cut -d " " -f 1', $result);
print_r($result);

?>