<?php
	require 'dblogin.php';
	$fname=$_POST['fromname'];
	$tname=$_POST['toname'];
//	echo $fname." ".$tname;
	$dist=$_POST['dist'];
	$cap=$_POST['cap'];
	$isdel=$_POST['isdel'];
//	echo $dist.' '.$cap.' '.$isdel;
	$fidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$fname}'");
	$fidrow=mysqli_fetch_array($fidres);
	$fid=$fidrow['vertexid'];
//	echo $fid;
	$tidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$tname}'");
	$tidrow=mysqli_fetch_array($tidres);
	$tid=$tidrow['vertexid'];
//	echo $fid." ".$tid;
	
	if($isdel=="on")
	{
		if	(!mysqli_query($con,"delete from edgeinfo where fromv={$fid} and tov={$tid};")){
			die(mysqli_error($con));
		}
		if	(!mysqli_query($con,"delete from edgeinfo where fromv={$tid} and tov={$fid};")){
			die(mysqli_error($con));
		}
	}
	else
	{
/*
select count(*) as cnt
from edgeinfo
where
fromv=2 and tov=6;

*/		
		$cntres=mysqli_query($con,"select count(*) as cnt
									from edgeinfo
									where
									fromv={$fid} and tov={$tid};
							");
		$cntrow=mysqli_fetch_array($cntres);
		if($cntrow['cnt']==0)
		{
			if	(!mysqli_query($con,"insert into edgeinfo values ({$fid},{$tid},{$dist},{$cap})")){
				die(mysqli_error($con));
			}
			if	(!mysqli_query($con,"insert into edgeinfo values ({$tid},{$fid},{$dist},{$cap})")){
				die(mysqli_error($con));
			}
		}
		else
		{
			if	(!mysqli_query($con,"update edgeinfo set dist={$dist},cap={$cap} where fromv={$fid} and tov={$tid};")){
				die(mysqli_error($con));
			}
			if	(!mysqli_query($con,"update edgeinfo set dist={$dist},cap={$cap} where fromv={$tid} and tov={$fid};")){
				die(mysqli_error($con));
			}
		}
	}
	echo '<script>';
	echo 'alert("update success!");parent.location.href="../";';
	echo '</script>';
?>