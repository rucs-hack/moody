<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
	<h2>Introduction to Spacecraft Simulation in Moody</h2>

	<p>Particles in Moody have the option of being converted into spacecraft. This functionality exists so it can be used in conjunction with evolutionary computation to discover routes that will allow the spacecraft to complete a journey you specify.</p>
	<p>When used as spacecraft, particles activate burn sequence management functionality. A burn sequence manager is a hierarchical structure and has several componants.</p>
<h3>The Design</h3>

<p>A spacecraft in Moody is a particle that has all the properties of a normal particle, but has had additional functionality activated. We'll cover that additional functionality, but first, lets look at the basic design of a spacecraft</p>
<p>When a particle is set up to be a spacecraft, its mass is divided among three properties. These are Structural Mass, Payload Mass, and Fuel Mass. </p>
<h4>Structural Mass</h4>
<p>This is the percentage of available mass which is assigned to represent the structure of the spacecraft (rockets, thrusters, computers, stuff like that)</p>
<h4>Payload Mass</h4>
<p>This is the percentage of available mass which is assigned to represent the payload being carried by a spacecraft.</p>
<h4>Fuel Mass</h4>
<p>This is the percentage of available mass which is assigned to represent the fuel that will be used as the spacecrafts rockets/thrusters are fired.</p>
<h4>Adjusting These Values</h4>
<p>Mutation operators will allow the percentages allocated to be altered, and applying thrust will use fuel up, reducing the fuel mass percentage (as well as overall mass).</p>

<h3>The Simulation of Thrust Application</h3>
<p>Thrust is always applied as a positive value in each of six directions. These are the positive and negative directions in all three axis, making six thrust directions in total.</p>
<p>The creation, management and alteration of thrust application over the course of an experiment/mission is handled by a particles Burn Sequence Manager. The componants of this we'll now go over.</p>
<h4>The BurnEvent Class</h4>
<p>This class represents a single instance of fuel being converted into thrust. A burn event knows what percentage of the fuel available it is allowed to use, and applies the resultant thrust by distributing it between all six possible directions - X+-,Y+-,Z+-. It also knows when in terms of the percentage of time available to its parent burn sequence it is going to fire.</p>

<h4>The BurnSequence Class</h4>
<p>This classmanages a set of burn events. It knows what percentage of the total available fuel it has available to it, and its burn event children get their own fuel amounts as a percentage of this amount. a burn sequence also knows when, during the total specified runtime in states/steps of the experiment it is active, and thus should be firing its burn sequences as their activation time arrives. Timings for burn events are set within the period of time that a burn sequence is active.</p>

<h4>The BurnSequenceManager Class</h4>
<p>This class manages the burn sequences that a particle will use (through creation,usage, and alteration by mutation operators it provides). It applies timings to sequences (which then apply sub-timings to their burn events), and when used as described below, can monitor the passage of states/steps during an experiment to see whether on of its burn sequences needs to activate (fire) a burn sequence.</p>
<p>It also provides mutation operations, so you can make random changes to burn sequences or individual burn events. Burn sequences are not allowed to overlap, and other values (such as total fuel available to a sequence or burn event) must be kept valid. By managing mutations itself rather than permitting direct access to the burn events and sequences, a burn sequence manager can maintain the validity of the sequences it contains.</p>

