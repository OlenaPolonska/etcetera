<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/***
 * 管理画面
***/

	$is_act = false;
	if(get_option('bxslider_wp_dir')){
		$file= get_option('bxslider_wp_dir');
		$is_act = false;
		
		foreach ((array) get_option('active_plugins') as $val) {
			if (preg_match('/'.preg_quote($file, '/').'/i', $val)) {
				$is_act = true;
			}
		}
	}

?>


<div class="wrap" style="float:left;"><br/>
	<h1>bxSlider for WordPress <font size="2">v1.2.3</font></h1>

			
			
<?php
	 /***
	   *Saveされた時の処理
	 ***/

     $BxsliderWp_save = htmlspecialchars($_POST['BxsliderWp_save'], ENT_QUOTES);
		
		if ( isset( $BxsliderWp_save )){

		   //nonceチェック
	       if ( isset( $_POST['_wpnonce'] ) && $_POST['_wpnonce'] ) {
	            if ( check_admin_referer( 'bxslider_wp_nonce', '_wpnonce' ) ) {

		        	//POST取得
		        	
		        	$bxslider_wp_auto_start = ( $_POST['bxslider_wp_auto_start'] == 'true' )? 'true' : 'false';
				        update_option('bxslider_wp_auto_start', $bxslider_wp_auto_start);
			        
			        
			        if ($_POST['bxslider_wp_slide_mode'] == "horizontal" or $_POST['bxslider_wp_slide_mode'] == "fade"  or  $_POST['bxslider_wp_slide_mode'] == "vertical"){
				        $bxslider_wp_slide_mode = $_POST['bxslider_wp_slide_mode']; 
			        }
			        update_option('bxslider_wp_slide_mode', $bxslider_wp_slide_mode);
			        
			        
			        $bxslider_wp_slide_infiniteLoop = ( $_POST['bxslider_wp_slide_infiniteLoop'] == 'true' )? 'true' : 'false';
			        update_option('bxslider_wp_slide_infiniteLoop', $bxslider_wp_slide_infiniteLoop);
			        
			        
			        if (ctype_digit($_POST['bxslider_wp_slide_speed'])){
				        $bxslider_wp_slide_speed = (int) $_POST['bxslider_wp_slide_speed'];
				        update_option('bxslider_wp_slide_speed', $bxslider_wp_slide_speed);
			        }
			        
			        
			        if (ctype_digit($_POST['bxslider_wp_slide_delay'])){
				        $bxslider_wp_slide_delay = (int) $_POST['bxslider_wp_slide_delay'];
				        update_option('bxslider_wp_slide_delay', $bxslider_wp_slide_delay);
			        }
			        
			        
			        if (ctype_digit($_POST['bxslider_wp_slide_size'])){
				        $bxslider_wp_slide_size = (int) $_POST['bxslider_wp_slide_size'];
				        update_option('bxslider_wp_slide_size', $bxslider_wp_slide_size);
			        }
			        
			        
			        $bxslider_wp_slide_javascript = $_POST['bxslider_wp_slide_javascript'];
			        $bxslider_wp_slide_javascript = wp_kses($bxslider_wp_slide_javascript, array());
			        update_option('bxslider_wp_slide_javascript', $bxslider_wp_slide_javascript);
			        
			  		
			        update_option('bxslider_wp_home_image_url1', esc_url($_POST['bxslider_wp_home_image_url1'] ));
					update_option('bxslider_wp_home_image_url2', esc_url($_POST['bxslider_wp_home_image_url2'] ));
					update_option('bxslider_wp_home_image_url3', esc_url($_POST['bxslider_wp_home_image_url3'] ));
			        update_option('bxslider_wp_home_image_url4', esc_url($_POST['bxslider_wp_home_image_url4'] ));
			        
			        if ($is_act){
			        	if(get_option('bx_wp_btn_num') >= 5){
					        for( $i=5; $i<= get_option('bx_wp_btn_num'); $i++ ){			        
				    			update_option('bxslider_wp_home_image_url'.$i, esc_url($_POST['bxslider_wp_home_image_url'.$i] ));	
					        }
					    }
			        }	        
			        
			        
			        if ($_POST['bxslider_wp_home_image_url2_clear'] == "clear"){
				        delete_option('bxslider_wp_home_image_url2');	
			        }
			        
			        if ($_POST['bxslider_wp_home_image_url3_clear'] == "clear"){
				        delete_option('bxslider_wp_home_image_url3');	
			        }
			        
			        if ($_POST['bxslider_wp_home_image_url4_clear'] == "clear"){
				        delete_option('bxslider_wp_home_image_url4');	
			        }
			        if ($is_act){
			        	if(get_option('bx_wp_btn_num') >= 5){
					        for( $i=5; $i<= get_option('bx_wp_btn_num'); $i++ ){
					        	if ($_POST['bxslider_wp_home_image_url_clear'.$i] == "clear"){
						        delete_option('bxslider_wp_home_image_url'.$i);	
						        }
					        }
					    }
			        }
			        
			        if ($is_act){
				   		if (ctype_digit($_POST['BxsliderWp_addbtn'])){
				   			$BxsliderWp_addbtn = $_POST['BxsliderWp_addbtn'];
				   			$BxsliderWp_addbtn = ( $BxsliderWp_addbtn >= 50 )? 50 : $BxsliderWp_addbtn;
				   			$BxsliderWp_addbtn = ( $BxsliderWp_addbtn <= 4 )? 4 : $BxsliderWp_addbtn;
							update_option('bx_wp_btn_num', (int)$BxsliderWp_addbtn);	

				        }
					}
				}
			}
		}	
