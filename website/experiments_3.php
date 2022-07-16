<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
<h2>Recording Particle History</h2>
<p>When you're running an experiment it can be useful to record the history of particle movement in order to do some post run analysis, fitness scoring, or some such thing. </p>
<p>Moody allows you to record particle history using a fairly simple interface</p>
<h3>Preparing particle history storage</h3>
<p>Previous versions (pre 1.5.2) had history storage space being allocated on the fly. This turned out to be a bad idea, since it slowed the model down far too much. So now you set up particle memory in advance with a call to the following Capsule method:</p>
<div class = "codeblock">
<pre class="hl">	
	<span class="hl kwb">void</span> <span class="hl kwd">createHistoryStorage</span><span class="hl opt">(</span><span class="hl kwb">int</span> frequency<span class="hl opt">)</span>
</pre>
</div>
<p>Simply put, this will create a history array with sufficient entries to record the number of history entries per state specified by the <i>frequency</i> parameter.</p>
<p>A history entry for a particle contains its position and velocity on all three axis, so you can later use this to calculate relative positions and velocities between particles.</p>
<p>As with all history related capsule methods, this is a wrapper that calls an equivilently named particle method for all particles in the environment set. You can call those directly for selected particles, thus not recording history for every particle, but the Capsule class (more accuratelly, the CapsuleBase class) doesn't yet have this option, so if you do you won't be able to use the provided capsule history methods. This ability will be added in the future.</p>
<p></p>
<h3>recording a state into history</h3>
<p>In order to record history during a model run/experiment, you need to call the following method at each iteration of the model.</p>
<div class = "codeblock">
<pre class="hl">	
	<span class="hl kwb">void</span> <span class="hl kwd">doHistory</span><span class="hl opt">()</span>
</pre>
</div>
<p>Using doHistory will effectivelly automate the process of history recording.</p>
<p>For clarity it's best that doHistory() is called either directly before or after the selected iterate method. Calling it less often than once per iteration will stop doHistory from working properly.</p>
<div class = "codeblock">
<pre class="hl">

        <span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> i <span class="hl opt">=</span> <span class="hl num">0</span><span class="hl opt">;</span> i<span class="hl opt">&lt;</span><span class="hl num">100</span><span class="hl opt">;</span>i<span class="hl opt">++) {</span>
                <span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> j<span class="hl opt">=</span><span class="hl num">0</span><span class="hl opt">;</span>j<span class="hl opt">&lt;</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumSteps</span><span class="hl opt">();</span>j<span class="hl opt">++) {</span>
                        experiment<span class="hl opt">-&gt;</span><span class="hl kwd">iterateRK4</span><span class="hl opt">(</span><span class="hl opt">);</span> 
			experiment<span class="hl opt">-&gt;</span><span class="hl kwd">doHistory</span><span class="hl opt">();</span>
                <span class="hl opt">}</span>    
	<span class="hl opt">}</span> 
<span class="hl opt">}</span>
</pre>
</div>
<p>doHistory calls equivilent methods for each particle, and they keep track of the passage of iterations in order to know when its time to record their current state to their history.</p>

<h3>getting the particle history array</h3>
<p>In order to retreive the history for a given particle, first you have to obtain that particle with a call to getEnvironmentSetMember, then call one  of two methods</p>
<div class = "codeblock">
<pre class="hl">
	ParticleHistory <span class="hl opt">&amp;</span> <span class="hl kwd">getHistory</span><span class="hl opt">()</span>
</pre>

<pre class="hl">
	ParticleHistory <span class="hl opt">&amp;</span> <span class="hl kwd">getHistoryEntry</span><span class="hl opt">(</span><span class="hl kwb">int</span> index<span class="hl opt">)</span>
</pre>
</div>
<p>getHistory will return the entire history array, getHistoryEntry will return a single entry in the history array as specified by the <i>index</i> parameter.</p>
<p>Before you can safely access the history array, you will need to know its size. This is defined not neccaserily in terms of the physical size of the array, but in term of how much of that array is filled. To get this value, call: </p>
<div class = "codeblock">
</pre><pre class="hl">	
	<span class="hl kwb">const int</span> <span class="hl kwd">getStoredHistoryCount</span><span class="hl opt">()</span>
</pre>
</div>

<h3>Resetting particle history</h3>
<p>In between experiments you're going to want to reset the history arrays. To do this call the following method</p>
<div class = "codeblock">
<pre class="hl">	
	<span class="hl kwb">void</span> <span class="hl kwd">resetHistory</span><span class="hl opt">()</span>
</pre>

</div>
<p>This blanks and resets history storage, but does not delete either it, or the particles knowledge of how much history is available to it.</p>

<h3>Deleting particle history</h3>
<p>Particle history is deleted when you delete the particle concerned, or the capsule you created to run an experiment. You needn't delete it directly unless you want to resize it or just free up the space for something else. To do this call the following method</p>
<div class = "codeblock">
<pre class="hl">	
	<span class="hl kwb">void</span> <span class="hl kwd">deleteHistory</span><span class="hl opt">()</span>
</pre>
</div>

<p>This removes particle history completelly. A history resize method that will allow you to specify a new size and have the capsule do the deleting and resizing itself will be in a future release.</p>

<h2>Using Particle History</h2>
<p>I've provided two methods that can be used to analyse particle history, which I detail below, but there are quite a large number of possibilities, so this is an area of Moody that will porobably grow as it gets more use and I make some progress with my research using it.</p>
<h3>Fitness via the proximity of two particles</h3>
<p>This method takes two particles, who must have had a history recorded and available, and scans that history to find the clostest distance they acheived.</p>
<div class = "codeblock">
	<pre class="hl">
	<span class="hl kwc">virtual</span> <span class="hl kwb">double</span> <span class="hl kwd">fitnessProximitySingleTargetUsingHistory</span> <span class="hl opt">(</span><span class="hl kwb">int</span> subject<span class="hl opt">,</span><span class="hl kwb">int</span> target<span class="hl opt">)</span>
	</pre>
</div>
<p>This closest distance is then returned. One would generally use this as a fitness measure for a chromosome when acheiving the closest pass relative to a target particle is the aim.</p>
<h3>Fitness via the proximity of two particles over a set period of time</h3>
<p>With this method two particle indexes, and a period of time (as expressed in number of history entries) is given. The particle history arrays of both particles are then examined to find the period of time of the specified length during which they were closest.</p>
<div class = "codeblock">
	<pre class="hl">
	<span class="hl kwc">virtual</span> <span class="hl kwb">double</span> <span class="hl kwd">fitnessProximityAndDurationSingleTargetUsingHistory</span> <span class="hl opt">(</span><span class="hl kwb">int</span> subject<span class="hl opt">,</span><span class="hl kwb">int</span> target <span class="hl opt">,</span> <span class="hl kwb">int</span> duration<span class="hl opt">)</span>
	</pre>
</div>
<p>This method then allows you to look not just at the distance, but at relative velocities of the two particles as well. This kind of fitness criteria means that chromosomes who have managed to match velocities best as well as acheive a good proximity will be the most fit.</p>
	<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
