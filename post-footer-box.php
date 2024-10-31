<?php
/*
Plugin Name: Post Footer Box
Plugin URI: http://taylormarek.com/2010/10/29/post-footer-box-wordpress-plugin/
Description: Add a custom text box to the blog post footer to encourage reader interaction.
Author: Taylor Marek
Version: 1.0
Author URI: http://taylormarek.com
*/

/*
Copyright (C) 2010 Taylor Marek, taylormarek.com (taylor AT taylormarek DOT com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

function cbox_options()
{
	add_options_page('Post Footer', 'Post Footer', 'administrator', basename(__FILE__), 'cbox_options_page');
}

function cbox_options_page()
{ ?>
<div class="wrap">
<div class="icon32" id="icon-options-general"><br /></div>
<h2 style="margin-bottom: 20px;">Post Footer Box Options</h2>

<div class="dlm" id="poststuff">
<form style="border: medium none; background: none repeat scroll 0% 0% transparent;" method="post" action="options.php">
<?php
	if(function_exists('settings_fields')){
		settings_fields('cbox-options');
	} else {
		wp_nonce_field('update-options');
		?>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="cbox_content" />
		<?php
	}
?>

	<div class="postbox">
		<h3 class="hndle"><span>General Options</span></h3>
		<div class="inside"><table class="form-table"><tbody>
		<tr>
			<th><label for="cbox_content">Insert Text Here</label></th>
			<td><input class="code" type="text" name="cbox_content" id="cbox_content" size="73" value="<?php echo(htmlentities(get_option('cbox_content'))); ?>" /></td>
		</tr>
		<tr>
		</tbody></table></div>
	</div>
	<p class="submit">
		<input type="submit" class="button-primary" name="Submit" value="Save Changes" />
	</p>
</form>
</div>
</div>
<?php }

function cbox_style()
{ ?>
<style type="text/css">
#custom-box {
background:#ffffcc;
border:1px solid #ddd;
margin:auto;
padding:10px;
width:auto;
}

</style>
<?php }

function cbox_show($content)
{
	global $post;
	$box = '';
	
	if (is_single()) {
		$box = '<div id="custom-box">';
		$box .= $img . "\n"
		. '<div style="float:left; text-align:center; padding-left:10px; ' . (($img != '') ? 'width:330px;' : '') . '">' . "\n";
		$box .= '<p>' . get_option('cbox_content') . '</p>' . "\n";
		$box .= '</div>';
		$box .= '<div style="clear:both"></div></div>';
	}
	
	return $content . $box;
}

// On access of the admin page, register these variables (required for WP 2.7 & newer)
function cbox_init(){
    if(function_exists('register_setting')){
        register_setting('cbox-options', 'cbox_content');
    }
}

if(is_admin()){
    add_action('admin_menu', 'cbox_options');
	add_action('admin_init', 'cbox_init');
}

// Set the default options when the plugin is activated
function cbox_activation()
{
	add_option('cbox_content', 'This is where you can type out your text. Keep it short and sweet. A paragraph would be acceptable.');
}

register_activation_hook( __FILE__, 'cbox_activation');

add_filter('the_content', 'cbox_show');
add_filter('wp_head', 'cbox_style');

?>