<h3>How to turn a particle into a spacecraft</h3>
<p>In order for a normal particle to become a spacecraft, you need first need to prepare a structure that contains all the information required. This is a struct named 'spacecraftInitialiser'. It's a plain struct, rather than a class, because all members are public.</p>
<p>After that you have to give it a position and velocity. Normally position would be relative to some existing particle, but it needn't be. For our purposes in the example code that follows we will assume that you want this spacecraft to be at some random point around Earth, at Low Earth Orbit altitude, and travelling at the correct escape velocity to leave the vacinity of Earth.</p>
<p>Finally we need to provide the spacecraft with a series of burn sequences. The following code segment shows the preparation of 100 spacecraft, each with a maximum of five burn sequences (minimum one), where each has one to five burns. The maximum number of states a burn sequence in this example can occupy is ten.</p>
<div class = "codeblock">
<pre class="hl">	Particle tmp<span class="hl opt">;</span>
	<span class="hl slc">// store some vars in shorter variable names</span>
	<span class="hl slc">// Not required really, but it makes the tutorial code fit on the page</span>
	<span class="hl kwb">int</span> ns <span class="hl opt">=</span> experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumSteps</span><span class="hl opt">();</span>
	<span class="hl kwb">int</span> nst <span class="hl opt">=</span> experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumStates</span><span class="hl opt">();</span>
	<span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> <span class="hl kwd">x</span><span class="hl opt">(</span><span class="hl num">0</span><span class="hl opt">);</span>x<span class="hl opt">&lt;</span><span class="hl num">100</span><span class="hl opt">;</span>x<span class="hl opt">++) {</span>
		SpacecraftInitialiser sci<span class="hl opt">;</span>
		std<span class="hl opt">::</span>string <span class="hl kwd">s</span><span class="hl opt">(</span><span class="hl str">&quot;spacecraft_&quot;</span><span class="hl opt">);</span>
		std<span class="hl opt">::</span>stringstream oss<span class="hl opt">;</span>
		oss <span class="hl opt">&lt;&lt;</span> s <span class="hl opt">&lt;&lt;</span> x<span class="hl opt">+</span><span class="hl num">1</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>name <span class="hl opt">=</span> oss<span class="hl opt">.</span><span class="hl kwd">str</span><span class="hl opt">();</span>
		sci<span class="hl opt">.</span>red <span class="hl opt">=</span> <span class="hl num">28</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>green <span class="hl opt">=</span> <span class="hl num">255</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>blue <span class="hl opt">=</span> <span class="hl num">50</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>identity <span class="hl opt">=</span> Advisor<span class="hl opt">::</span>spacecraft<span class="hl opt">;</span>
		sci<span class="hl opt">.</span>interactionPermission <span class="hl opt">=</span> Advisor<span class="hl opt">::</span>interactDifferentOnly<span class="hl opt">;</span>
		sci<span class="hl opt">.</span>mass <span class="hl opt">=</span> <span class="hl num">5573</span><span class="hl opt">;</span> <span class="hl slc">// mass of the Cassini probe when loaded with fuel</span>
		sci<span class="hl opt">.</span>payloadPercentage <span class="hl opt">=</span> <span class="hl num">0.23</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>structurePercentage <span class="hl opt">=</span> <span class="hl num">0.23</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>fuelPercentage <span class="hl opt">=</span> <span class="hl num">0.54</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>radius <span class="hl opt">=</span> <span class="hl num">10</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>specificImpulse <span class="hl opt">=</span> <span class="hl num">445</span><span class="hl opt">;</span>
		sci<span class="hl opt">.</span>visualRepresentation <span class="hl opt">=</span> <span class="hl num">6</span><span class="hl opt">;</span>
		<span class="hl slc">// use this initialisation structure we just filled to turn the particle into a spacecraft</span>
		tmp<span class="hl opt">.</span><span class="hl kwd">makeSpacecraft</span><span class="hl opt">(</span>sci<span class="hl opt">);</span>
		<span class="hl kwb">int</span> ec <span class="hl opt">=</span> experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getEnvironmentParticleCount</span><span class="hl opt">();</span>
		<span class="hl slc">// Place this spacecraft in a random position around Earth</span>
		<span class="hl slc">// Explanation of literal values:</span>
		<span class="hl slc">// Value: 3 - meaning: The index of Earth in the project being used.</span>
		<span class="hl slc">// Value: 1000000 - meaning: Altitude from the Earths Surface (as  detyermined by the radius set) in meters.</span>
		<span class="hl slc">// Value: 10900 - meaning: Escape velocity at low earth orbit in meters per second.</span>
		tmp<span class="hl opt">.</span><span class="hl kwd">generateOrbitalPosition</span><span class="hl opt">(</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getparticleClassEnvironmentSet</span><span class="hl opt">(),</span>ec<span class="hl opt">,</span><span class="hl num">3</span><span class="hl opt">,</span><span class="hl num">1000000</span><span class="hl opt">,</span><span class="hl kwa">true</span><span class="hl opt">,</span><span class="hl kwa">true</span><span class="hl opt">,</span><span class="hl num">10900</span><span class="hl opt">);</span>
		<span class="hl slc">// Add to both particle sets in this case, since that gives us a placeholder location for each spacecraft in the environment</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">addParticleToEnvironmentAndPopulation</span><span class="hl opt">(</span>tmp<span class="hl opt">);</span>
		<span class="hl kwb">int</span> pc <span class="hl opt">=</span> experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getPopulationParticleCount</span><span class="hl opt">();</span>
		<span class="hl kwb">int</span> rnd1 <span class="hl opt">=</span> <span class="hl kwd">rand</span><span class="hl opt">() %</span><span class="hl num">5</span><span class="hl opt">+</span><span class="hl num">1</span><span class="hl opt">;</span>
		<span class="hl kwb">int</span> rnd2 <span class="hl opt">=</span> <span class="hl kwd">rand</span><span class="hl opt">() %</span><span class="hl num">5</span><span class="hl opt">+</span><span class="hl num">1</span><span class="hl opt">;</span>
		<span class="hl slc">// maximum sequence size allowed is ten states, defined here as that amount in steps</span>
		<span class="hl kwb">int</span> seqLenMax <span class="hl opt">=</span> experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumSteps</span><span class="hl opt">()*(</span><span class="hl kwd">rand</span><span class="hl opt">() %</span><span class="hl num">10</span><span class="hl opt">+</span><span class="hl num">1</span><span class="hl opt">);</span>
		<span class="hl slc">// build the burn sequences for the particle in the Population set, since this is the one which is retained and mutated.</span>
		<span class="hl kwa">this</span><span class="hl opt">-&gt;</span><span class="hl kwd">getparticleClassPopulationSetMember</span><span class="hl opt">(</span>pc<span class="hl opt">-</span><span class="hl num">1</span><span class="hl opt">).</span><span class="hl kwd">getBurnsManager</span><span class="hl opt">()-&gt;</span><span class="hl kwd">buildBurnSequences</span><span class="hl opt">(</span>rnd1<span class="hl opt">,</span>rnd2<span class="hl opt">,</span>seqLenMax<span class="hl opt">,</span>nst<span class="hl opt">,</span>ns<span class="hl opt">);</span>
		<span class="hl slc">// whenever a burn sequence is built or its timing mutated, the burn sequence lookup tables needs to be rebuilt.</span>
		<span class="hl slc">// this should be done for all spacecraft, as the mutation might be one that moves the sequence itself.</span>
		<span class="hl kwa">this</span><span class="hl opt">-&gt;</span><span class="hl kwd">getparticleClassPopulationSetMember</span><span class="hl opt">(</span>pc<span class="hl opt">-</span><span class="hl num">1</span><span class="hl opt">).</span><span class="hl kwd">getBurnsManager</span><span class="hl opt">()-&gt;</span><span class="hl kwd">rebuildBurnSequenceTimingTables</span><span class="hl opt">(</span>nst<span class="hl opt">,</span>ns<span class="hl opt">);</span>
		std<span class="hl opt">::</span>cout <span class="hl opt">&lt;&lt;</span> <span class="hl str">&quot;built spacecraft &quot;</span> <span class="hl opt">&lt;&lt;</span> oss<span class="hl opt">.</span><span class="hl kwd">str</span><span class="hl opt">() &lt;&lt;</span> std<span class="hl opt">::</span>endl<span class="hl opt">;</span>
	<span class="hl opt">}</span>
