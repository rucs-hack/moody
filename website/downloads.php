<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">

		<h1>Downloads</h1>
		<p>The Moody n-Body model development framework has several componants, all of which are available for download on this page. <span style="">Scroll down</span> to see them all and download what you need. </p>
		<a name="moody"></a> 
		<h2>Moody</h2>
		<p>Moody Source Code</p>
			<div class="linkSurroundDownload" style = "width: 100px;">
			<a href="http://www.politespider.com/moody/releases/moody_src-all_platforms.zip" >Download</a>
			</div>
			<p style="">Current Version: 2.01 - 28/08/2011</p>
			<p>This package is cross platform. Visual Studio 2010 is required for Windows. For Linux or Mac, use the provided Makefile</p>
			<p>You will also need to have <a href="http://software.intel.com/en-us/articles/intel-threading-building-blocks-documentation/" target="_blank" style = "font-weight: bold; text-decoration: underline;">Intel Thread Building Blocks</a> installed before you can use that option in Moody.</p>
			<p>To compile MopViewer you will need QT4. For compilation instructions, see the  <a href="http://moody.politespider.com/mopviewer.php" style = "font-weight: bold; text-decoration: underline;">MopViewer page</a>.</p>			
			<p>pyMoody is currently only for Unix based systems. To compile it you will need to have python 2.7 installed. To compile it run the compile.sh script. Should you get the error 'python.h not found' and python.h is on your system, update the Makefile to point to the correct location. It likely won't be hard to set pyMoody up to compile on Windows, I just haven't done it. pyMoody uses OpenMP by default, but you can change this to Intels Thread Building Blocks if you like.</p>		
			<p>Moody is set to compile with Thread Building Blocks support on Windows, and OpenMP on Linux. To change these defaults, see the instructions on the <a href="http://www.politespider.com/moody/compilation.php" style = "font-weight: bold; text-decoration: underline;">Compiling Moody</a> page. The same method is used to change pyMoody over as well, except to do that you edit the Makefile in moody/pymoody.</p>
			<div class = "horizontalDivider"></div>
			<a name="mopviewer"></a> 
			<h2>Compiled Binaries</h2>
			<p>These precompiled binaries are of MopViewer only. Moody and pyMoody are best compiled on your own system</p>
			<h3>MopViewer Linux x86 Binary</h3>
			<p>temporaily unavailable</p>
			<div class="linkSurroundDownload" style = "width: 100px;">
				<a href="http://www.politespider.com/moody/releases/MopViewer-bin-linux.x86.tar.gz">Download</a>
			</div>
			<h3>MopViewer Windows Binary</h3>
			<div class="linkSurroundDownload" style = "width: 100px;">
				<a href="http://www.politespider.com/moody/releases/mopviewer-win32-bin.zip">Download</a>
			</div>
			<h2>Source code documentation for Moody</h2>
			<p>Source code documentation in downloadable form</p>
			<div class="linkSurroundDownload" style = "width: 100px;">
				<a href="http://www.politespider.com/moody/releases/Moody_source_documentation.zip" >Download</a>
			</div>
			<p>This documentation is the primary source for detailed information on Moody. All classes and methods are documented, and relationships graphed. For actual tutorials on using Moody, refer to the rest of the site. Those tutorials will assume for the most part that you have this documentation available.</p>
			<div class = "horizontalDivider"></div>
			<h2>Example Projects</h2>
			<a name="refp"></a> 
			<h3>The Reference Project</h3>
			<p style="">Version 1.8 (25/06/2010)</p>
			<p>This is the default project for Moody. It contains a model of the Solar System that I've been developing for a while. For more information, go to the <a href="reference_project.php"   style = "font-weight: bold; text-decoration: underline;">Reference Project</a> Page</p>
			<div class="linkSurroundDownload" style = "width: 100px;">
				<a href="http://www.politespider.com/moody/releases/Reference_Project-v1.8.zip">Download</a>
			</div>
			<h3>Optimised Project</h3>
			<p>Moody has the ability to ignore specified particle interactions, which lets you cut down on the processing time required for experiments where not all particles are strictly required to interact. This project demonstrates that feature.</p>
			<div class="linkSurroundDownload" style = "width: 100px;">	
				<a href="http://www.politespider.com/moody/releases/Optimised_Project_v1.zip">Download</a>
			</div>
			<div class = "horizontalDivider"></div>
			<h2>Demonstration Time Series Results</h2>
			<p>These are all output time series mop files from the <a href="reference_project.php" style = "font-weight: bold; text-decoration: underline;">Reference Project</a>, use MopViewer to play them back.</p>
				<div class="linkSurroundDownload" style = "width: 130px;">
				<a href="http://www.politespider.com/moody/releases/10000_days.zip">10000 Days - 21.9Mb</a>
				</div>
				<div class="linkSurroundDownload" style = "width: 130px;">
				<a href="http://www.politespider.com/moody/releases/1000_days.zip">1000 Days - 2.04Mb</a>
				</div>
			<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
