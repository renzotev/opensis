<?php
#**************************************************************************
#  openSIS is a free student information system for public and non-public 
#  schools from Open Solutions for Education, Inc. web: www.os4ed.com
#
#  openSIS is  web-based, open source, and comes packed with features that 
#  include student demographic info, scheduling, grade book, attendance, 
#  report cards, eligibility, transcripts, parent portal, 
#  student portal and more.   
#
#  Visit the openSIS web site at http://www.opensis.com to learn more.
#  If you have question regarding this system or the license, please send 
#  an email to info@os4ed.com.
#
#  This program is released under the terms of the GNU General Public License as  
#  published by the Free Software Foundation, version 2 of the License. 
#  See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
#***************************************************************************************
include('../../../Redirect_includes.php');
echo '<TABLE width=100% border=0 cellpadding=6>';
echo '<TR>';
$_SESSION['staff_selected']=$staff['STAFF_ID'];
if(clean_param($_REQUEST['staff_id'],PARAM_ALPHANUM)!='new' && $UserPicturesPath && (($file = @fopen($picture_path=$UserPicturesPath.UserSyear().'/'.UserStaffID().'.JPG','r')) || $staff['ROLLOVER_ID'] && ($file = @fopen($picture_path=$UserPicturesPath.(UserSyear()-1).'/'.$staff['ROLLOVER_ID'].'.JPG','r'))))
{
	fclose($file);
	echo '<TD width=150><IMG SRC="'.$picture_path.'" width=150></TD><TD valign=top>';
}
else
	echo '<TD colspan=2>';

echo '<TABLE width=100%  cellpadding=5 >';
echo '<TR><td valign="top">';
echo '<TABLE border=0>';
echo '<tr><td style=width:100px>Name</td><td>:</td><td>';
if(clean_param($_REQUEST['staff_id'],PARAM_ALPHA)=='new')
	echo '<TABLE><TR><TD>'.SelectInput($staff['TITLE'],'staff[TITLE]','Title',array('Mr.'=>'Mr.','Mrs.'=>'Mrs.','Ms.'=>'Ms.','Miss'=>'Miss', 'Dr'=>'Dr', 'Rev'=>'Rev'),'').'</TD><TD>'.TextInput($staff['FIRST_NAME'],'staff[FIRST_NAME]','<FONT class=red>First</FONT>','id=fname size="20" maxlength=50 class=cell_floating').'</TD><TD>'.TextInput($staff['MIDDLE_NAME'],'staff[MIDDLE_NAME]','Middle','size="18" maxlength=50 class=cell_floating').'</TD><TD>'.TextInput($staff['LAST_NAME'],'staff[LAST_NAME]','<FONT color=red>Last</FONT>','id=lname size="20" maxlength=50 class=cell_floating').'</TD></TR></TABLE>';
	else
		echo '<DIV id=user_name><div onclick=\'addHTML("<TABLE><TR><TD>'.str_replace('"','\"',SelectInput($staff['TITLE'],'staff[TITLE]','Title',array('Mr.'=>'Mr.','Mrs.'=>'Mrs.','Ms.'=>'Ms.','Miss'=>'Miss', 'Dr'=>'Dr', 'Rev'=>'Rev'),'','',false)).'</TD><TD>'.str_replace('"','\"',TextInput($staff['FIRST_NAME'],'staff[FIRST_NAME]',(!$staff['FIRST_NAME']?'<FONT color=red>':'').'First'.(!$staff['FIRST_NAME']?'</FONT>':''),'id=fname size=20 maxlength=50',false)).'</TD><TD>'.str_replace('"','\"',TextInput($staff['MIDDLE_NAME'],'staff[MIDDLE_NAME]','Middle','size=18 maxlength=50',false)).'</TD><TD>'.str_replace('"','\"',TextInput($staff['LAST_NAME'],'staff[LAST_NAME]',(!$staff['LAST_NAME']?'<FONT color=red>':'').'Last'.(!$staff['LAST_NAME']?'</FONT>':''),'id=lname size=20 maxlength=50',false)).'</TD></TR></TABLE>","user_name",true);\'>'.(!$staff['TITLE']&&!$staff['FIRST_NAME']&&!$staff['MIDDLE_NAME']&&!$staff['LAST_NAME']?'-':$staff['TITLE'].' '.$staff['FIRST_NAME'].' '.$staff['MIDDLE_NAME'].' '.$staff['LAST_NAME']).'</div></DIV><small>'.(!$staff['FIRST_NAME']||!$staff['LAST_NAME']?'<FONT color=red>':'<FONT color='.Preferences('TITLES').'>').'</FONT></small>';
