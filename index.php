<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Image Gallery Template</title>
		<link rel="stylesheet" href="css/basic.css" type="text/css" />
		<link rel="stylesheet" href="css/galleriffic-3.css" type="text/css" />
		<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="js/jquery.history.js"></script>
		<script type="text/javascript" src="js/jquery.galleriffic.js"></script>
		<script type="text/javascript" src="js/jquery.opacityrollover.js"></script>
		<!-- We only want the thunbnails to display when javascript is disabled -->
		<script type="text/javascript">
			/*
			// Uncomment below code to refresh page automatically after 5 second
			if(window.top==window) {
				// you're not in a frame so you reload the site
				window.setTimeout('location.reload()', 5000); //reloads after 5 seconds
			} else {
				//you're inside a frame, so you stop reloading
			}
			*/
			
			document.write('<style>.noscript { display: none; }</style>');
			
		</script>
		<style type='text/css'>.slideshow-container img { width:500px; height:500px; } </style>
	</head>
	<body>
		<div id="page">
			<div id="container">
				<table width='100%' border='0' style='margin-bottom:30px;'>
				<tr><td width='50%'><h1><img src='css/Logo.png' height='50px' width='175px' border='0' /></h1></td>
				<td style='text-align:right;' width='50%'><h2> Right <span style='color:red'>Side</span> Text</h2></td></tr>
				</table>
				<!-- Start Advanced Gallery Html Containers -->
				<div id="gallery" class="content">
					<div id="controls" class="controls"></div>
					<div class="slideshow-container">
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container"></div>
				</div>
				<div id="thumbs" class="navigation">
					<ul class="thumbs noscript">
					<?php
						if ($handle = opendir("images/")) {
							while (false !== ($entry = readdir($handle))) {
								if ($entry == '.' || $entry == '..'){
									echo "";
								} else if (is_dir($entry)) {	//	check if it a directory
									echo "";
								} else {
									$type = substr($entry, -4, 4);
									if ($type == ".jpg") {	// match a particular file extension
										echo '<li>
											<a name="'.$entry.'" class="thumb" height="500px" width="500px" href="images/'.$entry.'">
												<img src="images/'.$entry.'" width="130px" height="150px" alt="'.$entry.'" />
											</a><div class="caption">
												<div class="download">
													<a href="images/'.$entry.'">Enlarge Image</a>
												</div>
											</div>
										</li>';
									}
								}
							}
						}
					?>
					</ul>
				</div>
				<!-- End Advanced Gallery Html Containers -->
				<div style="clear: both;"></div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				// We only want these styles applied when javascript is enabled
				$('div.navigation').css({'width' : '300px', 'float' : 'left'});
				$('div.content').css('display','block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs ul.thumbs li').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});
				
				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs').galleriffic({
					delay:                     4000,
					numThumbs:                 6,
					preloadAhead:              10,
					enableTopPager:            true,
					enableBottomPager:         true,
					maxPagesToShow:            4,
					imageContainerSel:         '#slideshow',
					controlsContainerSel:      '#controls',
					captionContainerSel:       '#caption',
					loadingContainerSel:       '#loading',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              '',
					pauseLinkText:             '',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             true,
					autoStart:                 true,
					syncTransitions:           true,
					defaultTransitionDuration: 900,
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							.eq(nextIndex).fadeTo('fast', 1.0);
					},
					onPageTransitionOut:       function(callback) {
						this.fadeTo('fast', 0.0, callback);
					},
					onPageTransitionIn:        function() {
						this.fadeTo('fast', 1.0);
					}
				});

				/**** Functions to support integration of galleriffic with the jquery.history plugin ****/

				// PageLoad function
				// This function is called when:
				// 1. after calling $.historyInit();
				// 2. after calling $.historyLoad();
				// 3. after pushing "Go Back" button of a browser
				function pageload(hash) {
					// alert("pageload: " + hash);
					// hash doesn't contain the first # character.
					if(hash) {
						$.galleriffic.gotoImage(hash);
					} else {
						gallery.gotoIndex(0);
					}
				}

				// Initialize history plugin.
				// The callback is called at once by present location.hash. 
				$.historyInit(pageload, "advanced.html");

				// set onlick event for buttons using the jQuery 1.3 live method
				$("a[rel='history']").live('click', function(e) {
					if (e.button != 0) return true;
					
					var hash = this.href;
					hash = hash.replace(/^.*#/, '');

					// moves to a new page. 
					// pageload is called at once. 
					// hash don't contain "#", "?"
					$.historyLoad(hash);

					return false;
				});

				/****************************************************************************************/
			});
		</script>
	</body>
</html>