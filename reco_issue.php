<?php
  require_once 'inc/head.inc';
   require_once 'inc/menuproj.inc';
  require_once 'inc/menureco.inc';

  $bodyclass = "recommendations"; 
$pagetitle = "$as_sitename Recommendations - $appname";
$mypage = "reco_issue";
  
  if (isset($_GET['scview'])) {$qs_reco_edit = sanitizeString($_GET['scview']);}else {$qs_reco_edit = "";}
  if (isset($_POST['reco_id'])){
  include 'inc/issue_form_proc.inc';
  }
  $issue_view = "";
  $query_site_details = "SELECT legacy_signchart_id, site_name, project_id, address, address2, city, state, zip FROM resulttable WHERE legacy_signchart_id = (SELECT site_id FROM reco WHERE reco_id = '$qs_reco_id');";
 $query_reco =  "SELECT rt.site_name As 'site_name', rt.client_site_id, rc.site_id, rt.project_id, action, exterior_sign_type, new_sign_type, new_sign_type_description, sign_number, face_material, graphics_material, face_height, face_width, square_feet, overall_height, illuminated, electrical, wall_material, sign_comment, photo_survey, photo_morphed, action, new_sign_type_code, new_sign_type_description, new_sign_overall_height, new_sign_overall_width, new_sign_logo_height, new_sign_letter_height, new_sign_illuminated, message_a, message_b, rest_and_fab, comments, rc.site_id, reco_id FROM reco rc INNER JOIN resulttable rt ON rc.site_id = rt.legacy_signchart_id WHERE rc.reco_id ='" . $qs_reco_id."' ;";
 $query_issue = "SELECT issue_id, legacy_issue_id, reco_id, issue_type, site_id, creator, resolution, add_date, resolve_date, resolve_user, issue, requestor, comments FROM issue WHERE reco_id = $qs_reco_id;"; 
  
   $result = queryMySQL(query_prep($query_issue, '','',''));
 foreach ($result as $row) {
  
if (isset($row['issue_id'])) {$issue_issue_id = $row['issue_id'] ; } else {$issue_issue_id = '';} 
if (isset($row['legacy_issue_id'])) {$issue_legacy_issue_id = $row['legacy_issue_id'] ; } else {$issue_legacy_issue_id = '';} 
if (isset($row['reco_id'])) {$issue_reco_id = $row['reco_id'] ; } else {$issue_reco_id = '';} 
if (isset($row['issue_type'])) {$issue_issue_type = $row['issue_type'] ; } else {$issue_issue_type = '';} 
if (isset($row['site_id'])) {$issue_site_id = $row['site_id'] ; } else {$issue_site_id = '';} 
if (isset($row['creator'])) {$issue_creator = $row['creator'] ; } else {$issue_creator = '';} 
if (isset($row['resolution'])) {$issue_resolution = $row['resolution'] ; } else {$issue_resolution = '';} 
if (isset($row['add_date'])) {$issue_add_date = $row['add_date'] ; } else {$issue_add_date = '';} 
if (isset($row['resolve_date'])) {$issue_resolve_date = $row['resolve_date'] ; } else {$issue_resolve_date = '';} 
if (isset($row['resolve_user'])) {$issue_resolve_user = $row['resolve_user'] ; } else {$issue_resolve_user = '';} 
if (isset($row['issue'])) {$issue_issue = $row['issue'] ; } else {$issue_issue = '';} 
if (isset($row['requestor'])) {$issue_requestor = $row['requestor'] ; } else {$issue_requestor = '';} 
if (isset($row['comments'])) {$issue_comments = $row['comments'] ; } else {$issue_comments = '';} 
if (trim($issue_resolve_date) == ""){
$ifrcount += 1;}

$issue_view .= "<h2>Issue #" . $issue_issue_id . " Issue Type: $issue_issue_type </h2>";
$issue_view .= "<h3>Detail</h3>	  <ul><li>Created by " . $issue_creator . " on $issue_add_date </li><li>Note:</li><li>" . $issue_issue . "</li></ul>";
if ($issue_resolve_date == "") {
$issue_view .= "<h3>Resolution</h3><form method=\"post\" action=\"" . $mypage . ".php?reco_id=" . $qs_reco_id. "\"><ul><li><input type=\"hidden\" name=\"ifrcount\" value=\"" . $ifrcount . "\"><input type=\"hidden\" name=\"issue_id\" value=\"" . $issue_issue_id . "\"><input type=\"hidden\" name=\"resolve_user\" value=\"" . $_SESSION['user'] . "\"><input type=\"hidden\" name=\"reco_id\" value=\"" . $qs_reco_id . "\"><input type=\"hidden\" name=\"site_id\" value=\"" . $qs_site_id . "\">Resolution: <textarea name=\"resolution\" rows=\"2\" cols=\"60\"></textarea></li><li><input type=\"submit\" value=\"Resolve\" name=\"Resolver\"></li></ul></form>";} else {
$issue_view .= "<h3>Resolution</h3><ul><li>Resolution by " . $issue_resolve_user . " on $issue_resolve_date </li><li>Resolution</li><li>" . $issue_resolution . "</li></ul>";}
$issue_view .= "<h3>Comments</h3><p>$issue_comments</p>";
}

 $headerli = "";