echo'</td></tr>';
echo '<tr><td>Email Address</td><td>:</td><td>';
echo TextInput($staff['EMAIL'],'staff[EMAIL]','','size=25 maxlength=100 id=email class=cell_floating');

echo '</TD></tr>';
echo '<tr><td>Phone Number</td><td>:</td><td><table cellpadding=0 cellspacing=0><tr><td>';
echo TextInput($staff['PHONE'],'staff[PHONE]','','size=25 maxlength=100 class=cell_floating');
echo '</td></tr></table></TD>';
if($_REQUEST['staff_id']!='new')
{
echo '<TR><TD>';
echo 'Disable User</TD><TD>:</TD><TD>'.CheckboxInput($staff['IS_DISABLE'],'staff[IS_DISABLE]','','CHECKED',$new,'<IMG SRC=assets/check.gif width=15>','<IMG SRC=assets/x.gif width=15>');
echo '</TD></TR>';
echo '<TR><TD>';
echo 'Last Login</TD><TD>:</TD><TD>'.NoInput(ProperDate(substr($staff['LAST_LOGIN'],0,10)).substr($staff['LAST_LOGIN'],10));
echo '</TD></TR>';
echo '<TR><TD>';
echo 'Staff ID</TD><TD>:</TD><TD>'.NoInput($staff['STAFF_ID']);
echo '</TD></TR>';
}
echo '</TR>';

echo'</table></td>';

echo '<TD>';
$UserPicturesPath='assets/UserPhotos/';
$profile=DBGet(DBQuery('SELECT PROFILE FROM staff WHERE STAFF_ID=\''.UserStaffID().'\' '));
if($profile[1]['PROFILE']!='parent')
{
if($_REQUEST['staff_id']!='new' && $UserPicturesPath && (($file = @fopen($picture_path=$UserPicturesPath.'/'.UserStudentID().'.JPG','r')) || ($file = @fopen($picture_path=$UserPicturesPath.'/'.UserStaffID().'.JPG','r'))))
{
        fclose($file);
	echo '<div width=150 align="center"><IMG SRC="'.$picture_path.'?id='.rand(6,100000).'" width=150 class=pic>';
	if(User('PROFILE')=='admin' && User('PROFILE')!='student' && User('PROFILE')!='parent')
	echo '<br><a href=Modules.php?modname=Users/UploadUserPhoto.php?modfunc=edit style="text-decoration:none"><b>Update Staff\'s Photo</b></a></div>';
	else
	echo '';
}
else
{
	if($_REQUEST['staff_id']!='new')
	{
	echo '<div align="center"><IMG SRC="assets/noimage.jpg?id='.rand(6,100000).'" width=144 class=pic>';
	if(User('PROFILE')=='admin' && User('PROFILE')!='student' && User('PROFILE')!='parent')
	echo '<br><a href=Modules.php?modname=Users/UploadUserPhoto.php style="text-decoration:none"><b>Upload Staff\'s Photo</b></a></div>';
	}
	else
	echo '';
}
}
echo '</TD>';

echo '</TR>';


//echo '<TR>';
//echo '<TD>';
//echo CheckboxInput($staff['IS_DISABLE'],'staff[IS_DISABLE]','','CHECKED',$new,'<IMG SRC=assets/check.gif width=15>','<IMG SRC=assets/x.gif width=15>').'Disable User';
//echo '</TD>';

//echo '<TD>';
//echo NoInput(ProperDate(substr($staff['LAST_LOGIN'],0,10)).substr($staff['LAST_LOGIN'],10),'Last Login');
//echo '</TD>';
    
