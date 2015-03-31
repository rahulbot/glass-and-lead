<?php 
define("THIS_PAGE",basename(__FILE__));
include("includes/header.php") ?>

<p>
How I work:
</p>

<?php

$images = array(
	"cartoon.jpg"=>"To begin, I draw a cartoon that becomes the pattern pieces and the layout board.",
	"cutting-foiling.jpg"=>"Based on the cartoon, I cut glass to fit each pattern piece and wrap some of them in copper foil.",
	"building.jpg"=>"To construct the window, I use lead came to build the panels out of the pieces of glass and sections of foiled glass.",
	"cementing-1.jpg"=>"I use glazing compound to fill the spaces in the lead channel.",
	"whiting.jpg"=>"With flour, I \"white\" the leading to darken it and get rid of excess glazing compound.",
	"inframe.jpg"=>"The final piece is installed.",
);

?>
<center>
<table>
<?php
foreach($images as $img=>$txt){
?>
	<tr>
		<td><img class="listImg" src="images/studio/<?php echo $img?>"></td>
		<td class="listText"><?php echo $txt?></td>
	</tr>

<?php
}?>
</table>
</center>
	
<?php include("includes/footer.php") ?>