?>


	<form method="post" id="bxSliderWP_form" action="">
		<fieldset class="options">
		<table width="765" class="form-table" style="width:550px">
		
		
			<?php
				/***
				 * 画像アップロード用インプット・Javascript
				***/
			?>		
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Slide image 1', $this->textdomain );?> :</th> 
				<td width="430">
					  <input name="<?php echo bxslider_wp_home_image_url1; ?>" type="hidden" value="<?php echo esc_url(get_option('bxslider_wp_home_image_url1')); ?>" />
					  <input type="button" name="<?php echo bxslider_wp_home_image_url1; ?>_slect" value="<?php _e(esc_attr('Select', $this->textdomain )); ?>" />
					  <div id="<?php echo bxslider_wp_home_image_url1; ?>_thumbnail" class="uploded-thumbnail">
					    <?php if (get_option('bxslider_wp_home_image_url1')): ?>
					      <img src="<?php echo get_option('bxslider_wp_home_image_url1'); ?>" alt="Selected picture" style="max-width:300px;">
					    <?php endif ?>
					  </div>
			  </td>
				
			
			</tr>
			
			
			<?php
				/***
				 * 画像アップロード用インプット・Javascript
				***/
			?>		
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Slide image 2', $this->textdomain );?> :</th> 
				<td>
					  <input name="<?php echo bxslider_wp_home_image_url2; ?>" type="hidden" value="<?php echo esc_url(get_option('bxslider_wp_home_image_url2')); ?>" />
					  <input type="button" name="<?php echo bxslider_wp_home_image_url2; ?>_slect" value="<?php _e(esc_attr('Select', $this->textdomain )); ?>" />
					  <input type="checkbox" id="bxslider_wp_home_image_url2_clear" name="bxslider_wp_home_image_url2_clear" value="<?php echo (esc_attr("clear")); ?>"  />
						<?php _e('Clear', $this->textdomain ); ?>
					  <div id="<?php echo bxslider_wp_home_image_url2; ?>_thumbnail" class="uploded-thumbnail">
					    <?php if (get_option('bxslider_wp_home_image_url2')): ?>
					      <img src="<?php echo get_option('bxslider_wp_home_image_url2'); ?>" alt="Selected picture" style="max-width:300px;">
					    <?php endif ?>
					  </div>
				</td>
				

			
			</tr>
			
			
			<?php
				/***
				 * 画像アップロード用インプット・Javascript
				***/
			?>		
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Slide image 3', $this->textdomain );?> :</th> 
				<td>
					  <input name="<?php echo bxslider_wp_home_image_url3; ?>" type="hidden" value="<?php echo esc_url(get_option('bxslider_wp_home_image_url3')); ?>" />
					  <input type="button" name="<?php echo bxslider_wp_home_image_url3; ?>_slect" value="<?php _e(esc_attr('Select', $this->textdomain )); ?>" />
					  <input type="checkbox" id="bxslider_wp_home_image_url3_clear" name="bxslider_wp_home_image_url3_clear" value="<?php echo (esc_attr("clear")); ?>"  />
						<?php _e('Clear', $this->textdomain ); ?>
					  <div id="<?php echo bxslider_wp_home_image_url3; ?>_thumbnail" class="uploded-thumbnail">
					    <?php if (get_option('bxslider_wp_home_image_url3')): ?>
					      <img src="<?php echo get_option('bxslider_wp_home_image_url3'); ?>" alt="Selected picture" style="max-width:300px;">
					    <?php endif ?>
					  </div>
				</td>

			</tr>
			
			
			<?php
				/***
				 * 画像アップロード用インプット・Javascript
				***/
			?>		
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Slide image 4', $this->textdomain );?> :</th> 
				<td>
					  <input name="<?php echo bxslider_wp_home_image_url4; ?>" type="hidden" value="<?php echo esc_url(get_option('bxslider_wp_home_image_url4')); ?>" />
					  <input type="button" name="<?php echo bxslider_wp_home_image_url4; ?>_slect" value="<?php _e(esc_attr('Select', $this->textdomain )); ?>" />
					  <input type="checkbox" id="bxslider_wp_home_image_url4_clear" name="bxslider_wp_home_image_url4_clear" value="<?php echo (esc_attr("clear")); ?>"  />
						<?php _e('Clear', $this->textdomain ); ?>
					  <div id="<?php echo bxslider_wp_home_image_url4; ?>_thumbnail" class="uploded-thumbnail">
					    <?php if (get_option('bxslider_wp_home_image_url4')): ?>
					      <img src="<?php echo get_option('bxslider_wp_home_image_url4'); ?>" alt="Selected picture" style="max-width:300px;">
					    <?php endif ?>
					  </div>
				</td>
				
			</tr>
			
			
			<?php
			if ( $is_act == true ){
				if ( get_option('bxslider_wp_dir') ){
				if( get_option('bx_wp_btn_num' ) >= 5 ){
					for ($i = 1; $i <= get_option('bx_wp_btn_num')-4; $i++){
					
			?>
					
						<?php
							/***
							 * 画像アップロード用インプット・Javascript
							***/
						?>		
						<tr valign="top"> 
							<?php $y=$i+4; ?>
							
							<th width="108" scope="row"><?php _e('Slide image'.$y, $this->textdomain );?> :</th> 
							<td>
								  <input name="<?php echo bxslider_wp_home_image_url.$y; ?>" type="hidden" value="<?php echo esc_url(get_option('bxslider_wp_home_image_url'.$y)); ?>" />
								  <input type="button" name="<?php echo bxslider_wp_home_image_url.$y; ?>_slect" value="<?php _e(esc_attr('Select', $this->textdomain )); ?>" />
								  
								  <input type="checkbox" id="bxslider_wp_home_image_url_clear<?php echo $y; ?>" name="bxslider_wp_home_image_url_clear<?php echo $y; ?>" value="<?php echo (esc_attr("clear")); ?>"  />
									<?php _e('Clear', $this->textdomain ); ?>
								  
								  <div id="<?php echo bxslider_wp_home_image_url.$y; ?>_thumbnail" class="uploded-thumbnail">
								    <?php if (get_option('bxslider_wp_home_image_url'.$y)): ?>
								      <img src="<?php echo get_option('bxslider_wp_home_image_url'.$y); ?>" alt="Selected picture" style="max-width:300px;">
								    <?php endif ?>
								  </div>
							</td>
							
						</tr>			
			<?php

					}
				}
				}
			}
			?>
			
			
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Add pictures', $this->textdomain );?> :</th> 
				<td>
				<input name="BxsliderWp_addbtn" type="text" value="<?php echo _e(esc_attr(get_option('bx_wp_btn_num')));?>" size="5" placeholder="4"/>
				<?php if(!$is_act){ ?><a href= "https://global-s-h.com/shop/product/bxslider-for-wordpress-plus/" target="_blank"><?php _e('Pro version from here!', $this->textdomain ); ?></a><?php } ?>
				<br /><?php if($is_act){ ?><?php _e('<span style="color:#ed8702">Make sure to upload all ', $this->textdomain ); ?><?php echo _e(esc_attr(get_option('bx_wp_btn_num')));?><?php _e(' pictures.', $this->textdomain ); ?><br><?php _e(' Slider will not work properly.</span>', $this->textdomain ); ?><?php } ?>
				<br /><?php _e('You can add 50 more slide images with pro version!', $this->textdomain ); ?>
				<hr>
				</td> 
			</tr>			
			
			
			
		<?php wp_nonce_field( 'bxslider_wp_nonce', '_wpnonce' ); ?>

			<tr valign="top" style="white-space:nowrap;">
				<th width="108" scope="row"><?php _e('Auto start', $this->textdomain );?> :</th> 
				<td>
				<input type="radio" name="bxslider_wp_auto_start" value="<?php echo (esc_attr("true")); ?>" <?php if(get_option('bxslider_wp_auto_start') == "true") echo('checked'); ?> />
				<?php _e('true', $this->textdomain );?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="bxslider_wp_auto_start" value="<?php echo (esc_attr("false")); ?>" <?php if(get_option('bxslider_wp_auto_start') == "false") echo('checked'); ?> />
				<?php _e('false', $this->textdomain );?><br />
				</td>
			</tr>

			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Infinite loop', $this->textdomain );?> :</th> 
				<td>
				<input type="radio" name="bxslider_wp_slide_infiniteLoop" value="<?php echo (esc_attr("true")); ?>" <?php if(get_option('bxslider_wp_slide_infiniteLoop') == "true") echo('checked'); ?> />
				<?php _e('true', $this->textdomain );?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="bxslider_wp_slide_infiniteLoop" value="<?php echo (esc_attr("false")); ?>" <?php if(get_option('bxslider_wp_slide_infiniteLoop') == "false") echo('checked'); ?> />
				<?php _e('false', $this->textdomain );?><br />
				</td>
			</tr>
			
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Slide mode', $this->textdomain );?> :</th> 
				<td>
				<input type="radio" name="bxslider_wp_slide_mode" value="<?php echo (esc_attr("horizontal")); ?>" <?php if(get_option('bxslider_wp_slide_mode') == "horizontal") echo('checked'); ?> />
				<?php _e('horizontal', $this->textdomain );?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="bxslider_wp_slide_mode" value="<?php echo (esc_attr("fade")); ?>" <?php if(get_option('bxslider_wp_slide_mode') == "fade") echo('checked'); ?> />
				<?php _e('fade', $this->textdomain );?>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="bxslider_wp_slide_mode" value="<?php echo (esc_attr("vertical")); ?>" <?php if(get_option('bxslider_wp_slide_mode') == "vertical") echo('checked'); ?> />
				<?php _e('vertical', $this->textdomain );?><br />
				</td>
			</tr>

			<tr valign="top" style="white-space:nowrap;">
				<th width="108" scope="row"><?php _e('Slide size', $this->textdomain );?> :</th> 
				<td>
				<input name="bxslider_wp_slide_size" type="text" value="<?php echo _e(esc_attr(get_option('bxslider_wp_slide_size')));?>" size="30"/>
				<br /><?php _e('Size of the slider. Put 0 for full width', $this->textdomain ); ?></td> 
			</tr>
			
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Speed', $this->textdomain );?> :</th> 
				<td>
				<input name="bxslider_wp_slide_speed" type="text" value="<?php echo _e(esc_attr(get_option('bxslider_wp_slide_speed')));?>" size="30"/>
				<br /><?php _e('Speed of the slide', $this->textdomain ); ?></td> 
			</tr>

			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Delay', $this->textdomain );?> :</th> 
				<td>
				<input name="bxslider_wp_slide_delay" type="text" value="<?php echo _e(esc_attr(get_option('bxslider_wp_slide_delay')));?>" size="30"/>
				<br /><?php _e('The time to the next slide', $this->textdomain ); ?></td> 
			</tr>
			
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Add Javascript', $this->textdomain );?> :</th> 
				<td>
				<textarea name="bxslider_wp_slide_javascript" cols="60" rows="7" type="text" size="60"placeholder="autoControls: true,&#13;&#10;stopAutoOnClick: true,&#13;&#10;pager: true,&#13;&#10;slideWidth: 600" /><?php echo _e(esc_attr(get_option('bxslider_wp_slide_javascript')));?></textarea>
				<br /><?php _e('<span style="color:#ed8702">Be careful. bxslider will not work if the written Javascript is wrong.</span><br>You can put options for bxSlider. <a href="https://bxslider.com/options/" target="_blank">Explanation</a><br>example: <br><br>auto: true,<br>
									  autoControls: true,<br>
									  stopAutoOnClick: true,<br>
									  pager: true,<br>
									  slideWidth: 600', $this->textdomain ); ?></td> 
			</tr>
			<tr>
			    <th width="108" scope="row"><?php _e('Save setting', $this->textdomain );?> :</th> 
			    <td>
				<input type="submit" name="BxsliderWp_save" value="<?php _e(esc_attr('Save', $this->textdomain )); ?>" /><br /></td>
		    </tr>
		    
			<tr valign="top"> 
				<th width="108" scope="row"><?php _e('Use shortcode', $this->textdomain );?> :</th> 
				<td>
				<?php _e('<span style="font-size:19px;"><strong>How to use</strong></span><br>
							To show your bxSlider, paste the red shortcode below to the page.<br>
							If you want your bxSlider to the header section on the theme file, please add the surrounded gray PHP code as well. ', $this->textdomain ); ?><br><br>
							
							<div style="border: solid #c6c6c6 1px;background-color:white;padding:12px;"><span style="color:gray">&lt;?php echo do_shortcode('<span style="color:red"><br>[BxSlider_for_WP]<br></span>'); ?&gt;</span>
				</td> 
			</tr>
			
			</table>
		</fieldset>
	</form>
	</table>

</div>


<div style="float:right;margin-top:200px;">
<?php _e('Please see the explanation of this plugin from here!', $this->textdomain );?>
<br />
<a href="https://global-s-h.com/bxsliderwp/en/" target="_blank">Explanation</a>

| <a href="https://global-s-h.com/bxsliderwp/en/" target="_blank"><?php _e('Help page for troubles', $this->textdomain );?> </a> | <a href="https://global-s-h.com/bxsliderwp/en/index.php#donate" target="_blank"> <?php _e('Donate', $this->textdomain );?> </a> | 
<br /><br />
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fwebshakehands&amp;width=285&amp;height=65&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false&amp;" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:305px; height:65px;" allowTransparency="true"></iframe>

</div>


<?php
/***
 * 画像アップロード用インプット・Javascript
***/



$bxslider_wp_pic_number = ( $is_act == true )? get_option('bx_wp_btn_num') : 4;
?>

<?php $i = 0; for ($i = 1; $i <= $bxslider_wp_pic_number; $i++){ ?>

  <script type="text/javascript">
  jQuery(function ($) {
 
      var custom_uploader;

       $("input:button[name=<?php echo bxslider_wp_home_image_url.$i; ?>_slect]").click(function(e) {
 
          e.preventDefault();
 
          if (custom_uploader) {
 
              custom_uploader.open();
              return;
 
          }
 
          custom_uploader = wp.media({
 
              title: "Please select a picture",
 
              /* ライブラリの一覧は画像のみにする */
              library: {
                  type: "image"
              },
 
              button: {
                  text: "Select"
              },
 
              /* 選択できる画像は 1 つだけにする */
              multiple: false
 
          });
          
 
        custom_uploader.on("select", function() {
 
              var images = custom_uploader.state().get("selection");
 
              /* file の中に選択された画像の各種情報が入っている */
              images.each(function(file){
 
                  /* hiddenと表示されたサムネイル画像があればクリア */
                  $("input:hidden[name=<?php echo bxslider_wp_home_image_url.$i; ?>]").val("");
                  $("#<?php echo bxslider_wp_home_image_url.$i; ?>_thumbnail").empty();
 
                  /* テキストフォームに画像の URL を表示 */
                  $("input:hidden[name=<?php echo bxslider_wp_home_image_url.$i; ?>]").val(file.attributes.sizes.full.url);
                  
                  /* プレビュー用に選択されたサムネイル画像を表示 */
                  $("#<?php echo bxslider_wp_home_image_url.$i; ?>_thumbnail").append('<img src="'+file.attributes.sizes.full.url+'" style="max-width:300px;" />');
                  
              });
         });
 
          custom_uploader.open();
 
      });
      
  })(jQuery);
  </script>
  
<?php } ?>