<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
	<h2>Experiment Populations in Moody (currently outdated as of version 1.5 and being re-written)</h2>

	<p>If you want to conduct an experiment with Moody that uses an evolutionary algorithm, you need to set up a population of chromosomes, which in Moody are Particles which can also behave as spacecraft if required. Moody has features to accomodate this, and in this tutorial we'll be covering those features.</p>
	<div class = "horizontalDivider"></div>
	<h3>The Environment, Intermediate and and Population Sets</h3>
	<p>Moody uses three sets of particles while being uses for evolutionary computation experiments. The population set is used to store the particles that are being evolved (acting as chromosomes in the EA), the environment set, where particles are placed to be tested in the n-Body model for fitness, and the intermediate set, where particles are placed before being mutated, and from which they are moved into the environment set for testing. </p>
	<p>Movement of particles between these sets is as follows:</p>
	<div class = "codeblock" style = "width:531px" >
		<img src="images/set_motion.png" alt= "set motion"></img>
		</div>
	<p>Particles are not able to move from the environment set back into the intermediate set because they will have undergone a change in state, either in terms of position and velocity, or in terms of mass and its distribution if they are set up as spacecraft. Since the particles that are being tested exist unused in the intermediate set, those are allowed to return to the population if they have proved to be better as a result of the mutation.</p>
	
	<p>The only aspect you want to preserve after a particle has been iterated in the model would be it's score, the measure of how well it did at the current task. Calculation of that score is done on the particle while it is still on the environment set, but should be stored in the particle copy that resides in the intermediate set. How this is done will be demonstrated in a later tutorial, when we get to that part.</p>
	<div class = "horizontalDivider"></div>
	<h3>Population Creation</h3>
	<p>Unlike the particles in the environment set, particles in the population set aren't loaded in via the project files. Instead you create them at runtime.</p>
	<p>This section is being re-written.</p>



	<h3>Recording initial conditions</h3>
	<p>When the initial starting conditions for your population and the environment have been established, those conditions need to be stored. This is because each time the model is run to test a chromosome, the positions and velocities of all particles in the environment set change, and we have to reset them afterwards ready for the next round of testing.</p>
	<p>The methods a particle uses to store its own state are used as follows:</p>
	<div class = "codeblock">
<pre class="hl">	<span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> <span class="hl kwd">x</span><span class="hl opt">(</span><span class="hl num">0</span><span class="hl opt">);</span>x<span class="hl opt">&lt;</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentParticleCount</span><span class="hl opt">();</span>x<span class="hl opt">++) {</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentSetMember</span><span class="hl opt">(</span>x<span class="hl opt">).</span><span class="hl kwd">storeStartingPosition</span><span class="hl opt">();</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentSetMember</span><span class="hl opt">(</span>x<span class="hl opt">).</span><span class="hl kwd">storeStartingVelocity</span><span class="hl opt">();</span>
	<span class="hl opt">}</span>
</pre>

	</div>
	
	<p>And to recall this previous state:</p>
	<div class = "codeblock">
<pre class="hl">	<span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> <span class="hl kwd">x</span><span class="hl opt">(</span><span class="hl num">0</span><span class="hl opt">);</span>x<span class="hl opt">&lt;</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentParticleCount</span><span class="hl opt">();</span>x<span class="hl opt">++) {</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentSetMember</span><span class="hl opt">(</span>x<span class="hl opt">).</span><span class="hl kwd">resetToStoredStartingPosition</span><span class="hl opt">();</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentSetMember</span><span class="hl opt">(</span>x<span class="hl opt">).</span><span class="hl kwd">resetToStoredStartingVelocity</span><span class="hl opt">();</span>
	<span class="hl opt">}</span>
</pre>
	</div>
	
		<p>That covers population creation when it's just particles, now we'll see how to do the same for spacecraft</p>
		
<h3>Adding spacecraft particles to the population set</h3>
<p>This block of code shows how you turn a particle into a spacecraft. Each step is commented, but this is here mainly for consistancy, since it is part of the process of population creation. We will be covering spacecraft simulation in Moody in detail in more specific tutorials later.</p>
	<div class = "codeblock">