$firstli = $secondli = $thirdli = "";
 $form_num = "0";
 $firsttable = "";
 $secondtable = "";
 $thirdtable = "";
 $edit_firsttable = $edit_secondtable = $edit_thirdtable = "";
 

 $result = queryMySQL(query_prep($query_reco, '','',''));
 foreach ($result as $row) {
include 'inc/transform_asset.inc';  
include '/inc/rec_navigation.inc'; 

$firstli = $rec_photo_survey->photodisplay2('', '0', '') ;
$firstli .= "<h3>Existing</h3>";
$firstli .= $screco->recoli('Sign Number', $sign_number) . "\r";
$firstli .= $screco->recoli('Exterior Sign Type',$exterior_sign_type ) . "\r";
$firstli .= $screco->recoli('Face Material', $face_material) . "\r";
$firstli .= $screco->recoli('Graphics Material', $graphics_material) . "\r";
$firstli .= $screco->recoli('Overall Height', $overall_height) . "\r";
$firstli .= $screco->recoli('Face Height', $face_height) . "\r";
$firstli .= $screco->recoli('Face Width', $face_width) . "\r";
$firstli .= $screco->recoli('Square Feet', $square_feet) . "\r";
$firstli .= $screco->recoli('Illuminated', $illuminated) . "\r";
$firstli .= $screco->recoli('Electrical', $electrical) . "\r";
$firstli .= $screco->recoli('Wall Material', $wall_material) . "\r";
$firstli .= $screco->recoli('Sign Comments', $sign_comment) . "\r";

$edit_firstli = $rec_photo_survey->photodisplay2('', '0', '') ;
$edit_firstli .= "<h3>Existing</h3>";
$edit_firstli .= $screco->editrecoli('Sign Number',sanitizeString($sign_number), 'text', 'reco', 'sign_number') . "\r";
$edit_firstli .= $screco->editrecoli('Exterior Sign Type', sanitizeString($exterior_sign_type), 'text', 'reco', 'exterior_sign_type') . "\r";
$edit_firstli .= $screco->editrecoli('Face Material', sanitizeString($face_material), 'text', 'reco', 'face_material') . "\r";
$edit_firstli .= $screco->editrecoli('Graphics Material',  sanitizeString($graphics_material), 'text', 'reco', 'graphics_material') . "\r";
$edit_firstli .= $screco->editrecoli('Overall Height', sanitizeString($overall_height), 'text', 'reco', 'overall_height') . "\r";
$edit_firstli .= $screco->editrecoli('Face Height', sanitizeString($face_height), 'text', 'reco', 'face_height') . "\r";
$edit_firstli .= $screco->editrecoli('Face Width', sanitizeString($face_width), 'text', 'reco', 'face_width') . "\r";
$edit_firstli .= $screco->editrecoli('Square Feet', sanitizeString($square_feet), 'text', 'reco', 'square_feet') . "\r";
$edit_firstli .= $screco->editrecoli('Illuminated', $illuminated, 'select', 'reco', 'illuminated') . "\r";
$edit_firstli .= $screco->editrecoli('Electrical', sanitizeString($electrical), 'text', 'reco', 'electrical') . "\r";
$edit_firstli .= $screco->editrecoli('Wall Material', sanitizeString($wall_material), 'text', 'reco', 'wall_material') . "\r";
$edit_firstli .= $screco->editrecoli('Sign Comments', sanitizeString($sign_comment), 'textarea', 'reco', 'sign_comment') . "\r";

$headerli .= "<div class=\"cols cols1-3 col1\">" . "\r" . $rec_photo_survey->photodisplay2('', '0', '') . "\r" . "/></div>";
$headerli .= "<div class=\"cols cols1-3 col2\">" . "\r" . $rec_photo_morphed->photodisplay2('', '0', '') . "\r" . "/></div>";
$headerli .= "<div class=\"cols cols1-3 col3\">" . "\r" . $rec_photo_asbuilt->photodisplay2('', '0', '') . "\r" . "/></div>";
							
											
	

	$secondli = $rec_photo_morphed->photodisplay2('', '0', '') ;
	$secondli .= "<h3>Proposed</h3>";
   	 $secondli .= $screco->recoli('Sign Number', $sign_number) . "\r";
	$secondli .= $screco->recoli('Sign Type', $new_sign_type) . "\r";
	$secondli .= $screco->recoli('Action Code', $xaction) . "\r";
	$secondli .= $screco->recoli('Description', htmlentities($new_sign_type_description)) . "\r";
	$secondli .= $screco->recoli('Overall Height', $new_sign_overall_height) . "\r";
	$secondli .= $screco->recoli('Overall Width', $new_sign_overall_width) . "\r";
	$secondli .= $screco->recoli('Logo Height', $new_sign_logo_height) . "\r";
	$secondli .= $screco->recoli('Letter Height', $new_sign_letter_height) . "\r";
	$secondli .= $screco->recoli('Illuminated', $new_sign_illuminated) . "\r";
	$secondli .= $screco->recoli('Message A', $message_a) . "\r";
	$secondli .= $screco->recoli('Message B', $message_b) . "\r";
	$secondli .= $screco->recoli('Comments', $comments) . "\r";
	$secondli .= $screco->recoli('Restoration Notes', $rest_and_fab) . "\r";
	
$edit_secondli = $rec_photo_survey->photodisplay2('', '0', '') . "\r";
	$edit_secondli .= "<h3>Proposed</h3>". "\r";
	$edit_secondli .= $screco->recoli('Sign Number', $sign_number) . "\r";
	$edit_secondli .= $screco->editrecoli('New Sign Type', $new_sign_type, 'select', 'reco', 'new_sign_type') . "\r";
	$edit_secondli .= $screco->editrecoli('Action Code', $xaction, 'select', 'reco', 'action') . "\r";
	$edit_secondli .= $screco->editrecoli('Description', htmlentities($new_sign_type_description), 'text', 'reco', 'new_sign_type_description') . "\r";
	$edit_secondli .= $screco->editrecoli('Overall Height', $new_sign_overall_height, 'text', 'reco', 'new_sign_overall_height') . "\r";
	$edit_secondli .= $screco->editrecoli('Overall Width', $new_sign_overall_width, 'text', 'reco', 'new_sign_overall_width') . "\r";
	$edit_secondli .= $screco->editrecoli('Logo Height', $new_sign_logo_height, 'text', 'reco', 'new_sign_logo_height') . "\r";
	$edit_secondli .= $screco->editrecoli('Letter Height', $new_sign_letter_height, 'text', 'reco', 'new_sign_letter_height') . "\r";
	$edit_secondli .= $screco->editrecoli('Illuminated', $new_sign_illuminated, 'select', 'reco', 'new_sign_illuminated') . "\r";
	$edit_secondli .= $screco->editrecoli('Message A', htmlentities($message_a), 'textarea', 'reco', 'message_a') . "\r";
	$edit_secondli .= $screco->editrecoli('Message B', htmlentities($message_b), 'textarea', 'reco', 'message_b') . "\r";
	$edit_secondli .= $screco->editrecoli('Comments', htmlentities($comments), 'textarea', 'reco', 'comments') . "\r";
	$edit_secondli .= $screco->editrecoli('Restoration Notes', htmlentities($rest_and_fab), 'textarea', 'reco', 'rest_and_fab') . "\r";
	$edit_secondli .= hidden('reco_id',$screco->reco_id) . hidden('site_id',$screco->site_id) ;
	
	   	$thirdli = $rec_photo_asbuilt->photodisplay2('', '0', '')  . "\r";
	$thirdli .= "<h3>As Built</h3>";
	$thirdli .= "<a href=\"reco.php?reco_id=$qs_reco_id&scview=issues\">ISSUES</a><br/>"  . "\r";
	$thirdli .= "<a href=\"reco.php?reco_id=$qs_reco_id&scview=edit\">EDIT</a><br/>"  . "\r";
	$thirdli .= "<a href=\"reco.php?reco_id=$qs_reco_id&scview=delete\">DELETE ASSET</a><br/>"  . "\r";
	
		
 	$edit_thirdli = $rec_photo_asbuilt->photodisplay2('', '0', '')  . "\r";
	$edit_thirdli .= "<h3>As Built</h3>";
	$edit_thirdli .= "<a href=\"reco.php?reco_id=$qs_reco_id&scview=issues\">ISSUES</a><br/>"  . "\r";
	$edit_thirdli .= "<a href=\"reco.php?reco_id=$qs_reco_id&scview=delete\">DELETE ASSET</a><br/>"  . "\r";

	$edit_thirdli .= "<br/><input type=\"submit\" value=\"Save Changes\"><br/>"  . "\r";

$firsttable .= "<tr>" . $rec_photo_survey->photodisplay2('', '1', '') . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Sign Number',$sign_number) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Exterior Sign Type',$exterior_sign_type ) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Face Material', $face_material) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Graphics Material', $graphics_material) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Overall Height', $overall_height) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Face Height', $face_height) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Face Width', $face_width) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Square Feet', $square_feet) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Illuminated', $illuminated) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Electrical', $electrical) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Wall Material', $wall_material) . "</tr>";
$firsttable .= "<tr>" . $screco->recotable('Sign Comments', $sign_comment) . "</tr>";

    $secondtable .= "<tr>" . $rec_photo_morphed->photodisplay2('319', '1', '') . "</tr>";
    $secondtable .= "<tr>" . $screco->recotable('Sign Number', $sign_number) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Sign Type', $new_sign_type) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Action Code', $xaction) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Description', htmlentities($new_sign_type_description)) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Overall Height', $new_sign_overall_height) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Overall Width', $new_sign_overall_width) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Logo Height', $new_sign_logo_height) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Letter Height', $new_sign_letter_height) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Illuminated', $new_sign_illuminated) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Message A', $message_a) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Message B', $message_b) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Comments', $comments) . "</tr>";
	$secondtable .= "<tr>" . $screco->recotable('Restoration Notes', $rest_and_fab) . "</tr>";
	
	
