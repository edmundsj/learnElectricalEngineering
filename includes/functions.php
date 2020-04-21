<?php

function beginPage() {
	echo '<body class="is-preload">';
	echo '<div id="wrapper">';
}

function endPage() {
	echo '</div>';
	echo '</body>';
	echo '</html>';
}

function beginWrapper() {
	echo '<div id="main">';
	echo '<div class="inner">';
}

function endWrapper() {
	echo '</div>';
	echo '</div>';
}

function addLessonNavigation($leftLink, $rightLink, $leftName="", $rightName="") {
	echo '<div style="width:100%; overflowlow: hidden;">';
	echo '<a style="float:left!important" href="' . $leftLink . '">&#8592;Previous Lesson: ' . $leftName . '</a>';
	echo '<a style="float:right!important" href="' . $rightLink . '">Next Lesson: ' . $rightName . ' &#8594;</a>';
	echo '</div>';
	echo '<br>';
	echo '<br>';
}

function addMobileImageFull($imageName) {
	echo '<div style="width:100%; overflow: hidden;">';
	echo '<img src="/images/' . $imageName . '", style="width:auto; height:auto; max-width:100%" />';
	echo '</div>';
}

function addMobileImage($imageName, $alignment="left") {
	echo '<img src="/images/' . $imageName . '", align="' . $alignment . '", style="width:auto; height: auto; max-width:100%" />';
}
