<?php
/*
Plugin Name: eBibleicious
Version: 1.02
Plugin URI: http://ebible.com/toolkit/developers
Description: Automatically finds and brings all Bible references to life! (For Wordpress 1.5+)
Author: Team eBible
Author URI: http://ebible.com
*/

if (! function_exists('includeJSHeader')) {

    function includeJSHeader() {
        $mode = get_option('ebible_mode');

        // build the script include tag
        $content = "<script type=\"text/javascript\" src=\"http://www.ebible.com/api/ebibleicious?mode=".$mode."&amp;translation=".get_option('ebible_translation')."&amp;new_window=".get_option('ebible_new_window')."&amp;key=".get_option('ebible_devkey')."&amp;related_topics=".get_option('ebible_related_topics')."&amp;element=".get_option('ebible_element')."&amp;class_name=".get_option('ebible_class_name')."&amp;v=".get_option('ebible_version')."\"></script>";

    	// append default stylesheet if requested and in mouseover or snippet mode
    	if (get_option('ebible_stylesheet') == 'true' && ($mode == 'mouseover' || $mode == 'snippet')) {
			$content = $content."<link href='http://ebible.com/stylesheets/ebSnippet.css' media='screen' rel='Stylesheet' type='text/css' />";
		}
    	echo $content;

    }
}

// add an admin options subpanel
if (! function_exists('ebible_admin')) {
  function ebible_admin() {
    if (function_exists('add_options_page')) {
      add_options_page('eBibleicious Plugin Options', 'eBibleicious', 9, basename(__FILE__), 'ebible_adminpanel');
    }
  }
}

