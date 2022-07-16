<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">


<h2>The Project Format used by Moody</h2>		

<p>Rather than a single file, Moody uses a folder to contain its projects. This makes it easier to keep all the files associated with a project in one place, and the use of a directory structure rather then a single file means the various aspects of a Moody Project can be seperated, which I beleive makes the various componants of a project easier to manage.</p>
<p>By far the simplest way to understand the individual files that make up a project is to open them and read, but I will go through them here</p>

<h2>The Project Folder Structure</h2>

<p>A Moody Project has three sub folders: <b>cfg</b>, <b>particles</b> and <b>result</b>.</p>
<h3>cfg folder</h3>
<p>This is where the information needed to set up the model, the value of G, runtime, step size and such are specified in an xml file called cfg.xml.</p>

<div class = "codeblock">
		<pre class="hl">
<span class="hl kwa">&lt;?xml</span> <span class="hl kwb">version</span>=<span class="hl str">&quot;1.0&quot;</span> <span class="hl kwb">encoding</span>=<span class="hl str">&quot;UTF-8&quot;</span><span class="hl kwa">?&gt;</span>
<span class="hl kwa">&lt;root</span> xsi:noNamespaceSchemaLocation = <span class="hl str">&quot;environmentSetup.xsd&quot;</span> xmlns:xsi = <span class="hl str">&quot;http://www.w3.org/2001/XMLSchema-instance&quot;</span><span class="hl kwa">&gt;</span>
	<span class="hl kwa">&lt;G&gt;</span><span class="hl num">6.674040E-11</span><span class="hl kwa">&lt;/G&gt;</span>
	<span class="hl kwa">&lt;states&gt;</span><span class="hl num">500</span><span class="hl kwa">&lt;/states&gt;</span>
	<span class="hl kwa">&lt;steps&gt;</span><span class="hl num">1440</span><span class="hl kwa">&lt;/steps&gt;</span>
	<span class="hl kwa">&lt;stepSize&gt;</span><span class="hl num">60</span><span class="hl kwa">&lt;/stepSize&gt;</span>
	<span class="hl kwa">&lt;version&gt;</span><span class="hl num">1.0</span><span class="hl kwa">&lt;/version&gt;</span>
	<span class="hl kwa">&lt;MopName&gt;</span>Reference_Project<span class="hl kwa">&lt;/MopName&gt;</span>
<span class="hl kwa">&lt;/root&gt;</span>
</pre>
</div>
<p>these entries are used as follows</p>
<h4>G</h4>
<p>The measure of the Gravitational Constant you want to use</p>
<h4>States, Steps and Stepsize</h4>
<p>Moody uses states, steps and stepsize to specify how long a given experiment is to run. Stepsize is the number of seconds that a single step is to cover. Actually it doesn't have to be seconds, it could be years, millenia, or any unit, but in the Reference Project it's seconds.</p>
<p>Steps refers to the number of steps that should be performed in order for a single State to be completed.</p>
<p>In the Reference Project, from which the above cfg.xml is taken, the stepsize is 60 seconds, the number of steps in a state is 1440, and the number of states is 500. This setup means that the Reference Project, when run, will reproduce 500 days of Solar System motion.</p>
<p>As I said there is no reason to use seconds, stepsize could mean anything you wish, so long as the masses and velocities of your particles are compatible.</p>
<p>The convention among n-Body modellers is to scale all masses, positions and velocities between 0..1. Moody can do this, as I said, but my own interest lies in modelling on the Solar System scale.</p>
<h4>Version</h4>
<p>This is something you don't need to change, it's there just in case there end up being several types of cfg.xml file for different tasks, and that isn't the case yet.</p>
<h4>MopName</h4>
<p>This is used to name the output time series mop file.</p>


<h3>Result Folder</h3>
<p>This is where binary time series <a href= "mopfiles.php">mop files</a> and any other result files you might be producing are written. It is possible to specify a different location when setting the output folder, but the  code snippet shown uses the default. To change it alter the second parameter to suit your needs.</p>
<div class = "codeblock">
	<pre class="hl">
	createMopFile</span><span class="hl opt">(</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getResultFolder</span><span class="hl opt">(),</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getMopName</span><span class="hl opt">());</span> 
	</pre>
