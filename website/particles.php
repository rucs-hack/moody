<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">

	<h2>The Particle Class</h2>
				
	<p>This class represents a particle in the model. A Particle object is responsible for its own interactions and movement. While it is true that a Capsule operates the n-body model, it is the particles themselves that contain the integrator which moves them.</p>

	<p>A Particle is responsible for managing its own interactions, and as has been said, its own motion. The integrator that a Particle possesses is a simple first order method. Using this, more advanced integrators can be constructed fairly easily.</p>

	<p>The interaction method a particle uses concerns only its own movement, not that of other particles.</p> 
	<p>Particles have to share information about their state in order for other particles to calculate how they must move in relation to them, but this sharing is a <i>read only</i> operation. A particle may request the current position and mass of another particle, but it may not make any changes to another particle.</p>

	<p>The advantage of this approach is that a Particles motion can be calculated in a lock free way, with no delays waiting to access a critical section to update the other Particle's fields, or indeed to update its own. Thus concurrency can be acheived with ease.</p>

	<p>There is of course a cost associated with this approach. For a particle to establish the gravitational effect another particle will have on it, it must work out the distance and calculate the force that other particle is exerting on it. Since the result of this calculation is not shared with other particles, every particle has to compare itself with every other particle whenever it finds the total gravitational forces acting on it. This does cause some slowdown, but the alternative, using critical sections to allow a particle to update the fields of another particle would be equally costly, due to the delays caused by waits on mutexes, and considerably more complex. Therefore the <i>read only</i> particle interaction aproach seems the best one.</p>

	<h4>Controlling Particle Motion</h4>

    <p>Since particles in Moody do not alter the state of other particles when calculating gravitational effects, they are limited as to what they can do without needing to have other particles update their positions before they can move again.</p>
	<p>As a result, a particle can do one of three things</p>
	 <ul class = "generalList">
		<li>A single Euler Method Step</li>
		<li>A single Drift move</li>
		<li>a single Kick move</li>
	</ul>
	<p>For which the following methods exist</p>
	<div class = "codeblock">
	<pre class="hl">	
	<span class="hl slc">//One Euler Method Step</span>
	<span class="hl kwb">void</span> <span class="hl kwd">moveParticle</span><span class="hl opt">(</span><span class="hl kwb">const int</span> travelTime<span class="hl opt">);</span>
	
	<span class="hl slc">// Calculate the forces acting on this particle then apply that times the size of the step</span>
	<span class="hl kwb">void</span> <span class="hl kwd">kick</span><span class="hl opt">(</span>Particle <span class="hl opt">*</span> allParticles<span class="hl opt">,</span><span class="hl kwb">const int</span> numParticles<span class="hl opt">,</span> <span class="hl kwb">const double</span> G<span class="hl opt">,</span> <span class="hl kwb">const int</span> myIndex<span class="hl opt">,</span> <span class="hl kwb">int</span> stepsize<span class="hl opt">);</span>
	
	<span class="hl slc">//kick this particles velocity using the existing forces</span>
	<span class="hl kwc">inline</span> <span class="hl kwb">void</span> <span class="hl kwd">kick_noforceCalc</span><span class="hl opt">(</span><span class="hl kwb">int</span> stepsize<span class="hl opt">);</span>
	
	<span class="hl slc">//drift this particle across a step</span>
	<span class="hl kwc">inline</span> <span class="hl kwb">void</span> <span class="hl kwd">drift</span> <span class="hl opt">(</span><span class="hl kwb">int</span> stepsize<span class="hl opt">);</span>
	</pre>
	</div>
	<p>The Integrators available in Moody - 2nd Order Symplectic, 2nd Order MidPoint, and 4th Order Runge-Kutta are built using these. These are covered in more detail on the <a href = "integrators.php">integrators</a> page.</p>
    <p>The particle class has other methods involved in building these integrators, I suggest you read the particle and capsule class files directly to see what they are, and how they are used.</p>
	<h3>Particles as subjects of evolutionary computation</h3>
	<p>Particles contain mutation operators that allow for their use in experiments that use evolutionary computation.</p>
	<p>When a particle is being used to represent a natural object, such as a planet or asteroid, the following mutation operators are able to be used</p>
	<div class = "codeblock">
<pre class="hl"> <span class="hl kwb">void</span> <span class="hl kwd">mutateVelocity</span><span class="hl opt">();</span>
 <span class="hl kwb">void</span> <span class="hl kwd">mutateLocation</span><span class="hl opt">();</span>
 <span class="hl kwb">void</span> <span class="hl kwd">mutateMass</span><span class="hl opt">();</span>
</pre>
</div>
<p>Note that mutating a particles mass will have little or no effect if it is sufficiently dominated by a collapsor, generally mass mutation only has a measureable efect if the particle is a spacecraft</p>
<p>If the particle has been turned into a spacecraft, additional mutation operators become available, for more information, refer to the <a href = "http://moody.politespider.com/experiments_2.php" style = "color: #F26522;font-weight: bold; text-decoration: underline;">rocketry tutorial</a>.</p>
	
	<h3>Extending the Particle Class</h3>
	<h4>Adding Methods</h4>

	<p>You can add additional methods, or overload existing methods as required by your particuler experiment. Particles are passed between Capsules as structs, which only include Particle members, not methods, so adding new methods will not interfere with data sharing between Capsules.</p>

	<h4>Adding Members</h4>

	<p>If you wish to add additional members to the particle class, you can do so, but bear in mind that the particles struct, and the content assignment/export methods will also need to be updated, and there may be compatability issues with Capsules written by other researchers.</p>
	<p>If you do make changes to the particle class and feel they are of sufficient value that they should be included in the main release of Moody, then <a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#99;&#97;&#114;&#101;&#121;&#46;&#112;&#114;&#105;&#100;&#103;&#101;&#111;&#110;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;" style = "font-weight: bold;">&#101;&#109;&#97;&#105;&#108;&#32;&#109;&#101;</a> to discuss it.</p>
	<div class = "horizontalDivider"></div>


<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