</pre>

</div>
<h3>How to use a spacecraft</h3>
<p>This at least is pretty simple. All you need to do is add the following method call to your driver, just before the call to the iterator.</p>
<div class = "codeblock">
<pre class="hl">
	experiment<span class="hl opt">-&gt;</span><span class="hl kwd">processSpacecraft</span><span class="hl opt">(</span>i<span class="hl opt">,</span>j<span class="hl opt">);</span>
</pre>
</div>
<p>Or in a more complete example:</p>

<div class = "codeblock">
<pre class="hl">		<span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> i <span class="hl opt">=</span> <span class="hl num">1</span><span class="hl opt">;</span> i<span class="hl opt">&lt;</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumStates</span><span class="hl opt">()+</span><span class="hl num">1</span><span class="hl opt">;</span>i<span class="hl opt">++) {</span>
			experiment<span class="hl opt">-&gt;</span><span class="hl kwd">writeCurrentStateToMopFile</span><span class="hl opt">();</span>
			<span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> j<span class="hl opt">=</span><span class="hl num">0</span><span class="hl opt">;</span>j<span class="hl opt">&lt;</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumSteps</span><span class="hl opt">();</span>j<span class="hl opt">++) {</span>
				experiment<span class="hl opt">-&gt;</span><span class="hl kwd">processSpacecraft</span><span class="hl opt">(</span>i<span class="hl opt">,</span>j<span class="hl opt">);</span>
				experiment<span class="hl opt">-&gt;</span><span class="hl kwd">iterateSym</span><span class="hl opt">(</span><span class="hl opt">);</span>
			<span class="hl opt">}</span>
		<span class="hl opt">}</span>