//echo '</TR>';
echo '</TABLE>';
echo '</TD></TR></TABLE>';
echo '<div class=break></div>';
echo '<TABLE border=0 cellpadding=6 width=100%>';
if(basename($_SERVER['PHP_SELF'])!='index.php')
{
	echo '<TR>';
	echo '<TD>';
	echo '<TABLE><tr><td style=width:100px>User Profile</td><td>:</td><td><TD>';
	unset($options);
		$profiles_options = DBGet(DBQuery('SELECT PROFILE ,TITLE, ID FROM user_profiles WHERE ID <> 0 ORDER BY ID'));
		$i = 1;
		foreach($profiles_options as $options)
		{
			
			$option[$options['ID']] = $options['TITLE'];
			$i++;
		}
	echo SelectInput($staff['PROFILE_ID'],'staff[PROFILE]',(!$staff['PROFILE']?'<FONT color=red>':'').''.(!$staff['PROFILE']?'</FONT>':''),$option,'','id=profile');
	

	echo '</TD></tr><tr><td style=width:100px>Permissions</td><td>:</td><td><TD>';
	unset($profiles);
	if(clean_param($_REQUEST['staff_id'],PARAM_ALPHANUM)!='new')
	{
		$profiles_RET = DBGet(DBQuery('SELECT ID,TITLE FROM user_profiles WHERE TITLE=\''.$staff[PROFILE].'\' AND ID <>0 ORDER BY ID'));
		foreach($profiles_RET as $profile)
			$profiles[$profile['ID']] = 'Default';
		$na = 'Custom';
	}
	else
		$na = 'Default';
	echo SelectInput($staff['PROFILE_ID'],'staff[Permissions]','',$profiles,$na);
	echo '</TD></TR></TABLE>';
	echo '</TD>';
	echo '<TD>'; 
	$schools_RET=  DBGet(DBQuery('SELECT s.ID,s.TITLE FROM schools s,staff st INNER JOIN staff_school_relationship ssr USING(staff_id) WHERE s.id=ssr.school_id AND ssr.syear='.UserSyear().' AND st.staff_id='.User('STAFF_ID')));
	unset($options);
	if(count($schools_RET) && User('PROFILE')=='admin')
	{
		$i = 0;
		$_SESSION[staff_school_chkbox_id]=0;
		//echo '<TABLE><TR>';
            if($staff['STAFF_ID'])
               $schools=GetUserSchools($staff['STAFF_ID']);
            //print_r($schools);
           //print_r($schools_RET_);
            #echo $staff['STAFF_ID'];
           
            
            
//		foreach($schools_RET as $value)
//		{   
//                    #echo $qqq='SELECT SCHOOL_ID,START_DATE,END_DATE FROM staff_school_relationship WHERE STAFF_ID=\''.$staff[STAFF_ID].'\' AND SCHOOL_ID=\''.$value[ID].'\' AND SYEAR=\''.  UserSyear().'\'';
//                    $dates=DBGet(DBQuery('SELECT SCHOOL_ID,START_DATE,END_DATE FROM staff_school_relationship WHERE STAFF_ID=\''.$staff[STAFF_ID].'\' AND SCHOOL_ID=\''.$value[ID].'\' AND SYEAR=\''.  UserSyear().'\'')); 
//                    #print_r($value);
//                   #print_r($dates);
//                    if($dates[1]['START_DATE']=='0000-00-00')
//                    {
//                      $dates[1]['START_DATE']='';  
//                    }
//                    if($dates[1]['END_DATE']=='0000-00-00')
//                    {
//                      $dates[1]['END_DATE']='';  
//                    }
//                            if(!empty ($q))
//                            {
//                            
//                            
//                            
//                            #echo $values['SCHOOL_ID'];
//                                $staff_school_chkbox_id++;
//			if($i%3==0) 
//				echo '</TR><TR>';
//                        echo '<TD>'.CheckboxInput(((in_array($value['ID'],$schools)==true)?'Y':''),'values[SCHOOLS]['.$value['ID'].']','','',true,'<IMG SRC=assets/check.gif width=15>','<IMG SRC=assets/x.gif width=15>',true,'id=staff_SCHOOLS'.$staff_school_chkbox_id).'<label for=staff_SCHOOLS'.$staff_school_chkbox_id.'>'.$value['TITLE'].'</label></TD>';
//                        echo '<TD>Start Date</TD>';
//                        echo '<TD>'.DateInput($dates[1]['START_DATE'],'values[SCHOOLS][START_DATE]['.$values['SCHOOL_ID'].']','').'</TD>';
//                        echo '<TD>End Date</TD>';
//                        echo '<TD>'.DateInput($dates[1]['END_DATE'],'values[SCHOOLS][END_DATE]['.$values['SCHOOL_ID'].']','').'</TD>';
//                        echo '</TR>';
//                        $i++;
//                            
// 
//                       
//                        
//                            }
//                            else {
//                         
//                                 $staff_school_chkbox_id++;
//			if($i%3==0) 
//				echo '</TR><TR>';
//                       echo '<TD>'.CheckboxInput(((in_array($value['ID'],$schools)==true)?'Y':''),'values[SCHOOLS]['.$value['ID'].']','','',true,'<IMG SRC=assets/check.gif width=15>','<IMG SRC=assets/x.gif width=15>',true,'id=staff_SCHOOLS'.$staff_school_chkbox_id).'<label for=staff_SCHOOLS'.$staff_school_chkbox_id.'>'.$value['TITLE'].'</label></TD>';
//                        echo '<TD>Start Date</TD>';
//                        echo '<TD>'.DateInput($dates[1]['START_DATE'],'values[START_DATE]['.$value['ID'].']','').'</TD>';
//                        echo '<TD>End Date</TD>';
//                        echo '<TD>'.DateInput($dates[1]['END_DATE'],'values[END_DATE]['.$value['ID'].']','').'</TD>';
//                        echo '</TR>';
//                        $i++;
//                      
//                            }
 
			
//		}
		
		//echo '</TR></TABLE>';
		
//                if(!$staff['PROFILE']) echo '<FONT color=red>Schools</FONT>';
//                else echo '<FONT color='.Preferences('TITLES').'>Schools</FONT>';
	}
	elseif(User('PROFILE')!='admin')
	{
		$i = 0;
		echo '<TABLE><TR><TD>Schools : </TD>';
		foreach($schools_RET as $value)
		{
			if($i%3==0)
				echo '</TR><TR>';
                    if(in_array($value['ID'],GetUserSchools($staff['STAFF_ID']))==true)
			echo '<TD align = center>'.$value['TITLE'].'</TD><TD>&nbsp;</TD>';              
			$i++;
		}
		echo '</TR></TABLE>';
	}
	
	echo '</TD>';
	echo '</TR>';
}
echo '<TR>';
echo '<TD><TABLE><tr><td style=width:100px>Username</td><td>:</td><td>';
echo TextInput($staff['USERNAME'],'staff[USERNAME]','','size=25 maxlength=100 class=cell_floating  onkeyup="usercheck_init(this)"');
echo '<div id="ajax_output"></div>';
echo '</TD></tr><tr><td style=width:100px>Password</td><td>:</td><td>';
//for adding new user
if(!isset($staff['STAFF_ID']))
{
 echo TextInput(array($staff['PASSWORD'],str_repeat('*',strlen($staff['PASSWORD']))),'staff[PASSWORD]','',"size=25 maxlength=100 class=cell_floating AUTOCOMPLETE = off onkeyup=passwordStrength(this.value);validate_password(this.value);");   
}
//for existing users while updating
 else
{
   echo TextInput(array($staff['PASSWORD'],str_repeat('*',strlen($staff['PASSWORD']))),'staff[PASSWORD]','',"size=25 maxlength=100 class=cell_floating AUTOCOMPLETE = off onkeyup=passwordStrength(this.value);validate_password(this.value,$staff[STAFF_ID]);"); 
}

