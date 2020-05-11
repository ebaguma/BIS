<?php
//print_r($argv);
$ldap = @ldap_connect($argv[1]);
if ($bind = @ldap_bind($ldap, "$argv[2]\\$argv[3]","$argv[4]")) {
//if ($bind = ldap_bind($ldap, "UETCL\\trans-jombjo","123456")) {
//if ($bind = ldap_bind($ldap, "UETCL\\suport","123456")) {
echo "Y";
} else {
echo "N";
}
?>