$edit_firsttable .= "<tr>" . $rec_photo_survey->photodisplay2('319', '1', '') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Sign Number',sanitizeString($sign_number), 'text', 'reco', 'sign_number') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Exterior Sign Type', sanitizeString($exterior_sign_type), 'text', 'reco', 'exterior_sign_type') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Face Material', sanitizeString($face_material), 'text', 'reco', 'face_material') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Graphics Material',  sanitizeString($graphics_material), 'text', 'reco', 'graphics_material') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Overall Height', sanitizeString($overall_height), 'text', 'reco', 'overall_height') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Face Height', sanitizeString($face_height), 'text', 'reco', 'face_height') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Face Width', sanitizeString($face_width), 'text', 'reco', 'face_width') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Square Feet', sanitizeString($square_feet), 'text', 'reco', 'square_feet') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Illuminated', $illuminated, 'select', 'reco', 'illuminated') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Electrical', sanitizeString($electrical), 'text', 'reco', 'electrical') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Wall Material', sanitizeString($wall_material), 'text', 'reco', 'wall_material') . "</tr>";
$edit_firsttable .= "<tr>" . $screco->editrecotable('Sign Comments', sanitizeString($sign_comment), 'textarea', 'reco', 'sign_comment') . "</tr>";
	
	$edit_secondtable .= "<tr>" . $rec_photo_morphed->photodisplay2('319', '1', '') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->recotable('Sign Number', $sign_number) . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('New Sign Type', $new_sign_type, 'select', 'reco', 'new_sign_type') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Action Code', $xaction, 'select', 'reco', 'action') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Description', htmlentities($new_sign_type_description), 'text', 'reco', 'new_sign_type_description') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Overall Height', $new_sign_overall_height, 'text', 'reco', 'new_sign_overall_height') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Overall Width', $new_sign_overall_width, 'text', 'reco', 'new_sign_overall_width') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Logo Height', $new_sign_logo_height, 'text', 'reco', 'new_sign_logo_height') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Letter Height', $new_sign_letter_height, 'text', 'reco', 'new_sign_letter_height') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Illuminated', $new_sign_illuminated, 'select', 'reco', 'new_sign_illuminated') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Message A', htmlentities($message_a), 'textarea', 'reco', 'message_a') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Message B', htmlentities($message_b), 'textarea', 'reco', 'message_b') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Comments', htmlentities($comments), 'textarea', 'reco', 'comments') . "</tr>";
	$edit_secondtable .= "<tr>" . $screco->editrecotable('Restoration Notes', htmlentities($rest_and_fab), 'textarea', 'reco', 'rest_and_fab') . "</tr>";
	$edit_secondtable .= hidden('reco_id',$screco->reco_id) . hidden('site_id',$screco->site_id) ;
}
	$edit_secondtable .= "<tr><td>" . hidden('reco_id',$screco->reco_id) ." <input type=\"submit\" value=\"Save\"></td></tr>";
	
	$final_output = "<div class=\"mainNav\"><h3>Sign No. $screco->sign_number</h3> <div class=\"nav3\">" . asset_nav_view($nav_prev_reco, "&lt;&lt; Previous") 
	. "<span class=\"spacedPipe\">|</span>"
							. $sign_number	
	. "<span class=\"spacedPipe\">|</span>"
							. asset_nav_view($nav_next_reco, "Next  -&gt;")
	. "<span class=\"spacedPipe\">|</span>"
							. asset_nav_view($nav_last_reco, "Last  &gt;&gt;")
	.	"</div></div><div class=\"columns3Wrap\"><div class=\"cols cols1-3 col1\">" ;
	if ($qs_reco_edit == "edit"){
	$final_output .= "<form action=\"reco.php?reco_id=" . $qs_reco_id . "\" method=\"post\">" ;}
	
		if ($qs_reco_edit == "edit"){
							$final_output .= $edit_firstli ;
							} else {
							$final_output .= $firstli ;}
							
	$final_output .= "</div><div class=\"cols cols1-3 col2\">"; 
						if ($qs_reco_edit == "edit"){
							$final_output .= $edit_secondli ;
							} else {
							$final_output .= $secondli ;}
	
	$final_output .= "</div><div class=\"cols cols1-3 col3\">"; 
						if ($qs_reco_edit == "edit"){
							$final_output .= $edit_thirdli ;
							} else {
							$final_output .= $thirdli ;}
							
	$final_output .= $LF . "</form></div></div>";
		
	