echo "<span id='passwordStrength'></span>";
echo '</TD></TR></TABLE></TD>';
echo '</TR>';
echo '<TR><TD><TABLE>';
include('modules/Users/includes/Other_Info.inc.php');
echo '</TABLE></TD></TR>';
echo '<TR><td height="30px" colspan=2 class=hseparator><b>School Information </b></td></tr><tr><td colspan="2">';
$functions = array('START_DATE'=>'_makeStartInputDate','PROFILE'=>'_makeUserProfile','END_DATE'=>'_makeEndInputDate','SCHOOL_ID'=>'_makeCheckBoxInput_gen','ID'=>'_makeStatus');
#$functions2=array('SCHOOL_ID'=>'_makeCheckBoxInput_gen');

$sql='SELECT s.ID,ssr.SCHOOL_ID,s.TITLE,ssr.START_DATE,ssr.END_DATE,st.PROFILE FROM schools s,staff st INNER JOIN staff_school_relationship ssr USING(staff_id) WHERE s.id=ssr.school_id  AND st.staff_id='.User('STAFF_ID').' GROUP BY ssr.SCHOOL_ID';
$school_admin=DBGet(DBQuery($sql),$functions);
//$columns = array('SCHOOL_ID'=>'','START_DATE'=>'Start Date','END_DATE'=>'Drop Date','TITLE'=>'School');
$columns = array('SCHOOL_ID'=>'','TITLE'=>'School','PROFILE'=>'Profile','START_DATE'=>'Start Date','END_DATE'=>'Drop Date','ID'=>'Status');

