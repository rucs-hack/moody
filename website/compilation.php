<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
<h2>Compiling Moody</h2>
<h3>On Linux/Unix</h3>
	<h4>Prerequisites</h4>
		<ul class = "generalList">
			<li>OpenMP and/or Intel Thread Building Blocks.</li>
		</ul>	
	<p>When compiling Moody you need to decide which parallelisation library you want to use. The choices are OpenMP or Thread Building Blocks. Since OpenMP is present on any Linux/Unix system that includes the GNU C++ compiler, that is the default for those platforms.</p>	
	<p>Selecting which Parallelisation library to use with Moody is set by a compiler define in the Makefile. This is set to <i style="font-weight:bold;">OMPLIB</i> by default</p>
	<p>It should be noted that unless runtime load balancing is of particuler concern, there's not much difference between OpenMP and Thread Building Blocks in term of the speed of Moody, so unless you particulerly want to do otherwise, OpenMP should be fine.</p>
	<p>Note that you can have either <i style="font-weight:bold;">OMPLIB</i> or and <i style="font-weight:bold;">TBBLIB</i> set, but not both at the same time.</p>
	<p>If you use the integrators provided with Moody you will not need to change your code if you decide to switch Parallisation APIs during your development process.</p>
	<p>The compiled Binary will appear in <i style="font-weight:bold;">moody/bin/</i></p>
<h3>On Windows</h3>
	<h4>Prerequisites</h4>
		<ul class = "generalList">
			<li>Visual Studio 10</li>
			<li>OpenMP and/or Intel Thread Building Blocks</li>
		</ul>	
	<p>If you have the express version of Visual Studio 10, then you cannot use OpenMP, since it is only available in the pro or team editions. For this reason the default parallelisation library on windows is Thread Building Blocks.</p>	
	<p>Since the Express edition of visual studio does not include OpenMP, you have to disable it in Moody's project settings. To do this go to <i style="font-weight:bold;">properties->C++->Language</i> and set <i style="font-weight:bold;">OpenMP Support</i> to <i style="font-weight:bold;">No (/openmp-)</i></p>		
    <p>To obtain and install Intel Thread Building Blocks, see <a href="http://software.intel.com/en-us/articles/intel-threading-building-blocks-documentation/" target="_blank" style = "font-weight: bold; text-decoration: underline;"> Intels documentation</a>.</p>
	<h4>Setting up Moody in Visual Studio</h4>
	<p>Before you can compile Moody you will need to have either set up Thread Building Blocks, or be able to use OpenMP.</p>
	<p>If you want to use OpenMP and not install Thread Building Blocks at all, then you will need to remove the following setting in the Visual studio project:</p> 
	<p>In <i style="font-weight:bold;">Properties->Linker->Command Line</i>  you need to remove the line <i style="font-weight:bold;">tbb.lib</i>, or as it is in the debug build target, <i style="font-weight:bold;">tbb_debug.lib</i></p>
	<p>You don't <i>have</i> to remove this dependancy if you have Thread Building Blocks installed and want to use OpenMP for a while.</p>
	<h4>Choosing the parallelisation method</h4>
	<p>To select which Parallisation library will be used, you need to change a Define value in Moodys project setup. </p> 
	<p>Your options are:</p>
	
    <p><i style="font-weight:bold;">/D "TBBLIB" </i> - Use Intels Thread Building Blocks</p>
	<p><i style="font-weight:bold;">/D "OMPLIB" </i> - Use OpenMP</p>
	<p>To do this, open Moody in Visual Studio, right click on the Solution in the Solution Explorer and select to view Moodys Properties.</p>
	<p>Go to <i style="font-weight:bold;">C/C++ -> Command Line</i>, and you will see that the define <i style="font-weight:bold;">/D "TBBLIB" </i> is set. If you are using Thread Building Blocks, then you can leave this as it is</p>
	<p>To change to using OpenMP, change <i style="font-weight:bold;">/D "TBBLIB" </i> back to <i style="font-weight:bold;">/D "OMPLIB" </i> </p>
	<p>You will now be able to compile Moody with the selected parallelisation library active.</p>
	<p><i style="font-weight:bold;">Note:</i> If you for some reason want to run your model without using the parallel integrators, which can be handy whilst searching for bugs (most free debugging tools cannot debug parallel code), change the #define to <i style="font-weight:bold;">/D "SERIAL" </i>. This will cause Moody to work without a parallelisation library.</p>
		<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