if (! function_exists('ebible_adminpanel')) {
  function ebible_adminpanel() {

    if (isset($_POST['info_update'])) {
      if ($_POST['ebible_devkey'] == "") {
		$_POST['ebible_devkey'] = "";
      }

      if ($_POST['ebible_mode'] == "") {
		$_POST['ebible_mode'] = "mouseover";
      }

      if ($_POST['ebible_translation'] == "") {
		$_POST['ebible_translation'] = "NKJV";
      }

      if ($_POST['ebible_class_name'] == "") {
		$_POST['ebible_class_name'] = "ebdPassage";
      }

      if ($_POST['ebible_stylesheet'] == "") {
		$_POST['ebible_stylesheet'] = "true";
      }

      if ($_POST['ebible_related_topics'] == "") {
		$_POST['ebible_related_topics'] = "5";
      }

      if ($_POST['ebible_element'] == "") {
		$_POST['ebible_element'] = "content";
      }

      if ($_POST['ebible_new_window'] == "") {
		$_POST['ebible_new_window'] = "false";
      }

      if ($_POST['ebible_version'] == "") {
		$_POST['ebible_version'] = "1.0";
      }

      update_option('ebible_devkey', $_POST['ebible_devkey']);
      update_option('ebible_mode', $_POST['ebible_mode']);
      update_option('ebible_translation', $_POST['ebible_translation']);
      update_option('ebible_class_name', $_POST['ebible_class_name']);
      update_option('ebible_stylesheet', $_POST['ebible_stylesheet']);
      update_option('ebible_related_topics', $_POST['ebible_related_topics']);
      update_option('ebible_element', $_POST['ebible_element']);
      update_option('ebible_new_window', $_POST['ebible_new_window']);
	  update_option('ebible_version', $_POST['ebible_version']);

	  ?>
	  <div class="updated"><p><b>Options are now updated.</b></p></div>
	  <?php

	}

  ?>
  	<style>
  	.ebible-option {
  		margin-bottom: 15px;
  		margin-left: 30px;
  	}
  	.ebible-option #label {
  		font-decoration: bold;
  	}
    </style>
	<div class="wrap">
		<h2>eBibleicious Options</h2>
		<form method="post">

		<h4>Bring your Bible references to life!</h4>
		<br/>
		<div class="option-section">
			To use the eBible.com plugin, you must have a developer key. After signing up as a free user you can <a href="http://www.ebible.com/api/signup">register for a key here</a>.<br /><br />

			<div class="ebible-option">
				<label for="ebible_devkey">Developer key:</label><br /><input id="ebible_devkey" type="text" name="ebible_devkey" value="<?php echo get_option('ebible_devkey'); ?>" size="30">
			</div>


			<div class="ebible-option">
			<label for="ebible_mode">eBibleicious Mode:</label><br />
				<input id="ebible_mode_mouseover" name="ebible_mode" type="radio" value="mouseover" <?php if(get_option('ebible_mode') == "mouseover") echo "checked" ?> />
					<label for="ebible_mode_mouseover" title="Displays the passage in a javascript popup when moused over">
						Mouseover
					</label><br />

				<input id="ebible_mode_snippet" name="ebible_mode" type="radio" value="snippet" <?php if(get_option('ebible_mode') == "snippet") echo "checked" ?> />
					<label for="ebible_mode_snippet" title="Dynamically replaces all passage references with the actual passage text as a snippet">
						Snippet
					</label><br />

				<input id="ebible_mode_link" name="ebible_mode" type="radio" value="link" <?php if(get_option('ebible_mode') == "link") echo "checked" ?> />
					<label for="ebible_mode_link" title="Simply hyperlinks all passage references to eBible.com 'Quick View' page">
						Link
					</label><br />

				<input id="ebible_mode_study" name="ebible_mode" type="radio" value="study" <?php if(get_option('ebible_mode') == "study") echo "checked" ?> />
					<label for="ebible_mode_study" title="Simply hyperlinks all passage references directly to eBible.com 'Study Browser'">
						Study
					</label>
			</div>

			<div class="ebible-option">
				<label for="ebible_translation">Translation</label><br /><input id="ebible_translation" type="text" name="ebible_translation" value="<?php echo get_option('ebible_translation'); ?>" size="5">
			    Must be one of: NASB, MSG, KJV, NKJV, ESV, HCSB, NCV, SpaRV, ItalRV
			</div>

			<div class="ebible-option">
				<label for="ebible_stylesheet">Include default CSS stylesheet?</label> <input id="ebible_stylesheet" name="ebible_stylesheet" value="false" type="checkbox" <?php if(get_option('ebible_stylesheet') == "true") echo "checked" ?> />
			</div>

			<div class="ebible-option">
				<label for="ebible_related_topics">Number of related topics to show:</label><br /><input id="ebible_related_topics" type="text" name="ebible_related_topics" value="<?php echo get_option('ebible_related_topics'); ?>" size="10">
			</div>

			<div class="ebible-option">
				<label for="ebible_new_window">Open links in a new window?</label> <input id="ebible_new_window" name="ebible_new_window" value="true" type="checkbox" <?php if(get_option('ebible_new_window') == "true") echo "checked" ?> />
			</div>

			<div class="ebible-option">
				<label for="ebible_class_name">HTML Class Name to mark references with:</label><br /><input id="ebible_class_name" type="text" name="ebible_class_name" value="<?php echo get_option('ebible_class_name'); ?>" size="10">
			</div>

			<div class="ebible-option">
				<label for="ebible_element">HTML Element to search for references within:</label><br /><input id="ebible_element" type="text" name="ebible_element" value="<?php echo get_option('ebible_element'); ?>" size="10">
			</div>

			<div class="ebible-option">
				<label for="ebible_version">Version:</label><br /><input id="ebible_version" type="text" name="ebible_version" value="<?php echo get_option('ebible_version'); ?>" size="5">
			</div>

		<br /><br />
		<input type="submit" name="info_update" value="Update Options" /><br /><br />

		</form>

	</div>
  <?php

  }
}

add_action('admin_menu', 'ebible_admin');
add_action('wp_head', 'includeJSHeader', 40);

?>