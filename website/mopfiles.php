<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">

<h2>The Mop File Format</h2>
<p>Mop files are the time series files produced by Moody. Mop file handling is provided by the MopFile class.</p>
<p>You create a new MopFile object for each mop file you want to record. By default the Capsule class has one MopFile object member. This will be expanded to allow for more than one MopFile later.</p>
<p>In the demonstration code provided in moody.cpp, Mop files are filled one 'state' at a time, where a state is defined in a projects config file. In the Reference Project provided with Moody a step is sixty seconds, and one state is defined as a days worth of steps, so the example mop files provided show motion in 24 hour intervals. The frequency of state recording in your own experiment can be whatever you require.</p>
<p>A single entry in a mop file consists of an integer recording how many particles are in the state following it, followed by a series of MopItems written to the file as character arrays. The MopFile library translates to and from the MopFile struct when mopfiles are read or written. A MopItem is formed from the following struct:</p>
<div class = "codeblock">
<pre class="hl"> 
<span class="hl kwb">struct</span> MopItem <span class="hl opt">{</span>
	<span class="hl kwb">double</span> mass<span class="hl opt">;</span>
	<span class="hl kwb">double</span> radius<span class="hl opt">;</span>
	<span class="hl slc">//position in the WCS</span>
	<span class="hl kwb">double</span> x<span class="hl opt">;</span>
	<span class="hl kwb">double</span> y<span class="hl opt">;</span>
	<span class="hl kwb">double</span> z<span class="hl opt">;</span>
	<span class="hl slc">//Velocity in the WCS</span>
	<span class="hl kwb">double</span> xd<span class="hl opt">;</span>
	<span class="hl kwb">double</span> yd<span class="hl opt">;</span>
	<span class="hl kwb">double</span> zd<span class="hl opt">;</span>
	<span class="hl slc">//Force acting on this particle in the WCS</span>
	<span class="hl kwb">double</span> xf<span class="hl opt">;</span>
	<span class="hl kwb">double</span> yf<span class="hl opt">;</span>
	<span class="hl kwb">double</span> zf<span class="hl opt">;</span>
	<span class="hl slc">// the colour of a particle</span>
	<span class="hl kwb">int</span> red<span class="hl opt">;</span>
	<span class="hl kwb">int</span> green<span class="hl opt">;</span>
	<span class="hl kwb">int</span> blue<span class="hl opt">;</span>
	<span class="hl kwb">char</span> name<span class="hl opt">[</span><span class="hl num">50</span><span class="hl opt">];</span>     <span class="hl slc">// name of particle</span>
	<span class="hl kwb">int</span> interactionPermission<span class="hl opt">;</span> <span class="hl slc">// Used to say what types of particle this particle is allowed to interact with.</span>
	<span class="hl kwb">int</span> identity<span class="hl opt">;</span>   <span class="hl slc">// used to tell this particle what type it is (collapsor/normal particle/placemark/spacecraft)</span>
	<span class="hl kwb">int</span> visualRepresentation<span class="hl opt">;</span> <span class="hl slc">// what shape/size this particle will have when displayed in a visualisation</span>
<span class="hl opt">};</span>
</pre>
</div>
<p>the xf,yf and zf members of the struct are not normally used by Moodyand MopViewer, they are present for experiments where you are specifically interested in recording forces acting on a particle.</p>
<h3>Creating a Mop File</h3>

<p>Mop files are controlled by an instance of a MopFile class, one per file. The demonstration build of Moody currently holds just one Mopfile instance, but later versions will allow for multiple mop files to be in use at once.</p>

<h3>Setting the Mop Filename</h3>

<p>You set the filename for a mop file by calling one of the following two methods</p>

<div class = "codeblock">
	<pre class="hl">	
		<span class="hl kwb">void</span> <span class="hl kwd">setFilename</span><span class="hl opt">(</span>std<span class="hl opt">::</span>string path<span class="hl opt">,</span>std<span class="hl opt">::</span>string fn<span class="hl opt">);</span>
		
		<span class="hl kwb">void</span> <span class="hl kwd">setFilename</span> <span class="hl opt">(</span>std<span class="hl opt">::</span>string fn<span class="hl opt">);</span>
	</pre>