<pre class="hl">		<span class="hl slc">// The SpacecraftInitialiser struct is used to initialise a particle as a spacecraft.</span>
		<span class="hl slc">// </span>
		SpacecraftInitialiser sci<span class="hl opt">;</span>
	<span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> <span class="hl kwd">x</span><span class="hl opt">(</span><span class="hl num">0</span><span class="hl opt">);</span>x<span class="hl opt">&lt;</span>populationSize<span class="hl opt">;</span>x<span class="hl opt">++) {</span>
		<span class="hl slc">// again we want a unique name for the particle</span>
		std<span class="hl opt">::</span>string <span class="hl kwd">s</span><span class="hl opt">(</span><span class="hl str">&quot;spacecraft_&quot;</span><span class="hl opt">);</span>
		std<span class="hl opt">::</span>stringstream oss<span class="hl opt">;</span>
		oss <span class="hl opt">&lt;&lt;</span> s <span class="hl opt">&lt;&lt;</span> x<span class="hl opt">+</span><span class="hl num">1</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>name <span class="hl opt">=</span> oss<span class="hl opt">.</span><span class="hl kwd">str</span><span class="hl opt">();</span>
		sci<span class="hl opt">.</span>red <span class="hl opt">=</span> <span class="hl num">28</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>green <span class="hl opt">=</span> <span class="hl num">255</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>blue <span class="hl opt">=</span> <span class="hl num">50</span><span class="hl opt">;</span>
		<span class="hl slc">// again we set up the particles identity and interaction status so we can run more than one</span>
		<span class="hl slc">// in the model at the same time and not have them interfere with each other</span>
		sci<span class="hl opt">.</span>identity <span class="hl opt">=</span> Advisor<span class="hl opt">::</span>spacecraft<span class="hl opt">;</span>
		sci<span class="hl opt">.</span>interactionPermission <span class="hl opt">=</span> Advisor<span class="hl opt">::</span>interactDifferentOnly<span class="hl opt">;</span>
		 <span class="hl slc">// We're using the mass of the Cassini probe when loaded with fuel</span>
		sci<span class="hl opt">.</span>mass <span class="hl opt">=</span> <span class="hl num">5573</span><span class="hl opt">;</span>
		<span class="hl slc">// now we need to state, in percentages, how this mass is distributed.</span>
		<span class="hl slc">// Payload first</span>
		sci<span class="hl opt">.</span>payloadPercentage <span class="hl opt">=</span> <span class="hl num">0.23</span><span class="hl opt">;</span>
		<span class="hl slc">// now the actual structure of the spacecraft</span>
		sci<span class="hl opt">.</span>structurePercentage <span class="hl opt">=</span> <span class="hl num">0.23</span><span class="hl opt">;</span>
		<span class="hl slc">// and the amount of the mass given over to fuel</span>
		sci<span class="hl opt">.</span>fuelPercentage <span class="hl opt">=</span> <span class="hl num">0.54</span><span class="hl opt">;</span>
		<span class="hl slc">// radius, not used by moody unless you add code to check for collisions in your</span>
		<span class="hl slc">// evaluation code</span>
		sci<span class="hl opt">.</span>radius <span class="hl opt">=</span> <span class="hl num">10</span><span class="hl opt">;</span>
		<span class="hl slc">// this sets the power of the fuel in use, this value is for Liquid Oxygen(LOX)</span>
		sci<span class="hl opt">.</span>specificImpulse <span class="hl opt">=</span> <span class="hl num">445</span><span class="hl opt">;</span>
		<span class="hl slc">// and again, this value determines the size of sphere given to this particle when displayed in MopViewer</span>
		sci<span class="hl opt">.</span>visualRepresentation <span class="hl opt">=</span> <span class="hl num">6</span><span class="hl opt">;</span>
		<span class="hl slc">// now we pass this struct to the particle method which turns the particle into a spacecraft</span>
		tmp<span class="hl opt">.</span><span class="hl kwd">makeSpacecraft</span><span class="hl opt">(</span>sci<span class="hl opt">);</span>
		<span class="hl slc">// and we put it in a random orbital position around Earth, at Low Earth Orbit, having a velocity equal to escape velocity at that altitude</span>
		tmp<span class="hl opt">.</span><span class="hl kwd">generateOrbitalPosition</span><span class="hl opt">(</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentSet</span><span class="hl opt">(),</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentParticleCount</span><span class="hl opt">()-</span><span class="hl num">1</span><span class="hl opt">),</span><span class="hl num">1</span><span class="hl opt">,</span><span class="hl num">1000000</span><span class="hl opt">,</span><span class="hl kwa">true</span><span class="hl opt">,</span><span class="hl kwa">true</span><span class="hl opt">,</span><span class="hl num">10900</span><span class="hl opt">);</span>
		<span class="hl slc">// now we add it to the population set. This MUST be done before assigning burn sequences</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">addToPopulationSet</span><span class="hl opt">(</span>tmp<span class="hl opt">);</span>
		<span class="hl slc">// ok, now we generate burn sequences for the spacecraft</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getPopulationSetMember</span><span class="hl opt">(</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getPopulationParticleCount</span><span class="hl opt">()-</span><span class="hl num">1</span><span class="hl opt">).</span><span class="hl kwd">getBurnsManager</span><span class="hl opt">()-&gt;</span><span class="hl kwd">buildBurnSequences</span><span class="hl opt">(</span>
			<span class="hl opt">(</span><span class="hl kwd">rand</span><span class="hl opt">() %</span><span class="hl num">5</span><span class="hl opt">+</span><span class="hl num">1</span><span class="hl opt">),(</span><span class="hl kwd">rand</span><span class="hl opt">() %</span><span class="hl num">5</span><span class="hl opt">+</span><span class="hl num">1</span><span class="hl opt">),</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumSteps</span><span class="hl opt">()*(</span><span class="hl kwd">rand</span><span class="hl opt">() %</span><span class="hl num">10</span><span class="hl opt">+</span><span class="hl num">1</span><span class="hl opt">),</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumStates</span><span class="hl opt">(),</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumSteps</span><span class="hl opt">());</span>
		<span class="hl slc">// and build the burn timing tables in the particle that give it a fast way to check to see whether a burn event is due</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getPopulationSetMember</span><span class="hl opt">(</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getPopulationParticleCount</span><span class="hl opt">()-</span><span class="hl num">1</span><span class="hl opt">).</span><span class="hl kwd">getBurnsManager</span><span class="hl opt">()-&gt;</span><span class="hl kwd">rebuildBurnSequenceTimingTables</span><span class="hl opt">(</span>
			experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumStates</span><span class="hl opt">(),</span> experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumSteps</span><span class="hl opt">());</span>
	<span class="hl opt">}</span> 
</pre>
 

	</div>
<p>I'll cover how to do spacecraft related experiments in a later tutorial.</p>
<h3>Moving particles between the Population, Intermediate and Environment sets</h3>
<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
