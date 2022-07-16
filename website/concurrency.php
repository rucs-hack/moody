<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">

	<h2>Concurrency in Moody</h2>
	<h3>Introduction</h3>
	<p>n-body models by their very nature require a lot of particle interactions. For the Particle-Particle approach the number of interactions required to complete a single step is <i>n(n-1)/2</i>. Moody was designed with an eye to minimising the potential costs associated with parallelising those interactions.</p>
	<h4>Rethinking the serial n-Body algorithm</h4>
	<p>Consider for a moment a typical aproach for representing particles in an n-body model. In a serial n-body model you have some structure representing a particle, and hold these in an array. Each time you iterate through the array calculating gravitational effects, you're free to update the state vectors of both particles involved in a given interaction any time you want, because those operations are serial. It's just not possible to update a particle in the wrong order, or read a value while it's being changed, because there is only ever one particle being read from or written to at any time.</p>
	<p>Take that same algorithm and turn it into a parallel algorithm in order to take advantage of mutiple cores and you have a problem. Now you need to make sure reads and writes happen in the right order, because many or all of the particles are having their motion calculated at the same time. The former orderly progression through an array is gone.</p>
	<p>There is a solution, critical sections, mutex locked variables that cannot be updated or read by more than one other thread at a time, avoiding the problem of read/write out of order errors.</p>
	<p>So fine, use them and all is well? Alas no, at least not when it comes to particle simulation. </p>
	<p>Consider an n-body model with for example ten particles. That's ten particles, each of which needs to have the result of it's interaction with the other nine particles calculated many times over. Even considering that some pairwise calculations don't need to be repeated, as we'd be updating each particle in a pairwise intraction, thats 45 pairwise interactions, all trying to occur at the same time, and all needing access to the critical sections of each particle in the model. At this level the performance hit of those critical sections and the queues of pairwise interactions waiting for access them would be fairly small, but move the model up to several hundred, or thousands of particles, and the critical section access queues will be so large that your n-body model will be spending most of its time waiting to be allowed to finish pairwise interactions.</p>
	<p>So, not so good. Critical sections and mutexes work for some applications, but they are a solution for making serial algorithms parallel, and that's the problem. In todays multi-core and distributed computing world, serial algorithms just aren't up to the job. In order to write code that will scale, your algorithms need to be designed in such a way that they are <i>trivially parallelisable</i>, meaning there are not going to be any read/write conflicts when you let it run in parallel mode.</p>
	<p>As for instantiating your algorithm, there are two choices of which I am aware. The first is to write your n-body code in a language which is designed specifically for parallel programming, such as <a href="http://www.cs.cmu.edu/~scandal/nesl.html" style = "color: #F26522;font-weight: bold; text-decoration: underline;" target = "_blank">NESL</a> or <a href="http://clojure.org/" style = "color: #F26522;font-weight: bold; text-decoration: underline;" target = "_blank">Clojure</a>. The other is to write your code in a language which isn't (such as C++) and employ a parallelisation library, which is how Moody does it. Moody makes use of two such external libraries, Intels Thread Building Blocks or OpenMP.</p>

	
	<h4>Ask Don't Tell - the Object Orientated Method</h4>
	<p>I sought to solve this problem in Moody by taking on board the Object Orientism concept of <i>Ask Don't Tell</i>. The problem with a serial n-body model is that you are telling the particles how to move, writing to their state vectors, using a pairwise interaction process to which both particles are bound until it's complete.</p>
	<p>Instead, I decided that a particle should be <i>asked</i> to move, and handle everything itself. However I added that a particle should only be concerned with its own motion, not that of other particles. That way it's own motion can be calculated without needing to be bound to the time (and critical section) consuming pairwise interaction problem.</p>
	<p>At the start of a step a particle stores its current state in a state vector that other particles can read. Each particle reads each other particles states, then decide how they will move given the effect of the particle. This is the point where a normal pairwise interaction would require a critical section, but those in Moody do not.</p>
	<p>Instead, Moodys particles update their own state and discard the result of the interaction which would usually be used to update the other particle in that pairwise interaction.</p>
	<p>Since no particle in Moody tells another what to do, there is no possibility of read/write conflicts. There is obviously a cost for this approach, now instead of <i>n(n-1)/2</i> interactions (pairwise gravitational force calculations) to complete a step, there are <i>n(n-1)</i> interactions.</p>
	
	<p>On first glance this looks pretty bad. After all we just doubled the number of interactions required. Admittedly, for a small number of particles, or a single core, this approach is really quite poor when it comes to performance. However that's not really the point. </p>
	<p>In practical terms this removes the critical section penalty associated with having large numbers of particles in a parallel n-body model. Now the n-body model is free to scale, and the more cores it has available, the faster it gets.</p>

	<p>Of course particles wouldn't cope too well with being cut off from other particles during, for example, Midpoint integration. They would need to know the revised state of all other particles at the mid point of the step in order to complete the step correctly.</p>
	<p>Therefore the most complex movements that a particle in Moody can do alone are either a single Euler Method Step and the Kick and Drift operations used in Symplectic Integration. The integrators Moody employs are then built using these. This need to stop during the execution of these more complex integrators and allow the particles to update themselves regarding the new position of other particles in the model is a read only operation as well, so again we can parallelise it, bring yet another saving in time taken. In fact since a particle in Moody is responsible for almost everything that can happen to it, we can employ parallisation quite widely.</p>
	<h4>Running Moody on a cluster</h4>
	<p>Moody will run on any cluster that employs SMP. Either OpenMP or Thread Building Blocks can be used, although the load balancing capabilities of Thread Building Blocks would probably make that a better choice.</p>
	<h4>GPUs and Moody</h4>
	<p>Moody does not use GPUs for particle integration yet. I left it out of this first version because relying on GPUs would mean that any machine using Moody would need to be equipped with a Cuda compatible card, and I didn't want that restriction initially.</p>
	<p>I'm currently looking into CUDA, so support for this may be in Moody soon.</p>
	<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
