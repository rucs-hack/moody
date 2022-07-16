<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
	<p><b>Moody</b> is a cross platform concurrent n-body model development framework written in C++ and QT. It is designed primarily for use in Celestial Mechanics and Astrodynamics research. Moody provides lock free concurrency through either Intel Thread Building Blocks or OpenMP, and will scale to fit the number of processors available to it.</p>

	<h2 style = "text-align: center;">Introduction</h2>

	<p>Writing code to perform n-Body experiments is a complex process. There is often a great deal of supporting code that must be created before actual experimentation can begin. Moody exists to simplify that process. You can either use the existing features, or extend Moody to add new functionality that suits your needs. Moody was designed under the assumption that you might do either of these things.</p>
	<p>Breif Summary of Features:</p>
    	<ul class = "generalList">
		<li>Orbital Mechanics and Evolutionary Computation functionality.</li>
		<li>Support for two commonly used cross platform concurrency libraries.</li>
		<li>Three parallel n-body algorithms, with versions of each for both of the supported concurrency libraries.</li>
		<li>Comprehensive particle management and manipulation functionality.</li>
		<li>An easy to understand xml project format to hold your particle data and experiment configuration.</li>
		<li>A time series result file format with its own viewer.</li>
	</ul>
	<p>If you have a question to ask, bugs to report or a suggestion regarding Moody you can get in touch with me via email at <a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#99;&#97;&#114;&#101;&#121;&#46;&#112;&#114;&#105;&#100;&#103;&#101;&#111;&#110;&#64;&#99;&#111;&#118;&#101;&#110;&#116;&#114;&#121;&#46;&#97;&#99;&#46;&#117;&#107;">&#99;&#97;&#114;&#101;&#121;&#46;&#112;&#114;&#105;&#100;&#103;&#101;&#111;&#110;&#64;&#99;&#111;&#118;&#101;&#110;&#116;&#114;&#121;&#46;&#97;&#99;&#46;&#117;&#107;</a></p>
	<div class = "horizontalDivider"></div>
	<h2 style = "text-align: center;">News</h2>
		<h4>28/08/2011</h4>
		<p class = "announce">Bugfix release - 2.01</p>
		<p>Moody has been updated to include a fix to the AU distance calculation in MopViewer. The Windows binary has been updated.</p>

			<h4>14/08/2011</h4>
		<p class = "announce">New release - 2.0</p>
		<p>Moody 2.0 introduces some significant changes.</p>
		<p>Moody is now available as a python module, called pyMoody, so you can use python rather than C++ to build experiments. Since this module wraps the c++ code there is no loss of speed.</p>
		<p>The Mop File format has been changed. The read/write interface is the same, but the files are no longer binary, which removes a problem with the previous binary format not being properly cross platform.</p>

	</ul>


		

	<div class = "horizontalDivider"></div>
	<p style = "text-align: center;">Author: <a href="http://www.politespider.com/">Dr Carey Pridgeon</a>, email <a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#99;&#97;&#114;&#101;&#121;&#46;&#112;&#114;&#105;&#100;&#103;&#101;&#111;&#110;&#64;&#99;&#111;&#118;&#101;&#110;&#116;&#114;&#121;&#46;&#97;&#99;&#46;&#117;&#107;">&#99;&#97;&#114;&#101;&#121;&#46;&#112;&#114;&#105;&#100;&#103;&#101;&#111;&#110;&#64;&#99;&#111;&#118;&#101;&#110;&#116;&#114;&#121;&#46;&#97;&#99;&#46;&#117;&#107;</a></p>


</div>
<?php
include("includes/footer.php");
?>