echo '</TD></TR>';
echo '</TABLE>';
ListOutput($school_admin,$columns,'School Record','School Records',array(),array(),array('search'=>false));
$_REQUEST['category_id'] = 1;
//include('modules/Users/includes/Other_Info.inc.php');

function _makeStartInputDate($value,$column)
{
    global $THIS_RET;
    #print_r($THIS_RET);
    if($_REQUEST['staff_id']=='new')
    {
        $date_value='';
    }
    else
    {
//    $sql='SELECT ssr.START_DATE FROM staff s,staff_school_relationship ssr  WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR='.UserSyear();
    $sql='SELECT ssr.START_DATE FROM staff s,staff_school_relationship ssr  WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR=(SELECT MAX(SYEAR) FROM  staff_school_relationship WHERE SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND STAFF_ID='.$_SESSION['staff_selected'].')';
    $user_exist_school=DBGet(DBQuery($sql));
    if($user_exist_school[1]['START_DATE']=='0000-00-00' || $user_exist_school[1]['START_DATE']=='')
        $date_value='';
    else
       $date_value=$user_exist_school[1]['START_DATE']; 
    }
        return '<TABLE class=LO_field><TR>'.'<TD>'.DateInput2($date_value,'values[START_DATE]['.$THIS_RET['ID'].']','1'.$THIS_RET['ID'],'').'</TD></TR></TABLE>';
}

function _makeUserProfile($value,$column)
{
   global $THIS_RET;
    if($_REQUEST['staff_id']=='new')
    {
        $profile_value='';
    }
    else
    {
//    $sql='SELECT up.TITLE FROM staff s,staff_school_relationship ssr,user_profiles up  WHERE ssr.STAFF_ID=s.STAFF_ID AND up.ID=s.PROFILE_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR='.UserSyear();
      $sql='SELECT up.TITLE FROM staff s,staff_school_relationship ssr,user_profiles up  WHERE ssr.STAFF_ID=s.STAFF_ID AND up.ID=s.PROFILE_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR=(SELECT MAX(SYEAR) FROM  staff_school_relationship WHERE SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND STAFF_ID='.$_SESSION['staff_selected'].')';    
    $user_profile=DBGet(DBQuery($sql));
    $profile_value=  $user_profile[1]['TITLE'];  
    }
        return '<TABLE class=LO_field><TR>'.'<TD>'.$profile_value.'</TD></TR></TABLE>'; 
}

