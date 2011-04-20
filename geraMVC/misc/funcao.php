<?php
function print_pre($array)
{
	?><pre><?php 
		print_r($array);?>
	</pre><?php
}
function optionDtaBase($array)
{
	if(count($array)>0)
	{
		?><option value="-1">--Selecione--</option><?
		for($i=0; $i<count($array); $i++)
		{
			?><option value="<?php echo $array[$i]?>"><?php echo $array[$i]?></option><?php
		}
	}//end if(count($dbs)>0)
}//end function optionDtaBase($host, $usr, $pwr)
function optionTables($array)
{
	if(count($array)>0)
	{
		for($i=0; $i<count($array); $i++)
		{
			?><option value="<?php echo $array[$i]?>"><?php echo $array[$i]?></option><?php
		}
	}
}//end function optionTables($host, $usr, $pwr, $db)
?>