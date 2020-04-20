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

function addLessonNavigation($leftLink, $rightLink) {
	echo '<div style="width:100%; overflowlow: hidden;">';
	echo '<a style="float:left!important" href="' . $leftLink . '.php">&#8592;Previous Lesson</a>';
	echo '<a style="float:right!important" href="' . $rightLink . '.php">Next Lesson &#8594;</a>';
	echo '</div>';
	echo '<br>';
	echo '<br>';
}