function _makeEndInputDate($value,$column)
{
    global $THIS_RET;
    if($_REQUEST['staff_id']=='new')
    {
        $date_value='';
    }
    else
    {
//    $sql='SELECT ssr.END_DATE FROM staff s,staff_school_relationship ssr  WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR='.UserSyear();
    $sql='SELECT ssr.END_DATE FROM staff s,staff_school_relationship ssr  WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR=(SELECT MAX(SYEAR) FROM  staff_school_relationship WHERE SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND STAFF_ID='.$_SESSION['staff_selected'].')';
    $user_exist_school=DBGet(DBQuery($sql));
    if($user_exist_school[1]['END_DATE']=='0000-00-00' || $user_exist_school[1]['END_DATE']=='')
        $date_value='';
    else
       $date_value=$user_exist_school[1]['END_DATE'];  
    }
        return '<TABLE class=LO_field><TR>'.'<TD>'.DateInput2($date_value,'values[END_DATE]['.$THIS_RET['ID'].']','2'.$THIS_RET['ID'].'','').'</TD></TR></TABLE>';
}
function _makeCheckBoxInput_gen($value,$column) 
{	
    global $THIS_RET;
    #print_r($THIS_RET);
    $_SESSION[staff_school_chkbox_id]++;
    $staff_school_chkbox_id=$_SESSION[staff_school_chkbox_id];
    if($_REQUEST['staff_id']=='new')
    {
      return '<TABLE class=LO_field><TR>'.'<TD>'.CheckboxInput('','values[SCHOOLS]['.$THIS_RET['ID'].']','','',true,'<IMG SRC=assets/check.gif width=15>','<IMG SRC=assets/x.gif width=15>',true,'id=staff_SCHOOLS'.$staff_school_chkbox_id).'</TD></TR></TABLE>';        
    }
    else
    {
//    $sql='SELECT SCHOOL_ID FROM staff s,staff_school_relationship ssr WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR='.UserSyear().' AND (ssr.END_DATE>=CURDATE() OR ssr.END_DATE=\'0000-00-00\')';
    $sql='SELECT SCHOOL_ID FROM staff s,staff_school_relationship ssr WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR=(SELECT MAX(SYEAR) FROM  staff_school_relationship WHERE SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND STAFF_ID='.$_SESSION['staff_selected'].') AND (ssr.END_DATE>=CURDATE() OR ssr.END_DATE=\'0000-00-00\')  ';
//    $sql='SELECT SCHOOL_ID FROM staff s,staff_school_relationship ssr WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR=(SELECT MAX(SYEAR) FROM  staff_school_relationship WHERE SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND STAFF_ID='.$_SESSION['staff_selected'].')';
    $user_exist_school=DBGet(DBQuery($sql));
    if(!empty($user_exist_school))
      return '<TABLE class=LO_field><TR>'.'<TD>'.CheckboxInput('Y','values[SCHOOLS]['.$THIS_RET['ID'].']','','',true,'<IMG SRC=assets/check.gif width=15>','<IMG SRC=assets/x.gif width=15>',true,'id=staff_SCHOOLS'.$staff_school_chkbox_id).'</TD></TR></TABLE>';
    else
      return '<TABLE class=LO_field><TR>'.'<TD>'.CheckboxInput('','values[SCHOOLS]['.$THIS_RET['ID'].']','','',true,'<IMG SRC=assets/check.gif width=15>','<IMG SRC=assets/x.gif width=15>',true,'id=staff_SCHOOLS'.$staff_school_chkbox_id).'</TD></TR></TABLE>';
    }
}

function _makeStatus($value,$column)
{
    global $THIS_RET;
    if($_REQUEST['staff_id']=='new')
        $status_value='';
    else
    {
//      $sql='SELECT SCHOOL_ID FROM staff s,staff_school_relationship ssr WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR='.UserSyear().' AND (ssr.END_DATE>=CURDATE() OR ssr.END_DATE=\'0000-00-00\')';
      $sql='SELECT SCHOOL_ID FROM staff s,staff_school_relationship ssr WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR=(SELECT MAX(SYEAR) FROM  staff_school_relationship WHERE SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND STAFF_ID='.$_SESSION['staff_selected'].') AND (ssr.END_DATE>=CURDATE() OR ssr.END_DATE=\'0000-00-00\') ';
//      $sql='SELECT SCHOOL_ID FROM staff s,staff_school_relationship ssr WHERE ssr.STAFF_ID=s.STAFF_ID AND ssr.SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND ssr.STAFF_ID='.$_SESSION['staff_selected'].' AND ssr.SYEAR=(SELECT MAX(SYEAR) FROM  staff_school_relationship WHERE SCHOOL_ID='.$THIS_RET['SCHOOL_ID'].' AND STAFF_ID='.$_SESSION['staff_selected'].')';
      $user_exist_school=DBGet(DBQuery($sql));
       if(!empty($user_exist_school))
         $status_value='Active';  
        else
        {
         $get_prev_schools=DBGet(DBQuery('SELECT COUNT(1) as TOTAL FROM staff_school_relationship WHERE STAFF_ID=\''.$_SESSION['staff_selected'].'\' AND  SCHOOL_ID=\''.$THIS_RET['SCHOOL_ID'].'\' '));
         if($get_prev_schools[1]['TOTAL']!=0)
         $status_value='Inactive';
         else
         $status_value='';
        }
    }    
     return '<TABLE class=LO_field><TR>'.'<TD>'.$status_value.'</TD></TR></TABLE>'; 
}

?>