?>					

<?php include  'inc/headtop.inc' ;?>

		<main>	<table border="0"><tr><td align="top">
		<?php echo $firstli ; ?><br>
		
		</td><td align="top">
<?php echo $issue_view ; ?>
<h3>New Issue</h3>
<table border="0">
		<form method="post" action="<?php echo $mypage .".php?reco_id=" . $qs_reco_id ?>">
		<input type="hidden" name="reco_id" value="<?php echo $qs_reco_id?>">
		<input type="hidden" name="site_id" value="<?php echo $qs_site_id?>">
		<input type="hidden" name="creator" value="<?php echo $_SESSION['user']?>">
		<tr><td colspan="2"><select name="issue_type"><option value=""><i>Issue Type-</i></option>
		<option value="1">N/A</option>
  <option value="2">Pre-Rec</option>
  <option value="3">Brand Approval</option>
  <option value="4">Landlord Approval</option>
  <option value="5">Permit Approval</option>
  <option value="6">Fabrication/Install</option>
  <option value="7">Change Control</option>
  </select></td></tr>
  <tr><td>Issue: </td><td><textarea name="issue" rows="7" cols="55"></textarea></td></tr>
  <tr><td>Requestor:</td><td><input type="text" name="requestor" /></td></tr>
  <tr><td>Comments:</td><td> <textarea name="comments"  rows="7" cols="55"></textarea></td></tr>
  <tr><td colspan="2"><input type="submit" value="Add Issue" /></td></tr></table>
  </form>
</td></table>

</main>
			</section>

			
</form>

<?php 
require_once 'inc/footer.inc';
?>