</pre>

</div>

<p>The parameters <b>i,j</b> refer to the state, then step. Calling this method will result in any burns that are due at the specified state/step being fired. Once fired they cannot be re-used, since they alter the mass of the spacecraft. It is for this reason that burn sequences belonging to spacecraft can be moved <i>from</i> the population set to the environment set via the intermediate set, but not <i>back</i> to it. </p>

<h3>Spacecraft mutation operators</h3>
<p>There are a number of mutation operators that are available when a particle is converted to a spacecraft. If they are called and the particle isn't a spacecraft they will either be unavailable or have no effect</p>
<p>It is important that you <b><i>NEVER</i></b> apply mutation operators to particles in either the population set or the environment set. To do so will lose the original particle that existed before the mutation. Instead, move a particle to the intermediate set, mutate it, test it in the environment set, and then, if the mutation is to be allowed to survive, select a member of the population set to overwrite and copy it back into the population.</p>
<p>The available mutation operators, which all effect very small changes are as follows</p>
	<h4> From within the burn sequence manager of a Particle</h4>
	
	<p>mutate burn event position for a randomly selected sequence burn sequence</p>
	<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">mutateSingleBurnEventPosition</span><span class="hl opt">(</span><span class="hl kwb">int</span> states<span class="hl opt">,</span> <span class="hl kwb">int</span> steps<span class="hl opt">);</span>
	</pre>
	</div>

	<p>mutate burn event thrust allocation for a single burn of a randomly selected sequence</p>
	<div class = "codeblock">
		<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">mutateSingleBurnEventThrust</span><span class="hl opt">();</span>
	</pre>
	</div>
	
	<p>mutate burn fuel allocation percentages for a randomly selected sequence by taking from one and giving to another</p>
	<div class = "codeblock">
		<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">mutateFuelAllocationForSingleSequence</span><span class="hl opt">();</span>
	</pre>
	</div>
	
	<p>mutate burn fuel allocation percentages for a randomly selected sequence by swapping allocations between burns</p>
	<div class = "codeblock">
		<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">mutateRandomBurnFuelAllocationsBySwapping</span><span class="hl opt">(</span><span class="hl kwb">int</span> swaps<span class="hl opt">);</span>
		</pre>
	</div>
	
	<p>swap the positioning of two sequences</p>
	<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">mutateSequencesBySwappingPosition</span><span class="hl opt">(</span><span class="hl kwb">int</span> swaps<span class="hl opt">);</span>
	</pre>
	</div>
	<p>mutate the positioning or size of a randomly selected sequence.</p>
	<div class = "codeblock">
		<pre class="hl">
		<span class="hl kwb">void</span> <span class="hl kwd">mutateSequenceByChangingTiming</span><span class="hl opt">(</span> <span class="hl kwb">int</span> numberOfStates<span class="hl opt">,</span> <span class="hl kwb">int</span> numberOfStepsPerState<span class="hl opt">)</span>
		</pre>
	</div>

	<h4> from the Particle class itself</h4>
	<p>alter the percentage of a particles mass that is available as fuel mass</p>
	<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwc">inline</span> <span class="hl kwb">void</span> <span class="hl kwd">mutateFuelPercentage</span><span class="hl opt">();</span>
	</pre>
	</div>

	
	<p>alter the percentage of a particles mass that is reserved for payload mass</p>
	<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwc">inline</span> <span class="hl kwb">void</span> <span class="hl kwd">mutatePayloadPercentage</span><span class="hl opt">();</span>
	</pre>
	</div>

		<p>alter the percentage of a particles mass that is reserved as structural mass</p>
	<div class = "codeblock">
	<pre class="hl">
		<span class="hl kwc">inline</span> <span class="hl kwb">void</span> <span class="hl kwd">mutateStructurePercentage</span><span class="hl opt">();</span>
	</pre>
	</div>


<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>