</div>

<p>The first requires a path and a filename (this is what you would use to always write to the current projects result folder), and the other lets you just specify a filename, which can have a path included or not.</p> 
<p>examples:</p>
<div class = "codeblock">
	<pre class="hl">
		experiment<span class="hl opt">-&gt;</span>mopSet<span class="hl opt">-&gt;</span><span class="hl kwd">setFilename</span><span class="hl opt">(</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getResultFolder</span><span class="hl opt">(),</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getProjectName</span><span class="hl opt">());</span>
		
		experiment<span class="hl opt">-&gt;</span>mopSet<span class="hl opt">-&gt;</span><span class="hl kwd">setFilename</span><span class="hl opt">(</span><span class="hl str">&quot;resultFile&quot;</span><span class="hl opt">);</span>


	</pre>
</div>


<p>While it isn't strictly required, I suggest that you keep to the convention that all mop files are written to a projects result folder.</p>

<h3>Writing to the the Mop File</h3>
<p>The method to write to the mop file is</p>
<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">writeState</span><span class="hl opt">(</span>Particle <span class="hl opt">*</span> localSet<span class="hl opt">,</span> <span class="hl kwb">int</span> particleSetLength<span class="hl opt">);</span>
	</pre>
</div>
<p>This opens the mopfile, appends the current state, then closes it again.</p>
<p>A capsule method is available that does the same thing and does not require parameters:</p>
<div class = "codeblock">
<pre class="hl">
		<span class="hl kwb">void </span><span class="hl kwd">writeCurrentStateToMopFile</span><span class="hl opt">();</span>
</pre>
</div>
<p>On writing a state to the mop file it will always be appended to the end of the mopfile.</p>
<p>This is a design choice to make it simpler to collate the results from an experiment. You might for example want to show the improvements in a population of particle chromosomes in an EA over the lifetime of the experiment. Since it is easier to have this happen automatically, and it is also something I have found to be useful in my research, this is the default action.</p>
<p>To prevent this from happening you have two options. The first is to change the mop filename stored in the MopFile object, thus causing a new mop file to be created.</p>
<p>The second is to clear the existing mop file with a call to</p>
<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwb">void </span><span class="hl kwd">emptyMopFile</span><span class="hl opt">();</span>
	</pre>
</div>

<p>There is a method in the MopFile class to close the file, but this is for when the file is being read, not written to.</p>

<h3>Reading a Mop File</h3>

<p>Reading binary files is different from reading normal files, because there is no end of file character to watch for. You need to explicitally state how large a block of data you wish to extract from the opened binary file, an you also need some mechanism for discovering that you are at the end of the file.</p>
<p>With Mopfiles you open the file and leave it open whilst it is being played back. The reader moves through the file one state at a time and resets to the start when it reaches the end of the file</p>

<p>The simplest means to read a mop file is to use ReadCyclingState. This method will read states until the end of the mopfile is reached, then reset the file and start from the beginning again.</p>
<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">readCyclingState</span><span class="hl opt">();</span>
	</pre>
</div>

<p>Should you wish to have a little more control over reading the Mopfile, these methods can be used.</p>
<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">openMopfileReader</span><span class="hl opt">();</span>
	</pre>
</div>
<p>Read a single state from the mop file</p>
<div class = "codeblock">
	<pre class="hl">
		MopState <span class="hl opt">*</span> <span class="hl kwd">readState</span><span class="hl opt">();</span>
	</pre>
</div>
<p>Reset to the beginning of the mop file</p>
<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">resetFile</span><span class="hl opt">();</span>
	</pre>
</div>
<p>Close the mop file</p>
<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">closeMopfileReader</span><span class="hl opt">();</span>
	</pre>
</div>
<div class = "horizontalDivider"></div> 

<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