</div>

<h3>Particles Folder</h3>
<p>This contains the particles.xml file which holds all the particles that will be running in the model.</p>	
	<h4>The Particle Data Format</h4 >
	<p>The best way to explain the particle data format is to add a new particle, so in this tutorial we will be adding the planetesimal Pluto to the particles.xml file in the reference project.</p>
	<p>start by opening the web interface of Horizons in a new tab</p>
	<a href="http://ssd.jpl.nasa.gov/horizons.cgi" target="_blank"  style = "color: #000000;font-weight: bold; text-decoration: underline;">Open the Horizons Web interface by clicking here</a>

	<p>The web interface has a number of options you have to set</p>

	<ul class = "generalList">
		<li>Ephemeris Type </li> 

		<li>Target Body </li> 

		<li>Observer Location </li> 

	   <li>Time Span </li> 

		<li>Table Settings </li> 

		<li>Display/Output </li> 
	</ul>

	<p>Exactly how you do this I will leave to the tutorial on the Horizons site, because they have some very good ones. What I will cover are the settings you need for Moody.</p>
	<h4>Ephemeris Type</h4>

	<p>Set this to <b>VECTORS</b></p>
	<h4>Target Body</h4>

	<p>by using the search function, find Pluto in their list and add it.</p>
	<h4>Observer Location</h4>

	<p>Set this to *Solar System Barycenter* (@0 in the search box)</p>
	<h4>Time Span</h4>

	<p>Set this to <b>discrete output times form</b> and choose the date you want If you want to keep the position of Pluto consistent with the rest of the dataset already present, use the date currently stated for the Reference Project - 2008-08-24.</p>
	<h4>Table Settings</h4>

	<p>This is a tad more complex. You need to open the table setting page and set quite a few things.</p>

	<p>Output units : set to <b>km &amp; km/sec</b></p>

	<p>quantities code: set to <b>state vector {x,y,z,vx,vy,vz}</b></p>

	<p>labels: enable labelling of each vector component</p>

	<p>CSV format: output data in Comma-Separated-Variables (CSV) format.</p>
	<h4>Display/Output</h4>

	<p>set this to html, unless you want a text file, it's up to you.</p>


	<h4>How to convert the data</h4>
	<p>The part we are interested in is between the labels <b>$$SOE</b> and <b>$$EOE</b></p>
	<div class = "codeblock">
	<p>$$SOE</p>

	<p>2454214.500000000, A.D. 2007-Apr-24 00:00:00.0000, -2.268943146888790E+08, -4.638380283374466E+09, 5.619670388509338E+08, 5.545686514294367E+00, -1.261288041409800E+00, -1.474365754204501E+00,</p>

	<p>$$EOE</p>
	</div>

	<p>The first two values _2454214.500000000, A.D. 2007-Apr-24 00:00:00.0000_ we can ignore, we don't need them.</p>

	<p>Note that I selected labels, but the values aren't labelled. This happens sometimes, it's not a problem mind.</p>

	<p>After disregarding the first two values we have:</p>
	<div class = "codeblock">
	<p>-2.268943146888790E+08, -4.638380283374466E+09, 5.619670388509338E+08, 5.545686514294367E+00, -1.261288041409800E+00, -1.474365754204501E+00,</p>
	</div>
	<p>The first three are X Y and Z location in kilometres</p>
	<div class = "codeblock">
		<p>X* -2.268943146888790E+08</p>

		<p>Y* -4.638380283374466E+09</p>

		<p>Z* 5.619670388509338E+08</p>
	</div>

	<p>The final three are velocity on X Y and Z in kilometres per second</p>
	<div class = "codeblock">
		<p>VX* 5.545686514294367E+00</p>

		<p>VY* -1.261288041409800E+00</p>

		<p>VZ* -1.474365754204501E+00</p>
	</div>

	<p>These need to be converted to meters for the position values, and meters per second for the velocity. This is a simple matter of multiplying each value by 1000.</p>

	<p>The result in this case is</p>
	<div class = "codeblock">
		<p>X* -2.268943146888790E+11 </p>

		<p>Y* -4.638380283374466E+12 </p>

		<p>Z* 5.619670388509338E+11 </p>

		<p>VX* 5.545686514294367E+03 </p>

		<p>VY* -1.261288041409800E+03</p>

		<p>VZ* -1.474365754204501E+03 </p>
	</div>

	<h4>Other information you need</h4>

	<p>You also need a Mass and Radius Value. As it happens this ephemera set has them, but not all do</p>
	<div class = "codeblock">
	<p>PHYSICAL DATA (updated 2006-Feb-27):</p>

	<p>Mass Pluto (10^22^ kg) = 1.314+-0.018</p>

	<p>Radius of Pluto, Rp = 1151 km</p>
	</div>

	<p>The radius needs also to be converted to meters.</p>

	<p>The Mass would be re-written as 1.314E+22 Ignore the +- value for now, it won't make much of a difference with Pluto. Ok yes, it's a pretty big deal for closer/smaller objects, but not in this case, and I haven't yet had the time to solve this problem. That is by way of being on my list..</p>

	<p>There are plenty of sources on the internet for Mass and Radius of astronomical bodies. Wikipedia has a lot of useful data.</p>
	<h4>Creating the final Particle data entry</h4>

	<p>Create a new xml fragment that we will append to the particles.xml file in the Rerefence Project.</p>

	<p>Here's such an entry, with no data</p>
	<div class = "codeblock">
	<pre class="hl">    <span class="hl kwa">&lt;particle&gt;</span>
			<span class="hl kwa">&lt;interactionPermission&gt;&lt;/interactionPermission&gt;</span>
			<span class="hl kwa">&lt;identity&gt;&lt;/identity&gt;</span>
			<span class="hl kwa">&lt;name&gt;&lt;/name&gt;</span>
			<span class="hl kwa">&lt;visualSize&gt;&lt;/visualSize&gt;</span>
			<span class="hl kwa">&lt;rgb&gt;</span>
				<span class="hl kwa">&lt;red&gt;&lt;/red&gt;</span>
				<span class="hl kwa">&lt;green&gt;&lt;/green&gt;</span>
				<span class="hl kwa">&lt;blue&gt;&lt;/blue&gt;</span>
			<span class="hl kwa">&lt;/rgb&gt;</span>
			<span class="hl kwa">&lt;mass&gt;&lt;/mass&gt;</span>
			<span class="hl kwa">&lt;radius&gt;&lt;/radius&gt;</span>
			<span class="hl kwa">&lt;vector&gt;</span>
				<span class="hl kwa">&lt;X&gt;&lt;/X&gt;</span>
				<span class="hl kwa">&lt;Y&gt;&lt;/Y&gt;</span>
				<span class="hl kwa">&lt;Z&gt;&lt;/Z&gt;</span>
				<span class="hl kwa">&lt;XD&gt;&lt;/XD&gt;</span>
				<span class="hl kwa">&lt;YD&gt;&lt;/YD&gt;</span>
				<span class="hl kwa">&lt;ZD&gt;&lt;/ZD&gt;</span>
			<span class="hl kwa">&lt;/vector&gt;</span>
		<span class="hl kwa">&lt;/particle&gt;</span>
	</pre>
	</div>


	<p>We fill in the data we have just built up, which gives us</p>
	<div class = "codeblock">
	<pre class="hl">    <span class="hl kwa">&lt;particle&gt;</span>
			<span class="hl kwa">&lt;interactionPermission&gt;&lt;/interactionPermission&gt;</span>
			<span class="hl kwa">&lt;identity&gt;&lt;/identity&gt;</span>
			<span class="hl kwa">&lt;name&gt;</span>Pluto<span class="hl kwa">&lt;/name&gt;</span>
			<span class="hl kwa">&lt;visualSize&gt;&lt;/visualSize&gt;</span>
			<span class="hl kwa">&lt;rgb&gt;</span>
				<span class="hl kwa">&lt;red&gt;&lt;/red&gt;</span>
				<span class="hl kwa">&lt;green&gt;&lt;/green&gt;</span>
				<span class="hl kwa">&lt;blue&gt;&lt;/blue&gt;</span>
			<span class="hl kwa">&lt;/rgb&gt;</span>
			<span class="hl kwa">&lt;mass&gt;</span><span class="hl num">1.314E+22</span><span class="hl kwa">&lt;/mass&gt;</span>
			<span class="hl kwa">&lt;radius&gt;</span><span class="hl num">1.15E+006</span><span class="hl kwa">&lt;/radius&gt;</span>
			<span class="hl kwa">&lt;vector&gt;</span>
				<span class="hl kwa">&lt;X&gt;</span>-<span class="hl num">2.268943146888790E+11</span> <span class="hl kwa">&lt;/X&gt;</span>
				<span class="hl kwa">&lt;Y&gt;</span>-<span class="hl num">4.638380283374466E+12</span><span class="hl kwa">&lt;/Y&gt;</span>
				<span class="hl kwa">&lt;Z&gt;</span><span class="hl num">5.619670388509338E+11</span><span class="hl kwa">&lt;/Z&gt;</span>
				<span class="hl kwa">&lt;XD&gt;</span><span class="hl num">5.545686514294367E+03</span><span class="hl kwa">&lt;/XD&gt;</span>
				<span class="hl kwa">&lt;YD&gt;</span>-<span class="hl num">1.261288041409800E+03</span><span class="hl kwa">&lt;/YD&gt;</span>
				<span class="hl kwa">&lt;ZD&gt;</span>-<span class="hl num">1.474365754204501E+03</span><span class="hl kwa">&lt;/ZD&gt;</span>
			<span class="hl kwa">&lt;/vector&gt;</span>
		<span class="hl kwa">&lt;/particle&gt;</span>
	</pre>
	</div>

	<p>We're not quite done yet. Moody still needs to know more about this particle, so we have to add those parts.</p>

	<h4>Interaction Control</h4>

	<p>Particles have two status settings, one tells them what their level of interactivity is, and the other what class of particle they are.</p>

	<p>The levels of interactivity are:</p>
	<ul class = "generalList">
		<li>interactALL - This particle will interact with any particle that allows it to</li>

		<li>interactNONE - This particle will not try to interact with any other particles</li>

		<li>interactDifferentOnly - This particle will only interact with particles that are not in its own class</li>
	</ul>
	<p>The particle class (type) specifiers are:</p>
	<ul class = "generalList">
		<li>collapsor - This particle is a collapsor and will interact with any particle that lets it</li>

		<li>collapsorFixed - This particle is a collapsor, but is not allowed to move</li>

		<li>nonInteractive - this particle is not allowed to interact with any other (basically it's a placeholder, or event location indicator)</li>

		<li>ordinary - This particle will interact with any particle that lets it</li>

		<li>chromosome - This particle will interact with any particle that lets it</li>

		<li>planetesimal - This particle will interact with any particle that lets it</li>
	</ul>

	<p>Using these it is possible to fine tune interactions within a model.</p>

	<p>For example, if you want to prevent moons from interacting, as you might do to avoid the trivial yet expensive calculation of interactions between a moon of Saturn and our own Moon, you would set the particle class of all moons to planetesimal, and their interaction status to interactDifferentOnly. Now when the model runs, moons will not interact. This example aside, there are practical reasons for preventing interactions in Moody.</p>
    <p>When running an evolutionary computation experiment that uses Moody as the fitness function, it becomes neccesary to disallow some interactions. By preventing chromosome particles from interacting with each other you can evaluate many more chomosomes simultaniously, and being able cut out some interactions, such as those between asteroids, it's possible to have a more complete model of the solar system active in an experiment whilst trimming computational costs.</p>
	<p>Obviously restricting some interactions will have an impact on orbit accuracy, but it won't be a problemm over a short period of time, and a spacecraft flying between moons or asteroids which are not themselves interacting will still be gravitationally influenced by those bodies itself.</p>
	<p>Anyway, we want Pluto to interact with all other particles in the model, so we set the particles interactionPermission to <b>interactALL</b>.</p>

	<p>For identity we'll use <b>ordinary</b> since thats what all particles in the Reference Project have (there is no interaction restriction in that project)</p>
	
	<p>Next is the visualSize parameter. This value is used by MopViewer when displaying the time series output. We'll set it to be the same size visually as the moons in the reference project, so 6. The larger this value is, the larger the particle will appear in the viewer</p>

	<p>The rgb attributes are again just for MopViewer, so I'll make them the same as I use for moons again, 10,103,106.</p>

	<div class = "codeblock">
		<pre class="hl">    
		   <span class="hl kwa">&lt;particle&gt;</span>
				<span class="hl kwa">&lt;interactionPermission&gt;</span>interactALL<span class="hl kwa">&lt;/interactionPermission&gt;</span>
				<span class="hl kwa">&lt;identity&gt;</span>ordinary<span class="hl kwa">&lt;/identity&gt;</span>
				<span class="hl kwa">&lt;name&gt;</span>Pluto<span class="hl kwa">&lt;/name&gt;</span>
				<span class="hl kwa">&lt;visualSize&gt;</span><span class="hl num">6</span><span class="hl kwa">&lt;/visualSize&gt;</span>
				<span class="hl kwa">&lt;rgb&gt;</span>
					<span class="hl kwa">&lt;red&gt;</span><span class="hl num">10</span><span class="hl kwa">&lt;/red&gt;</span>
					<span class="hl kwa">&lt;green&gt;</span><span class="hl num">103</span><span class="hl kwa">&lt;/green&gt;</span>
					<span class="hl kwa">&lt;blue&gt;</span><span class="hl num">106</span><span class="hl kwa">&lt;/blue&gt;</span>
				<span class="hl kwa">&lt;/rgb&gt;</span>
				<span class="hl kwa">&lt;mass&gt;</span><span class="hl num">1.314E+22</span><span class="hl kwa">&lt;/mass&gt;</span>
				<span class="hl kwa">&lt;radius&gt;</span><span class="hl num">1.15E+006</span><span class="hl kwa">&lt;/radius&gt;</span>
				<span class="hl kwa">&lt;vector&gt;</span>
					<span class="hl kwa">&lt;X&gt;</span>-<span class="hl num">2.268943146888790E+11</span> <span class="hl kwa">&lt;/X&gt;</span>
					<span class="hl kwa">&lt;Y&gt;</span>-<span class="hl num">4.638380283374466E+12</span><span class="hl kwa">&lt;/Y&gt;</span>
					<span class="hl kwa">&lt;Z&gt;</span><span class="hl num">5.619670388509338E+11</span><span class="hl kwa">&lt;/Z&gt;</span>
					<span class="hl kwa">&lt;XD&gt;</span><span class="hl num">5.545686514294367E+03</span><span class="hl kwa">&lt;/XD&gt;</span>
					<span class="hl kwa">&lt;YD&gt;</span>-<span class="hl num">1.261288041409800E+03</span><span class="hl kwa">&lt;/YD&gt;</span>
					<span class="hl kwa">&lt;ZD&gt;</span>-<span class="hl num">1.474365754204501E+03</span><span class="hl kwa">&lt;/ZD&gt;</span>
				<span class="hl kwa">&lt;/vector&gt;</span>
			<span class="hl kwa">&lt;/particle&gt;</span>
		</pre>
	</div>

	<p>And that's it, the xml scrap is now ready to be appended to the particles.xml file. It would go after the last particle, but before <b>&#60;/root&#62;</b>.</p>

<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
