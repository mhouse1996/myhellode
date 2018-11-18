<?php
//MySQL Parameters
$configs = array();
$configs['mysql']['host']="localhost";
$configs['mysql']['user']="root";
$configs['mysql']['password']="";
$configs['mysql']['db']="myhello";
//BreakSystem Parameters
#Time after a break ticket is given free automatically in Minutes
$configs['breakSystem']['latencyTime'] = 45;
#Minimum user grant level for BreakSystem Admin tool
$configs['breakSystem']['adminSysGrantlevel'] = 2;
?>
