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
error_reporting(0);
include('Redirect_root.php');
include("data.php");
$connection=mysql_connect($DatabaseServer,$DatabaseUsername,$DatabasePassword);
mysql_select_db($DatabaseName,$connection);
$log_msg=mysql_fetch_assoc(mysql_query("SELECT MESSAGE FROM login_message WHERE DISPLAY='Y'"));
//mysql_query("CALL SEAT_COUNT()");
Warehouse('header');
	echo '<link rel="stylesheet" type="text/css" href="styles/login.css">';
	echo '<script type="text/javascript" src="js/tabmenu.js"></script>';
	echo "
	<script type='text/javascript'>
	function delete_cookie (cookie_name)
		{
  			var cookie_date = new Date ( );
  			cookie_date.setTime ( cookie_date.getTime() - 1 );
			  document.cookie = cookie_name += \"=; expires=\" + cookie_date.toGMTString();
		}
                
</script>";
	echo "<BODY onLoad='document.loginform.USERNAME.focus();  delete_cookie(\"dhtmlgoodies_tab_menu_tabIndex\");'>";
	echo "";
	
	echo "<div class='container' style='max-width:330px'>
	<form name=loginform method='post' class='form-signin' action='index.php' role='form'>
    <h2 class='form-signin-heading'><img src='assets/logoupc.png' width='100%' ></h2>
    <input name='USERNAME' placeholder='User' type='text' class='form-control' required autofocus>

    <input name='PASSWORD' class='form-control' placeholder='Password' type='password' AUTOCOMPLETE = 'off' required>
    <input name='' type='submit' class='btn btn-lg btn-primary btn-block' value='Send' onMouseDown=Set_Cookie('dhtmlgoodies_tab_menu_tabIndex','',-1) />";
    echo "</form>";
    if($_REQUEST['maintain']=='Y'){
        echo "<div class='alert alert-danger' role='alert'>openSIS is under maintenance and login privileges have been turned off. Please log in when it is available again.</div>";
          }
      $mesanjeError = ErrorMessage($error,'Error');
      if ($mesanjeError != null) {
        echo "<div class='alert alert-danger' role='alert'>".$mesanjeError."</div>";
      }
     
  echo "<div class='alert alert-info' role='alert'>".$log_msg['MESSAGE']."</div>";
  echo '</div>';
    

	Warehouse("footer");
?>
