<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
	
	<h2>The Capsule Class</h2>

	<p>This class is the key to Moody. The Capsule holds and manages Particle data, and contains the integrators used by Moody.</p> 
	<p>Capsules can exchange the particle data they hold with each other, allowing for Capsules to be written which have dedicated tasks.</p>
	<p>There are three integrators available in the Capsule Class (see <a href="http://moody.politespider.com/integrators.php" style = ";font-weight: bold; text-decoration: underline;">Integrators Available</a>), implemented in either OpenMP or Thread Building Blocks, and you select which implementations to use when compiling Moody.</p> 
	<p>The Capsule Class you use directly has no members or methods itself, they're all inherited. I decided to make the top level class an empty one so there would be a clear seperation between new code/overloaded methods you write, and existing code/methods.</p>
	<p>Particle data is shared between Capsules through being passed by either the standard method of an overloaded '=' operator, or if not all content is to be shared (for example, settings but not particles, or particles but not settings), methods exist to share just those aspects.</p>
	<div class = "codeblock">
		<pre class="hl">
		<span class="hl slc">// Use either the standard assignment operator to copy capsule contents</span>
		experiment1 <span class="hl opt">=</span> experiment2<span class="hl opt">;</span>
		<span class="hl slc">//or just move the settings accross</span>
		<span class="hl kwb">void</span> <span class="hl kwd">TakeSettingsFromAnotherCapsule</span><span class="hl opt">(</span> Capsule <span class="hl opt">&amp;</span>other<span class="hl opt">);</span>
		<span class="hl slc">// or just the particles</span>
		<span class="hl kwb">void</span> <span class="hl kwd">TakeParticlesFromAnotherCapsule</span><span class="hl opt">(</span> Capsule <span class="hl opt">&amp;</span>other<span class="hl opt">);</span>
		</pre>
	</div>
	<p>A Capsule stores particle data in arrays of pointers to instances of a <a href = "particles.php">Particle Class</a>, rather then vectors, as this provides a considerable runtime performance boost over the container classes when it comes to passing the particles into the integrators.</p>
<div class = "horizontalDivider"></div>
	<p>To load a project into a Capsule, you call the loadProject method, which takes a string containing the path to the project you want to load.</p>

	<p>The prototype for this method is:</p>
	<div class = "codeblock">
		<span class="hl kwb">void</span> <span class="hl kwd">loadProject</span><span class="hl opt">(</span>std<span class="hl opt">::</span>string projectFolder<span class="hl opt">)</span>
	</div>

	<p>the Capsule class manages the housekeeping aspects of the arrays of particles it holds, providing methods to allow for array insertion and deletion, as well as accessing specific members of an array. In essence, all memory management is handled for you.</p>
	<p>The Capsule has three seperate particle arrays, one called the Environment Set, meaning those particles that are moved via the n-body model, the Population Set, which contains those particles acting as chromosomes in an evolutionary computation experiment, and the intermediate set, which is used when moving particles between the environment and population sets.</p>
	<p>For now we will concern ourselves with the Environment Set, since that is the one that gets created automaticallty for you when you load a project. The methods below exist for each particle array.</p>
	
	<h3>Addition and Deletion of Particles from a Capsule</h3> 
	<div class = "codeblock">
	<pre class="hl">
	<span class="hl kwb">void</span> <span class="hl kwd">addToEnvironmentSet</span><span class="hl opt">(</span>Particle <span class="hl opt">&amp;</span> p<span class="hl opt">)</span>
	
	<span class="hl kwb">void</span> <span class="hl kwd">deleteFromEnvironmentSet</span> <span class="hl opt">(</span><span class="hl kwb">int</span> index<span class="hl opt">)</span>
	</pre>
	</div>
     <p>When adding a particle you can use either an instance of the particle class or a struct that duplicates all the private members of the particle class. These structs are used for alteration/initialisation/copying of particle objects.</p>
	 <p>In fact, since an instance of the Particle Class can only have its members filled by passing it a Particle Struct, it's easier to just use those in most instances.</p>
	 <p>Deleting particles acts in similer fashion, the same delete call works whichever particle storage method is in use.</p>
	 <p>Never directly add or deleta a particle yourself, always use the add/delete methods. You can write your own methods to manipulate the array or its members in any other way.</p>

	<p>If you want to know the current size of the environment particle array you call the following method</p>
	<div class = "codeblock">
	<pre class="hl">
	<span class="hl kwb">int</span> <span class="hl kwd">getEnvironmentSetSize</span><span class="hl opt">()</span> <span class="hl kwb">const</span>
	</pre>
	</div>
	<h3>reading from and writing to particles</h3>
	<p>To access a particle to read from or update it you use the following method, which returns a single specified particle. Here we're retreiving a particle and requesting that its internal state be exported to xml (matching the form used in particles.xml).</p>
	<div class = "codeblock">
		<pre class="hl">
	<span class="hl kwa">this</span><span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentSetMember</span><span class="hl opt">(</span>i<span class="hl opt">).</span><span class="hl kwd">exportAsXmlScrap</span><span class="hl opt">();</span>
	</pre>
	</div> 
	<h3>Capsules and evolutionary computation</h3>
	<p>Capsules contain methods designed for use in evolutionary computation experiments. For the moment this is in terms of experiments that employ single objective optimisation. It is also possible to evaluate multiple chromosomes in parallel, a feature added in order to mitigate the computational cost of chromosome testing in an n-body model.</p>
	<p>This aspect of Capsules will be discussed in more detail in a specific tutorial.</p>
<p>There are a number of additional methods in Capsule that I haven't described here, as the Capsule class is quite large. A more complete documentation of the Capsule class is available in the source code documentation, which you can get from the <a href="http://moody.politespider.com/downloads.php" style = ";font-weight: bold; text-decoration: underline;">download page</a>.</p>
<p>More of the functionality available in the Capsule class will be covered in later tutorials.</p>
<div class = "horizontalDivider"></div>
<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
